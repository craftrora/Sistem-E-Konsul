<?php

namespace App\Http\Controllers\Irban;

use App\Enums\MessageType;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReplyRequest;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function __construct(private TicketService $tiketService) {}

    /** Tiket yang baru didisposisikan, belum pernah dijawab Irban. */
    public function baru(Request $request): View
    {
        return $this->daftar($request, [TicketStatus::DIPROSES], 'Tiket Baru');
    }

    /** Tiket yang sudah dijawab minimal sekali, menunggu kelanjutan dari OPD. */
    public function diproses(Request $request): View
    {
        return $this->daftar($request, [TicketStatus::SUDAH_DIJAWAB, TicketStatus::MENUNGGU_BALASAN_OPD], 'Tiket Diproses');
    }

    public function selesai(Request $request): View
    {
        return $this->daftar($request, [TicketStatus::SELESAI], 'Tiket Selesai');
    }

    private function daftar(Request $request, array $status, string $judulHalaman): View
    {
        $tiket = Ticket::query()
            ->with(['opd', 'category'])
            ->visibleTo($request->user())
            ->status($status)
            ->search($request->string('cari')->value())
            ->latest()
            ->paginate(config('ekonsul.per_halaman'))
            ->withQueryString();

        return view('irban.tiket.index', compact('tiket', 'judulHalaman'));
    }

    public function show(Ticket $tiket): View
    {
        $this->pastikanUnitSendiri($tiket);

        $tiket->load(['messages.user', 'messages.attachments', 'category', 'opd', 'statusLogs.user']);

        return view('irban.tiket.show', compact('tiket'));
    }

    public function balas(StoreReplyRequest $request, Ticket $tiket): RedirectResponse
    {
        $this->pastikanUnitSendiri($tiket);
        abort_if($tiket->belumDiverifikasi(), 403, 'Tiket ini belum diverifikasi Admin.');

        $statusTujuan = $request->boolean('minta_info')
            ? TicketStatus::MENUNGGU_BALASAN_OPD
            : TicketStatus::SUDAH_DIJAWAB;

        $this->tiketService->balas(
            $tiket,
            $request->user(),
            $request->string('isi')->value(),
            $request->file('lampiran', []),
            MessageType::JAWABAN,
            $statusTujuan
        );

        return back()->with('sukses', 'Jawaban berhasil dikirim.');
    }

    public function tutup(Request $request, Ticket $tiket): RedirectResponse
    {
        $this->pastikanUnitSendiri($tiket);

        $this->tiketService->ubahStatus(
            $tiket,
            $request->user(),
            TicketStatus::SELESAI,
            $request->string('catatan')->value() ?: null
        );

        return redirect()
            ->route('irban.tiket.selesai')
            ->with('sukses', "Tiket {$tiket->kode_tiket} ditandai selesai.");
    }

    private function pastikanUnitSendiri(Ticket $tiket): void
    {
        abort_unless(
            $tiket->unit_irban_id === auth()->user()->unit_irban_id,
            403,
            'Anda tidak memiliki akses ke tiket ini.'
        );
    }
}
