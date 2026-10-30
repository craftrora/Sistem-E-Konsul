@props(['pesan' => 'Belum ada data.', 'icon' => 'bi-inbox', 'aksiTeks' => null, 'aksiUrl' => null])

<div class="text-center py-5 px-3">
    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
         style="width:64px;height:64px;background:#e8f2fb;color:#14539e;font-size:1.7rem;">
        <i class="bi {{ $icon }}"></i>
    </div>
    <p class="mb-0" style="color:#5b6b7c;font-size:.95rem;">{{ $pesan }}</p>

    @if ($aksiTeks && $aksiUrl)
        <a href="{{ $aksiUrl }}" class="btn btn-primary mt-3">
            <i class="bi bi-plus-circle"></i> {{ $aksiTeks }}
        </a>
    @endif
</div>
