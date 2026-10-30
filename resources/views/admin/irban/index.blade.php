@extends('layouts.app')

@section('title', 'Akun Irban')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Akun Irban</h4>
    <a href="{{ route('admin.irban.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle"></i> Tambah Akun Irban
    </a>
</div>

<div class="card">
    <div class="card-header bg-white">
        <form method="GET" class="row g-2">
            <div class="col-auto flex-grow-1">
                <input type="text" name="cari" value="{{ request('cari') }}"
                       class="form-control form-control-sm" placeholder="Cari nama atau email...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        @if ($irban->isEmpty())
            <x-empty-state pesan="Belum ada akun Irban." icon="bi-person-badge" />
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Unit Irban</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($irban as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td class="small text-muted">{{ $item->email }}</td>
                                <td class="small">{{ $item->unitIrban?->nama ?? '—' }}</td>
                                <td class="small text-muted">{{ $item->jabatan ?: '—' }}</td>
                                <td>
                                    <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.irban.show', $item) }}"
                                       class="btn btn-sm btn-outline-primary">Detail</a>
                                    <a href="{{ route('admin.irban.edit', $item) }}"
                                       class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form method="POST" action="{{ route('admin.irban.toggle', $item) }}" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm {{ $item->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                onclick="return confirm('{{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun ini?')">
                                            {{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $irban->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
