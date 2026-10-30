<?php

namespace App\Http\Controllers\Irban;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $ringkasan = [
            'baru'             => Ticket::query()->visibleTo($user)->status(TicketStatus::DIPROSES)->count(),
            'menunggu_balasan' => Ticket::query()->visibleTo($user)->status(TicketStatus::MENUNGGU_BALASAN_OPD)->count(),
            'sudah_dijawab'    => Ticket::query()->visibleTo($user)->status(TicketStatus::SUDAH_DIJAWAB)->count(),
            'selesai'          => Ticket::query()->visibleTo($user)->status(TicketStatus::SELESAI)->count(),
            'total'            => Ticket::query()->visibleTo($user)->count(),
        ];

        // 5 tiket terbaru yang perlu ditangani (status aktif, diurutkan berdasarkan yang paling lama)
        $tiketBaru = Ticket::query()->visibleTo($user)
            ->status(TicketStatus::DIPROSES)
            ->with(['opd', 'category'])
            ->oldest()
            ->take(5)
            ->get();

        // 5 tiket yang menunggu balasan OPD
        $tiketMenungguBalasan = Ticket::query()->visibleTo($user)
            ->status(TicketStatus::MENUNGGU_BALASAN_OPD)
            ->with(['opd', 'category'])
            ->latest('last_reply_at')
            ->take(5)
            ->get();

        // 5 tiket terbaru yang baru saja selesai
        $tiketSelesai = Ticket::query()->visibleTo($user)
            ->status(TicketStatus::SELESAI)
            ->with(['opd', 'category'])
            ->latest('closed_at')
            ->take(5)
            ->get();

        return view('irban.dashboard', compact(
            'ringkasan',
            'tiketBaru',
            'tiketMenungguBalasan',
            'tiketSelesai',
        ));
    }
}
