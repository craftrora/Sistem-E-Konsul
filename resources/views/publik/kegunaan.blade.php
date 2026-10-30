@extends('layouts.publik')

@section('judul', 'Kegunaan')

@push('gaya')
<style>
    .kepala-hal {
        background:
            radial-gradient(ellipse 60% 70% at 82% 30%, rgba(43,143,214,.10) 0%, transparent 60%),
            var(--latar);
        padding: 3.4rem 0 3rem;
        border-bottom: 1px solid var(--garis);
    }
    .banding { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    .banding .sisi {
        border-radius: 16px; padding: 1.85rem 1.7rem; border: 1px solid var(--garis); background: #fff;
    }
    .banding .sisi.dulu { background: #fdf7f6; border-color: #f2dcd8; }
    .banding .sisi.kini { background: #f4fbf7; border-color: #cfeadd; }
    .banding .kepala-sisi {
        display: flex; align-items: center; gap: .55rem;
        font-weight: 700; font-size: .98rem; margin-bottom: 1.1rem;
    }
    .banding .dulu .kepala-sisi { color: #a8402f; }
    .banding .kini .kepala-sisi { color: #1a7f4f; }
    .banding ul { list-style: none; margin: 0; padding: 0; }
    .banding li {
        position: relative; padding: .5rem 0 .5rem 1.6rem;
        font-size: .9rem; color: var(--abu); line-height: 1.6;
    }
    .banding li::before {
        position: absolute; left: 0; top: .55rem;
        font-family: 'bootstrap-icons'; font-size: .82rem;
    }
    .banding .dulu li::before { content: '\F62A'; color: #c65a48; }
    .banding .kini li::before { content: '\F26E'; color: #1a7f4f; }

    .daftar-guna { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.35rem; }
    .guna {
        display: flex; gap: 1.1rem; padding: 1.6rem;
        border: 1px solid var(--garis); border-radius: 16px; background: #fff;
        transition: border-color .25s, box-shadow .25s, transform .25s;
    }
    .guna:hover { border-color: #cfe0f0; box-shadow: 0 .9rem 2rem rgba(13,47,94,.08); transform: translateY(-3px); }
    .guna .ikon {
        width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: var(--langit); color: var(--biru); font-size: 1.15rem;
    }
    .guna h3 { font-size: 1.02rem; font-weight: 700; color: var(--biru-tua); margin: 0 0 .4rem; letter-spacing: -.018em; }
    .guna p { font-size: .89rem; color: var(--abu); line-height: 1.66; margin: 0; }

    @media (max-width: 860px) {
        .banding, .daftar-guna { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('isi')

<section class="kepala-hal">
    <div class="wadah">
        <span class="eyebrow">Kegunaan</span>
        <h1 class="judul-hal">Mengapa Menggunakan <em>E-KONSUL</em></h1>
        <p class="teks-pengantar">
            Konsultasi Perangkat Daerah kepada Inspektorat selama ini berlangsung melalui
            pesan pribadi. Cara tersebut menyulitkan penelusuran dan rawan hilang.
        </p>
    </div>
</section>

<section class="petak">
    <div class="wadah">
        <div class="banding nampak">
            <div class="sisi dulu">
                <div class="kepala-sisi"><i class="bi bi-chat-dots"></i> Melalui Pesan Pribadi</div>
                <ul>
                    <li>Percakapan tersebar di banyak nomor dan perangkat</li>
                    <li>Tidak ada penomoran sehingga sulit direkapitulasi</li>
                    <li>Tidak jelas siapa yang bertanggung jawab menjawab</li>
                    <li>Riwayat hilang ketika terjadi mutasi pegawai</li>
                    <li>Lemah dari sisi bukti dan pertanggungjawaban</li>
                </ul>
            </div>
            <div class="sisi kini">
                <div class="kepala-sisi"><i class="bi bi-shield-check"></i> Melalui E-KONSUL</div>
                <ul>
                    <li>Seluruh konsultasi terpusat dalam satu sistem</li>
                    <li>Nomor register terbit otomatis untuk tiap pengajuan</li>
                    <li>Penanganan didisposisikan ke Irban sesuai wilayah</li>
                    <li>Riwayat tersimpan permanen dan dapat ditelusuri</li>
                    <li>Tersedia rekapitulasi sebagai bahan evaluasi</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="petak terang">
    <div class="wadah">
        <div class="nampak" style="margin-bottom: 2.4rem; max-width: 40rem;">
            <h2 class="judul-petak">Yang tersedia di dalam sistem</h2>
            <p class="teks-pengantar">
                Dirancang sederhana agar dapat digunakan seluruh pegawai Perangkat Daerah
                tanpa memerlukan pelatihan khusus.
            </p>
        </div>

        <div class="daftar-guna nampak">
            <div class="guna">
                <div class="ikon"><i class="bi bi-hash"></i></div>
                <div>
                    <h3>Penomoran Otomatis</h3>
                    <p>Kode seperti EKS-2026-000128 terbit seketika saat pengajuan dikirim, dijamin tidak terduplikasi.</p>
                </div>
            </div>
            <div class="guna">
                <div class="ikon"><i class="bi bi-diagram-3"></i></div>
                <div>
                    <h3>Disposisi Terarah</h3>
                    <p>Administrator meneruskan pengajuan kepada Irban Wilayah I sampai IV atau Irban Khusus sesuai tugas pokoknya.</p>
                </div>
            </div>
            <div class="guna">
                <div class="ikon"><i class="bi bi-whatsapp"></i></div>
                <div>
                    <h3>Pemberitahuan WhatsApp</h3>
                    <p>Pemberitahuan otomatis dikirim ketika pengajuan diterima, telah dijawab, dan dinyatakan selesai.</p>
                </div>
            </div>
            <div class="guna">
                <div class="ikon"><i class="bi bi-paperclip"></i></div>
                <div>
                    <h3>Lampiran Dokumen</h3>
                    <p>Dokumen pendukung dapat diunggah dan hanya dapat diakses pihak yang berkepentingan.</p>
                </div>
            </div>
            <div class="guna">
                <div class="ikon"><i class="bi bi-chat-square-text"></i></div>
                <div>
                    <h3>Percakapan Menyatu</h3>
                    <p>Pertanyaan lanjutan tetap berada dalam pengajuan yang sama sehingga konteksnya tidak terpecah.</p>
                </div>
            </div>
            <div class="guna">
                <div class="ikon"><i class="bi bi-clock-history"></i></div>
                <div>
                    <h3>Riwayat Penanganan</h3>
                    <p>Setiap perubahan status tercatat lengkap dengan pelaksana dan waktunya.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="petak" style="padding-top: 0;">
    <div class="wadah" style="text-align:center;">
        <a href="{{ route('alur') }}" class="btn-utama">
            Lihat Alur Layanan <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</section>

@endsection
