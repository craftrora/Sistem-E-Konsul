@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <h4 class="mb-0">Notifikasi</h4>

    @if ($jumlahBelum > 0)
        <form method="POST" action="{{ route('notifikasi.baca-semua') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-check2-all"></i> Tandai semua terbaca
            </button>
        </form>
    @endif
</div>

<ul class="nav nav-pills mb-3 gap-1">
    <li class="nav-item">
        <a class="nav-link {{ ! $saring ? 'active' : '' }}" href="{{ route('notifikasi.index') }}">
            Semua
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $saring === 'belum' ? 'active' : '' }}"
           href="{{ route('notifikasi.index', ['saring' => 'belum']) }}">
            Belum Dibaca
            @if ($jumlahBelum > 0)
                <span class="badge bg-light text-dark ms-1">{{ $jumlahBelum }}</span>
            @endif
        </a>
    </li>
</ul>

<div class="card">
    <div class="card-body p-0">
        @if ($notifikasi->isEmpty())
            <div class="kosong-notif" style="padding: 3.5rem 1rem;">
                <i class="bi bi-bell-slash"></i>
                <span>{{ $saring === 'belum' ? 'Tidak ada notifikasi yang belum dibaca.' : 'Belum ada notifikasi.' }}</span>
            </div>
        @else
            @foreach ($notifikasi as $notif)
                <a href="{{ route('notifikasi.buka', $notif) }}"
                   class="baris-notif {{ $notif->sudahDibaca() ? '' : 'baru' }}"
                   style="padding: 1rem 1.25rem;">
                    <span class="ikon-notif warna-{{ $notif->tipe->warna() }}">
                        <i class="bi {{ $notif->tipe->ikon() }}"></i>
                    </span>
                    <span class="teks-notif">
                        <span class="judul-baris">{{ $notif->judul }}</span>
                        <span class="pesan-baris">{{ $notif->pesan }}</span>
                        <span class="waktu-baris">
                            {{ $notif->created_at->translatedFormat('d M Y, H:i') }}
                            &middot; {{ $notif->created_at->diffForHumans() }}
                        </span>
                    </span>
                    @unless ($notif->sudahDibaca())
                        <span class="titik-baru" aria-label="Belum dibaca"></span>
                    @endunless
                </a>
            @endforeach

            <div class="p-3">
                {{ $notifikasi->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
