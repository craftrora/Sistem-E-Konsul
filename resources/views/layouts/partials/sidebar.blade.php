@php
    $ada = fn (string $r) => \Illuminate\Support\Facades\Route::has($r);
    $aktifRoute = fn (string $r) => $ada($r) && request()->routeIs($r);

    $jumlahNotif = \App\Models\Notifikasi::query()
        ->milik(auth()->user())
        ->belumDibaca()
        ->count();
@endphp

<a href="{{ auth()->user()?->isAdmin() ? route('admin.dashboard') : (auth()->user()?->isIrban() ? route('irban.dashboard') : route('opd.dashboard')) }}"
   class="merek-sisi" style="text-decoration:none; color:inherit;">
    @if (file_exists(public_path('assets/img/logo-ekonsul-ikon.png')))
        <img src="{{ asset('assets/img/logo-ekonsul-ikon.png') }}" alt="E-KONSUL" class="ikon-merek-sisi">
    @else
        <div class="kotak"><i class="bi bi-shield-check"></i></div>
    @endif
    <div>
        <div class="nama">E-KONSUL</div>
        <div class="sub">{{ config('ekonsul.nama_instansi') }}</div>
    </div>
</a>

@if (auth()->user()?->isOpd() && $ada('opd.konsultasi.create'))
    <a href="{{ route('opd.konsultasi.create') }}" class="btn-cta-sisi">
        <i class="bi bi-plus-circle"></i> Buat Konsultasi Baru
    </a>
@endif

<nav class="menu-sisi">
    @if (auth()->user()?->isOpd())
        <a href="{{ $ada('opd.dashboard') ? route('opd.dashboard') : '#' }}"
           class="{{ $aktifRoute('opd.dashboard') ? 'active' : '' }} {{ $ada('opd.dashboard') ? '' : 'disabled' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ $ada('opd.konsultasi.index') ? route('opd.konsultasi.index') : '#' }}"
           class="{{ $aktifRoute('opd.konsultasi.index') ? 'active' : '' }} {{ $ada('opd.konsultasi.index') ? '' : 'disabled' }}">
            <i class="bi bi-chat-left-text"></i> Konsultasi Saya
        </a>
        <a href="{{ $ada('opd.riwayat') ? route('opd.riwayat') : '#' }}"
           class="{{ $aktifRoute('opd.riwayat') ? 'active' : '' }} {{ $ada('opd.riwayat') ? '' : 'disabled' }}">
            <i class="bi bi-clock-history"></i> Riwayat
        </a>
        <a href="{{ route('notifikasi.index') }}" class="{{ request()->routeIs('notifikasi.index') ? 'active' : '' }}">
            <i class="bi bi-bell"></i> Notifikasi
            @if ($jumlahNotif > 0)<span class="lencana-menu">{{ $jumlahNotif }}</span>@endif
        </a>
        <a href="{{ $ada('opd.profil') ? route('opd.profil') : '#' }}"
           class="{{ $aktifRoute('opd.profil') ? 'active' : '' }} {{ $ada('opd.profil') ? '' : 'disabled' }}">
            <i class="bi bi-person"></i> Profil Saya
        </a>

    @elseif (auth()->user()?->isIrban())
        <a href="{{ $ada('irban.dashboard') ? route('irban.dashboard') : '#' }}"
           class="{{ $aktifRoute('irban.dashboard') ? 'active' : '' }} {{ $ada('irban.dashboard') ? '' : 'disabled' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ $ada('irban.tiket.baru') ? route('irban.tiket.baru') : '#' }}"
           class="{{ $aktifRoute('irban.tiket.baru') ? 'active' : '' }} {{ $ada('irban.tiket.baru') ? '' : 'disabled' }}">
            <i class="bi bi-inbox"></i> Tiket Baru
        </a>
        <a href="{{ $ada('irban.tiket.diproses') ? route('irban.tiket.diproses') : '#' }}"
           class="{{ $aktifRoute('irban.tiket.diproses') ? 'active' : '' }} {{ $ada('irban.tiket.diproses') ? '' : 'disabled' }}">
            <i class="bi bi-hourglass-split"></i> Tiket Diproses
        </a>
        <a href="{{ $ada('irban.tiket.selesai') ? route('irban.tiket.selesai') : '#' }}"
           class="{{ $aktifRoute('irban.tiket.selesai') ? 'active' : '' }} {{ $ada('irban.tiket.selesai') ? '' : 'disabled' }}">
            <i class="bi bi-check2-circle"></i> Tiket Selesai
        </a>
        <a href="{{ route('notifikasi.index') }}" class="{{ request()->routeIs('notifikasi.index') ? 'active' : '' }}">
            <i class="bi bi-bell"></i> Notifikasi
            @if ($jumlahNotif > 0)<span class="lencana-menu">{{ $jumlahNotif }}</span>@endif
        </a>

    @elseif (auth()->user()?->isAdmin())
        <a href="{{ $ada('admin.dashboard') ? route('admin.dashboard') : '#' }}"
           class="{{ $aktifRoute('admin.dashboard') ? 'active' : '' }} {{ $ada('admin.dashboard') ? '' : 'disabled' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ $ada('admin.tiket.index') ? route('admin.tiket.index') : '#' }}"
           class="{{ $aktifRoute('admin.tiket.index') ? 'active' : '' }} {{ $ada('admin.tiket.index') ? '' : 'disabled' }}">
            <i class="bi bi-ticket-detailed"></i> Kelola Tiket
        </a>
        <a href="{{ route('notifikasi.index') }}" class="{{ request()->routeIs('notifikasi.index') ? 'active' : '' }}">
            <i class="bi bi-bell"></i> Notifikasi
            @if ($jumlahNotif > 0)<span class="lencana-menu">{{ $jumlahNotif }}</span>@endif
        </a>
        <a href="{{ $ada('admin.opd.index') ? route('admin.opd.index') : '#' }}"
           class="{{ $aktifRoute('admin.opd.index') ? 'active' : '' }} {{ $ada('admin.opd.index') ? '' : 'disabled' }}">
            <i class="bi bi-building"></i> Akun OPD
        </a>
        <a href="{{ $ada('admin.irban.index') ? route('admin.irban.index') : '#' }}"
           class="{{ $aktifRoute('admin.irban.index') ? 'active' : '' }} {{ $ada('admin.irban.index') ? '' : 'disabled' }}">
            <i class="bi bi-person-badge"></i> Akun Irban
        </a>
        <a href="{{ $ada('admin.kategori.index') ? route('admin.kategori.index') : '#' }}"
           class="{{ $aktifRoute('admin.kategori.index') ? 'active' : '' }} {{ $ada('admin.kategori.index') ? '' : 'disabled' }}">
            <i class="bi bi-tags"></i> Kategori
        </a>
        <a href="{{ $ada('admin.audit-log.index') ? route('admin.audit-log.index') : '#' }}"
           class="{{ $aktifRoute('admin.audit-log.index') ? 'active' : '' }} {{ $ada('admin.audit-log.index') ? '' : 'disabled' }}">
            <i class="bi bi-journal-text"></i> Audit Log
        </a>
        <a href="{{ $ada('admin.laporan.index') ? route('admin.laporan.index') : '#' }}"
           class="{{ $aktifRoute('admin.laporan.index') ? 'active' : '' }} {{ $ada('admin.laporan.index') ? '' : 'disabled' }}">
            <i class="bi bi-bar-chart"></i> Laporan
        </a>
    @endif
</nav>

<div class="tag-bawah-sisi">
    @if (auth()->user()?->isOpd())
        Konsultasi resmi Perangkat Daerah
    @elseif (auth()->user()?->isIrban())
        Penanganan Konsultasi Resmi
    @else
        Administrasi E-KONSUL
    @endif
</div>
