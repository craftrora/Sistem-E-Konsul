@extends('layouts.app')

@section('title', $irban->name)

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.irban.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0">{{ $irban->name }}</h4>
    <span class="badge {{ $irban->is_active ? 'bg-success' : 'bg-danger' }} ms-1">
        {{ $irban->is_active ? 'Aktif' : 'Nonaktif' }}
    </span>
</div>

<div class="card" style="max-width:540px;">
    <div class="card-header bg-white"><strong>Detail Akun Irban</strong></div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-4">Nama</dt>
            <dd class="col-sm-8">{{ $irban->name }}</dd>

            <dt class="col-sm-4">Email</dt>
            <dd class="col-sm-8">{{ $irban->email }}</dd>

            <dt class="col-sm-4">Unit Irban</dt>
            <dd class="col-sm-8">{{ $irban->unitIrban?->nama ?? '—' }}</dd>

            <dt class="col-sm-4">Jabatan</dt>
            <dd class="col-sm-8">{{ $irban->jabatan ?: '—' }}</dd>

            <dt class="col-sm-4">No. WhatsApp</dt>
            <dd class="col-sm-8">{{ $irban->no_wa ?: '—' }}</dd>

            <dt class="col-sm-4">Login Terakhir</dt>
            <dd class="col-sm-8">{{ $irban->last_login_at?->diffForHumans() ?? 'Belum pernah' }}</dd>
        </dl>
    </div>
    <div class="card-footer bg-white d-flex gap-2">
        <a href="{{ route('admin.irban.edit', $irban) }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <form method="POST" action="{{ route('admin.irban.toggle', $irban) }}">
            @csrf
            <button type="submit"
                    class="btn btn-sm {{ $irban->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"
                    onclick="return confirm('{{ $irban->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun ini?')">
                {{ $irban->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
        </form>
    </div>
</div>
@endsection
