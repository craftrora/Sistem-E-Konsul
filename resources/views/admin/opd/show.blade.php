@extends('layouts.app')

@section('title', $opd->nama_opd)

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.opd.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0">{{ $opd->nama_opd }}</h4>
    <span class="badge {{ $opd->is_active ? 'bg-success' : 'bg-danger' }} ms-1">
        {{ $opd->is_active ? 'Aktif' : 'Nonaktif' }}
    </span>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white"><strong>Informasi OPD</strong></div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-5">Kode OPD</dt>
                    <dd class="col-sm-7 font-monospace">{{ $opd->kode_opd }}</dd>

                    <dt class="col-sm-5">Unit Irban</dt>
                    <dd class="col-sm-7">{{ $opd->unitIrban?->nama ?? '—' }}</dd>

                    <dt class="col-sm-5">Alamat</dt>
                    <dd class="col-sm-7">{{ $opd->alamat ?: '—' }}</dd>

                    <dt class="col-sm-5">No. WhatsApp</dt>
                    <dd class="col-sm-7">{{ $opd->no_wa ?: '—' }}</dd>

                    <dt class="col-sm-5">Pendaftaran</dt>
                    <dd class="col-sm-7">
                        <span class="badge {{ $opd->pendaftaran_dibuka ? 'bg-success' : 'bg-secondary' }}">
                            {{ $opd->pendaftaran_dibuka ? 'Dibuka' : 'Ditutup' }}
                        </span>
                    </dd>

                    <dt class="col-sm-5">Kode Daftar</dt>
                    <dd class="col-sm-7">
                        <code>{{ $opd->kode_pendaftaran }}</code>
                        <form method="POST" action="{{ route('admin.opd.reset-kode', $opd) }}" class="d-inline ms-2">
                            @csrf
                            <button type="submit" class="btn btn-xs btn-outline-warning btn-sm"
                                    onclick="return confirm('Reset kode pendaftaran?')"
                                    title="Reset kode pendaftaran">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </form>
                    </dd>
                </dl>
            </div>
            <div class="card-footer bg-white d-flex gap-2">
                <a href="{{ route('admin.opd.edit', $opd) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <form method="POST" action="{{ route('admin.opd.toggle', $opd) }}">
                    @csrf
                    <button type="submit"
                            class="btn btn-sm {{ $opd->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"
                            onclick="return confirm('{{ $opd->is_active ? 'Nonaktifkan' : 'Aktifkan' }} OPD ini?')">
                        {{ $opd->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header bg-white"><strong>Akun Pengguna OPD</strong></div>
            @if ($opd->users->isEmpty())
                <div class="card-body text-muted small">Belum ada akun terdaftar.</div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach ($opd->users as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div>{{ $user->name }}</div>
                                <div class="text-muted small">{{ $user->email }}</div>
                            </div>
                            <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="card">
            <div class="card-header bg-white"><strong>Tiket Terbaru</strong></div>
            @if ($opd->tickets->isEmpty())
                <div class="card-body text-muted small">Belum ada tiket.</div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach ($opd->tickets as $tiket)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="font-monospace small text-muted">{{ $tiket->kode_tiket }}</span>
                                    <div>{{ $tiket->judul }}</div>
                                </div>
                                <span class="badge {{ $tiket->status->badge() }} ms-2">{{ $tiket->status->label() }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
