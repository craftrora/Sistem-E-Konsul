<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('deskripsi', 'Layanan konsultasi elektronik Perangkat Daerah kepada Inspektorat Kabupaten Ngawi.')">
    <title>@yield('judul', 'Beranda') — E-KONSUL Inspektorat Kabupaten Ngawi</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,600;1,700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
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
            --latar:     #ffffff;
            --latar-mud: #f6f9fc;

            --font: 'Plus Jakarta Sans', system-ui, sans-serif;
            --mono: 'JetBrains Mono', ui-monospace, monospace;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: var(--font);
            color: var(--tinta);
            background: var(--latar);
            -webkit-font-smoothing: antialiased;
        }
        a { text-decoration: none; }

        .wadah { width: 100%; max-width: 1220px; margin: 0 auto; padding: 0 1.75rem; }

        /* ============ PITA ATAS ============ */
        .pita {
            background: var(--biru-tua);
            color: rgba(255,255,255,.7);
            font-size: .74rem; padding: .42rem 0;
        }
        .pita .wadah { display: flex; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
        .pita a { color: rgba(255,255,255,.7); }
        .pita a:hover { color: #fff; }

        /* ============ KOP + NAV ============ */
        .kepala {
            background: rgba(255,255,255,.94);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--garis);
            position: sticky; top: 0; z-index: 50;
            box-shadow: 0 1px 0 rgba(13,47,94,.02);
        }
        .kepala .wadah { display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; min-height: 84px; }

        .identitas-ganda { display: flex; align-items: center; gap: 1.1rem; }

        .merek { display: flex; align-items: center; gap: .8rem; }
        .merek .lambang { height: 48px; width: auto; }
        .merek .lambang-ganti {
            width: 44px; height: 44px; border-radius: 12px;
            background: linear-gradient(140deg, var(--biru-tua), var(--biru));
            color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.15rem;
        }
        .merek .nama { font-weight: 700; font-size: .98rem; letter-spacing: -.01em; color: var(--biru-tua); line-height: 1.25; }
        .merek .sub { font-size: .74rem; color: var(--abu); margin-top: .05rem; }

        .pemisah-identitas {
            width: 1px; height: 38px;
            background: linear-gradient(180deg, transparent, var(--garis) 20%, var(--garis) 80%, transparent);
        }

        .tautan-merek { display: flex; align-items: center; gap: .6rem; transition: opacity .2s; }
        .tautan-merek:hover { opacity: .8; }
        .tautan-merek .ikon-ekonsul-utama { height: 36px; width: auto; display: block; }
        .tautan-merek .kotak {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(140deg, var(--biru-tua), var(--biru));
            color: var(--emas); display: flex; align-items: center; justify-content: center; font-size: 1rem;
        }
        .tautan-merek .teks-ekonsul-utama { font-weight: 800; font-size: 1.05rem; color: var(--biru-tua); letter-spacing: -.01em; }

        .menu { display: flex; align-items: center; gap: .15rem; }
        .menu a {
            padding: .55rem .95rem; border-radius: 8px;
            color: var(--abu); font-size: .93rem; font-weight: 600;
            transition: color .18s, background-color .18s;
        }
        .menu a:hover { color: var(--biru-tua); background: var(--latar-mud); }
        .menu a.kini { color: var(--biru-tua); background: var(--langit); }

        .btn-masuk {
            background: var(--biru-tua); color: #fff;
            padding: .65rem 1.5rem; border-radius: 9px;
            font-weight: 700; font-size: .92rem;
            display: inline-flex; align-items: center; gap: .45rem;
            box-shadow: 0 .3rem .8rem rgba(13,47,94,.16);
            transition: background-color .2s, transform .2s, box-shadow .2s;
        }
        .btn-masuk:hover {
            background: var(--biru); color: #fff; transform: translateY(-1px);
            box-shadow: 0 .6rem 1.3rem rgba(13,47,94,.28);
        }

        .tombol-menu {
            display: none; background: none; border: 1px solid var(--garis);
            border-radius: 9px; padding: .5rem .7rem; font-size: 1.15rem;
            color: var(--biru-tua); cursor: pointer;
        }

        /* ============ TOMBOL UMUM ============ */
        .btn-utama {
            background: var(--biru-tua); color: #fff;
            padding: .85rem 1.8rem; border-radius: 10px;
            font-weight: 700; font-size: .98rem;
            display: inline-flex; align-items: center; gap: .5rem;
            transition: background-color .2s, transform .2s, box-shadow .2s;
        }
        .btn-utama:hover {
            background: var(--biru); color: #fff; transform: translateY(-2px);
            box-shadow: 0 .8rem 1.6rem rgba(13,47,94,.26);
        }
        .btn-garis {
            background: #fff; color: var(--biru-tua);
            padding: .85rem 1.6rem; border-radius: 10px;
            border: 1.5px solid var(--garis); font-weight: 700; font-size: .98rem;
            display: inline-flex; align-items: center; gap: .5rem;
            transition: border-color .2s, background-color .2s;
        }
        .btn-garis:hover { border-color: var(--biru-cerah); background: var(--latar-mud); color: var(--biru-tua); }

        /* ============ POTONGAN HALAMAN ============ */
        .petak { padding: 4.5rem 0; }
        .petak.terang { background: var(--latar-mud); }

        .eyebrow {
            display: inline-block;
            font-size: .74rem; font-weight: 700; letter-spacing: .1em;
            text-transform: uppercase; color: var(--biru);
            background: var(--langit); padding: .35rem .85rem; border-radius: 100px;
            margin-bottom: 1.1rem;
        }
        h1.judul-hal {
            font-size: clamp(2rem, 4.4vw, 3.1rem); font-weight: 800;
            letter-spacing: -.035em; line-height: 1.08;
            color: var(--biru-tua); margin: 0 0 1rem;
        }
        h1.judul-hal em { font-style: italic; font-weight: 700; color: var(--biru-cerah); }
        h2.judul-petak {
            font-size: clamp(1.5rem, 2.8vw, 2.1rem); font-weight: 800;
            letter-spacing: -.03em; color: var(--biru-tua); margin: 0 0 .7rem; line-height: 1.15;
        }
        .teks-pengantar { color: var(--abu); font-size: 1.02rem; line-height: 1.72; max-width: 40rem; }

        /* ============ KAKI ============ */
        .kaki { background: var(--biru-tua); color: rgba(255,255,255,.66); padding: 3.4rem 0 0; font-size: .92rem; }
        .kaki .kolom { display: grid; grid-template-columns: 1.7fr 1fr 1fr 1.4fr; gap: 2.5rem; }
        .kaki h5 { color: #fff; font-size: .8rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; margin: 0 0 1.05rem; }
        .kaki a { color: rgba(255,255,255,.66); transition: color .2s; }
        .kaki a:hover { color: var(--biru-cerah); }
        .kaki ul { list-style: none; margin: 0; padding: 0; }
        .kaki ul li { padding: .3rem 0; }
        .kaki .baris-kontak { display: flex; gap: .65rem; padding: .3rem 0; line-height: 1.6; }
        .kaki .baris-kontak i { color: var(--biru-cerah); margin-top: .25rem; }
        .kaki .merek-kaki { font-weight: 800; font-size: 1.3rem; color: #fff; letter-spacing: -.02em; }
        .kaki .baris-merek-kaki { display: flex; align-items: center; gap: .65rem; margin-bottom: .2rem; }
        .kaki .logo-kaki { height: 36px; width: auto; }
        .kaki .logo-kaki-ganti {
            width: 36px; height: 36px; border-radius: 9px;
            background: rgba(255,255,255,.12); color: #fff;
            display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;
        }
        .kaki .tutup {
            border-top: 1px solid rgba(255,255,255,.12);
            margin-top: 2.6rem; padding: 1.25rem 0;
            font-size: .82rem; color: rgba(255,255,255,.45); text-align: center;
        }

        /* ============ ANIMASI ============ */
        .nampak { opacity: 0; transform: translateY(18px); transition: opacity .65s cubic-bezier(.2,.7,.3,1), transform .65s cubic-bezier(.2,.7,.3,1); }
        .nampak.jadi { opacity: 1; transform: none; }

        /* ============ RESPONSIF ============ */
        @media (max-width: 980px) {
            .tombol-menu { display: block; }
            .kepala .wadah { position: relative; flex-wrap: wrap; }
            .menu {
                display: none; order: 3; width: 100%;
                flex-direction: column; align-items: stretch;
                padding: .5rem 0 1rem; gap: .1rem;
            }
            .menu.buka { display: flex; }
            .menu a { padding: .75rem 1rem; }
            .merek .sub { display: none; }
            .kaki .kolom { grid-template-columns: 1fr 1fr; gap: 2rem; }
        }
        @media (max-width: 560px) {
            .kaki .kolom { grid-template-columns: 1fr; }
            .pita .wadah span:last-child { display: none; }
        }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .nampak { opacity: 1; transform: none; transition: none; }
        }
    </style>
    @stack('gaya')
</head>
<body>

    <div class="pita">
        <div class="wadah">
            <span><i class="bi bi-geo-alt-fill"></i> Pemerintah Kabupaten Ngawi · Provinsi Jawa Timur</span>
            <span><i class="bi bi-clock"></i> Senin–Jumat, 07.30–15.30 WIB</span>
        </div>
    </div>

    <header class="kepala">
        <div class="wadah">
            <div class="identitas-ganda">
                <a href="{{ route('beranda') }}" class="merek">
                    @if (file_exists(public_path('assets/img/logo-ngawi.png')))
                        <img src="{{ asset('assets/img/logo-ngawi.png') }}" alt="Lambang Kabupaten Ngawi" class="lambang">
                    @else
                        <div class="lambang-ganti"><i class="bi bi-shield-shaded"></i></div>
                    @endif
                    <div>
                        <div class="nama">Pemerintah Kabupaten Ngawi</div>
                        <div class="sub">Inspektorat Daerah</div>
                    </div>
                </a>

                <span class="pemisah-identitas d-none d-sm-block" aria-hidden="true"></span>

                <a href="{{ route('beranda') }}" class="tautan-merek d-none d-sm-flex">
                    @if (file_exists(public_path('assets/img/logo-ekonsul-ikon.png')))
                        <img src="{{ asset('assets/img/logo-ekonsul-ikon.png') }}" alt="E-KONSUL" class="ikon-ekonsul-utama">
                    @else
                        <div class="kotak"><i class="bi bi-shield-check"></i></div>
                    @endif
                    <span class="teks-ekonsul-utama">E-KONSUL</span>
                </a>
            </div>

            <button class="tombol-menu" id="tombolMenu" aria-label="Buka menu" aria-expanded="false">
                <i class="bi bi-list"></i>
            </button>

            <nav class="menu" id="menuUtama">
                <a href="{{ route('beranda') }}"     class="{{ request()->routeIs('beranda') ? 'kini' : '' }}">Beranda</a>
                <a href="{{ route('kegunaan') }}"    class="{{ request()->routeIs('kegunaan') ? 'kini' : '' }}">Kegunaan</a>
                <a href="{{ route('alur') }}"        class="{{ request()->routeIs('alur') ? 'kini' : '' }}">Alur Layanan</a>
                <a href="{{ route('tanya-jawab') }}" class="{{ request()->routeIs('tanya-jawab') ? 'kini' : '' }}">Tanya Jawab</a>
                <a href="{{ route('kontak') }}"      class="{{ request()->routeIs('kontak') ? 'kini' : '' }}">Kontak</a>
            </nav>

            @auth
                @php
                    $tujuanDashboard = match (auth()->user()->role) {
                        \App\Enums\RoleEnum::ADMIN => route('admin.dashboard'),
                        \App\Enums\RoleEnum::IRBAN => route('irban.dashboard'),
                        \App\Enums\RoleEnum::OPD   => route('opd.dashboard'),
                    };
                @endphp
                <a href="{{ $tujuanDashboard }}" class="btn-masuk">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-masuk">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </a>
            @endauth
        </div>
    </header>

    <main>
        @yield('isi')
    </main>

    <footer class="kaki">
        <div class="wadah">
            <div class="kolom">
                <div>
                    <div class="baris-merek-kaki">
                        @if (file_exists(public_path('assets/img/logo-ekonsul-ikon.png')))
                            <img src="{{ asset('assets/img/logo-ekonsul-ikon.png') }}" alt="Logo E-KONSUL" class="logo-kaki">
                        @else
                            <div class="logo-kaki-ganti"><i class="bi bi-file-earmark-text"></i></div>
                        @endif
                        <div class="merek-kaki">E-KONSUL</div>
                    </div>
                    <p style="margin:.8rem 0 0; line-height:1.75;">
                        Layanan konsultasi elektronik Perangkat Daerah
                        kepada Inspektorat Kabupaten Ngawi.
                    </p>
                </div>

                <div>
                    <h5>Halaman</h5>
                    <ul>
                        <li><a href="{{ route('beranda') }}">Beranda</a></li>
                        <li><a href="{{ route('kegunaan') }}">Kegunaan</a></li>
                        <li><a href="{{ route('alur') }}">Alur Layanan</a></li>
                        <li><a href="{{ route('tanya-jawab') }}">Tanya Jawab</a></li>
                    </ul>
                </div>

                <div>
                    <h5>Layanan</h5>
                    <ul>
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                        @if (config('ekonsul.pendaftaran.dibuka'))
                            <li><a href="{{ route('register') }}">Daftar Akun</a></li>
                        @endif
                        <li><a href="{{ route('kontak') }}">Bantuan</a></li>
                    </ul>
                </div>

                <div>
                    <h5>Kantor</h5>
                    <div class="baris-kontak">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>Jalan Teuku Umar Nomor 12,<br>Ketanggi, Ngawi, Jawa Timur 63211</span>
                    </div>
                    <div class="baris-kontak">
                        <i class="bi bi-telephone-fill"></i>
                        <span>(0351) 749016</span>
                    </div>
                </div>
            </div>

            <div class="tutup">
                &copy; {{ date('Y') }} {{ config('ekonsul.nama_instansi', 'Inspektorat Kabupaten Ngawi') }}
            </div>
        </div>
    </footer>

    <script>
        (function () {
            var t = document.getElementById('tombolMenu');
            var m = document.getElementById('menuUtama');
            t.addEventListener('click', function () {
                var buka = m.classList.toggle('buka');
                t.setAttribute('aria-expanded', buka);
            });
        })();

        (function () {
            var el = document.querySelectorAll('.nampak');
            if (!('IntersectionObserver' in window)) {
                el.forEach(function (e) { e.classList.add('jadi'); });
                return;
            }
            var o = new IntersectionObserver(function (en) {
                en.forEach(function (e) {
                    if (!e.isIntersecting) return;
                    e.target.classList.add('jadi');
                    o.unobserve(e.target);
                });
            }, { threshold: .12, rootMargin: '0px 0px -50px 0px' });
            el.forEach(function (e) { o.observe(e); });
        })();
    </script>
    @stack('skrip')
</body>
</html>
