<?php

namespace App\Services;

use App\Enums\MessageType;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TicketService
{
    public function __construct(
        private TicketNumberGenerator $nomorTiket,
        private AttachmentService $lampiran,
        private NotificationService $notifikasi,
    ) {}

    /**
     * OPD mengajukan konsultasi baru. Menghasilkan nomor register otomatis
     * dan langsung merutekan ke Irban yang berwenang tanpa perlu verifikasi Admin.
     *
     * Prioritas routing:
     *   1. default_unit_irban_id pada kategori (Irban spesifik per topik)
     *   2. unit_irban_id pada OPD (Irban wilayah pengawasan OPD)
     */
    public function buatTiket(User $opd, array $data, array $files = []): Ticket
    {
        $tiket = DB::transaction(function () use ($opd, $data, $files) {
            // Tentukan Irban tujuan: prioritaskan kategori, fallback ke OPD
            $category    = \App\Models\Category::find($data['category_id']);
            $unitIrbanId = $category?->default_unit_irban_id
                ?? $opd->opd?->unit_irban_id
                ?? null;

            $tiket = Ticket::create([
                'kode_tiket'    => $this->nomorTiket->generate(),
                'judul'         => $data['judul'],
                'opd_id'        => $opd->opd_id,
                'created_by'    => $opd->id,
                'category_id'   => $data['category_id'],
                'unit_irban_id' => $unitIrbanId,
                'status'        => TicketStatus::DIPROSES,
                'last_reply_at' => now(),
            ]);

            $pesan = $tiket->messages()->create([
                'user_id' => $opd->id,
                'tipe'    => MessageType::PERTANYAAN->value,
                'isi'     => $data['pertanyaan'],
            ]);

            $this->lampiran->simpanBanyak($files, $pesan, $opd);

            $this->catatStatus(
                $tiket,
                null,
                TicketStatus::DIPROSES,
                $opd,
                'Konsultasi diajukan dan otomatis diteruskan ke unit Inspektur Pembantu.'
            );

            return $tiket->fresh();
        });

        $tiket->loadMissing(['opd', 'unitIrban']);
        $this->notifikasi->konsultasiDibuat($tiket, $opd);

        return $tiket;
    }

    /**
     * Administrator memverifikasi tiket dan mendisposisikannya ke unit Irban.
     */
    public function verifikasiDanDisposisi(Ticket $tiket, User $admin, int $unitIrbanId, ?string $catatan = null): Ticket
    {
        abort_unless(
            $tiket->status === TicketStatus::MENUNGGU_VERIFIKASI,
            403,
            'Tiket ini sudah pernah diverifikasi sebelumnya.'
        );

        $tiket = DB::transaction(function () use ($tiket, $admin, $unitIrbanId, $catatan) {
            $statusLama = $tiket->status;

            $tiket->update([
                'unit_irban_id' => $unitIrbanId,
                'status'        => TicketStatus::DIPROSES,
                'verified_by'   => $admin->id,
                'verified_at'   => now(),
            ]);

            $this->catatStatus(
                $tiket,
                $statusLama,
                TicketStatus::DIPROSES,
                $admin,
                $catatan ?: 'Diverifikasi dan didisposisikan ke unit Inspektur Pembantu.'
            );

            return $tiket->fresh();
        });

        $tiket->loadMissing(['creator', 'unitIrban', 'opd']);
        $this->notifikasi->konsultasiDiverifikasi($tiket);

        return $tiket;
    }

    /**
     * Menambahkan balasan atau jawaban, sekaligus memindahkan status
     * bila transisinya sah menurut TicketStatus::canTransitionTo().
     */
    public function balas(
        Ticket $tiket,
        User $user,
        string $isi,
        array $files,
        MessageType $tipe,
        ?TicketStatus $statusTujuan = null
    ): Ticket {
        abort_if($tiket->isLocked(), 403, 'Tiket ini sudah selesai dan tidak dapat dibalas lagi.');

        $tiket = DB::transaction(function () use ($tiket, $user, $isi, $files, $tipe, $statusTujuan) {
            $pesan = $tiket->messages()->create([
                'user_id' => $user->id,
                'tipe'    => $tipe->value,
                'isi'     => $isi,
            ]);

            $this->lampiran->simpanBanyak($files, $pesan, $user);

            $tiket->update(['last_reply_at' => now()]);

            if ($statusTujuan && $tiket->status->canTransitionTo($statusTujuan)) {
                $statusLama = $tiket->status;
                $tiket->update(['status' => $statusTujuan]);

                $this->catatStatus(
                    $tiket,
                    $statusLama,
                    $statusTujuan,
                    $user,
                    $tipe === MessageType::JAWABAN
                        ? 'Jawaban disampaikan oleh Inspektur Pembantu.'
                        : 'Balasan lanjutan disampaikan oleh Perangkat Daerah.'
                );
            }

            return $tiket->fresh();
        });

        $tiket->loadMissing(['creator', 'unitIrban', 'opd']);

        if ($tipe === MessageType::JAWABAN) {
            $this->notifikasi->konsultasiDijawab($tiket);
        } elseif ($tipe === MessageType::BALASAN) {
            $this->notifikasi->balasanLanjutan($tiket);
        }

        return $tiket;
    }

    /**
     * Mengubah status tiket secara eksplisit, misalnya menutup atau membuka kembali.
     */
    public function ubahStatus(Ticket $tiket, User $user, TicketStatus $statusBaru, ?string $catatan = null): Ticket
    {
        abort_unless(
            $tiket->status->canTransitionTo($statusBaru),
            422,
            "Tiket berstatus \"{$tiket->status->label()}\" tidak dapat diubah menjadi \"{$statusBaru->label()}\"."
        );

        $tiket = DB::transaction(function () use ($tiket, $user, $statusBaru, $catatan) {
            $statusLama = $tiket->status;

            $data = ['status' => $statusBaru];

            if ($statusBaru === TicketStatus::SELESAI) {
                $data['closed_by'] = $user->id;
                $data['closed_at'] = now();
            }

            if ($statusLama === TicketStatus::SELESAI && $statusBaru !== TicketStatus::SELESAI) {
                $data['closed_by'] = null;
                $data['closed_at'] = null;
            }

            $tiket->update($data);

            $this->catatStatus($tiket, $statusLama, $statusBaru, $user, $catatan);

            return $tiket->fresh();
        });

        if ($statusBaru === TicketStatus::SELESAI) {
            $tiket->loadMissing('creator');
            $this->notifikasi->konsultasiSelesai($tiket);
        }

        return $tiket;
    }

    private function catatStatus(Ticket $tiket, ?TicketStatus $lama, TicketStatus $baru, User $user, ?string $catatan = null): void
    {
        $tiket->statusLogs()->create([
            'user_id'     => $user->id,
            'status_lama' => $lama?->value,
            'status_baru' => $baru->value,
            'catatan'     => $catatan,
        ]);
    }
}
