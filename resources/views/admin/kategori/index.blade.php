@extends('layouts.app')

@section('title', 'Kategori Konsultasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Kategori Konsultasi</h4>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle"></i> Tambah Kategori
    </a>
</div>

<div class="card">
    <div class="card-header bg-white">
        <form method="GET" class="row g-2">
            <div class="col-auto flex-grow-1">
                <input type="text" name="cari" value="{{ request('cari') }}"
                       class="form-control form-control-sm" placeholder="Cari nama kategori...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        @if ($kategori->isEmpty())
            <x-empty-state pesan="Belum ada kategori konsultasi." icon="bi-tags" />
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Slug</th>
                            <th>Unit Irban Default</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategori as $item)
                            <tr>
                                <td>{{ $item->nama_kategori }}</td>
                                <td class="font-monospace small text-muted">{{ $item->slug }}</td>
                                <td class="small">{{ $item->defaultUnitIrban?->nama ?? '—' }}</td>
                                <td class="small text-muted">{{ Str::limit($item->deskripsi, 60) ?: '—' }}</td>
                                <td>
                                    <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.kategori.edit', $item) }}"
                                       class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form method="POST" action="{{ route('admin.kategori.toggle', $item) }}" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm {{ $item->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                onclick="return confirm('{{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }} kategori ini?')">
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
                {{ $kategori->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
