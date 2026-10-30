<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TicketStatus;
use App\Exports\KonsultasiExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\UnitIrban;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $tahun  = $request->integer('tahun', now()->year);
        $bulan  = $request->integer('bulan', 0); // 0 = semua bulan

        $query = Ticket::query();

        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }

        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }

        // Ringkasan per status
        $perStatus = collect(TicketStatus::cases())
            ->mapWithKeys(fn (TicketStatus $s) => [
                $s->label() => (clone $query)->where('status', $s->value)->count(),
            ]);

        // Ringkasan per unit irban
        $perUnit = UnitIrban::query()
            ->withCount(['tickets as jumlah' => function ($q) use ($tahun, $bulan) {
                if ($tahun) $q->whereYear('created_at', $tahun);
                if ($bulan) $q->whereMonth('created_at', $bulan);
            }])
            ->ordered()
            ->get();

        // Ringkasan per kategori
        $perKategori = Category::query()
            ->withCount(['tickets as jumlah' => function ($q) use ($tahun, $bulan) {
                if ($tahun) $q->whereYear('created_at', $tahun);
                if ($bulan) $q->whereMonth('created_at', $bulan);
            }])
            ->orderByDesc('jumlah')
            ->take(10)
            ->get();

        // Tren bulanan (hanya jika tampilkan semua bulan)
        $trenBulanan = collect();
        if (! $bulan && $tahun) {
            for ($m = 1; $m <= 12; $m++) {
                $trenBulanan->push([
                    'bulan'  => $m,
                    'label'  => now()->setDate($tahun, $m, 1)->translatedFormat('M'),
                    'total'  => Ticket::query()->whereYear('created_at', $tahun)->whereMonth('created_at', $m)->count(),
                    'selesai' => Ticket::query()->whereYear('created_at', $tahun)->whereMonth('created_at', $m)->where('status', TicketStatus::SELESAI->value)->count(),
                ]);
            }
        }

        $totalTiket    = $query->count();
        $tiketSelesai  = (clone $query)->where('status', TicketStatus::SELESAI->value)->count();
        $persentaseSelesai = $totalTiket > 0 ? round(($tiketSelesai / $totalTiket) * 100) : 0;

        $daftarTahun = range(now()->year, max(2024, now()->year - 4));

        return view('admin.laporan.index', compact(
            'perStatus',
            'perUnit',
            'perKategori',
            'trenBulanan',
            'totalTiket',
            'tiketSelesai',
            'persentaseSelesai',
            'tahun',
            'bulan',
            'daftarTahun',
        ));
    }

    /**
     * Mengunduh data mentah (raw) konsultasi dalam format Excel,
     * difilter berdasarkan bulan/tahun yang dipilih Admin.
     *
     * Query yang dipakai konsisten dengan filter Dashboard/Laporan
     * agar data yang diunduh selalu sesuai dengan yang ditampilkan.
     */
    public function export(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse|RedirectResponse
    {
        $request->validate([
            'tahun' => ['nullable', 'integer', 'digits:4', 'min:2020', 'max:' . (now()->year + 1)],
            'bulan' => ['nullable', 'integer', 'min:1', 'max:12'],
        ]);

        $tahun = $request->integer('tahun') ?: now()->year;
        $bulan = $request->integer('bulan') ?: null;

        $adaData = Ticket::query()
            ->when($tahun, fn ($q) => $q->whereYear('created_at', $tahun))
            ->when($bulan, fn ($q) => $q->whereMonth('created_at', $bulan))
            ->exists();

        if (! $adaData) {
            return back()->with('gagal', 'Tidak ada data pada periode yang dipilih.');
        }

        $namaBulan = $bulan
            ? str_replace(' ', '_', strtolower(now()->setMonth($bulan)->translatedFormat('F')))
            : null;

        $namaFile = $namaBulan
            ? "dataset_konsultasi_{$namaBulan}_{$tahun}.xlsx"
            : "dataset_konsultasi_{$tahun}.xlsx";

        return Excel::download(new KonsultasiExport($tahun, $bulan), $namaFile);
    }
}
