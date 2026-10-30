<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Models\Ticket;
use App\Models\UnitIrban;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $statistik = [
            'total_tiket'    => Ticket::count(),
            'tiket_diproses' => Ticket::query()->status([
                TicketStatus::DIPROSES,
                TicketStatus::SUDAH_DIJAWAB,
                TicketStatus::MENUNGGU_BALASAN_OPD,
            ])->count(),
            'tiket_selesai'  => Ticket::query()->status(TicketStatus::SELESAI)->count(),
            'jumlah_opd'     => Opd::query()->active()->count(),
            'jumlah_irban'   => User::query()->role(RoleEnum::IRBAN)->active()->count(),
        ];

        $tiketMenungguVerifikasi = Ticket::query()
            ->status(TicketStatus::MENUNGGU_VERIFIKASI)
            ->latest()
            ->take(5)
            ->get();

        $unitIrban = UnitIrban::query()->active()->ordered()->get();

        return view('admin.dashboard', compact('statistik', 'tiketMenungguVerifikasi', 'unitIrban'));
    }
}
