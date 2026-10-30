@extends('layouts.publik')

@section('judul', 'Tanya Jawab')

@push('gaya')
<style>
    .kepala-hal {
        background:
            radial-gradient(ellipse 60% 70% at 82% 30%, rgba(43,143,214,.10) 0%, transparent 60%),
            var(--latar);
        padding: 3.4rem 0 3rem;
        border-bottom: 1px solid var(--garis);
    }

    .kelompok { margin-bottom: 2.6rem; }
    .kelompok .nama-kelompok {
        font-size: .76rem; font-weight: 700; letter-spacing: .1em;
        text-transform: uppercase; color: var(--biru);
        padding-bottom: .7rem; margin-bottom: 1rem;
        border-bottom: 1px solid var(--garis);
    }

    .tanya-item {
        border: 1px solid var(--garis); border-radius: 14px;
        margin-bottom: .7rem; background: #fff;
        transition: border-color .22s, box-shadow .22s;
    }
    .tanya-item[open] { border-color: #cfe0f0; box-shadow: 0 .55rem 1.5rem rgba(13,47,94,.07); }
    .tanya-item summary {
        list-style: none; cursor: pointer; padding: 1.05rem 1.3rem;
        font-weight: 700; font-size: .97rem; color: var(--biru-tua);
        display: flex; justify-content: space-between; align-items: center; gap: 1rem;
    }
    .tanya-item summary::-webkit-details-marker { display: none; }
    .tanya-item summary::after {
        content: '\F64D'; font-family: 'bootstrap-icons';
        font-size: .9rem; color: var(--biru-cerah); flex-shrink: 0;
        transition: transform .25s;
    }
    .tanya-item[open] summary::after { transform: rotate(180deg); }
    .tanya-item summary:focus-visible { outline: 2px solid var(--biru-cerah); outline-offset: 2px; border-radius: 14px; }
    .tanya-item .jawaban {
        padding: 0 1.3rem 1.2rem;
        color: var(--abu); line-height: 1.75; font-size: .92rem;
    }

    .kotak-bantuan {
        background: var(--latar-mud); border: 1px solid var(--garis);
        border-radius: 16px; padding: 1.8rem; text-align: center;
    }
    .kotak-bantuan h3 { font-size: 1.08rem; font-weight: 700; color: var(--biru-tua); margin: 0 0 .5rem; }
    .kotak-bantuan p { color: var(--abu); font-size: .92rem; margin: 0 0 1.2rem; }
</style>
@endpush

@section('isi')

<section class="kepala-hal">
    <div class="wadah">
        <span class="eyebrow">Tanya Jawab</span>
        <h1 class="judul-hal">Pertanyaan yang <em>Sering Diajukan</em></h1>
        <p class="teks-pengantar">
            Sebelum mengajukan konsultasi, silakan periksa terlebih dahulu daftar berikut.
        </p>
    </div>
</section>

<section class="petak">
    <div class="wadah" style="max-width: 820px;">

        <div class="kelompok nampak">
            <div class="nama-kelompok">Akun dan Akses</div>

            <details class="tanya-item" open>
                <summary>Siapa yang boleh menggunakan E-KONSUL?</summary>
                <div class="jawaban">
                    Pegawai Organisasi Perangkat Daerah di lingkungan Pemerintah Kabupaten Ngawi
                    yang hendak berkonsultasi dengan Inspektorat.
                </div>
            </details>

            <details class="tanya-item">
                <summary>Bagaimana cara memperoleh akun?</summary>
                <div class="jawaban">
                    Pendaftaran dapat dilakukan sendiri melalui halaman pendaftaran. Isi nama,
                    Perangkat Daerah, jabatan, alamat surel, dan nomor WhatsApp. Akun langsung
                    dapat digunakan setelah pendaftaran berhasil.
                </div>
            </details>

            <details class="tanya-item">
                <summary>Apakah harus menggunakan surel dinas?</summary>
                <div class="jawaban">
                    Tidak. Alamat surel pribadi seperti Gmail dapat digunakan. Yang penting
                    alamat tersebut aktif dan dapat Anda akses.
                </div>
            </details>

            <details class="tanya-item">
                <summary>Lupa kata sandi, bagaimana?</summary>
                <div class="jawaban">
                    Silakan hubungi Sekretariat Inspektorat Kabupaten Ngawi untuk dilakukan
                    pengaturan ulang kata sandi.
                </div>
            </details>
        </div>

        <div class="kelompok nampak">
            <div class="nama-kelompok">Pengajuan Konsultasi</div>

            <details class="tanya-item">
                <summary>Berapa lama konsultasi dijawab?</summary>
                <div class="jawaban">
                    Setelah diverifikasi Administrator, pengajuan diteruskan kepada Inspektur
                    Pembantu terkait untuk ditindaklanjuti. Status penanganan dapat dipantau
                    sendiri melalui halaman konsultasi, sehingga tidak perlu menanyakan ulang.
                </div>
            </details>

            <details class="tanya-item">
                <summary>Apakah bisa melampirkan dokumen?</summary>
                <div class="jawaban">
                    Bisa. Dokumen berformat PDF, Word, Excel, atau gambar dapat dilampirkan,
                    baik saat mengajukan maupun saat membalas. Ukuran tiap berkas maksimal 5 MB
                    dengan jumlah paling banyak tiga berkas.
                </div>
            </details>

            <details class="tanya-item">
                <summary>Kalau jawabannya masih kurang jelas?</summary>
                <div class="jawaban">
                    Balas pada pengajuan yang sama. Seluruh percakapan tetap menyatu dalam satu
                    nomor register sehingga konteks pembahasan tidak terpecah.
                </div>
            </details>

            <details class="tanya-item">
                <summary>Apakah konsultasi yang sudah selesai bisa dibuka lagi?</summary>
                <div class="jawaban">
                    Pengajuan yang telah selesai tersimpan sebagai arsip dan tetap dapat dibaca
                    kapan saja. Untuk pertanyaan baru, silakan ajukan konsultasi baru.
                </div>
            </details>
        </div>

        <div class="kelompok nampak">
            <div class="nama-kelompok">Pemberitahuan</div>

            <details class="tanya-item">
                <summary>Apakah ada pemberitahuan bila sudah dijawab?</summary>
                <div class="jawaban">
                    Ada. Pemberitahuan dikirim ke nomor WhatsApp yang Anda isikan saat mendaftar,
                    yaitu ketika pengajuan diterima, telah dijawab, dan dinyatakan selesai.
                </div>
            </details>

            <details class="tanya-item">
                <summary>Nomor WhatsApp saya berubah, bagaimana?</summary>
                <div class="jawaban">
                    Nomor dapat diperbarui sendiri melalui menu Profil setelah masuk ke sistem.
                </div>
            </details>
        </div>

        <div class="kotak-bantuan nampak">
            <h3>Pertanyaan Anda belum terjawab?</h3>
            <p>Silakan hubungi Sekretariat Inspektorat Kabupaten Ngawi.</p>
            <a href="{{ route('kontak') }}" class="btn-utama">
                <i class="bi bi-telephone"></i> Lihat Kontak
            </a>
        </div>

    </div>
</section>

@endsection
