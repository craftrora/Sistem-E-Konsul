@props(['label', 'value', 'icon' => 'bi-file-earmark', 'warna' => 'biru'])

@php
    $peta = [
        'biru'   => ['bg' => '#e8f2fb', 'fg' => '#14539e'],
        'amber'  => ['bg' => '#fdf3e2', 'fg' => '#a8721a'],
        'hijau'  => ['bg' => '#e6f7ef', 'fg' => '#1a7f4f'],
        'primary'=> ['bg' => '#e8f2fb', 'fg' => '#14539e'],
        'warning'=> ['bg' => '#fdf3e2', 'fg' => '#a8721a'],
        'success'=> ['bg' => '#e6f7ef', 'fg' => '#1a7f4f'],
    ];
    $warnaAktif = $peta[$warna] ?? $peta['biru'];
@endphp

<div class="col-12 col-sm-6 col-lg-4 mb-3">
    <div class="card stat-card h-100">
        <div class="card-body d-flex align-items-center gap-3 p-4">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                 style="width:54px;height:54px;font-size:1.5rem;background:{{ $warnaAktif['bg'] }};color:{{ $warnaAktif['fg'] }};">
                <i class="bi {{ $icon }}"></i>
            </div>
            <div>
                <div class="fs-3 fw-bold" style="color:#0d2f5e;">{{ $value }}</div>
                <div class="text-muted" style="font-size:.88rem;">{{ $label }}</div>
            </div>
        </div>
    </div>
</div>
