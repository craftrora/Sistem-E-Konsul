@extends('layouts.app')

@section('title', $tiket->kode_tiket)

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('opd.konsultasi.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0">{{ $tiket->judul }}</h4>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <x-timeline-pesan :pesan="$tiket->publicMessages" />
            </div>
        </div>

        @if ($tiket->isLocked())
            <div class="alert alert-success">
                <i class="bi bi-check2-circle"></i> Konsultasi ini telah <strong>selesai</strong> dan tidak dapat dibalas lagi.
                Bila ada pertanyaan lanjutan, silakan buat konsultasi baru.
            </div>
        @elseif ($tiket->belumDiverifikasi())
            <div class="alert alert-secondary">
                <i class="bi bi-hourglass-split"></i> Konsultasi Anda sedang menunggu verifikasi oleh Admin.
                Anda dapat membalas setelah konsultasi didisposisikan ke Irban terkait.
            </div>
        @else
            <div class="card">
                <div class="card-header bg-white"><strong>Kirim Balasan</strong></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('opd.konsultasi.balas', $tiket) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <textarea name="isi" rows="4" class="form-control @error('isi') is-invalid @enderror"
                                      required placeholder="Tulis balasan Anda...">{{ old('isi') }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="file" name="lampiran[]" multiple
                                   class="form-control form-control-sm @error('lampiran.*') is-invalid @enderror"
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                            @error('lampiran.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-send"></i> Kirim Balasan
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card">
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
                    <span class="text-muted">Kategori</span>
                    <span>{{ $tiket->category->nama_kategori }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Ditangani</span>
                    <span>{{ $tiket->unitIrban?->nama ?? '—' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="text-muted">Diajukan</span>
                    <span>{{ $tiket->created_at->translatedFormat('d M Y, H:i') }}</span>
                </li>
            </ul>
        </div>

        <div class="mt-3">
            <x-riwayat-timeline :riwayat="$tiket->statusLogs" />
        </div>
    </div>
</div>
@endsection
