@extends('layouts.app')

@section('title', 'Kelola Tiket')

@section('content')
<h4 class="mb-4">Kelola Tiket</h4>

@if (session('sukses'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('sukses') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('gagal'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('gagal') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<ul class="nav nav-pills mb-3 flex-wrap gap-1">
    <li class="nav-item">
        <a class="nav-link {{ ! $status ? 'active' : '' }}" href="{{ route('admin.tiket.index') }}">
            Semua <span class="badge bg-light text-dark ms-1">{{ $ringkasanStatus->sum() }}</span>
        </a>
    </li>
    @foreach (\App\Enums\TicketStatus::cases() as $s)
        <li class="nav-item">
            <a class="nav-link {{ $status === $s->value ? 'active' : '' }}"
               href="{{ route('admin.tiket.index', ['status' => $s->value]) }}">
                {{ $s->label() }}
                <span class="badge bg-light text-dark ms-1">{{ $ringkasanStatus[$s->value] ?? 0 }}</span>
            </a>
        </li>
    @endforeach
</ul>

<div class="card">
    <div class="card-header bg-white">
        <form method="GET" class="row g-2">
            <input type="hidden" name="status" value="{{ $status }}">
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
            <x-empty-state pesan="Tidak ada tiket pada tampilan ini." icon="bi-ticket-detailed" />
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Tiket</th>
                            <th>OPD</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Unit Irban</th>
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
                                <td class="text-muted small">{{ $item->unitIrban?->nama ?? '—' }}</td>
                                <td><span class="badge {{ $item->status->badge() }}">{{ $item->status->label() }}</span></td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.tiket.show', $item) }}" class="btn btn-sm btn-outline-primary">
                                        Tinjau
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger ms-1"
                                            data-bs-toggle="modal" data-bs-target="#hapusTiketModal"
                                            data-kode="{{ $item->kode_tiket }}"
                                            data-url="{{ route('admin.tiket.destroy', $item) }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
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

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="hapusTiketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle text-danger me-2"></i>Hapus Tiket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">
                    Yakin ingin menghapus tiket <strong id="hapusTiketKode"></strong>?
                    Tindakan ini tidak dapat dibatalkan oleh pengguna dan seluruh riwayat percakapan pada tiket ini akan disembunyikan dari daftar.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <form id="formHapusTiket" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash me-1"></i>Ya, Hapus Tiket
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('hapusTiketModal').addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const kode   = button.getAttribute('data-kode');
        const url    = button.getAttribute('data-url');

        document.getElementById('hapusTiketKode').textContent = kode;
        document.getElementById('formHapusTiket').setAttribute('action', url);
    });
</script>
@endpush

@endsection
