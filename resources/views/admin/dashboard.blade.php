@extends('layouts.app')

@section('title', 'Dashboard Admin')


@push('styles')
<style>

.dashboard-title{
    font-size:1.8rem;
    font-weight:800;
    color:#102a56;
}

.dashboard-sub{
    color:#64748b;
    margin-top:5px;
}


/* EXPORT BAR */

.export-bar{
    display:flex;
    align-items:flex-end;
    gap:14px;
    margin-top:20px;
    background:white;
    border:1px solid #edf2f7;
    box-shadow:0 10px 25px rgba(15,23,42,.05);
    border-radius:16px;
    padding:18px 20px;
    flex-wrap:wrap;
}

.export-field{
    display:flex;
    flex-direction:column;
    gap:6px;
}

.export-field label{
    font-size:.8rem;
    font-weight:700;
    color:#334155;
}

.export-select{
    border:1.5px solid #e2e8f0;
    border-radius:10px;
    padding:.6rem .9rem;
    font-size:.88rem;
    color:#102a56;
    background:#fff;
    min-width:160px;
}

.export-select:focus{
    outline:none;
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,.12);
}

.btn-export{
    background:#16a34a;
    color:white;
    border:none;
    border-radius:10px;
    padding:.68rem 1.3rem;
    font-weight:700;
    font-size:.9rem;
    display:flex;
    align-items:center;
    gap:.5rem;
    margin-left:auto;
    transition:.2s;
}

.btn-export:hover{
    background:#15803d;
    color:white;
}

@media(max-width:700px){
    .export-bar{ flex-direction:column; align-items:stretch; }
    .btn-export{ margin-left:0; justify-content:center; }
}


/* STAT CARD */

.stat-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:18px;
    margin-top:25px;
}


.stat-card{
    background:white;
    border-radius:18px;
    padding:22px;
    border:1px solid #edf2f7;
    box-shadow:0 10px 25px rgba(15,23,42,.06);
    transition:.3s;
}


.stat-card:hover{
    transform:translateY(-5px);
}


.stat-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
}


.stat-icon{

    width:48px;
    height:48px;
    border-radius:14px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:22px;

}



.icon-blue{
    background:#e8f1ff;
    color:#2563eb;
}


.icon-yellow{
    background:#fff5d9;
    color:#d97706;
}


.icon-green{
    background:#dcfce7;
    color:#16a34a;
}


.icon-purple{
    background:#f3e8ff;
    color:#9333ea;
}


.icon-gray{
    background:#e5e7eb;
    color:#475569;
}



.stat-value{

    font-size:2rem;
    font-weight:800;
    margin-top:15px;
    color:#102a56;

}


.stat-label{

    color:#64748b;
    font-size:.9rem;

}



/* PANEL */

.dashboard-box{

background:white;

border-radius:20px;

border:1px solid #edf2f7;

box-shadow:
0 10px 25px rgba(15,23,42,.05);

overflow:hidden;

}


.box-header{

padding:18px 22px;

border-bottom:1px solid #edf2f7;

display:flex;

justify-content:space-between;

font-weight:800;

color:#102a56;

}




.table-modern th{

font-size:.85rem;

color:#64748b;

background:#f8fafc;

}


.table-modern td{

font-size:.9rem;

}




.irban-item{

padding:15px 20px;

border-bottom:1px solid #f1f5f9;

display:flex;

justify-content:space-between;

align-items:center;

}



.badge-ticket{

background:#f1f5f9;

border:1px solid #e2e8f0;

padding:5px 12px;

border-radius:20px;

font-size:.75rem;

font-weight:700;

}


@media(max-width:1200px){

.stat-grid{

grid-template-columns:repeat(2,1fr);

}

}


</style>
@endpush



@section('content')


<div>

<h1 class="dashboard-title">
Dashboard Admin
</h1>

<p class="dashboard-sub">
Selamat datang, berikut ringkasan informasi sistem E-KONSUL.
</p>

</div>


@if (session('gagal'))
    <div class="alert alert-danger mt-3" role="alert">
        {{ session('gagal') }}
    </div>
@endif

<form method="GET" action="{{ route('admin.laporan.export') }}" class="export-bar">

    <div class="export-field">
        <label for="export_bulan">Bulan</label>
        <select name="bulan" id="export_bulan" class="export-select">
            <option value="">Semua Bulan</option>
            @foreach (range(1, 12) as $m)
                <option value="{{ $m }}">{{ \Illuminate\Support\Carbon::create()->month($m)->translatedFormat('F') }}</option>
            @endforeach
        </select>
    </div>

    <div class="export-field">
        <label for="export_tahun">Tahun</label>
        <select name="tahun" id="export_tahun" class="export-select">
            @foreach (range(now()->year, now()->year - 4) as $y)
                <option value="{{ $y }}" @selected($y == now()->year)>{{ $y }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn-export">
        <i class="bi bi-file-earmark-excel"></i>
        Export Excel
    </button>

</form>




<!-- STATISTIK -->

<div class="stat-grid">


<div class="stat-card">

<div class="stat-top">

<div class="stat-icon icon-blue">
<i class="bi bi-inbox"></i>
</div>

</div>


<div class="stat-value">
{{ $statistik['tiket_masuk'] ?? 0 }}
</div>

<div class="stat-label">
Tiket Masuk
</div>


</div>





<div class="stat-card">

<div class="stat-top">

<div class="stat-icon icon-yellow">
<i class="bi bi-hourglass-split"></i>
</div>

</div>


<div class="stat-value">
{{ $statistik['tiket_diproses'] }}
</div>


<div class="stat-label">
Tiket Diproses
</div>


</div>





<div class="stat-card">

<div class="stat-top">

<div class="stat-icon icon-green">
<i class="bi bi-check-circle"></i>
</div>

</div>


<div class="stat-value">
{{ $statistik['tiket_selesai'] }}
</div>


<div class="stat-label">
Tiket Selesai
</div>


</div>





<div class="stat-card">

<div class="stat-top">

<div class="stat-icon icon-purple">
<i class="bi bi-ticket"></i>
</div>

</div>


<div class="stat-value">
{{ $statistik['total_tiket'] }}
</div>


<div class="stat-label">
Total Tiket
</div>


</div>





<div class="stat-card">

<div class="stat-top">

<div class="stat-icon icon-gray">
<i class="bi bi-building"></i>
</div>

</div>


<div class="stat-value">
{{ $statistik['jumlah_opd'] }}
</div>


<div class="stat-label">
Jumlah OPD
</div>


</div>



</div>





<div class="row g-4 mt-2">


<!-- TIKET -->

<div class="col-lg-6">


<div class="dashboard-box">


<div class="box-header">

<span>
<i class="bi bi-clock"></i>
Tiket Menunggu Verifikasi
</span>

<a href="#" class="text-primary small">
Lihat Semua →
</a>


</div>




@if($tiketMenungguVerifikasi->isEmpty())


<div class="text-center p-5 text-muted">

<i class="bi bi-inbox fs-1"></i>

<p class="mt-3">
Tidak ada tiket yang menunggu verifikasi.
</p>

</div>


@else


<div class="table-responsive">

<table class="table table-hover table-modern mb-0">


<thead>

<tr>

<th>No. Tiket</th>

<th>OPD Pengirim</th>

<th>Tanggal Masuk</th>

<th>Status</th>

</tr>

</thead>


<tbody>


@foreach($tiketMenungguVerifikasi as $tiket)


<tr>

<td>
{{ $tiket->kode_tiket }}
</td>


<td>
{{ $tiket->opd->nama_opd }}
</td>


<td>
{{ $tiket->created_at->format('d M Y') }}
</td>


<td>

<span class="badge-ticket">
Menunggu
</span>

</td>


</tr>


@endforeach


</tbody>


</table>

</div>


@endif



</div>


</div>






<!-- IRBAN -->


<div class="col-lg-6">


<div class="dashboard-box">


<div class="box-header">

<span>
<i class="bi bi-shield-check"></i>
Unit Irban
</span>


<a href="#" class="text-primary small">
Lihat Semua →
</a>


</div>



@foreach($unitIrban as $unit)


<div class="irban-item">


<span>
<i class="bi bi-building text-primary me-2"></i>

{{ $unit->nama }}

</span>



<span class="badge-ticket">

{{ $unit->tickets_count ?? $unit->tickets()->count() }}
tiket

</span>


</div>


@endforeach



</div>


</div>


</div>


@endsection