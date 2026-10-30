@extends('layouts.auth')

@section('judul', 'Daftar Akun')

@section('isi')
<h1>Daftar Akun Baru</h1>
<p class="pengantar">Khusus pegawai Perangkat Daerah Kabupaten Ngawi.</p>

@if ($errors->any())
    <div class="kabar gagal">
        @foreach ($errors->all() as $pesan)
            <div>{{ $pesan }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="kelompok">
        <label for="name">Nama Lengkap</label>
        <div class="kotak-isian">
            <i class="bi bi-person ikon-kiri"></i>
            <input type="text" name="name" id="name"
                   class="isian @error('name') salah @enderror"
                   value="{{ old('name') }}" required autofocus
                   placeholder="Nama sesuai data kepegawaian">
        </div>
    </div>

    <div class="kelompok">
        <label for="opd_id">Perangkat Daerah</label>
        <select name="opd_id" id="opd_id" class="pilihan polos @error('opd_id') salah @enderror" required>
            <option value="">— Pilih Perangkat Daerah —</option>
            @foreach ($daftarOpd as $opd)
                <option value="{{ $opd->id }}" @selected(old('opd_id') == $opd->id)>{{ $opd->nama_opd }}</option>
            @endforeach
        </select>
    </div>

    <div class="kelompok">
        <label for="jabatan">Jabatan</label>
        <div class="kotak-isian">
            <i class="bi bi-briefcase ikon-kiri"></i>
            <input type="text" name="jabatan" id="jabatan"
                   class="isian @error('jabatan') salah @enderror"
                   value="{{ old('jabatan') }}" required
                   placeholder="Contoh: Bendahara Pengeluaran">
        </div>
    </div>

    <div class="kelompok">
        <label for="email">Surel</label>
        <div class="kotak-isian">
            <i class="bi bi-envelope ikon-kiri"></i>
            <input type="email" name="email" id="email"
                   class="isian @error('email') salah @enderror"
                   value="{{ old('email') }}" required autocomplete="username"
                   placeholder="Masukkan surel Anda">
        </div>
    </div>

    @if (config('ekonsul.pendaftaran.wajib_kode'))
        <div class="kelompok">
            <label for="kode_pendaftaran">Kode Pendaftaran</label>
            <div class="kotak-isian">
                <i class="bi bi-key ikon-kiri"></i>
                <input type="text" name="kode_pendaftaran" id="kode_pendaftaran"
                       class="isian @error('kode_pendaftaran') salah @enderror"
                       value="{{ old('kode_pendaftaran') }}" required
                       placeholder="Kode dari Perangkat Daerah Anda">
            </div>
            <div class="bantuan">Diperoleh dari pimpinan atau operator Perangkat Daerah Anda.</div>
        </div>
    @endif

    <div class="kelompok">
        <label for="password">Kata Sandi</label>
        <div class="kotak-isian">
            <i class="bi bi-lock ikon-kiri"></i>
            <input type="password" name="password" id="password"
                   class="isian @error('password') salah @enderror"
                   required autocomplete="new-password" placeholder="Minimal 8 karakter">
        </div>
    </div>

    <div class="kelompok" style="margin-bottom: 1.6rem;">
        <label for="password_confirmation">Ulangi Kata Sandi</label>
        <div class="kotak-isian">
            <i class="bi bi-lock-fill ikon-kiri"></i>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="isian" required autocomplete="new-password" placeholder="Ketik ulang kata sandi">
        </div>
    </div>

    <button type="submit" class="btn-kirim">
        <i class="bi bi-person-plus"></i> Daftar
    </button>

    <p class="tautan-bawah">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </p>
</form>
@endsection
