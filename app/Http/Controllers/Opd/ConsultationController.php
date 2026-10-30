<?php

namespace App\Http\Controllers\Opd;

use App\Enums\MessageType;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReplyRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Models\Category;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConsultationController extends Controller
{
    public function __construct(private TicketService $tiketService) {}

    public function create(): View
    {
        $kategori = Category::query()->active()->orderBy('nama_kategori')->get();

        return view('opd.konsultasi.create', compact('kategori'));
    }

    public function store(StoreTicketRequest $request): RedirectResponse
    {
        $tiket = $this->tiketService->buatTiket(
            $request->user(),
            $request->validated(),
            $request->file('lampiran', [])
        );

        return redirect()
            ->route('opd.konsultasi.show', $tiket)
            ->with('sukses', "Konsultasi berhasil diajukan dengan kode tiket {$tiket->kode_tiket}.");
    }

    public function index(Request $request): View
    {
        $tiket = Ticket::query()
            ->with('category')
            ->visibleTo($request->user())
            ->status([
                TicketStatus::MENUNGGU_VERIFIKASI,
                TicketStatus::DIPROSES,
                TicketStatus::SUDAH_DIJAWAB,
                TicketStatus::MENUNGGU_BALASAN_OPD,
            ])
            ->search($request->string('cari')->value())
            ->latest()
            ->paginate(config('ekonsul.per_halaman'))
            ->withQueryString();

        return view('opd.konsultasi.index', [
            'tiket'       => $tiket,
            'judulHalaman' => 'Konsultasi Saya',
        ]);
    }

    public function riwayat(Request $request): View
    {
        $tiket = Ticket::query()
            ->with('category')
            ->visibleTo($request->user())
            ->status(TicketStatus::SELESAI)
            ->search($request->string('cari')->value())
            ->latest()
            ->paginate(config('ekonsul.per_halaman'))
            ->withQueryString();

        return view('opd.konsultasi.index', [
            'tiket'        => $tiket,
            'judulHalaman' => 'Riwayat Konsultasi',
        ]);
    }

    public function show(Ticket $tiket): View
    {
        $this->pastikanMilikSendiri($tiket);

        $tiket->load([
            'publicMessages.user',
            'publicMessages.attachments',
            'category',
            'unitIrban',
            'statusLogs.user',
        ]);

        return view('opd.konsultasi.show', compact('tiket'));
    }

    public function balas(StoreReplyRequest $request, Ticket $tiket): RedirectResponse
    {
        $this->pastikanMilikSendiri($tiket);

        $this->tiketService->balas(
            $tiket,
            $request->user(),
            $request->string('isi')->value(),
            $request->file('lampiran', []),
            MessageType::BALASAN,
            TicketStatus::DIPROSES
        );

        return back()->with('sukses', 'Balasan berhasil dikirim.');
    }

    private function pastikanMilikSendiri(Ticket $tiket): void
    {
        abort_unless($tiket->opd_id === auth()->user()->opd_id, 403, 'Anda tidak memiliki akses ke konsultasi ini.');
    }
}
