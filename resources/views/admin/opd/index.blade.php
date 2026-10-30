@extends('layouts.app')

@section('title', 'Akun OPD')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Akun OPD</h4>
    <a href="{{ route('admin.opd.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle"></i> Tambah OPD
    </a>
</div>

<div class="card">
    <div class="card-header bg-white">
        <form method="GET" class="row g-2">
            <div class="col-auto flex-grow-1">
                <input type="text" name="cari" value="{{ request('cari') }}"
                       class="form-control form-control-sm" placeholder="Cari kode atau nama OPD...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        @if ($opd->isEmpty())
            <x-empty-state pesan="Belum ada data OPD." icon="bi-building" />
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Kode OPD</th>
                            <th>Nama OPD</th>
                            <th>Unit Irban</th>
                            <th>Pendaftaran</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($opd as $item)
                            <tr>
                                <td class="font-monospace small">{{ $item->kode_opd }}</td>
                                <td>{{ $item->nama_opd }}</td>
                                <td class="text-muted small">{{ $item->unitIrban?->nama ?? '—' }}</td>
                                <td>
                                    @if ($item->pendaftaran_dibuka)
                                        <span class="badge bg-success">Dibuka</span>
                                    @else
                                        <span class="badge bg-secondary">Ditutup</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.opd.show', $item) }}"
                                       class="btn btn-sm btn-outline-primary">Detail</a>
                                    <a href="{{ route('admin.opd.edit', $item) }}"
                                       class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form method="POST" action="{{ route('admin.opd.toggle', $item) }}" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm {{ $item->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                onclick="return confirm('{{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }} OPD ini?')">
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
                {{ $opd->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
