<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotifikasiController extends Controller
{
    public function index(Request $request): View
    {
        $saring = $request->query('saring');

        $query = Notifikasi::query()
            ->milik($request->user())
            ->with('ticket')
            ->latest();

        if ($saring === 'belum') {
            $query->belumDibaca();
        }

        $notifikasi = $query->paginate(20)->withQueryString();

        $jumlahBelum = Notifikasi::query()->milik($request->user())->belumDibaca()->count();

        return view('notifikasi.index', compact('notifikasi', 'jumlahBelum', 'saring'));
    }

    /**
     * Membuka notifikasi: tandai terbaca lalu arahkan ke konsultasi terkait.
     */
    public function buka(Notifikasi $notifikasi): RedirectResponse
    {
        abort_unless($notifikasi->user_id === auth()->id(), 403);

        $notifikasi->tandaiDibaca();
        $notifikasi->loadMissing(['ticket', 'user']);

        return redirect($notifikasi->tautan());
    }

    public function bacaSemua(Request $request): RedirectResponse
    {
        Notifikasi::query()
            ->milik($request->user())
            ->belumDibaca()
            ->update(['dibaca_pada' => now()]);

        return back()->with('sukses', 'Semua notifikasi telah ditandai terbaca.');
    }
}
