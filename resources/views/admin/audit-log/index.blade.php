@extends('layouts.app')

@section('title', 'Audit Log')

@section('content')
<h4 class="mb-4">Audit Log</h4>

<div class="card">
    <div class="card-header bg-white">
        <form method="GET" class="row g-2">
            <div class="col-auto flex-grow-1">
                <input type="text" name="cari" value="{{ request('cari') }}"
                       class="form-control form-control-sm" placeholder="Cari aksi, model, atau nama pengguna...">
            </div>
            <div class="col-auto">
                <select name="aksi" class="form-select form-select-sm">
                    <option value="">Semua Aksi</option>
                    @foreach ($daftarAksi as $aksi)
                        <option value="{{ $aksi }}" {{ request('aksi') === $aksi ? 'selected' : '' }}>
                            {{ $aksi }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        @if ($log->isEmpty())
            <x-empty-state pesan="Tidak ada log yang ditemukan." icon="bi-journal-text" />
        @else
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu</th>
                            <th>Pengguna</th>
                            <th>Aksi</th>
                            <th>Model</th>
                            <th>ID</th>
                            <th>IP</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($log as $item)
                            <tr>
                                <td class="small text-muted text-nowrap">
                                    {{ $item->created_at->format('d/m/Y H:i:s') }}
                                </td>
                                <td class="small">{{ $item->user?->name ?? '<sistem>' }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace small">
                                        {{ $item->aksi }}
                                    </span>
                                </td>
                                <td class="small text-muted font-monospace">
                                    {{ class_basename($item->model_type) }}
                                </td>
                                <td class="small text-muted">{{ $item->model_id }}</td>
                                <td class="small text-muted">{{ $item->ip_address }}</td>
                                <td>
                                    @if ($item->nilai_lama || $item->nilai_baru)
                                        <button type="button"
                                                class="btn btn-sm btn-outline-secondary py-0 px-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-log-{{ $item->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        {{-- Modal detail perubahan --}}
                                        <div class="modal fade" id="modal-log-{{ $item->id }}"
                                             tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">
                                                            Detail Log — {{ $item->aksi }}
                                                            <span class="text-muted small ms-1">
                                                                {{ class_basename($item->model_type) }} #{{ $item->model_id }}
                                                            </span>
                                                        </h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body row g-3">
                                                        @if ($item->nilai_lama)
                                                            <div class="col-md-6">
                                                                <div class="fw-semibold small mb-1 text-danger">Nilai Lama</div>
                                                                <pre class="bg-light rounded p-2 small mb-0" style="max-height:300px;overflow:auto;">{{ json_encode($item->nilai_lama, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                            </div>
                                                        @endif
                                                        @if ($item->nilai_baru)
                                                            <div class="col-md-6">
                                                                <div class="fw-semibold small mb-1 text-success">Nilai Baru</div>
                                                                <pre class="bg-light rounded p-2 small mb-0" style="max-height:300px;overflow:auto;">{{ json_encode($item->nilai_baru, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $log->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
