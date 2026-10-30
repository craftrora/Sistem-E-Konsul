@extends('layouts.auth')

@section('judul', 'Masuk')

@section('isi')
<h1>Masuk ke Akun Anda</h1>
<p class="pengantar">Silakan masukkan alamat surel dan kata sandi Anda.</p>

@if (session('sukses'))
    <div class="kabar sukses">{{ session('sukses') }}</div>
@endif

@if ($errors->any())
    <div class="kabar gagal">
        @foreach ($errors->all() as $pesan)
            <div>{{ $pesan }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="kelompok">
        <label for="email">Surel</label>
        <div class="kotak-isian">
            <i class="bi bi-envelope ikon-kiri"></i>
            <input type="email" name="email" id="email"
                   class="isian @error('email') salah @enderror"
                   value="{{ old('email') }}" required autofocus autocomplete="username"
                   placeholder="Masukkan surel Anda">
        </div>
    </div>

    <div class="kelompok">
        <label for="password">Kata Sandi</label>
        <div class="kotak-isian">
            <i class="bi bi-lock ikon-kiri"></i>
            <input type="password" name="password" id="password"
                   class="isian @error('password') salah @enderror"
                   required autocomplete="current-password" placeholder="Masukkan kata sandi"
                   style="padding-right: 2.9rem;">
            <button type="button" class="lihat-sandi" id="lihatSandi"
                    tabindex="-1" aria-label="Tampilkan kata sandi">
                <i class="bi bi-eye" id="ikonSandi"></i>
            </button>
        </div>
    </div>

    <div class="centang">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Ingat saya</label>
    </div>

    <button type="submit" class="btn-kirim">
        <i class="bi bi-box-arrow-in-right"></i> Masuk
    </button>

    @if (config('ekonsul.pendaftaran.dibuka'))
        <p class="tautan-bawah">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </p>
    @endif
</form>

<script>
    (function () {
        var tombol = document.getElementById('lihatSandi');
        var kolom  = document.getElementById('password');
        var ikon   = document.getElementById('ikonSandi');

        tombol.addEventListener('click', function () {
            var sembunyi = kolom.type === 'password';
            kolom.type = sembunyi ? 'text' : 'password';
            ikon.className = sembunyi ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    })();
</script>
@endsection
