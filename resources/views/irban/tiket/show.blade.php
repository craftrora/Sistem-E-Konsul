@extends('layouts.app')

@section('title', $tiket->kode_tiket)

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('irban.tiket.baru') }}" class="btn btn-sm btn-outline-secondary">
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

        @if ($tiket->isLocked())
            <div class="alert alert-success">
                <i class="bi bi-check2-circle"></i> Tiket ini telah <strong>selesai</strong>.
            </div>
        @else
            <div class="card">
                <div class="card-header bg-white"><strong>Kirim Jawaban</strong></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('irban.tiket.balas', $tiket) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <textarea name="isi" rows="4" class="form-control @error('isi') is-invalid @enderror"
                                      required placeholder="Tulis jawaban Anda...">{{ old('isi') }}</textarea>
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
                        <div class="form-check mb-3">
                            <input type="checkbox" name="minta_info" value="1" id="mintaInfo" class="form-check-input">
                            <label for="mintaInfo" class="form-check-label small">
                                Saya membutuhkan informasi tambahan dari OPD sebelum dapat menjawab tuntas
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-send"></i> Kirim Jawaban
                        </button>
                    </form>
                </div>
            </div>
        @endif
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
            </ul>
        </div>

        <div class="mb-3">
            <x-riwayat-timeline :riwayat="$tiket->statusLogs" />
        </div>

        @if (! $tiket->isLocked())
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('irban.tiket.tutup', $tiket) }}"
                          onsubmit="return confirm('Tandai tiket ini selesai? OPD tidak akan bisa membalas lagi setelah ini.');">
                        @csrf
                        <label for="catatanTutup" class="form-label small fw-medium">Catatan Penutupan <span class="text-muted fw-normal">(opsional)</span></label>
                        <textarea name="catatan" id="catatanTutup" rows="2" class="form-control mb-2"></textarea>
                        <button type="submit" class="btn btn-outline-success w-100">
                            <i class="bi bi-check2-circle"></i> Tandai Selesai
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
