@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<h4 class="mb-4">Laporan Konsultasi</h4>

{{-- Filter --}}
<div class="card mb-4">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label form-label-sm mb-1">Tahun</label>
                <select name="tahun" class="form-select form-select-sm">
                    @foreach ($daftarTahun as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <label class="form-label form-label-sm mb-1">Bulan</label>
                <select name="bulan" class="form-select form-select-sm">
                    <option value="0" {{ $bulan == 0 ? 'selected' : '' }}>Semua Bulan</option>
                    @foreach (range(1,12) as $m)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                            {{ now()->setDate($tahun, $m, 1)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="bi bi-funnel"></i> Terapkan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Ringkasan utama --}}
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <div class="display-6 fw-bold text-primary">{{ $totalTiket }}</div>
                <div class="text-muted small">Total Tiket</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <div class="display-6 fw-bold text-success">{{ $tiketSelesai }}</div>
                <div class="text-muted small">Tiket Selesai</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <div class="display-6 fw-bold text-info">{{ $persentaseSelesai }}%</div>
                <div class="text-muted small">Tingkat Penyelesaian</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- Per Status --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white"><strong>Distribusi Status</strong></div>
            <ul class="list-group list-group-flush">
                @forelse ($perStatus as $label => $jumlah)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $label }}
                        <span class="badge bg-light text-dark border">{{ $jumlah }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Tidak ada data.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Per Unit Irban --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white"><strong>Tiket per Unit Irban</strong></div>
            <ul class="list-group list-group-flush">
                @forelse ($perUnit as $unit)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $unit->nama }}
                        <span class="badge bg-light text-dark border">{{ $unit->jumlah }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Tidak ada data.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

{{-- Per Kategori --}}
<div class="card mb-4">
    <div class="card-header bg-white"><strong>10 Kategori Terbanyak</strong></div>
    @if ($perKategori->isEmpty())
        <div class="card-body text-muted">Tidak ada data.</div>
    @else
        <ul class="list-group list-group-flush">
            @foreach ($perKategori as $kat)
                @php $pct = $totalTiket > 0 ? round(($kat->jumlah / $totalTiket) * 100) : 0; @endphp
                <li class="list-group-item">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small">{{ $kat->nama_kategori }}</span>
                        <span class="small text-muted">{{ $kat->jumlah }} tiket ({{ $pct }}%)</span>
                    </div>
                    <div class="progress" style="height:6px;">
                        <div class="progress-bar" style="width:{{ $pct }}%"></div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>

{{-- Tren bulanan --}}
@if ($trenBulanan->isNotEmpty())
    <div class="card">
        <div class="card-header bg-white">
            <strong>Tren Bulanan {{ $tahun }}</strong>
        </div>
        <div class="table-responsive">
            <table class="table table-sm mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Bulan</th>
                        <th class="text-end">Total Tiket</th>
                        <th class="text-end">Selesai</th>
                        <th>Grafik</th>
                    </tr>
                </thead>
                <tbody>
                    @php $maxBulan = $trenBulanan->max('total') ?: 1; @endphp
                    @foreach ($trenBulanan as $bln)
                        <tr>
                            <td>{{ $bln['label'] }}</td>
                            <td class="text-end">{{ $bln['total'] }}</td>
                            <td class="text-end text-success">{{ $bln['selesai'] }}</td>
                            <td style="width:40%">
                                <div class="progress" style="height:10px;">
                                    <div class="progress-bar bg-primary"
                                         style="width:{{ $bln['total'] > 0 ? round(($bln['total'] / $maxBulan) * 100) : 0 }}%"
                                         title="{{ $bln['total'] }} total"></div>
                                    <div class="progress-bar bg-success"
                                         style="width:{{ $bln['total'] > 0 ? round(($bln['selesai'] / $maxBulan) * 100) : 0 }}%"
                                         title="{{ $bln['selesai'] }} selesai"></div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
