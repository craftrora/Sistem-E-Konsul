@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0">Tambah Kategori</h4>
</div>

<div class="card" style="max-width:580px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.kategori.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}"
                       class="form-control @error('nama_kategori') is-invalid @enderror"
                       placeholder="Cth: Pengelolaan Keuangan Daerah">
                <div class="form-text">Slug akan digenerate otomatis dari nama.</div>
                @error('nama_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Unit Irban Default</label>
                <select name="default_unit_irban_id"
                        class="form-select @error('default_unit_irban_id') is-invalid @enderror">
                    <option value="">— Pilih (opsional) —</option>
                    @foreach ($unitIrban as $unit)
                        <option value="{{ $unit->id }}"
                                {{ old('default_unit_irban_id') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->nama }}
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Unit Irban yang otomatis menerima tiket dengan kategori ini.</div>
                @error('default_unit_irban_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                          class="form-control @error('deskripsi') is-invalid @enderror"
                          placeholder="Deskripsi singkat kategori ini...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
