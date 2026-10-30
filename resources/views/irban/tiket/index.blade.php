@extends('layouts.app')

@section('title', $judulHalaman)

@section('content')
<h4 class="mb-4">{{ $judulHalaman }}</h4>

<div class="card">
    <div class="card-header bg-white">
        <form method="GET" class="row g-2">
            <div class="col-auto flex-grow-1">
                <input type="text" name="cari" value="{{ request('cari') }}"
                       class="form-control form-control-sm" placeholder="Cari kode tiket atau judul...">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        @if ($tiket->isEmpty())
            <x-empty-state pesan="Tidak ada tiket pada tampilan ini." icon="bi-inbox" />
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Tiket</th>
                            <th>OPD</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tiket as $item)
                            <tr>
                                <td class="font-monospace small">{{ $item->kode_tiket }}</td>
                                <td class="small">{{ $item->opd->nama_opd }}</td>
                                <td>{{ $item->judul }}</td>
                                <td class="text-muted small">{{ $item->category->nama_kategori }}</td>
                                <td><span class="badge {{ $item->status->badge() }}">{{ $item->status->label() }}</span></td>
                                <td>
                                    <a href="{{ route('irban.tiket.show', $item) }}" class="btn btn-sm btn-outline-primary">
                                        Tinjau
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $tiket->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
