<?php

namespace App\Exports;

use App\Models\Ticket;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Ekspor data mentah (raw) konsultasi E-KONSUL ke Excel,
 * difilter berdasarkan bulan dan/atau tahun pengajuan.
 *
 * Query difokuskan agar konsisten dengan data yang tampil
 * pada Dashboard Admin dan halaman Laporan.
 */
class KonsultasiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(
        private readonly ?int $tahun = null,
        private readonly ?int $bulan = null,
    ) {}

    public function collection(): Collection
    {
        $query = Ticket::query()
            ->with([
                'opd',
                'creator',
                'category',
                'unitIrban',
                'verifier',
                'closer',
            ]);

        if ($this->tahun) {
            $query->whereYear('created_at', $this->tahun);
        }

        if ($this->bulan) {
            $query->whereMonth('created_at', $this->bulan);
        }

        return $query->orderBy('created_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID Konsultasi',
            'Nomor Tiket',
            'Tanggal Pengajuan',
            'Nama Pelapor',
            'Perangkat Daerah (OPD)',
            'Jenis Konsultasi',
            'Judul Konsultasi',
            'Status',
            'Prioritas',
            'Unit Irban',
            'Diverifikasi Oleh',
            'Tanggal Verifikasi',
            'Ditutup Oleh',
            'Tanggal Selesai',
            'Lama Penyelesaian (Hari)',
        ];
    }

    /**
     * @param Ticket $tiket
     */
    public function map($tiket): array
    {
        $lamaPenyelesaian = null;

        if ($tiket->closed_at && $tiket->created_at) {
            $lamaPenyelesaian = $tiket->created_at->diffInDays($tiket->closed_at);
        }

        return [
            $tiket->id,
            $tiket->kode_tiket,
            optional($tiket->created_at)->format('d-m-Y'),
            $tiket->creator?->name ?? '-',
            $tiket->opd?->nama_opd ?? '-',
            $tiket->category?->nama_kategori ?? '-',
            $tiket->judul,
            $tiket->status?->label() ?? '-',
            $tiket->prioritas ?? '-',
            $tiket->unitIrban?->nama ?? '-',
            $tiket->verifier?->name ?? '-',
            optional($tiket->verified_at)->format('d-m-Y'),
            $tiket->closer?->name ?? '-',
            optional($tiket->closed_at)->format('d-m-Y'),
            $lamaPenyelesaian ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'DBEAFE'],
                ],
            ],
        ];
    }
}
