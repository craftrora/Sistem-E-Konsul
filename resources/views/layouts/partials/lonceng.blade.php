@php
    $notifTerbaru = \App\Models\Notifikasi::query()
        ->milik(auth()->user())
        ->with('ticket')
        ->latest()
        ->take(6)
        ->get();

    $jumlahBelumBaca = \App\Models\Notifikasi::query()
        ->milik(auth()->user())
        ->belumDibaca()
        ->count();
@endphp

<div class="dropdown lonceng-bungkus">
    <button class="btn-lonceng" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
            aria-expanded="false" aria-label="Notifikasi">
        <i class="bi bi-bell"></i>
        @if ($jumlahBelumBaca > 0)
            <span class="lencana-lonceng">{{ $jumlahBelumBaca > 99 ? '99+' : $jumlahBelumBaca }}</span>
        @endif
    </button>

    <div class="dropdown-menu dropdown-menu-end panel-notif">

        <div class="kepala-notif">
            <span class="judul-notif">Notifikasi</span>
            @if ($jumlahBelumBaca > 0)
                <form method="POST" action="{{ route('notifikasi.baca-semua') }}" class="m-0">
                    @csrf
                    <button type="submit" class="tautan-kecil">Tandai semua terbaca</button>
                </form>
            @endif
        </div>

        <div class="isi-notif">
            @forelse ($notifTerbaru as $notif)
                <a href="{{ route('notifikasi.buka', $notif) }}"
                   class="baris-notif {{ $notif->sudahDibaca() ? '' : 'baru' }}">
                    <span class="ikon-notif warna-{{ $notif->tipe->warna() }}">
                        <i class="bi {{ $notif->tipe->ikon() }}"></i>
                    </span>
                    <span class="teks-notif">
                        <span class="judul-baris">{{ $notif->judul }}</span>
                        <span class="pesan-baris">{{ $notif->pesan }}</span>
                        <span class="waktu-baris">{{ $notif->created_at->diffForHumans() }}</span>
                    </span>
                    @unless ($notif->sudahDibaca())
                        <span class="titik-baru" aria-label="Belum dibaca"></span>
                    @endunless
                </a>
            @empty
                <div class="kosong-notif">
                    <i class="bi bi-bell-slash"></i>
                    <span>Belum ada notifikasi</span>
                </div>
            @endforelse
        </div>

        <a href="{{ route('notifikasi.index') }}" class="kaki-notif">
            Lihat semua notifikasi <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>
