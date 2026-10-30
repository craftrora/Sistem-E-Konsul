<?php

namespace App\Http\Controllers\OPD;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Enums\TicketStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class DashboardController extends Controller
{

    public function index(): View
    {

        $user = Auth::user();


        $query = Ticket::query()
            ->where('opd_id', $user->opd_id);



        $statistik = [

            'total' => (clone $query)
                ->count(),


            'diproses' => (clone $query)
                ->status(TicketStatus::DIPROSES)
                ->count(),


            'selesai' => (clone $query)
                ->status(TicketStatus::SELESAI)
                ->count(),

        ];



        $konsultasiTerbaru = Ticket::query()
            ->where('opd_id', $user->opd_id)
            ->latest()
            ->take(5)
            ->get();



        return view('opd.dashboard', compact(
            'statistik',
            'konsultasiTerbaru'
        ));


    }


    public function panduan(): View
    {

        return view('opd.panduan');

    }

}