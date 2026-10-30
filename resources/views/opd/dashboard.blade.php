@extends('layouts.app')

@section('title','Dashboard')

@push('styles')
<style>

.dashboard-opd{
    padding-bottom:30px;
}


/* HEADER */

.header-dashboard{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
    margin-bottom:35px;
}


.header-dashboard h1{
    font-size:32px;
    font-weight:800;
    color:#102a56;
    margin-bottom:8px;
}


.header-dashboard p{
    color:#64748b;
    margin:0;
}


.header-dashboard strong{
    color:#2563eb;
}




/* BUTTON */

.btn-konsultasi{
    background:#1769ff;
    color:white;
    border-radius:12px;
    padding:12px 20px;
    font-weight:700;
    border:none;
    text-decoration:none;
    white-space:nowrap;
    flex-shrink:0;
}

.btn-konsultasi:hover{
    color:white;
    background:#155ce0;
}




/* STAT CARD */

.stat-wrapper{

    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:30px;

}



.stat-card{

    background:white;
    border-radius:22px;
    padding:25px;
    min-height:150px;
    border:1px solid #e5edf7;
    box-shadow:0 10px 25px rgba(15,23,42,.06);

}



.stat-top{

    display:flex;
    justify-content:space-between;
    align-items:center;

}



.stat-icon{

    width:48px;
    height:48px;
    border-radius:15px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;

}



.blue{
    background:#dbeafe;
    color:#2563eb;
}


.orange{
    background:#fef3c7;
    color:#f59e0b;
}


.green{
    background:#d1fae5;
    color:#10b981;
}



.stat-number{

    font-size:36px;
    font-weight:800;
    color:#102a56;
    margin-top:15px;

}



.stat-label{

    color:#64748b;
    font-size:15px;

}



.stat-link{

    margin-top:20px;
    font-size:14px;
    font-weight:700;

}



.link-blue{
    color:#2563eb;
}

.link-orange{
    color:#f59e0b;
}

.link-green{
    color:#10b981;
}



/* TABLE */


.dashboard-box{

    background:white;
    border-radius:22px;
    border:1px solid #e5edf7;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(15,23,42,.05);
    margin-bottom:25px;

}



.box-header{

    padding:20px 25px;
    border-bottom:1px solid #edf2f7;
    display:flex;
    justify-content:space-between;
    align-items:center;

}



.box-header h5{

    margin:0;
    font-weight:800;
    color:#102a56;

}



.box-header a{

    color:#2563eb;
    font-weight:600;
    text-decoration:none;

}



.table th{

    background:#f8fafc;
    color:#334155;
    padding:15px 25px;

}



.table td{

    padding:18px 25px;

}




.badge-proses{

    background:#facc15;
    color:#713f12;
    padding:5px 12px;
    border-radius:10px;
    font-size:13px;
    font-weight:700;

}



/* PANDUAN */

.guide-box{

    background:#eff6ff;
    border:1px solid #dbeafe;
    border-radius:22px;
    padding:25px;
    display:flex;
    align-items:center;
    gap:25px;

}



.guide-icon{

    width:70px;
    height:70px;
    border-radius:18px;
    background:#dbeafe;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:35px;
    color:#2563eb;

}



.guide-text h5{

    font-weight:800;
    color:#102a56;

}



.guide-text p{

    color:#64748b;
    margin:0;

}



.btn-panduan{

    margin-left:auto;
    border:1px solid #2563eb;
    color:#2563eb;
    background:white;
    border-radius:12px;
    padding:10px 18px;
    font-weight:700;
    text-decoration:none;
    white-space:nowrap;
    flex-shrink:0;

}

.btn-panduan:hover{
    background:#2563eb;
    color:white;
}



@media(max-width:900px){

.stat-wrapper{
grid-template-columns:1fr;
}

.header-dashboard{
flex-direction:column;
}

}


</style>
@endpush



@section('content')

<div class="dashboard-opd">


<div class="header-dashboard">

<div>

<h1>
Halo, {{ explode(' ',auth()->user()->name)[0] }} 👋
</h1>

<p>
Ringkasan konsultasi dan layanan 
<strong>{{ auth()->user()->opd?->nama_opd }}</strong>.
</p>

</div>


<a href="{{ route('opd.konsultasi.create') }}"
class="btn-konsultasi">

<i class="bi bi-plus-circle"></i>
Buat Konsultasi Baru

</a>


</div>

<div class="stat-wrapper">


<div class="stat-card">

<div class="stat-top">

<div class="stat-icon blue">
<i class="bi bi-chat-square-text"></i>
</div>

</div>


<div class="stat-number">
{{ $statistik['total'] ?? 0 }}
</div>


<div class="stat-label">
Total Konsultasi
</div>


<div class="stat-link link-blue">
Lihat semua →
</div>

</div>





<div class="stat-card">

<div class="stat-top">

<div class="stat-icon orange">
<i class="bi bi-hourglass-split"></i>
</div>

</div>


<div class="stat-number">
{{ $statistik['diproses'] ?? 0 }}
</div>


<div class="stat-label">
Sedang Diproses
</div>


<div class="stat-link link-orange">
Lihat status →
</div>


</div>





<div class="stat-card">

<div class="stat-top">

<div class="stat-icon green">
<i class="bi bi-check-circle"></i>
</div>

</div>


<div class="stat-number">
{{ $statistik['selesai'] ?? 0 }}
</div>


<div class="stat-label">
Selesai
</div>


<div class="stat-link link-green">
Lihat yang berhasil →
</div>


</div>


</div>







<div class="dashboard-box">


<div class="box-header">

<h5>
<i class="bi bi-clock"></i>
Konsultasi Terbaru
</h5>


<a href="{{ route('opd.konsultasi.index') }}">
Lihat semua →
</a>


</div>



<table class="table mb-0">

<thead>

<tr>

<th>Kode Tiket</th>

<th>Judul</th>

<th>Status</th>

<th>Tanggal</th>


</tr>

</thead>


<tbody>


@forelse($konsultasiTerbaru as $item)


<tr>


<td>
{{ $item->kode_tiket }}
</td>


<td>
{{ $item->judul }}
</td>


<td>

<span class="badge-proses">
{{ $item->status->label() }}
</span>

</td>


<td>

{{ $item->created_at->format('d M Y') }}

</td>


</tr>


@empty


<tr>

<td colspan="4" class="text-center py-5">

Belum ada konsultasi

</td>

</tr>


@endforelse


</tbody>


</table>


</div>







<div class="guide-box">


<div class="guide-icon">

<i class="bi bi-search"></i>

</div>



<div class="guide-text">

<h5>
Belum tahu cara mulai?
</h5>


<p>

Klik "Buat Konsultasi Baru" di atas, isi judul singkat, pilih kategori yang paling sesuai, lalu jelaskan pertanyaan Anda.

</p>


</div>



<a href="{{ route('opd.panduan') }}" class="btn-panduan">

<i class="bi bi-chat-square-text"></i>

Panduan Penggunaan

</a>



</div>



</div>

@endsection