@extends('layouts.publik')

@section('judul', 'Beranda')

@push('gaya')
<style>
    /* ==================== HERO ==================== */
    .hero {
        position: relative;
        background: linear-gradient(170deg, #eef4fb 0%, #f7fafd 55%, #eef4fb 100%);
        padding: 3.6rem 0 5.4rem;
        overflow: hidden;
        border-bottom: 1px solid var(--garis);
    }
    .hero .wadah { position: relative; z-index: 3; }
    .hero .susun { display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: center; }
    .hero .aksi { display: flex; gap: .7rem; flex-wrap: wrap; margin-top: 1.9rem; }

    .catatan-kaki-hero {
        display: flex; gap: 1.8rem; flex-wrap: wrap;
        margin-top: 2.3rem; padding-top: 1.3rem;
        border-top: 1px solid rgba(13,47,94,.1);
    }
    .catatan-kaki-hero .butir { display: flex; align-items: center; gap: .5rem; font-size: .82rem; color: var(--abu); font-weight: 500; }
    .catatan-kaki-hero .ikon-mini {
        width: 26px; height: 26px; border-radius: 8px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: .78rem;
        background: var(--langit); color: var(--biru);
    }

    /* ==================== BACKGROUND GEDUNG ==================== */

.siluet-gedung{
    position:absolute;

    width:100%;
    max-width:1180px;

    height:100%;

    left:50%;
    top:0;

    transform:translateX(-50%);

    overflow:hidden;

    z-index:1;

    pointer-events:none;
}

.gambar-kantor{

    width:100%;
    height:100%;

    object-fit:contain;

    object-position:center center;

    opacity:.20;

    filter:brightness(1.1);

}

.siluet-gedung::after{
    content:"";
    position:absolute;
    inset:0;

    background:rgba(255,255,255,.60);

    z-index:2;
}

.siluet-gedung::after{
    content:"";
    position:absolute;
    inset:0;

    background:
        linear-gradient(
            to bottom,
            rgba(255,255,255,.72),
            rgba(255,255,255,.85)
        );
}
    /* ==================== PANGGUNG ILUSTRASI ==================== */
    .panggung { position: relative; z-index: 2; aspect-ratio: 600/460; width: 100%; max-width: 560px; margin: 0 auto; }
    .panggung-svg { position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; }

    .lencana-apung { animation: apungLencana 5.5s ease-in-out infinite; }
    .lencana-apung.d2 { animation-delay: .7s; }
    .lencana-apung.d3 { animation-delay: 1.4s; }
    .lencana-apung.d4 { animation-delay: 2.1s; }
    @keyframes apungLencana { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-9px); } }

    .putar-jalur { transform-origin: 300px 230px; animation: putarPelan 40s linear infinite; }
    @keyframes putarPelan { to { transform: rotate(360deg); } }

    .kedip-kilau { animation: kedipKilau 2.4s ease-in-out infinite; }
    @keyframes kedipKilau { 0%,100% { opacity: .35; transform: scale(.85); } 50% { opacity: 1; transform: scale(1.1); } }

    /* ==================== KEGUNAAN ==================== */
    .petak-guna { padding: 4.2rem 0; background: var(--latar); }
    .grid-guna { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.4rem; }

    .kartu-guna {
        background: #fff; border: 1px solid var(--garis); border-radius: 18px;
        padding: 2.1rem 1.7rem 1.7rem; text-align: center;
        transition: transform .3s cubic-bezier(.2,.8,.3,1), box-shadow .3s, border-color .3s;
    }
    .kartu-guna:hover { transform: translateY(-7px); box-shadow: 0 1.2rem 2.6rem rgba(13,47,94,.11); border-color: #cfe0f0; }

    .ikon-guna-bungkus { position: relative; width: 76px; height: 76px; margin: 0 auto 1.2rem; }
    .ikon-guna-utama {
        width: 76px; height: 76px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.7rem; transition: transform .3s;
    }
    .kartu-guna:hover .ikon-guna-utama { transform: scale(1.08) rotate(-4deg); }
    .ikon-guna-lencana {
        position: absolute; right: -2px; bottom: -2px;
        width: 26px; height: 26px; border-radius: 50%;
        background: var(--emas); color: var(--biru-tua);
        display: flex; align-items: center; justify-content: center;
        font-size: .78rem; border: 2.5px solid #fff;
    }

    .guna-biru  .ikon-guna-utama { background: var(--langit); color: var(--biru); }
    .guna-emas  .ikon-guna-utama { background: #fdf3e2; color: #c68a1e; }
    .guna-navy  .ikon-guna-utama { background: #e9edf5; color: var(--biru-tua); }

    .kartu-guna h3 { font-size: 1.08rem; font-weight: 700; color: var(--biru-tua); margin: 0 0 .5rem; letter-spacing: -.018em; }
    .kartu-guna p { font-size: .87rem; color: var(--abu); line-height: 1.65; margin: 0 0 1.3rem; }

    .nomor-guna {
        display: flex; align-items: center; justify-content: center; gap: .6rem;
        font-family: var(--mono); font-size: .78rem; font-weight: 700; color: var(--biru-cerah);
    }
    .nomor-guna::before, .nomor-guna::after {
        content: ''; height: 1px; width: 34px; background: var(--garis);
    }

    /* ==================== ALUR LAYANAN (terang, bergaris) ==================== */
    .petak-alur-terang { padding: 4.2rem 0; background: var(--latar-mud); }

    .baris-alur { position: relative; display: grid; grid-template-columns: repeat(5, 1fr); gap: .5rem; }
    .garis-alur {
        position: absolute; top: 34px; left: 10%; right: 10%; height: 2px;
        background: repeating-linear-gradient(90deg, var(--garis) 0 6px, transparent 6px 12px);
        z-index: 0;
    }
    .langkah-alur { position: relative; z-index: 1; text-align: center; padding: 0 .4rem; }
    .lingkaran-alur {
        width: 68px; height: 68px; border-radius: 50%; margin: 0 auto 1rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; background: #fff; color: var(--biru);
        border: 2px solid var(--langit);
        box-shadow: 0 .5rem 1.2rem rgba(13,47,94,.09);
        transition: transform .3s cubic-bezier(.2,.8,.3,1), background-color .3s, color .3s, border-color .3s;
    }
    .langkah-alur:hover .lingkaran-alur {
        transform: scale(1.1);
        background: var(--biru-tua); color: #fff; border-color: var(--biru-tua);
    }
    .langkah-alur h4 { font-size: .93rem; font-weight: 700; color: var(--biru-tua); margin: 0 0 .4rem; letter-spacing: -.015em; }
    .langkah-alur p { font-size: .78rem; color: var(--abu); line-height: 1.55; margin: 0; }

    /* ==================== CTA BERGAMBAR ==================== */
    .ajakan-gambar {
        background: linear-gradient(135deg, var(--biru-tua) 0%, var(--biru) 100%);
        border-radius: 22px; padding: 0; overflow: hidden; position: relative;
    }
    .ajakan-gambar::before {
        content: ''; position: absolute; inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,.05) 1px, transparent 1px);
        background-size: 26px 26px; pointer-events: none;
    }
    .susun-ajakan { display: grid; grid-template-columns: .8fr 1.2fr; align-items: center; gap: 1rem; position: relative; z-index: 2; }
    .ilustrasi-ajakan { display: flex; align-items: center; justify-content: center; padding: 2rem 1rem; }
    .ilustrasi-ajakan svg { width: 100%; max-width: 210px; height: auto; }
    .teks-ajakan { padding: 2.4rem 2.2rem 2.4rem 0; }
    .teks-ajakan h2 { color: #fff; font-size: clamp(1.35rem, 2.6vw, 1.8rem); font-weight: 800; letter-spacing: -.028em; margin: 0 0 .55rem; }
    .teks-ajakan p { color: rgba(255,255,255,.76); font-size: .93rem; margin: 0 0 1.5rem; line-height: 1.6; }
    .aksi-ajakan { display: flex; gap: .7rem; flex-wrap: wrap; }
    .btn-ajakan-terang {
        background: #fff; color: var(--biru-tua); padding: .75rem 1.5rem; border-radius: 10px;
        font-weight: 700; font-size: .9rem; display: inline-flex; align-items: center; gap: .5rem;
        transition: transform .2s, box-shadow .2s;
    }
    .btn-ajakan-terang:hover { transform: translateY(-2px); box-shadow: 0 .7rem 1.5rem rgba(0,0,0,.2); color: var(--biru-tua); }
    .btn-ajakan-garis {
        border: 1.5px solid rgba(255,255,255,.4); color: #fff; padding: .75rem 1.4rem; border-radius: 10px;
        font-weight: 700; font-size: .9rem; display: inline-flex; align-items: center; gap: .5rem;
        transition: background-color .2s, border-color .2s;
    }
    .btn-ajakan-garis:hover { background: rgba(255,255,255,.12); border-color: rgba(255,255,255,.6); color: #fff; }

    @media (max-width: 980px) {
        .hero .susun { grid-template-columns: 1fr; gap: 2.4rem; }
        .grid-guna { grid-template-columns: 1fr; }
        .baris-alur { grid-template-columns: repeat(1, 1fr); gap: 1.6rem; }
        .garis-alur { display: none; }
        .susun-ajakan { grid-template-columns: 1fr; text-align: center; }
        .ilustrasi-ajakan { padding-top: 2.2rem; }
        .teks-ajakan { padding: 0 1.8rem 2.2rem; }
        .aksi-ajakan { justify-content: center; }
    }
    @media (prefers-reduced-motion: reduce) {
        .lencana-apung, .putar-jalur, .kedip-kilau { animation: none; }
        .kartu-guna, .langkah-alur .lingkaran-alur { transition: none; }
    }
</style>
@endpush

@section('isi')

{{-- ==================== HERO ==================== --}}
<section class="hero" id="beranda">

    <div class="siluet-gedung">

    <img
    src="{{ asset('assets/img/kantor.png') }}"
    class="gambar-kantor"
    alt="Gedung Inspektorat">

</div>

    <div class="wadah">
        <div class="susun">

            <div>
                <span class="eyebrow">Layanan Konsultasi Elektronik</span>

                <h1 class="judul-hal">
                    Konsultasi Pengawasan<br>
                    yang <em>Tercatat</em>
                </h1>

                <p class="teks-pengantar">
                    Sarana resmi Perangkat Daerah menyampaikan konsultasi kepada Inspektorat
                    Kabupaten Ngawi. Setiap pengajuan memperoleh nomor register dan
                    ditindaklanjuti oleh Inspektur Pembantu sesuai wilayah kerja.
                </p>

                <div class="aksi">
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isIrban() ? route('irban.dashboard') : route('opd.dashboard')) }}"
                           class="btn-utama">
                            <i class="bi bi-speedometer2"></i> Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-utama">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem
                        </a>
                        @if (config('ekonsul.pendaftaran.dibuka'))
                            <a href="{{ route('register') }}" class="btn-garis">
                                <i class="bi bi-person-plus"></i> Daftar Akun
                            </a>
                        @endif
                    @endauth
                </div>

                <div class="catatan-kaki-hero">
                    <div class="butir"><span class="ikon-mini"><i class="bi bi-hash"></i></span> Nomor Register Otomatis</div>
                    <div class="butir"><span class="ikon-mini"><i class="bi bi-bell"></i></span> Pemberitahuan Real-time</div>
                    <div class="butir"><span class="ikon-mini"><i class="bi bi-folder2"></i></span> Riwayat Tersimpan Permanen</div>
                </div>
            </div>

            {{-- ===== ILUSTRASI: laptop + dokumen + lencana melayang ===== --}}
            <div class="panggung" role="img" aria-label="Ilustrasi alur konsultasi: diajukan, diverifikasi, diproses Irban, dan mendapat jawaban">
                <svg class="panggung-svg" viewBox="0 0 600 460" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">

                    {{-- jalur melingkar putus-putus, berputar pelan --}}
                    <g class="putar-jalur">
                        <circle cx="300" cy="230" r="168" fill="none" stroke="#bcdaf3" stroke-width="2" stroke-dasharray="3 10" stroke-linecap="round"/>
                    </g>

                    {{-- meja/alas --}}
                    <ellipse cx="300" cy="410" rx="200" ry="18" fill="#dbe6f1" opacity=".5"/>

                    {{-- rak folder kiri --}}
                    <g transform="translate(118 250)">
                        <rect x="0" y="30" width="16" height="90" rx="2" fill="#0d2f5e"/>
                        <rect x="20" y="20" width="16" height="100" rx="2" fill="#14539e"/>
                        <rect x="40" y="35" width="16" height="85" rx="2" fill="#2b8fd6"/>
                    </g>

                    {{-- tanaman kanan --}}
                    <g transform="translate(452 275)">
                        <rect x="10" y="55" width="34" height="30" rx="4" fill="#c68a1e"/>
                        <path d="M27 55 C10 40 10 15 27 4 C44 15 44 40 27 55 Z" fill="#2d7359"/>
                        <path d="M27 55 C16 44 16 26 27 16 C38 26 38 44 27 55 Z" fill="#3c9068"/>
                    </g>

                    {{-- badan laptop --}}
                    <g>
                        <rect x="190" y="150" width="220" height="150" rx="10" fill="#0d2f5e"/>
                        <rect x="202" y="162" width="196" height="118" rx="4" fill="#e8f2fb"/>
                        <path d="M160 300 L440 300 L410 330 L190 330 Z" fill="#14539e"/>
                        <rect x="160" y="300" width="280" height="10" rx="4" fill="#0d2f5e"/>
                    </g>

                    {{-- dokumen "KONSULTASI" bertumpuk di atas laptop --}}
                    <g transform="translate(228 118)">
                        <rect x="10" y="14" width="120" height="150" rx="8" fill="#dbe6f1"/>
                        <rect x="0" y="0" width="120" height="150" rx="8" fill="#ffffff" stroke="#e2e8f0"/>
                        <text x="60" y="30" text-anchor="middle" font-family="JetBrains Mono, monospace" font-size="10.5" font-weight="700" fill="#0d2f5e" letter-spacing="1">KONSULTASI</text>
                        <line x1="14" y1="42" x2="106" y2="42" stroke="#e2e8f0" stroke-width="1.5"/>
                        <rect x="14" y="56" width="92" height="7" rx="3.5" fill="#dbe6f1"/>
                        <rect x="14" y="72" width="92" height="7" rx="3.5" fill="#dbe6f1"/>
                        <rect x="14" y="88" width="65" height="7" rx="3.5" fill="#dbe6f1"/>
                        <path d="M22 118 C 30 112, 38 122, 46 114 S 60 110, 68 118" stroke="#2b8fd6" stroke-width="2.2" fill="none" stroke-linecap="round"/>

                        {{-- lencana centang hijau di sudut dokumen --}}
                        <circle cx="98" cy="128" r="20" fill="#1a7f4f"/>
                        <path d="M89 128 l6 7 l13 -15" stroke="#fff" stroke-width="3.2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>

                    {{-- kilau dekoratif --}}
                    <g class="kedip-kilau" transform="translate(372 108)">
                        <path d="M6 0 L8 4 L12 6 L8 8 L6 12 L4 8 L0 6 L4 4 Z" fill="#c68a1e"/>
                    </g>
                    <g class="kedip-kilau" style="animation-delay:1.1s" transform="translate(150 340)">
                        <path d="M5 0 L6.5 3.5 L10 5 L6.5 6.5 L5 10 L3.5 6.5 L0 5 L3.5 3.5 Z" fill="#2b8fd6"/>
                    </g>

                    {{-- ===== 4 lencana melayang ===== --}}

                    {{-- kiri atas: Ajukan Konsultasi --}}
                    <g class="lencana-apung d1">
                        <circle cx="108" cy="118" r="34" fill="#e8f2fb"/>
                        <foreignObject x="88" y="98" width="40" height="40">
                            <div xmlns="http://www.w3.org/1999/xhtml" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#14539e;">
                                <i class="bi bi-chat-left-text"></i>
                            </div>
                        </foreignObject>
                    </g>
                    <text x="108" y="168" text-anchor="middle" font-family="Plus Jakarta Sans, sans-serif" font-size="12" font-weight="700" fill="#0d2f5e">Ajukan</text>
                    <text x="108" y="182" text-anchor="middle" font-family="Plus Jakarta Sans, sans-serif" font-size="12" font-weight="700" fill="#0d2f5e">Konsultasi</text>

                    {{-- kanan atas: Terverifikasi --}}
                    <g class="lencana-apung d2">
                        <circle cx="492" cy="118" r="34" fill="#fdf3e2"/>
                        <foreignObject x="472" y="98" width="40" height="40">
                            <div xmlns="http://www.w3.org/1999/xhtml" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#c68a1e;">
                                <i class="bi bi-shield-check"></i>
                            </div>
                        </foreignObject>
                    </g>
                    <text x="492" y="168" text-anchor="middle" font-family="Plus Jakarta Sans, sans-serif" font-size="12" font-weight="700" fill="#0d2f5e">Terverifikasi</text>
                    <text x="492" y="182" text-anchor="middle" font-family="Plus Jakarta Sans, sans-serif" font-size="12" font-weight="700" fill="#0d2f5e">Inspektorat</text>

                    {{-- kiri bawah: Diproses Irban --}}
                    <g class="lencana-apung d3">
                        <circle cx="108" cy="352" r="34" fill="#e9edf5"/>
                        <foreignObject x="88" y="332" width="40" height="40">
                            <div xmlns="http://www.w3.org/1999/xhtml" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#0d2f5e;">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </foreignObject>
                    </g>
                    <text x="108" y="402" text-anchor="middle" font-family="Plus Jakarta Sans, sans-serif" font-size="12" font-weight="700" fill="#0d2f5e">Diproses</text>
                    <text x="108" y="416" text-anchor="middle" font-family="Plus Jakarta Sans, sans-serif" font-size="12" font-weight="700" fill="#0d2f5e">Irban</text>

                    {{-- kanan bawah: Riwayat Konsultasi --}}
<g class="lencana-apung d4">
    <circle cx="492" cy="352" r="34" fill="#e6f7ef"/>
    <foreignObject x="472" y="332" width="40" height="40">
        <div xmlns="http://www.w3.org/1999/xhtml" 
        style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#1a7f4f;">
            <i class="bi bi-folder-check"></i>
        </div>
    </foreignObject>
</g>

<text x="492" y="402" text-anchor="middle" 
font-family="Plus Jakarta Sans, sans-serif" 
font-size="12" font-weight="700" fill="#0d2f5e">
Riwayat
</text>

<text x="492" y="416" text-anchor="middle" 
font-family="Plus Jakarta Sans, sans-serif" 
font-size="12" font-weight="700" fill="#0d2f5e">
Konsultasi
</text>
                </svg>
            </div>

        </div>
    </div>
</section>

{{-- ==================== KEGUNAAN ==================== --}}
<section class="petak-guna" id="guna">
    <div class="wadah">
        <div class="nampak" style="text-align:center; margin-bottom: 2.6rem;">
            <span class="eyebrow">Kegunaan</span>
            <h2 class="judul-petak">Tiga hal yang berubah dengan <span style="color:var(--biru-cerah);">E-KONSUL</span></h2>
        </div>

        <div class="grid-guna">

            <div class="kartu-guna guna-biru nampak">
                <div class="ikon-guna-bungkus">
                    <div class="ikon-guna-utama"><i class="bi bi-file-earmark-text"></i></div>
                    <div class="ikon-guna-lencana"><i class="bi bi-check-lg"></i></div>
                </div>
                <h3>Lebih Mudah</h3>
                <p>Ajukan konsultasi persuratan kapan saja melalui sistem tanpa perlu datang langsung.</p>
                <div class="nomor-guna">01</div>
            </div>

            <div class="kartu-guna guna-emas nampak">
                <div class="ikon-guna-bungkus">
                    <div class="ikon-guna-utama"><i class="bi bi-bell"></i></div>
                    <div class="ikon-guna-lencana"><i class="bi bi-plus-lg"></i></div>
                </div>
                <h3>Lebih Cepat</h3>
                <p>Pengajuan langsung diverifikasi dan ditindaklanjuti oleh Inspektur Pembantu.</p>
                <div class="nomor-guna">02</div>
            </div>

            <div class="kartu-guna guna-navy nampak">
                <div class="ikon-guna-bungkus">
                    <div class="ikon-guna-utama"><i class="bi bi-folder2"></i></div>
                    <div class="ikon-guna-lencana"><i class="bi bi-lock-fill"></i></div>
                </div>
                <h3>Lebih Transparan</h3>
                <p>Pantau progres konsultasi secara real-time hingga memperoleh jawaban resmi.</p>
                <div class="nomor-guna">03</div>
            </div>

        </div>
    </div>
</section>

{{-- ==================== ALUR LAYANAN ==================== --}}
<section class="petak-alur-terang" id="alur">
    <div class="wadah">
        <div class="nampak" style="text-align:center; margin-bottom: 3rem;">
            <span class="eyebrow">Alur Layanan</span>
            <h2 class="judul-petak">Bagaimana <span style="color:var(--biru-cerah);">E-KONSUL</span> bekerja?</h2>
        </div>

        <div class="baris-alur nampak">
            <div class="garis-alur" aria-hidden="true"></div>

            <div class="langkah-alur">
                <div class="lingkaran-alur"><i class="bi bi-pencil-square"></i></div>
                <h4>1. Pengajuan</h4>
                <p>Perangkat Daerah mengajukan konsultasi melalui form yang tersedia.</p>
            </div>
            <div class="langkah-alur">
                <div class="lingkaran-alur"><i class="bi bi-shield-check"></i></div>
                <h4>2. Verifikasi</h4>
                <p>Admin Inspektorat memverifikasi kelengkapan data dan dokumen pengajuan.</p>
            </div>
            <div class="langkah-alur">
                <div class="lingkaran-alur"><i class="bi bi-person-fill"></i></div>
                <h4>3. Disposisi Irban</h4>
                <p>Pengajuan diteruskan kepada Inspektur Pembantu sesuai wilayah kerja.</p>
            </div>
            <div class="langkah-alur">
                <div class="lingkaran-alur"><i class="bi bi-chat-dots"></i></div>
                <h4>4. Jawaban</h4>
                <p>Irban memberikan jawaban atau rekomendasi atas konsultasi yang diajukan.</p>
            </div>
            <div class="langkah-alur">
                <div class="lingkaran-alur"><i class="bi bi-journal-check"></i></div>
                <h4>5. Selesai</h4>
                <p>Jawaban tersimpan di sistem dan dapat diunduh oleh pemohon.</p>
            </div>
        </div>
    </div>
</section>

{{-- ==================== AJAKAN BERGAMBAR ==================== --}}
<section class="petak" style="padding: 4rem 0;">
    <div class="wadah">
        <div class="ajakan-gambar nampak">
            <div class="susun-ajakan">

                <div class="ilustrasi-ajakan">
                    <svg viewBox="0 0 220 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="40" y="20" width="110" height="140" rx="8" fill="rgba(255,255,255,.14)" transform="rotate(-6 95 90)"/>
                        <rect x="55" y="14" width="110" height="140" rx="8" fill="#fff"/>
                        <rect x="70" y="34" width="80" height="8" rx="4" fill="#dbe6f1"/>
                        <rect x="70" y="52" width="80" height="6" rx="3" fill="#eef4fb"/>
                        <rect x="70" y="66" width="80" height="6" rx="3" fill="#eef4fb"/>
                        <rect x="70" y="80" width="55" height="6" rx="3" fill="#eef4fb"/>
                        <rect x="20" y="110" width="150" height="80" rx="10" fill="#c68a1e"/>
                        <path d="M20 118 L95 158 L170 118" stroke="#0d2f5e" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="150" cy="150" r="26" fill="#1a7f4f"/>
                        <path d="M138 150 l8 8 l16 -18" stroke="#fff" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>

                <div class="teks-ajakan">
                    <h2>Siap menggunakan E-KONSUL?</h2>
                    <p>Masuk ke sistem atau daftar akun baru untuk mulai mengajukan konsultasi pengawasan.</p>
                    <div class="aksi-ajakan">
                        @auth
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isIrban() ? route('irban.dashboard') : route('opd.dashboard')) }}"
                               class="btn-ajakan-terang">
                                <i class="bi bi-speedometer2"></i> Buka Dashboard
                            </a>
                        @else
                            @if (config('ekonsul.pendaftaran.dibuka'))
                                <a href="{{ route('register') }}" class="btn-ajakan-garis">
                                    <i class="bi bi-person-plus"></i> Daftar Akun
                                </a>
                            @endif
                            <a href="{{ route('login') }}" class="btn-ajakan-terang">
                                <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem
                            </a>
                        @endauth
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
