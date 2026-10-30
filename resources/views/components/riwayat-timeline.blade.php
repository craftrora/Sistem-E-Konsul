@props(['riwayat'])

@php
    use App\Enums\TicketStatus;
    // Urutkan dari terlama ke terbaru supaya alurnya terbaca runtut
    $urut = $riwayat->sortBy('created_at')->values();
    $terakhir = $urut->count() - 1;
@endphp

<div class="card">
    <div class="card-header bg-white">
        <strong><i class="bi bi-clock-history"></i> Riwayat Penanganan</strong>
    </div>
    <div class="card-body">
        @if ($urut->isEmpty())
            <p class="text-muted small mb-0">Belum ada riwayat penanganan.</p>
        @else
            <div class="lini-riwayat">
                @foreach ($urut as $i => $log)
                    @php
                        $statusBaru = TicketStatus::tryFrom($log->status_baru);
                        $statusLama = $log->status_lama ? TicketStatus::tryFrom($log->status_lama) : null;

                        $kelas = match (true) {
                            $statusBaru === TicketStatus::SELESAI => 'selesai',
                            $i === $terakhir                      => 'kini',
                            default                               => 'selesai',
                        };
                    @endphp

                    <div class="butir-riwayat {{ $kelas }}">
                        <span class="penanda">
                            @if ($kelas === 'selesai')
                                <i class="bi bi-check"></i>
                            @endif
                        </span>

                        <div class="judul-riwayat">
                            @if ($statusLama)
                                {{ $statusLama->label() }}
                                <i class="bi bi-arrow-right text-muted mx-1" style="font-size:.72rem;"></i>
                            @endif
                            {{ $statusBaru?->label() ?? $log->status_baru }}
                        </div>

                        <div class="rinci-riwayat">
                            Oleh <strong>{{ $log->user?->name ?? 'Sistem' }}</strong>
                            @if ($log->user?->role)
                                <span class="text-muted">({{ $log->user->role->label() }})</span>
                            @endif
                            @if ($log->catatan)
                                <br>{{ $log->catatan }}
                            @endif
                        </div>

                        <div class="waktu-riwayat">
                            {{ $log->created_at->translatedFormat('d F Y, H:i') }} WIB
                            &middot; {{ $log->created_at->diffForHumans() }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
