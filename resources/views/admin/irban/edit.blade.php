@extends('layouts.app')

@section('title', 'Edit Akun Irban')

@section('content')
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.irban.show', $irban) }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0">Edit Akun — {{ $irban->name }}</h4>
</div>

<div class="card" style="max-width:640px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.irban.update', $irban) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name', $irban->name) }}"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" value="{{ old('email', $irban->email) }}"
                       class="form-control @error('email') is-invalid @enderror">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password Baru</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Kosongkan jika tidak diubah">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Unit Irban <span class="text-danger">*</span></label>
                <select name="unit_irban_id" class="form-select @error('unit_irban_id') is-invalid @enderror">
                    <option value="">— Pilih Unit Irban —</option>
                    @foreach ($unitIrban as $unit)
                        <option value="{{ $unit->id }}"
                                {{ old('unit_irban_id', $irban->unit_irban_id) == $unit->id ? 'selected' : '' }}>
                            {{ $unit->nama }}
                        </option>
                    @endforeach
                </select>
                @error('unit_irban_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan', $irban->jabatan) }}"
                       class="form-control @error('jabatan') is-invalid @enderror">
                @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">No. WhatsApp</label>
                <input type="text" name="no_wa" value="{{ old('no_wa', $irban->no_wa) }}"
                       class="form-control @error('no_wa') is-invalid @enderror">
                @error('no_wa')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Perbarui
                </button>
                <a href="{{ route('admin.irban.show', $irban) }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
