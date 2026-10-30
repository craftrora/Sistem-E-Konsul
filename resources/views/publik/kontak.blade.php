@extends('layouts.publik')

@section('judul', 'Kontak')

@push('gaya')
<style>
    .kepala-hal {
        background:
            radial-gradient(ellipse 60% 70% at 82% 30%, rgba(43,143,214,.10) 0%, transparent 60%),
            var(--latar);
        padding: 3.4rem 0 3rem;
        border-bottom: 1px solid var(--garis);
    }

    .susun-kontak { display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; align-items: start; }

    .kartu-kontak {
        border: 1px solid var(--garis); border-radius: 16px;
        background: #fff; overflow: hidden;
    }
    .kartu-kontak .baris-info {
        display: flex; gap: 1rem; padding: 1.35rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .kartu-kontak .baris-info:last-child { border-bottom: none; }
    .kartu-kontak .ikon {
        width: 42px; height: 42px; border-radius: 11px; flex-shrink: 0;
        background: var(--langit); color: var(--biru);
        display: flex; align-items: center; justify-content: center; font-size: 1.08rem;
    }
    .kartu-kontak .label {
        font-size: .74rem; font-weight: 700; letter-spacing: .07em;
        text-transform: uppercase; color: var(--abu-mud); margin-bottom: .25rem;
    }
    .kartu-kontak .nilai { font-size: .96rem; color: var(--tinta); line-height: 1.6; font-weight: 500; }
    .kartu-kontak .nilai a { color: var(--biru); }
    .kartu-kontak .nilai a:hover { text-decoration: underline; }

    .peta {
        border: 1px solid var(--garis); border-radius: 16px; overflow: hidden;
        background: var(--latar-mud); height: 320px;
        display: flex; align-items: center; justify-content: center; flex-direction: column;
        gap: .8rem; color: var(--abu-mud); text-align: center; padding: 2rem;
    }
    .peta i { font-size: 2.2rem; color: var(--biru-cerah); }

    .jam-tabel { width: 100%; border-collapse: collapse; font-size: .92rem; }
    .jam-tabel td { padding: .68rem 0; border-bottom: 1px solid #f1f5f9; }
    .jam-tabel tr:last-child td { border-bottom: none; }
    .jam-tabel td:first-child { color: var(--abu); }
    .jam-tabel td:last-child { text-align: right; font-weight: 600; color: var(--tinta); }
    .jam-tabel .tutup-hari td:last-child { color: #c65a48; }

    @media (max-width: 860px) { .susun-kontak { grid-template-columns: 1fr; } }
</style>
@endpush

@section('isi')

<section class="kepala-hal">
    <div class="wadah">
        <span class="eyebrow">Kontak</span>
        <h1 class="judul-hal">Hubungi <em>Inspektorat</em></h1>
        <p class="teks-pengantar">
            Untuk pertanyaan mengenai penggunaan sistem atau kendala akun,
            silakan hubungi Sekretariat Inspektorat Kabupaten Ngawi.
        </p>
    </div>
</section>

<section class="petak">
    <div class="wadah">
        <div class="susun-kontak">

            <div class="nampak">
                <div class="kartu-kontak">
                    <div class="baris-info">
                        <div class="ikon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <div class="label">Alamat Kantor</div>
                            <div class="nilai">
                                Jalan Teuku Umar Nomor 12, Ketanggi<br>
                                Kabupaten Ngawi, Jawa Timur 63211
                            </div>
                        </div>
                    </div>

                    <div class="baris-info">
                        <div class="ikon"><i class="bi bi-telephone-fill"></i></div>
                        <div>
                            <div class="label">Telepon</div>
                            <div class="nilai"><a href="tel:0351749016">(0351) 749016</a></div>
                        </div>
                    </div>

                    <div class="baris-info">
                        <div class="ikon"><i class="bi bi-envelope-fill"></i></div>
                        <div>
                            <div class="label">Surel</div>
                            <div class="nilai"><a href="mailto:inspektorat@ngawikab.go.id">inspektorat@ngawikab.go.id</a></div>
                        </div>
                    </div>

                    <div class="baris-info">
                        <div class="ikon"><i class="bi bi-globe"></i></div>
                        <div>
                            <div class="label">Laman Resmi</div>
                            <div class="nilai"><a href="https://inspektorat.ngawikab.go.id" target="_blank" rel="noopener">inspektorat.ngawikab.go.id</a></div>
                        </div>
                    </div>
                </div>

                <div class="kartu-kontak" style="margin-top: 1.5rem;">
                    <div style="padding: 1.35rem 1.5rem;">
                        <div class="label" style="margin-bottom:.9rem;">Jam Pelayanan</div>
                        <table class="jam-tabel">
                            <tr><td>Senin – Kamis</td><td>07.30 – 15.30 WIB</td></tr>
                            <tr><td>Jumat</td><td>07.30 – 14.00 WIB</td></tr>
                            <tr class="tutup-hari"><td>Sabtu, Minggu, dan hari libur</td><td>Tutup</td></tr>
                        </table>
                        <p style="font-size:.85rem; color:var(--abu); margin:1rem 0 0; line-height:1.65;">
                            Pengajuan konsultasi melalui sistem dapat dilakukan kapan saja.
                            Penanganan dilaksanakan pada hari dan jam kerja.
                        </p>
                    </div>
                </div>
            </div>

            <div class="nampak">
                <div class="peta">
                    <i class="bi bi-map"></i>
                    <div style="font-weight:600; color:var(--tinta);">Inspektorat Kabupaten Ngawi</div>
                    <div style="font-size:.88rem;">Jalan Teuku Umar Nomor 12, Ketanggi, Ngawi</div>
                    <a href="https://www.google.com/maps/search/?api=1&query=Inspektorat+Kabupaten+Ngawi"
                       target="_blank" rel="noopener" class="btn-garis" style="margin-top:.6rem;">
                        <i class="bi bi-box-arrow-up-right"></i> Buka di Peta
                    </a>
                </div>

                <div class="kartu-kontak" style="margin-top: 1.5rem;">
                    <div style="padding: 1.5rem;">
                        <div style="font-weight:700; color:var(--biru-tua); margin-bottom:.5rem;">
                            Kendala penggunaan sistem?
                        </div>
                        <p style="font-size:.92rem; color:var(--abu); line-height:1.7; margin:0 0 1.2rem;">
                            Periksa terlebih dahulu halaman Tanya Jawab. Sebagian besar kendala
                            umum sudah dijelaskan di sana.
                        </p>
                        <a href="{{ route('tanya-jawab') }}" class="btn-utama">
                            <i class="bi bi-question-circle"></i> Buka Tanya Jawab
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
