@extends('layouts.publik')

@section('judul', 'Alur Layanan')

@push('gaya')
<style>
    .kepala-hal {
        background:
            radial-gradient(ellipse 60% 70% at 82% 30%, rgba(43,143,214,.10) 0%, transparent 60%),
            var(--latar);
        padding: 3.4rem 0 3rem;
        border-bottom: 1px solid var(--garis);
    }

    .lini { position: relative; padding-left: 2.6rem; }
    .lini::before {
        content: ''; position: absolute; left: 15px; top: 8px; bottom: 8px;
        width: 2px; background: linear-gradient(180deg, var(--biru-cerah), #dbe6f1);
    }
    .tahap { position: relative; padding-bottom: 2.1rem; }
    .tahap:last-child { padding-bottom: 0; }
    .tahap .bulat {
        position: absolute; left: -2.6rem; top: 2px;
        width: 32px; height: 32px; border-radius: 50%;
        background: #fff; border: 2px solid var(--biru-cerah);
        display: flex; align-items: center; justify-content: center;
        font-family: var(--mono); font-size: .74rem; font-weight: 600; color: var(--biru);
    }
    .tahap .pelaku {
        display: inline-block; font-size: .72rem; font-weight: 700;
        letter-spacing: .06em; text-transform: uppercase;
        padding: .22rem .65rem; border-radius: 100px; margin-bottom: .55rem;
    }
    .tahap .pelaku.opd   { background: var(--langit);  color: var(--biru); }
    .tahap .pelaku.admin { background: #fdf3e2;        color: #a8721a; }
    .tahap .pelaku.irban { background: #eaf7f0;        color: #1a7f4f; }
    .tahap h3 { font-size: 1.14rem; font-weight: 700; color: var(--biru-tua); margin: 0 0 .4rem; letter-spacing: -.022em; }
    .tahap p { font-size: .93rem; color: var(--abu); line-height: 1.7; margin: 0; max-width: 38rem; }

    /* Lembar konsultasi contoh */
    .lembar {
        background: #fff; border: 1px solid var(--garis); border-radius: 18px;
        overflow: hidden; box-shadow: 0 1.2rem 2.6rem rgba(13,47,94,.08);
        position: sticky; top: 110px;
    }
    .lembar .atas {
        background: linear-gradient(135deg, var(--biru-tua), var(--biru));
        color: #fff; padding: 1.15rem 1.35rem;
        display: flex; justify-content: space-between; align-items: center;
    }
    .lembar .atas .tajuk { font-size: .82rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
    .lembar .atas .ta { font-family: var(--mono); font-size: .74rem; color: rgba(255,255,255,.7); }
    .lembar .isi { padding: 1.35rem; }
    .lembar .baris {
        display: flex; justify-content: space-between; gap: 1rem;
        padding: .62rem 0; border-bottom: 1px solid #f1f5f9; font-size: .87rem;
    }
    .lembar .baris:last-of-type { border-bottom: none; }
    .lembar .baris .kunci { color: var(--abu-mud); font-size: .78rem; flex-shrink: 0; padding-top: .1rem; }
    .lembar .baris .isi-nilai { text-align: right; font-weight: 600; color: var(--tinta); }
    .lembar .baris .isi-nilai.kode { font-family: var(--mono); color: var(--biru-tua); }

    .lembar .status-kotak {
        background: var(--latar-mud); border-radius: 12px;
        padding: 1rem 1.1rem; margin-top: 1rem;
    }
    .lembar .status-kotak .label {
        font-size: .7rem; font-weight: 700; letter-spacing: .08em;
        text-transform: uppercase; color: var(--abu-mud); margin-bottom: .75rem;
    }
    .jejak-baris { display: flex; align-items: center; gap: .6rem; padding: .34rem 0; font-size: .82rem; }
    .jejak-baris .tanda {
        width: 17px; height: 17px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; font-size: .55rem; color: #fff;
    }
    .jejak-baris.usai .tanda { background: #1a7f4f; }
    .jejak-baris.kini .tanda { background: var(--emas); }
    .jejak-baris.belum .tanda { background: #dbe3ec; }
    .jejak-baris.belum { color: var(--abu-mud); }
    .jejak-baris .waktu { margin-left: auto; font-family: var(--mono); font-size: .7rem; color: var(--abu-mud); }

    .susun-alur { display: grid; grid-template-columns: 1.25fr .75fr; gap: 3rem; align-items: start; }

    @media (max-width: 980px) {
        .susun-alur { grid-template-columns: 1fr; gap: 2.5rem; }
        .lembar { position: static; }
    }
</style>
@endpush

@section('isi')

<section class="kepala-hal">
    <div class="wadah">
        <span class="eyebrow">Alur Layanan</span>
        <h1 class="judul-hal">Dari Bertanya sampai <em>Selesai</em></h1>
        <p class="teks-pengantar">
            Enam tahap yang dilalui setiap konsultasi. Perangkat Daerah cukup mengisi
            formulir, selebihnya diproses oleh sistem dan petugas Inspektorat.
        </p>
    </div>
</section>

<section class="petak">
    <div class="wadah">
        <div class="susun-alur">

            <div class="lini nampak">
                <div class="tahap">
                    <div class="bulat">01</div>
                    <span class="pelaku opd">Perangkat Daerah</span>
                    <h3>Masuk ke sistem</h3>
                    <p>Gunakan akun yang telah dimiliki. Bila belum, pendaftaran dapat dilakukan sendiri melalui halaman pendaftaran tanpa perlu menunggu dibuatkan.</p>
                </div>

                <div class="tahap">
                    <div class="bulat">02</div>
                    <span class="pelaku opd">Perangkat Daerah</span>
                    <h3>Mengajukan konsultasi</h3>
                    <p>Isi perihal, pilih kategori, uraikan pertanyaan, dan lampirkan dokumen pendukung bila diperlukan. Nomor register terbit seketika setelah dikirim.</p>
                </div>

                <div class="tahap">
                    <div class="bulat">03</div>
                    <span class="pelaku admin">Administrator</span>
                    <h3>Verifikasi pengajuan</h3>
                    <p>Administrator memeriksa kelengkapan dan kejelasan pengajuan sebelum diteruskan, sehingga Inspektur Pembantu menerima pertanyaan yang sudah utuh.</p>
                </div>

                <div class="tahap">
                    <div class="bulat">04</div>
                    <span class="pelaku admin">Administrator</span>
                    <h3>Disposisi ke Irban</h3>
                    <p>Pengajuan diteruskan kepada Inspektur Pembantu Wilayah I sampai IV atau Inspektur Pembantu Khusus, sesuai wilayah kerja dan bidang permasalahan.</p>
                </div>

                <div class="tahap">
                    <div class="bulat">05</div>
                    <span class="pelaku irban">Inspektur Pembantu</span>
                    <h3>Pemberian jawaban</h3>
                    <p>Irban menyampaikan jawaban melalui sistem. Pemberitahuan otomatis dikirim ke nomor WhatsApp pemohon begitu jawaban tersedia.</p>
                </div>

                <div class="tahap">
                    <div class="bulat">06</div>
                    <span class="pelaku irban">Inspektur Pembantu</span>
                    <h3>Penyelesaian</h3>
                    <p>Bila permasalahan telah tuntas, pengajuan dinyatakan selesai dan tersimpan sebagai arsip yang dapat dibuka kembali sewaktu-waktu.</p>
                </div>
            </div>

            {{-- Contoh lembar konsultasi --}}
            <div class="nampak">
                <div class="lembar">
                    <div class="atas">
                        <span class="tajuk">Lembar Konsultasi</span>
                        <span class="ta">TA 2026</span>
                    </div>
                    <div class="isi">
                        <div class="baris">
                            <span class="kunci">Nomor Register</span>
                            <span class="isi-nilai kode">EKS-2026-000128</span>
                        </div>
                        <div class="baris">
                            <span class="kunci">Perangkat Daerah</span>
                            <span class="isi-nilai">Dinas Kesehatan</span>
                        </div>
                        <div class="baris">
                            <span class="kunci">Perihal</span>
                            <span class="isi-nilai">Pertanggungjawaban perjalanan dinas</span>
                        </div>
                        <div class="baris">
                            <span class="kunci">Kategori</span>
                            <span class="isi-nilai">Perjalanan Dinas</span>
                        </div>
                        <div class="baris">
                            <span class="kunci">Unit Penanganan</span>
                            <span class="isi-nilai">Irban Wilayah II</span>
                        </div>

                        <div class="status-kotak">
                            <div class="label">Riwayat Penanganan</div>
                            <div class="jejak-baris usai">
                                <span class="tanda"><i class="bi bi-check"></i></span>
                                <span>Diajukan</span>
                                <span class="waktu">02/08</span>
                            </div>
                            <div class="jejak-baris usai">
                                <span class="tanda"><i class="bi bi-check"></i></span>
                                <span>Diverifikasi</span>
                                <span class="waktu">02/08</span>
                            </div>
                            <div class="jejak-baris kini">
                                <span class="tanda"></span>
                                <span>Dalam penanganan</span>
                                <span class="waktu">berjalan</span>
                            </div>
                            <div class="jejak-baris belum">
                                <span class="tanda"></span>
                                <span>Selesai</span>
                                <span class="waktu">—</span>
                            </div>
                        </div>
                    </div>
                </div>

                <p style="font-size:.8rem; color:var(--abu-mud); text-align:center; margin-top:.9rem;">
                    Contoh tampilan lembar konsultasi
                </p>
            </div>

        </div>
    </div>
</section>

<section class="petak terang">
    <div class="wadah" style="text-align:center;">
        <h2 class="judul-petak">Siap mengajukan konsultasi?</h2>
        <p class="teks-pengantar" style="margin: 0 auto 1.8rem;">
            Masuk menggunakan akun Anda, atau daftar bila belum memilikinya.
        </p>
        <a href="{{ route('login') }}" class="btn-utama">
            <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem
        </a>
    </div>
</section>

@endsection
