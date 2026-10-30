@extends('layouts.app')

@section('title', $tiket->kode_tiket)

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.tiket.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0">{{ $tiket->judul }}</h4>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <x-timeline-pesan :pesan="$tiket->messages" />
            </div>
        </div>

        <x-riwayat-timeline :riwayat="$tiket->statusLogs" />
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header bg-white"><strong>Informasi Tiket</strong></div>
            <ul class="list-group list-group-flush small">
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Kode Tiket</span>
                    <span class="font-monospace">{{ $tiket->kode_tiket }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="text-muted">Status</span>
                    <span class="badge {{ $tiket->status->badge() }}">{{ $tiket->status->label() }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">OPD</span>
                    <span>{{ $tiket->opd->nama_opd }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Kategori</span>
                    <span>{{ $tiket->category->nama_kategori }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Diajukan</span>
                    <span>{{ $tiket->created_at->translatedFormat('d M Y, H:i') }}</span>
                </li>
            </ul>
        </div>

        @if ($tiket->belumDiverifikasi())
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-check2-square"></i> Verifikasi &amp; Disposisi
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.tiket.disposisi', $tiket) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="unit_irban_id" class="form-label small fw-medium">Tujuan Disposisi</label>
                            <select name="unit_irban_id" id="unit_irban_id"
                                    class="form-select @error('unit_irban_id') is-invalid @enderror" required>
                                <option value="">— Pilih Unit Irban —</option>
                                @foreach ($unitIrban as $unit)
                                    <option value="{{ $unit->id }}"
                                        @selected($tiket->category->default_unit_irban_id === $unit->id)>
                                        {{ $unit->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit_irban_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($tiket->category->defaultUnitIrban)
                                <div class="form-text">
                                    Saran berdasarkan kategori: {{ $tiket->category->defaultUnitIrban->nama }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label small fw-medium">Catatan <span class="text-muted fw-normal">(opsional)</span></label>
                            <textarea name="catatan" id="catatan" rows="2" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-send-check"></i> Verifikasi &amp; Disposisikan
                        </button>
                    </form>
                </div>
            </div>
        @elseif ($tiket->status === \App\Enums\TicketStatus::SELESAI)
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.tiket.buka-kembali', $tiket) }}"
                          onsubmit="return confirm('Buka kembali tiket ini?');">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning w-100">
                            <i class="bi bi-arrow-counterclockwise"></i> Buka Kembali Tiket
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body small text-muted">
                    <i class="bi bi-diagram-3"></i> Ditangani oleh <strong>{{ $tiket->unitIrban?->nama }}</strong>.
                    Diverifikasi oleh {{ $tiket->verifier?->name }} pada
                    {{ $tiket->verified_at?->translatedFormat('d M Y, H:i') }}.
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
