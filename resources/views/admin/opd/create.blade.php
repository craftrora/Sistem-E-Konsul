@extends('layouts.app')

@section('title', 'Tambah OPD')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.opd.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0">Tambah OPD</h4>
</div>

<div class="card" style="max-width:640px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.opd.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Kode OPD <span class="text-danger">*</span></label>
                <input type="text" name="kode_opd" value="{{ old('kode_opd') }}"
                       class="form-control @error('kode_opd') is-invalid @enderror"
                       placeholder="Cth: DISDIK, DINKES">
                @error('kode_opd')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama OPD <span class="text-danger">*</span></label>
                <input type="text" name="nama_opd" value="{{ old('nama_opd') }}"
                       class="form-control @error('nama_opd') is-invalid @enderror"
                       placeholder="Nama lengkap OPD">
                @error('nama_opd')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Unit Irban Pengawas</label>
                <select name="unit_irban_id" class="form-select @error('unit_irban_id') is-invalid @enderror">
                    <option value="">— Pilih Unit Irban —</option>
                    @foreach ($unitIrban as $unit)
                        <option value="{{ $unit->id }}" {{ old('unit_irban_id') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->nama }}
                        </option>
                    @endforeach
                </select>
                @error('unit_irban_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat</label>
                <textarea name="alamat" rows="2"
                          class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
                @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">No. WhatsApp OPD</label>
                <input type="text" name="no_wa" value="{{ old('no_wa') }}"
                       class="form-control @error('no_wa') is-invalid @enderror"
                       placeholder="628xxxxxxxxxx">
                @error('no_wa')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="pendaftaran_dibuka"
                           id="pendaftaran_dibuka" value="1"
                           {{ old('pendaftaran_dibuka', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="pendaftaran_dibuka">
                        Buka pendaftaran akun untuk OPD ini
                    </label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
                <a href="{{ route('admin.opd.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
