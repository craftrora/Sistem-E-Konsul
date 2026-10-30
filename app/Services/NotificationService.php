<?php

namespace App\Services;

use App\Enums\NotifType;
use App\Enums\RoleEnum;
use App\Mail\KonsultasiDibuat;
use App\Mail\KonsultasiDijawab;
use App\Mail\KonsultasiSelesai;
use App\Models\Notifikasi;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Mengelola notifikasi dalam aplikasi dan surel.
 *
 * Seluruh pengiriman dibungkus penanganan galat agar kegagalan surel
 * tidak pernah membatalkan proses tiket yang sedang berjalan.
 */
class NotificationService
{
    /* =====================================================================
     |  Peristiwa alur konsultasi
     ===================================================================== */

    /** Konsultasi baru diajukan OPD. */
    public function konsultasiDibuat(Ticket $tiket, User $pengaju): void
    {
        $this->buat(
            $pengaju,
            $tiket,
            NotifType::DIBUAT,
            'Konsultasi berhasil diajukan',
            "Konsultasi {$tiket->kode_tiket} telah diterima dan menunggu verifikasi."
        );

        // Beri tahu seluruh Administrator agar segera memverifikasi
        foreach ($this->daftarAdmin() as $admin) {
            $this->buat(
                $admin,
                $tiket,
                NotifType::DIBUAT,
                'Konsultasi baru masuk',
                "{$tiket->opd?->nama_opd} mengajukan konsultasi {$tiket->kode_tiket}."
            );
        }

        $this->kirimSurel($pengaju, new KonsultasiDibuat($tiket));
    }

    /** Administrator memverifikasi dan mendisposisikan tiket. */
    public function konsultasiDiverifikasi(Ticket $tiket): void
    {
        $tiket->loadMissing(['creator', 'unitIrban']);

        if ($tiket->creator) {
            $this->buat(
                $tiket->creator,
                $tiket,
                NotifType::DIVERIFIKASI,
                'Konsultasi telah diverifikasi',
                "Konsultasi {$tiket->kode_tiket} diteruskan ke {$tiket->unitIrban?->nama}."
            );
        }

        // Beri tahu Irban pada unit tujuan bahwa ada tiket masuk
        foreach ($this->daftarIrban($tiket->unit_irban_id) as $irban) {
            $this->buat(
                $irban,
                $tiket,
                NotifType::DIPROSES,
                'Tiket baru untuk unit Anda',
                "Konsultasi {$tiket->kode_tiket} dari {$tiket->opd?->nama_opd} menunggu jawaban."
            );
        }
    }

    /** Irban memberikan jawaban. */
    public function konsultasiDijawab(Ticket $tiket): void
    {
        $tiket->loadMissing('creator');

        if (! $tiket->creator) {
            return;
        }

        $this->buat(
            $tiket->creator,
            $tiket,
            NotifType::DIJAWAB,
            'Konsultasi telah dijawab',
            "Konsultasi {$tiket->kode_tiket} telah mendapat jawaban dari Inspektorat."
        );

        $this->kirimSurel($tiket->creator, new KonsultasiDijawab($tiket));
    }

    /** OPD mengirim balasan lanjutan. */
    public function balasanLanjutan(Ticket $tiket): void
    {
        foreach ($this->daftarIrban($tiket->unit_irban_id) as $irban) {
            $this->buat(
                $irban,
                $tiket,
                NotifType::BALASAN,
                'Balasan lanjutan dari OPD',
                "{$tiket->opd?->nama_opd} membalas pada konsultasi {$tiket->kode_tiket}."
            );
        }
    }

    /** Konsultasi dinyatakan selesai. */
    public function konsultasiSelesai(Ticket $tiket): void
    {
        $tiket->loadMissing('creator');

        if (! $tiket->creator) {
            return;
        }

        $this->buat(
            $tiket->creator,
            $tiket,
            NotifType::SELESAI,
            'Konsultasi telah selesai',
            "Konsultasi {$tiket->kode_tiket} dinyatakan selesai dan tersimpan sebagai arsip."
        );

        $this->kirimSurel($tiket->creator, new KonsultasiSelesai($tiket));
    }

    /* =====================================================================
     |  Pembantu
     ===================================================================== */

    private function buat(User $penerima, Ticket $tiket, NotifType $tipe, string $judul, string $pesan): void
    {
        Notifikasi::create([
            'user_id'   => $penerima->id,
            'ticket_id' => $tiket->id,
            'tipe'      => $tipe->value,
            'judul'     => $judul,
            'pesan'     => $pesan,
        ]);
    }

    /**
     * Mengirim surel. Kegagalan hanya dicatat pada log, tidak dilempar,
     * supaya proses tiket tetap berjalan meski SMTP bermasalah.
     */
    private function kirimSurel(User $penerima, $surel): void
    {
        if (! config('ekonsul.surel.aktif')) {
            return;
        }

        if (blank($penerima->email)) {
            return;
        }

        try {
            Mail::to($penerima->email)->send($surel);
        } catch (Throwable $e) {
            Log::warning('Gagal mengirim surel notifikasi E-KONSUL', [
                'penerima' => $penerima->email,
                'galat'    => $e->getMessage(),
            ]);
        }
    }

    private function daftarAdmin()
    {
        return User::query()->role(RoleEnum::ADMIN)->active()->get();
    }

    private function daftarIrban(?int $unitIrbanId)
    {
        if (! $unitIrbanId) {
            return collect();
        }

        return User::query()
            ->role(RoleEnum::IRBAN)
            ->active()
            ->where('unit_irban_id', $unitIrbanId)
            ->get();
    }
}
