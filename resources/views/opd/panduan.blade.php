@extends('layouts.app')

@section('title', 'Panduan Penggunaan')

@push('styles')
<style>
.panduan-hero {
    background: linear-gradient(135deg, #0d2f5e 0%, #1e4a8a 100%);
    border-radius: 22px;
    padding: 32px 36px;
    color: #fff;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 20px;
}
.panduan-hero .hero-icon {
    width: 64px; height: 64px;
    background: rgba(255,255,255,.15);
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem;
    flex-shrink: 0;
}
.panduan-hero h1 { font-size: 1.5rem; font-weight: 800; margin: 0 0 6px; }
.panduan-hero p  { margin: 0; opacity: .8; font-size: .95rem; }

.step-list { display: flex; flex-direction: column; gap: 16px; margin-bottom: 28px; }
.step-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e5edf7;
    box-shadow: 0 10px 25px rgba(15,23,42,.05);
    padding: 22px 24px;
    display: flex;
    gap: 18px;
    align-items: flex-start;
}
.step-num {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0d2f5e, #1e4a8a);
    color: #fff;
    font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.step-body h5 { font-size: 1rem; font-weight: 700; color: #102a56; margin: 0 0 6px; }
.step-body p  { font-size: .9rem; color: #64748b; margin: 0; line-height: 1.65; }
.step-tip {
    display: inline-flex; align-items: center; gap: 6px;
    margin-top: 10px;
    background: #eff6ff;
    border: 1px solid #dbeafe;
    color: #2563eb;
    border-radius: 10px;
    padding: 6px 12px;
    font-size: .82rem;
    font-weight: 600;
}

.status-ref {
    display: flex; flex-direction: column; gap: 14px;
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e5edf7;
    box-shadow: 0 10px 25px rgba(15,23,42,.05);
    padding: 22px 24px;
    margin-bottom: 28px;
}
.status-ref-item { display: flex; align-items: center; gap: 12px; font-size: .9rem; color: #334155; }
.status-ref-item .badge { flex-shrink: 0; }

.faq-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e5edf7;
    box-shadow: 0 10px 25px rgba(15,23,42,.05);
    overflow: hidden;
    margin-bottom: 28px;
}
.faq-item { border-bottom: 1px solid #edf2f7; }
.faq-item:last-child { border-bottom: none; }
.faq-q {
    width: 100%; background: none; border: none; text-align: left;
    padding: 18px 24px;
    font-size: .93rem; font-weight: 600; color: #102a56;
    cursor: pointer;
    display: flex; justify-content: space-between; align-items: center; gap: 12px;
}
.faq-q:hover { background: #f8fafc; }
.faq-q i { transition: transform .25s; flex-shrink: 0; color: #64748b; }
.faq-q.aktif i { transform: rotate(180deg); }
.faq-a { display: none; padding: 0 24px 18px; font-size: .88rem; color: #475569; line-height: 1.75; }
.faq-a.tampil { display: block; }

.panduan-cta {
    background: #eff6ff;
    border: 1px solid #dbeafe;
    border-radius: 22px;
    padding: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}
.panduan-cta h5 { font-weight: 800; color: #102a56; margin: 0 0 4px; font-size: 1rem; }
.panduan-cta p  { color: #64748b; margin: 0; font-size: .9rem; }
.btn-cta {
    border: none;
    background: #1769ff;
    color: #fff;
    border-radius: 12px;
    padding: 12px 20px;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
}
.btn-cta:hover { background: #155ce0; color: #fff; }

@media(max-width:900px){
    .panduan-hero, .panduan-cta { flex-direction: column; align-items: flex-start; }
}
</style>
@endpush


@section('content')

<div class="panduan-hero">
    <div class="hero-icon"><i class="bi bi-book-half"></i></div>
    <div>
        <h1>Panduan Penggunaan E-KONSUL</h1>
        <p>Ikuti langkah-langkah berikut untuk mengajukan dan memantau konsultasi Anda ke Inspektorat Kabupaten Ngawi.</p>
    </div>
</div>


<h5 class="fw-bold mb-3" style="color:#102a56;">
    <i class="bi bi-list-ol me-2 text-primary"></i>Langkah Pengajuan Konsultasi
</h5>

<div class="step-list">

    <div class="step-card">
        <div class="step-num">1</div>
        <div class="step-body">
            <h5>Klik "Buat Konsultasi Baru"</h5>
            <p>Tombol tersedia di pojok kanan atas dashboard dan di sidebar sebelah kiri.</p>
        </div>
    </div>

    <div class="step-card">
        <div class="step-num">2</div>
        <div class="step-body">
            <h5>Isi Judul Konsultasi</h5>
            <p>Tuliskan judul singkat yang menggambarkan topik konsultasi. Contoh: <em>"Pertanyaan terkait mekanisme perjalanan dinas luar daerah"</em>.</p>
        </div>
    </div>

    <div class="step-card">
        <div class="step-num">3</div>
        <div class="step-body">
            <h5>Pilih Kategori Konsultasi</h5>
            <p>Pilih kategori yang paling sesuai dengan topik pertanyaan Anda. Kategori ini menentukan ke unit Inspektur Pembantu mana konsultasi diteruskan secara otomatis.</p>
            <span class="step-tip"><i class="bi bi-info-circle"></i> Pilih kategori seakurat mungkin agar sampai ke Irban yang tepat</span>
        </div>
    </div>

    <div class="step-card">
        <div class="step-num">4</div>
        <div class="step-body">
            <h5>Tulis Pertanyaan Anda</h5>
            <p>Jelaskan pertanyaan atau permasalahan secara detail. Semakin lengkap informasi yang diberikan, semakin cepat dan tepat jawaban dari Inspektorat.</p>
        </div>
    </div>

    <div class="step-card">
        <div class="step-num">5</div>
        <div class="step-body">
            <h5>Lampirkan Dokumen Pendukung (Opsional)</h5>
            <p>Lampirkan dokumen relevan seperti SK, kontrak, atau laporan. Format yang diterima: PDF, Word, Excel, JPG, dan PNG. Maksimal 5MB per berkas.</p>
        </div>
    </div>

    <div class="step-card">
        <div class="step-num">6</div>
        <div class="step-body">
            <h5>Kirim dan Pantau Status</h5>
            <p>Setelah dikirim, konsultasi langsung diteruskan ke Irban yang berwenang. Pantau status di menu <strong>Konsultasi Saya</strong>. Notifikasi akan muncul saat ada jawaban baru.</p>
        </div>
    </div>

</div>


<h5 class="fw-bold mb-3" style="color:#102a56;">
    <i class="bi bi-tag me-2 text-primary"></i>Arti Status Konsultasi
</h5>

<div class="status-ref">
    <div class="status-ref-item">
        <span class="badge bg-warning text-dark">Diproses</span>
        Konsultasi diterima dan sedang dikerjakan oleh Irban
    </div>
    <div class="status-ref-item">
        <span class="badge bg-info text-dark">Sudah Dijawab</span>
        Irban telah memberikan jawaban — segera buka dan baca
    </div>
    <div class="status-ref-item">
        <span class="badge bg-primary">Menunggu Balasan OPD</span>
        Irban menunggu klarifikasi atau dokumen tambahan dari Anda
    </div>
    <div class="status-ref-item">
        <span class="badge bg-success">Selesai</span>
        Konsultasi telah selesai dan tersimpan sebagai arsip
    </div>
</div>


<h5 class="fw-bold mb-3" style="color:#102a56;">
    <i class="bi bi-question-circle me-2 text-primary"></i>Pertanyaan yang Sering Diajukan
</h5>

<div class="faq-card">

    <div class="faq-item">
        <button type="button" class="faq-q" onclick="toggleFaq(this)">
            Berapa lama waktu respons dari Inspektorat?
            <i class="bi bi-chevron-down"></i>
        </button>
        <div class="faq-a">
            Waktu respons umumnya 1–3 hari kerja, tergantung kompleksitas pertanyaan dan antrean konsultasi pada unit Irban yang bersangkutan.
        </div>
    </div>

    <div class="faq-item">
        <button type="button" class="faq-q" onclick="toggleFaq(this)">
            Apakah satu OPD bisa mengajukan lebih dari satu konsultasi?
            <i class="bi bi-chevron-down"></i>
        </button>
        <div class="faq-a">
            Bisa. Tidak ada batasan jumlah konsultasi. Namun disarankan setiap tiket hanya memuat satu topik agar lebih mudah ditindaklanjuti.
        </div>
    </div>

    <div class="faq-item">
        <button type="button" class="faq-q" onclick="toggleFaq(this)">
            Bagaimana jika saya salah memilih kategori?
            <i class="bi bi-chevron-down"></i>
        </button>
        <div class="faq-a">
            Admin Inspektorat dapat meneruskan ulang konsultasi ke Irban yang tepat. Namun untuk efisiensi, pilihlah kategori yang paling sesuai sejak awal.
        </div>
    </div>

    <div class="faq-item">
        <button type="button" class="faq-q" onclick="toggleFaq(this)">
            Apakah konsultasi bersifat rahasia?
            <i class="bi bi-chevron-down"></i>
        </button>
        <div class="faq-a">
            Ya. Konsultasi hanya dapat diakses oleh OPD yang mengajukan dan unit Irban yang berwenang. OPD lain tidak dapat melihat konsultasi Anda.
        </div>
    </div>

    <div class="faq-item">
        <button type="button" class="faq-q" onclick="toggleFaq(this)">
            Bisakah saya membalas jawaban Irban untuk klarifikasi?
            <i class="bi bi-chevron-down"></i>
        </button>
        <div class="faq-a">
            Bisa. Selama konsultasi belum berstatus <strong>Selesai</strong>, Anda dapat mengirim balasan lanjutan melalui halaman detail tiket.
        </div>
    </div>

</div>


<div class="panduan-cta">
    <div>
        <h5>Siap mengajukan konsultasi?</h5>
        <p>Pilih kategori yang tepat agar konsultasi langsung diterima Irban yang berwenang.</p>
    </div>
    <a href="{{ route('opd.konsultasi.create') }}" class="btn-cta">
        <i class="bi bi-plus-circle me-1"></i>Buat Konsultasi Baru
    </a>
</div>

@endsection


@push('scripts')
<script>
function toggleFaq(btn) {
    var answer = btn.nextElementSibling;
    var isOpen = answer.classList.contains('tampil');

    document.querySelectorAll('.faq-a').forEach(function (a) { a.classList.remove('tampil'); });
    document.querySelectorAll('.faq-q').forEach(function (b) { b.classList.remove('aktif'); });

    if (!isOpen) {
        answer.classList.add('tampil');
        btn.classList.add('aktif');
    }
}
</script>
@endpush