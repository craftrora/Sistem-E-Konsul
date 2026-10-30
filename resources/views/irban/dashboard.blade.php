@extends('layouts.app')

@section('title','Dashboard Irban')


@push('styles')

<style>

.dashboard-title{
    font-size:26px;
    font-weight:800;
    color:#102a56;
}


.dashboard-sub{
    color:#64748b;
}


/* WELCOME */

.welcome-bar{

    background:linear-gradient(
        135deg,
        #0d2f5e,
        #2563eb
    );

    border-radius:18px;
    padding:25px 30px;
    color:white;

    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:25px;

}


.welcome-name{

    font-size:22px;
    font-weight:800;

}


.welcome-date{

    opacity:.8;
    margin-top:5px;

}


.unit-box{

    background:rgba(255,255,255,.15);
    padding:10px 18px;
    border-radius:12px;

}




/* STAT CARD */


.stat-grid{

display:grid;

grid-template-columns:repeat(5,1fr);

gap:16px;

margin-bottom:25px;

}



.stat-card{

background:white;

border-radius:18px;

padding:20px;

border:1px solid #edf2f7;

box-shadow:
0 5px 20px rgba(15,23,42,.06);

transition:.3s;

}



.stat-card:hover{

transform:translateY(-5px);

}



.stat-icon{

width:45px;
height:45px;

border-radius:14px;

display:flex;

align-items:center;

justify-content:center;

font-size:20px;

margin-bottom:15px;

}



.icon-blue{

background:#e8f1ff;
color:#2563eb;

}


.icon-yellow{

background:#fff5d9;
color:#d97706;

}


.icon-teal{

background:#d4f4f0;
color:#0f766e;

}


.icon-green{

background:#dcfce7;
color:#16a34a;

}


.icon-gray{

background:#e5e7eb;
color:#475569;

}




.stat-value{

font-size:32px;

font-weight:800;

color:#102a56;

}


.stat-label{

font-size:14px;

color:#64748b;

}




/* PANEL */


.dashboard-box{

background:white;

border-radius:18px;

border:1px solid #edf2f7;

box-shadow:
0 5px 20px rgba(15,23,42,.05);

overflow:hidden;

height:100%;

}



.box-header{

padding:18px 22px;

border-bottom:1px solid #edf2f7;

display:flex;

justify-content:space-between;

align-items:center;

font-weight:800;

color:#102a56;

}




/* CHART */


.chart-box{

background:white;

border-radius:18px;

padding:22px;

border:1px solid #edf2f7;

box-shadow:
0 5px 20px rgba(15,23,42,.05);

}



.chart-title{

font-weight:800;

color:#102a56;

margin-bottom:20px;

}




/* TABLE */


.table thead th{

background:#f8fafc;

font-size:13px;

color:#64748b;

}



.table td{

font-size:14px;

vertical-align:middle;

}



.kode{

font-weight:700;

color:#2563eb;

}




/* PROGRESS */


.progress-circle{

width:130px;

height:130px;

border-radius:50%;

background:
conic-gradient(
#16a34a 0deg,
#16a34a 220deg,
#e5e7eb 220deg
);


display:flex;

align-items:center;

justify-content:center;

margin:auto;

}



.progress-inner{

width:95px;

height:95px;

border-radius:50%;

background:white;

display:flex;

align-items:center;

justify-content:center;

font-size:25px;

font-weight:800;

color:#102a56;

}




@media(max-width:1200px){

.stat-grid{

grid-template-columns:repeat(3,1fr);

}

}


</style>

@endpush




@section('content')



<div class="welcome-bar">


<div>


<div class="welcome-name">

Selamat datang, {{ auth()->user()->name }} 👋

</div>


<div class="welcome-date">

{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}

</div>


</div>



@if(auth()->user()->unitIrban)


<div class="unit-box">

<i class="bi bi-shield-check me-2"></i>

{{ auth()->user()->unitIrban->nama }}

</div>


@endif


</div>





<div class="stat-grid">



<div class="stat-card">

<div class="stat-icon icon-blue">

<i class="bi bi-inbox-fill"></i>

</div>


<div class="stat-value">

{{ $ringkasan['baru'] }}

</div>


<div class="stat-label">

Perlu Ditangani

</div>


</div>





<div class="stat-card">

<div class="stat-icon icon-yellow">

<i class="bi bi-hourglass-split"></i>

</div>


<div class="stat-value">

{{ $ringkasan['menunggu_balasan'] }}

</div>


<div class="stat-label">

Menunggu Balasan OPD

</div>


</div>





<div class="stat-card">

<div class="stat-icon icon-teal">

<i class="bi bi-reply-fill"></i>

</div>


<div class="stat-value">

{{ $ringkasan['sudah_dijawab'] }}

</div>


<div class="stat-label">

Sudah Dijawab

</div>


</div>





<div class="stat-card">

<div class="stat-icon icon-green">

<i class="bi bi-check-circle"></i>

</div>


<div class="stat-value">

{{ $ringkasan['selesai'] }}

</div>


<div class="stat-label">

Selesai

</div>


</div>





<div class="stat-card">

<div class="stat-icon icon-gray">

<i class="bi bi-ticket-perforated"></i>

</div>


<div class="stat-value">

{{ $ringkasan['total'] }}

</div>


<div class="stat-label">

Total Tiket

</div>


</div>



</div>





<div class="row g-4 mb-4">


<div class="col-lg-7">


<div class="chart-box">


<div class="chart-title">

<i class="bi bi-graph-up"></i>

Ringkasan Tiket

</div>


<canvas id="statusChart"></canvas>


</div>


</div>




<div class="col-lg-5">


<div class="chart-box">


<div class="chart-title">

<i class="bi bi-pie-chart"></i>

Distribusi Status

</div>


<canvas id="statusPie"></canvas>


</div>


</div>


</div>




{{-- TIKET PERLU DITANGANI --}}

<div class="row g-4 mb-4">


<div class="col-lg-6">


<div class="dashboard-box">


<div class="box-header">

<span>
<i class="bi bi-inbox"></i>
Perlu Ditangani
</span>


<a href="{{ route('irban.tiket.baru') }}"
class="text-primary small">

Lihat Semua →

</a>


</div>




@if($tiketBaru->isEmpty())


<div class="text-center p-5 text-muted">

<i class="bi bi-inbox fs-1"></i>

<p class="mt-3">
Tidak ada tiket baru.
</p>


</div>



@else


<div class="table-responsive">


<table class="table mb-0">


<thead>

<tr>

<th>Kode</th>

<th>OPD</th>

<th>Kategori</th>

<th>Masuk</th>

</tr>


</thead>



<tbody>


@foreach($tiketBaru as $tiket)


<tr>


<td>

<span class="kode">

{{ $tiket->kode_tiket }}

</span>

</td>


<td>

{{ $tiket->opd->nama_opd ?? '-' }}

</td>


<td>

{{ $tiket->category->nama ?? '-' }}

</td>


<td>

{{ $tiket->created_at->diffForHumans() }}

</td>


</tr>


@endforeach


</tbody>


</table>


</div>


@endif



</div>


</div>








{{-- PROGRESS --}}


<div class="col-lg-6">


<div class="dashboard-box p-4">


<div class="box-header mb-4">

Progress Penyelesaian

</div>



@php

$persen = $ringkasan['total'] > 0

? round(($ringkasan['selesai'] / $ringkasan['total']) * 100)

: 0;

@endphp




<div class="progress-circle">


<div class="progress-inner">

{{ $persen }}%

</div>


</div>



<div class="text-center mt-4">


<h5 class="fw-bold">

{{ $ringkasan['selesai'] }}

Tiket Selesai

</h5>


<p class="text-muted">

dari {{ $ringkasan['total'] }} total tiket

</p>


</div>



</div>


</div>


</div>


{{-- BOTTOM SECTION --}}

<div class="row g-4 mb-4">


{{-- MENUNGGU BALASAN --}}

<div class="col-lg-6">


<div class="dashboard-box">


<div class="box-header">


<span>
<i class="bi bi-hourglass-split text-warning"></i>
Menunggu Balasan OPD
</span>


<a href="{{ route('irban.tiket.diproses') }}"
class="text-primary small">

Lihat Semua →

</a>


</div>



<div style="min-height:260px;">


@if($tiketMenungguBalasan->isEmpty())


<div class="text-center text-muted"
style="padding-top:80px;">


<i class="bi bi-hourglass"
style="font-size:45px;">
</i>


<p class="mt-3">
Tidak ada tiket menunggu balasan.
</p>


</div>


@else



<div class="table-responsive">


<table class="table mb-0">


<thead>

<tr>

<th>Kode</th>

<th>OPD</th>

<th>Status</th>

</tr>

</thead>


<tbody>


@foreach($tiketMenungguBalasan as $tiket)


<tr>


<td>

<span class="kode">
{{ $tiket->kode_tiket }}
</span>

</td>


<td>

{{ $tiket->opd->nama_opd ?? '-' }}

</td>


<td>

<span class="badge bg-warning">

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


</div>





{{-- SELESAI --}}


<div class="col-lg-6">


<div class="dashboard-box">



<div class="box-header">


<span>

<i class="bi bi-check-circle text-success"></i>

Tiket Selesai Terbaru

</span>


<a href="{{ route('irban.tiket.selesai') }}"
class="text-primary small">

Lihat Semua →

</a>


</div>





<div style="min-height:260px;">



@if($tiketSelesai->isEmpty())


<div class="text-center text-muted"
style="padding-top:80px;">


<i class="bi bi-check-circle"
style="font-size:45px;">
</i>


<p class="mt-3">

Belum ada tiket selesai.

</p>


</div>


@else



<div class="table-responsive">


<table class="table mb-0">


<thead>

<tr>

<th>Kode</th>

<th>OPD</th>

<th>Selesai</th>

</tr>


</thead>


<tbody>


@foreach($tiketSelesai as $tiket)


<tr>


<td>

<span class="kode">

{{ $tiket->kode_tiket }}

</span>

</td>


<td>

{{ $tiket->opd->nama_opd ?? '-' }}

</td>


<td>

{{ $tiket->updated_at->format('d M Y') }}

</td>


</tr>


@endforeach


</tbody>


</table>


</div>



@endif



</div>


</div>


</div>


</div>



{{-- CHART JS --}}


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>


new Chart(document.getElementById('statusChart'),{


type:'line',


data:{


labels:[

'Baru',
'Diproses',
'Dijawab',
'Selesai'

],


datasets:[{


label:'Jumlah Tiket',


data:[

{{ $ringkasan['baru'] }},

{{ $ringkasan['menunggu_balasan'] }},

{{ $ringkasan['sudah_dijawab'] }},

{{ $ringkasan['selesai'] }}

],


borderWidth:3,


tension:.4,


fill:false


}]


},


options:{


responsive:true,


plugins:{


legend:{


display:false


}


}


}



});





new Chart(document.getElementById('statusPie'),{


type:'doughnut',


data:{


labels:[

'Perlu Ditangani',

'Menunggu',

'Sudah Dijawab',

'Selesai'

],


datasets:[{


data:[


{{ $ringkasan['baru'] }},

{{ $ringkasan['menunggu_balasan'] }},

{{ $ringkasan['sudah_dijawab'] }},

{{ $ringkasan['selesai'] }}


]


}]


},


options:{


responsive:true


}



});



</script>



@endsection