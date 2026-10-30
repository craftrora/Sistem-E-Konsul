@props(['lampiran'])

@if ($lampiran->isNotEmpty())
    <div class="d-flex flex-wrap gap-2 mt-2">
        @foreach ($lampiran as $berkas)
            <a href="{{ route('lampiran.unduh', $berkas) }}"
               class="d-inline-flex align-items-center gap-2 border rounded px-2 py-1 text-decoration-none small text-dark bg-light">
                <i class="bi {{ $berkas->ikon }}"></i>
                <span class="text-truncate" style="max-width: 160px;">{{ $berkas->nama_asli }}</span>
                <span class="text-muted">({{ $berkas->ukuran_terbaca }})</span>
                <i class="bi bi-download text-primary"></i>
            </a>
        @endforeach
    </div>
@endif
