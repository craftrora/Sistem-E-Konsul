<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\DispositionRequest;
use App\Models\AuditLog;
use App\Models\Ticket;
use App\Models\UnitIrban;
use App\Services\TicketService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function __construct(private TicketService $tiketService) {}

    public function index(Request $request): View
    {
        $status = $request->query('status');

        $query = Ticket::query()->with(['opd', 'category', 'unitIrban'])->latest();

        if ($status && in_array($status, TicketStatus::values(), true)) {
            $query->where('status', $status);
        }

        $tiket = $query
            ->search($request->string('cari')->value())
            ->paginate(config('ekonsul.per_halaman'))
            ->withQueryString();

        $ringkasanStatus = collect(TicketStatus::cases())
            ->mapWithKeys(fn (TicketStatus $s) => [$s->value => Ticket::query()->where('status', $s->value)->count()]);

        return view('admin.tiket.index', compact('tiket', 'ringkasanStatus', 'status'));
    }

    public function show(Ticket $tiket): View
    {
        $tiket->load(['messages.user', 'messages.attachments', 'category', 'opd', 'unitIrban', 'statusLogs.user']);

        $unitIrban = UnitIrban::query()->active()->ordered()->get();

        return view('admin.tiket.show', compact('tiket', 'unitIrban'));
    }

    public function disposisi(DispositionRequest $request, Ticket $tiket): RedirectResponse
    {
        $this->tiketService->verifikasiDanDisposisi(
            $tiket,
            $request->user(),
            $request->integer('unit_irban_id'),
            $request->string('catatan')->value() ?: null
        );

        return redirect()
            ->route('admin.tiket.show', $tiket)
            ->with('sukses', 'Tiket berhasil diverifikasi dan didisposisikan.');
    }

    public function bukaKembali(Request $request, Ticket $tiket): RedirectResponse
    {
        $this->tiketService->ubahStatus($tiket, $request->user(), TicketStatus::DIPROSES, 'Dibuka kembali oleh Admin.');

        return back()->with('sukses', 'Tiket berhasil dibuka kembali.');
    }

    /**
     * Menghapus tiket (soft delete). Data tetap tersimpan di database
     * untuk kebutuhan audit, namun tidak lagi tampil di daftar tiket.
     */
    public function destroy(Request $request, Ticket $tiket): RedirectResponse
    {
        $kodeTiket = $tiket->kode_tiket;

        AuditLog::create([
            'user_id'    => $request->user()->id,
            'aksi'       => 'hapus_tiket',
            'model_type' => Ticket::class,
            'model_id'   => $tiket->id,
            'nilai_lama' => [
                'kode_tiket' => $tiket->kode_tiket,
                'judul'      => $tiket->judul,
                'status'     => $tiket->status->value,
                'opd_id'     => $tiket->opd_id,
            ],
            'nilai_baru'  => null,
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->userAgent(),
        ]);

        $tiket->delete();

        return redirect()
            ->route('admin.tiket.index')
            ->with('sukses', "Tiket {$kodeTiket} berhasil dihapus.");
    }
}
