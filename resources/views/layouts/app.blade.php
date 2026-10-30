<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('ekonsul.nama_instansi') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --biru-tua:  #0d2f5e;
            --biru:      #14539e;
            --biru-cerah:#2b8fd6;
            --langit:    #e8f2fb;
            --emas:      #c68a1e;
            --tinta:     #16202b;
            --abu:       #5b6b7c;
            --abu-mud:   #8695a5;
            --garis:     #e2e8f0;
            --latar-mud: #f4f7fb;
            --font: 'Plus Jakarta Sans', 'Segoe UI', Arial, sans-serif;
            --mono: 'JetBrains Mono', ui-monospace, monospace;
        }

        body {
            font-family: var(--font); background: var(--latar-mud); color: var(--tinta);
            margin: 0;
        }
        footer.kaki-app { color: var(--abu-mud); font-size: .82rem; }

        /* ============ KERANGKA ============ */
        .shell-app { display: flex; min-height: 100vh; }

        /* ============ SIDEBAR NAVY PENUH ============ */
        .sisi-app {
            width: 272px; flex-shrink: 0;
            position: sticky; top: 0; height: 100vh; overflow-y: auto;
            background:
                radial-gradient(ellipse 70% 40% at 10% 0%, rgba(43,143,214,.22) 0%, transparent 55%),
                linear-gradient(190deg, #0a2648 0%, #0d2f5e 55%, #123a6b 100%);
            color: #fff;
            display: flex; flex-direction: column;
            padding: 1.7rem 1.25rem 1.4rem;
            z-index: 40;
            transition: transform .25s ease;
        }
        .sisi-app::-webkit-scrollbar { width: 5px; }
        .sisi-app::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 10px; }

        .merek-sisi { display: flex; align-items: center; gap: .7rem; padding: 0 .3rem .5rem; margin-bottom: 1.5rem; }
        .merek-sisi img.ikon-merek-sisi { height: 38px; width: auto; }
        .merek-sisi .kotak {
            width: 38px; height: 38px; border-radius: 11px;
            background: rgba(255,255,255,.14); color: var(--emas);
            display: flex; align-items: center; justify-content: center; font-size: 1.05rem;
        }
        .merek-sisi .nama { font-weight: 800; font-size: 1.05rem; letter-spacing: -.01em; line-height: 1.1; }
        .merek-sisi .sub { font-size: .68rem; color: rgba(255,255,255,.5); margin-top: .1rem; }

        .btn-cta-sisi {
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            background: linear-gradient(135deg, var(--biru-cerah), var(--biru));
            color: #fff; font-weight: 700; font-size: .88rem;
            padding: .78rem 1rem; border-radius: 11px; margin-bottom: 1.6rem;
            box-shadow: 0 .5rem 1.1rem rgba(43,143,214,.32);
            transition: transform .2s, box-shadow .2s, filter .2s;
        }
        .btn-cta-sisi:hover { transform: translateY(-2px); filter: brightness(1.06); color: #fff; box-shadow: 0 .7rem 1.4rem rgba(43,143,214,.4); }

        .menu-sisi { display: flex; flex-direction: column; gap: .2rem; flex: 1; }
        .menu-sisi a {
            display: flex; align-items: center; gap: .75rem;
            padding: .68rem .85rem; border-radius: 10px;
            color: rgba(255,255,255,.68); font-size: .88rem; font-weight: 500;
            transition: background-color .18s, color .18s;
            position: relative;
        }
        .menu-sisi a i { font-size: 1.02rem; width: 20px; text-align: center; flex-shrink: 0; }
        .menu-sisi a:hover:not(.disabled) { background: rgba(255,255,255,.07); color: #fff; }
        .menu-sisi a.active { background: rgba(255,255,255,.13); color: #fff; font-weight: 700; }
        .menu-sisi a.active::before {
            content: ''; position: absolute; left: -1.25rem; top: 50%; transform: translateY(-50%);
            width: 3px; height: 20px; background: var(--emas); border-radius: 0 3px 3px 0;
        }
        .menu-sisi a.disabled { opacity: .38; pointer-events: none; }
        .lencana-menu {
            margin-left: auto; background: #dc3545; color: #fff;
            font-size: .66rem; font-weight: 700; padding: .1rem .4rem; border-radius: 100px;
        }

        .tag-bawah-sisi {
            margin-top: 1.4rem; padding: .8rem .9rem;
            background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1);
            border-radius: 11px; font-size: .74rem; color: rgba(255,255,255,.6);
            text-align: center; line-height: 1.5;
        }

        .tombol-tutup-sisi { display: none; }

        /* ============ AREA KONTEN ============ */
        .konten-app { flex: 1; min-width: 0; display: flex; flex-direction: column; }

        .atas-konten {
            background: #fff; border-bottom: 1px solid var(--garis);
            padding: .85rem 1.8rem; display: flex; align-items: center; justify-content: space-between;
            gap: 1rem; position: sticky; top: 0; z-index: 30;
        }
        .tombol-buka-sisi {
            display: none; background: none; border: 1px solid var(--garis); border-radius: 8px;
            padding: .4rem .65rem; color: var(--biru-tua); font-size: 1.1rem; cursor: pointer;
        }
        .kanan-atas-konten { display: flex; align-items: center; gap: .9rem; margin-left: auto; }
        .info-pengguna-atas { text-align: right; font-size: .8rem; line-height: 1.35; }
        .info-pengguna-atas .nama-pengguna { font-weight: 700; color: var(--tinta); }
        .info-pengguna-atas .peran-pengguna { color: var(--abu-mud); }

        .avatar-bulat {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--biru-tua), var(--biru));
            color: #fff; font-weight: 700; font-size: .86rem;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }

        .dropdown-akun-atas .dropdown-toggle::after { display: none; }
        .dropdown-akun-atas .btn-akun-atas {
            display: flex; align-items: center; gap: .55rem; background: none; border: none; padding: 0; cursor: pointer;
        }

        .area-utama { flex: 1; padding: 1.8rem; }

        /* ============ LONCENG NOTIFIKASI (di header terang) ============ */
        .lonceng-bungkus { position: relative; }
        .btn-lonceng {
            position: relative; background: var(--latar-mud);
            border: 1px solid var(--garis); color: var(--biru-tua);
            border-radius: .5rem; width: 38px; height: 38px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.05rem; cursor: pointer; transition: background-color .2s;
        }
        .btn-lonceng:hover { background: var(--langit); }
        .lencana-lonceng {
            position: absolute; top: -5px; right: -5px;
            min-width: 17px; height: 17px; padding: 0 4px;
            border-radius: 9px; background: #dc3545; color: #fff;
            font-size: .64rem; font-weight: 700; line-height: 17px; text-align: center;
        }

        .panel-notif {
            width: 360px; max-width: calc(100vw - 2rem);
            padding: 0; border: 1px solid var(--garis); border-radius: .8rem;
            box-shadow: 0 .8rem 2rem rgba(0,0,0,.14); overflow: hidden;
        }
        .kepala-notif {
            display: flex; justify-content: space-between; align-items: center;
            padding: .8rem 1rem; border-bottom: 1px solid #eef1f4; background: #fff;
        }
        .kepala-notif .judul-notif { font-weight: 700; font-size: .95rem; color: var(--tinta); }
        .kepala-notif .tautan-kecil { background: none; border: none; padding: 0; font-size: .78rem; color: var(--biru); cursor: pointer; }
        .kepala-notif .tautan-kecil:hover { text-decoration: underline; }

        .isi-notif { max-height: 380px; overflow-y: auto; }
        .baris-notif {
            display: flex; gap: .7rem; align-items: flex-start;
            padding: .8rem 1rem; border-bottom: 1px solid #f2f4f7;
            text-decoration: none; color: inherit; transition: background-color .18s; position: relative;
        }
        .baris-notif:last-child { border-bottom: none; }
        .baris-notif:hover { background: var(--latar-mud); }
        .baris-notif.baru { background: var(--langit); }
        .baris-notif.baru:hover { background: #ddeefb; }

        .ikon-notif {
            width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: .92rem;
        }
        .ikon-notif.warna-biru  { background: var(--langit); color: var(--biru); }
        .ikon-notif.warna-hijau { background: #e6f7ef; color: #1a7f4f; }
        .ikon-notif.warna-amber { background: #fdf3e2; color: #a8721a; }
        .ikon-notif.warna-ungu  { background: #f0ebfa; color: #6941c6; }

        .teks-notif { display: flex; flex-direction: column; gap: .12rem; min-width: 0; flex: 1; }
        .teks-notif .judul-baris { font-size: .87rem; font-weight: 700; color: var(--tinta); }
        .teks-notif .pesan-baris {
            font-size: .8rem; color: var(--abu); line-height: 1.45;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .teks-notif .waktu-baris { font-size: .72rem; color: var(--abu-mud); margin-top: .15rem; }

        .titik-baru { width: 8px; height: 8px; border-radius: 50%; background: var(--biru); flex-shrink: 0; margin-top: .45rem; }

        .kosong-notif { display: flex; flex-direction: column; align-items: center; gap: .5rem; padding: 2.4rem 1rem; color: var(--abu-mud); font-size: .87rem; }
        .kosong-notif i { font-size: 1.6rem; }

        .kaki-notif {
            display: flex; align-items: center; justify-content: center; gap: .4rem;
            padding: .75rem; background: var(--latar-mud); border-top: 1px solid #eef1f4;
            font-size: .85rem; font-weight: 700; color: var(--biru); text-decoration: none;
        }
        .kaki-notif:hover { background: var(--langit); color: var(--biru-tua); }

        /* ============ TIMELINE RIWAYAT ============ */
        .lini-riwayat { position: relative; padding-left: 1.9rem; }
        .lini-riwayat::before { content: ''; position: absolute; left: 9px; top: 6px; bottom: 6px; width: 2px; background: var(--garis); }
        .butir-riwayat { position: relative; padding-bottom: 1.15rem; }
        .butir-riwayat:last-child { padding-bottom: 0; }
        .butir-riwayat .penanda {
            position: absolute; left: -1.9rem; top: 2px; width: 20px; height: 20px; border-radius: 50%;
            background: #fff; border: 2px solid #cfd8e3;
            display: flex; align-items: center; justify-content: center; font-size: .55rem; color: #fff;
        }
        .butir-riwayat.selesai .penanda { background: #1a7f4f; border-color: #1a7f4f; }
        .butir-riwayat.kini .penanda    { background: var(--emas); border-color: var(--emas); }
        .butir-riwayat .judul-riwayat { font-size: .88rem; font-weight: 700; color: var(--tinta); }
        .butir-riwayat .rinci-riwayat { font-size: .8rem; color: var(--abu); margin-top: .12rem; line-height: 1.55; }
        .butir-riwayat .waktu-riwayat { font-size: .74rem; color: var(--abu-mud); margin-top: .2rem; }

        /* ============ RESPONSIF ============ */
        @media (max-width: 900px) {
            .sisi-app {
                position: fixed; left: 0; top: 0; bottom: 0;
                transform: translateX(-100%);
                box-shadow: 0 0 3rem rgba(0,0,0,.3);
            }
            .sisi-app.buka { transform: translateX(0); }
            .tombol-buka-sisi { display: flex; align-items: center; justify-content: center; }
            .tombol-tutup-sisi {
                display: flex; align-items: center; justify-content: center;
                background: rgba(255,255,255,.08); border: none; color: #fff;
                width: 30px; height: 30px; border-radius: 8px; margin-left: auto;
                position: absolute; top: 1.5rem; right: 1.1rem;
            }
            .info-pengguna-atas { display: none; }
        }
        @media (max-width: 560px) {
            .area-utama { padding: 1.1rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="shell-app">

        <div class="tirai-sisi" id="tiraiSisi" style="display:none; position:fixed; inset:0; background:rgba(10,20,35,.4); z-index:39;"></div>

        <aside class="sisi-app" id="sisiApp">
            <button class="tombol-tutup-sisi" id="tombolTutupSisi" aria-label="Tutup menu">
                <i class="bi bi-x-lg"></i>
            </button>

            @include('layouts.partials.sidebar')
        </aside>

        <div class="konten-app">
            <header class="atas-konten">
                <button class="tombol-buka-sisi" id="tombolBukaSisi" aria-label="Buka menu">
                    <i class="bi bi-list"></i>
                </button>

                <div class="kanan-atas-konten">
                    @include('layouts.partials.lonceng')

                    <div class="dropdown dropdown-akun-atas">
                        <button class="btn-akun-atas" type="button" data-bs-toggle="dropdown">
                            <div class="info-pengguna-atas">
                                <div class="nama-pengguna">{{ auth()->user()?->name }}</div>
                                <div class="peran-pengguna">{{ auth()->user()?->role->label() }}</div>
                            </div>
                            <div class="avatar-bulat">{{ strtoupper(substr(auth()->user()?->name ?? '?', 0, 1)) }}</div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('beranda') }}"><i class="bi bi-house"></i> Beranda Situs</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <main class="area-utama">
                @include('layouts.partials.alert')
                @yield('content')
            </main>

            <footer class="kaki-app text-center py-3">
                &copy; {{ date('Y') }} {{ config('ekonsul.nama_instansi') }}
            </footer>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            var sisi = document.getElementById('sisiApp');
            var tirai = document.getElementById('tiraiSisi');
            var tombolBuka = document.getElementById('tombolBukaSisi');
            var tombolTutup = document.getElementById('tombolTutupSisi');

            function buka() {
                sisi.classList.add('buka');
                tirai.style.display = 'block';
            }
            function tutup() {
                sisi.classList.remove('buka');
                tirai.style.display = 'none';
            }

            tombolBuka?.addEventListener('click', buka);
            tombolTutup?.addEventListener('click', tutup);
            tirai?.addEventListener('click', tutup);
        })();
    </script>
    @stack('scripts')
</body>
</html>
