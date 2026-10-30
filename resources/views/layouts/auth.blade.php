<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judul', 'Masuk') — E-KONSUL Inspektorat Kabupaten Ngawi</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
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
            --latar-mud: #f6f9fc;
            --font: 'Plus Jakarta Sans', system-ui, sans-serif;
            --mono: 'JetBrains Mono', ui-monospace, monospace;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh;
            font-family: var(--font); color: var(--tinta);
            background: #fff;
            display: grid; grid-template-columns: 1fr 1fr;
            -webkit-font-smoothing: antialiased;
        }
        a { text-decoration: none; }

        /* ===== Sisi kiri: panel navy + ilustrasi jaringan ===== */
        .panel {
    position: relative;
    overflow: hidden;

    background:
    radial-gradient(circle at 20% 20%,
    rgba(255,255,255,.12),
    transparent 25%),

    radial-gradient(circle at 80% 80%,
    rgba(43,143,214,.35),
    transparent 35%),

    linear-gradient(
    145deg,
    #071d3b,
    #103d73 50%,
    #1769aa
    );

    color:#fff;

    padding:2.6rem 3rem;

    display:flex;
    flex-direction:column;
    justify-content:space-between;
}
        .panel > * { position: relative; z-index: 2; }

        /* baris identitas: lambang + E-KONSUL sejajar satu baris */
        .baris-identitas { display: flex; align-items: center; gap: .85rem; flex-wrap: wrap; }
        .identitas-instansi { display: flex; align-items: center; gap: .55rem; }
        .identitas-instansi img.lambang-kecil { height: 30px; width: auto; }
        .identitas-instansi .kotak {
            width: 30px; height: 30px; border-radius: 9px;
            background: rgba(255,255,255,.14); color: #fff;
            display: flex; align-items: center; justify-content: center; font-size: .88rem;
        }
        .identitas-instansi .nama { font-weight: 700; font-size: .78rem; letter-spacing: -.005em; color: rgba(255,255,255,.92); line-height: 1.25; }
        .identitas-instansi .sub { font-size: .66rem; color: rgba(255,255,255,.55); }

        .pemisah-vertikal { width: 1px; height: 30px; background: rgba(255,255,255,.2); flex-shrink: 0; }

        .merek-ekonsul-panel { display: flex; align-items: center; gap: .6rem; }
        .merek-ekonsul-panel .ikon-panel { height: 32px; width: auto; }
        .merek-ekonsul-panel .kotak {
            width: 32px; height: 32px; border-radius: 9px;
            background: rgba(255,255,255,.14); color: var(--emas);
            display: flex; align-items: center; justify-content: center; font-size: .92rem;
        }
        .merek-ekonsul-panel .nama { font-weight: 800; font-size: 1.02rem; color: #fff; letter-spacing: -.01em; }

        /* ilustrasi jaringan */
        .panggung-ilustrasi {

    flex:1;

    display:flex;

    align-items:center;

    justify-content:center;

    margin:0;

    min-height:0;

    position:absolute;

    top:50%;

    left:50%;

    transform:translate(-50%,-50%);

    width:100%;

}
        .panggung-ilustrasi svg { width: 100%; max-width: 400px; height: auto; }

        .apung-panel { animation: apungPanel 5.5s ease-in-out infinite; }
        .apung-panel.j2 { animation-delay: .6s; }
        .apung-panel.j3 { animation-delay: 1.2s; }
        .apung-panel.j4 { animation-delay: 1.8s; }
        @keyframes apungPanel { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-7px); } }

        .alir-titik { animation: alirTitik 3s ease-in-out infinite; }
        @keyframes alirTitik { 0%,100% { opacity: .3; } 50% { opacity: 1; } }

        .panel h2 {
            font-size: 1.7rem; font-weight: 800; letter-spacing: -.032em;
            line-height: 1.22; margin: 0 0 .8rem;
        }
        .panel h2 em { font-style: italic; color: #8ecbf5; }
        .panel .ket { color: rgba(255,255,255,.72); line-height: 1.7; font-size: .92rem; max-width: 23rem; margin: 0 0 1.3rem; }

        .poin { display: flex; flex-direction: column; gap: .6rem; }
        .poin div { display: flex; align-items: center; gap: .6rem; font-size: .86rem; color: rgba(255,255,255,.85); }
        .poin i { color: #8ecbf5; }

        .balik {

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:.5rem;

    padding:.65rem 1.2rem;

    border-radius:10px;

    background:rgba(255,255,255,.12);

    border:1px solid rgba(255,255,255,.2);

    color:#fff;

    font-size:.87rem;

    font-weight:600;

    transition:.3s ease;

}


.balik:hover{

    background:rgba(255,255,255,.22);

    transform:translateY(-2px);

    color:#fff;

}



.hak{

    width:100%;

    text-align:center;

    font-size:.74rem;

    color:rgba(255,255,255,.55);

    margin-top:1rem;

}

        /* ===== Animasi Alur Konsultasi ===== */

.alur-konsultasi{
    width:100%;
    max-width:340px;

    display:flex;
    flex-direction:column;
    align-items:center;
    gap:.8rem;

    position:relative;
}
/* dekorasi glow belakang */

.panggung-ilustrasi::before{

    content:"";

    position:absolute;

    width:280px;

    height:280px;

    border-radius:50%;

    background:
    radial-gradient(
        circle,
        rgba(43,143,214,.35),
        transparent 70%
    );

    filter:blur(10px);

    animation:glowMove 5s ease-in-out infinite;

}



.panggung-ilustrasi::after{

    content:"";

    position:absolute;

    width:90px;

    height:90px;

    border-radius:50%;

    background:
    rgba(255,255,255,.12);

    top:20px;

    right:40px;

    animation:bubbleFloat 6s ease-in-out infinite;

}

/* ===================== PARTICLE BACKGROUND ===================== */

.panel::before{

    content:"";

    position:absolute;

    inset:0;

    background-image:
        radial-gradient(circle, rgba(255,255,255,.8) 1px, transparent 2px),
        radial-gradient(circle, rgba(142,203,245,.7) 1.5px, transparent 3px),
        radial-gradient(circle, rgba(255,255,255,.4) 2px, transparent 4px);

    background-size:
        80px 80px,
        120px 120px,
        180px 180px;

    background-position:
        0 0,
        40px 80px,
        90px 40px;

    opacity:.35;

    animation:
        particleMove 18s linear infinite;

    z-index:0;

}



/* gelembung transparan */

.panel::after{

    content:"";

    position:absolute;

    width:260px;

    height:260px;

    border-radius:50%;

    background:

    radial-gradient(
        circle,
        rgba(255,255,255,.15),
        rgba(255,255,255,0)
    );


    top:25%;

    right:8%;


    animation:

    bubbleMove 8s ease-in-out infinite;


    z-index:0;

}




@keyframes particleMove{


    from{

        background-position:
        0 0,
        40px 80px,
        90px 40px;

    }


    to{

        background-position:
        120px 120px,
        180px 160px,
        260px 100px;

    }


}



@keyframes bubbleMove{


    0%,100%{

        transform:
        translateY(0)
        scale(1);

        opacity:.5;

    }


    50%{

        transform:
        translateY(-35px)
        scale(1.15);

        opacity:.9;

    }

}

@keyframes glowMove{

    0%,100%{
        transform:scale(1);
        opacity:.7;
    }

    50%{
        transform:scale(1.15);
        opacity:1;
    }

}



@keyframes bubbleFloat{

    0%,100%{
        transform:translateY(0);
    }

    50%{
        transform:translateY(-20px);
    }

}

.flow-card{

    width:300px;

    display:flex;
    align-items:center;
    gap:1rem;

    padding:1rem 1.2rem;

    border-radius:18px;

    background:rgba(255,255,255,.12);

    border:1px solid rgba(255,255,255,.18);

    backdrop-filter:blur(12px);

    color:#fff;

    box-shadow:
    0 15px 35px rgba(0,0,0,.15);

    animation:floatingCard 4s ease-in-out infinite;

    transition:.3s ease;

}

.flow-card:hover{

    transform:translateY(-5px) scale(1.03);

    background:rgba(255,255,255,.18);

}

.flow-card:nth-child(3){
    animation-delay:.7s;
}


.flow-card:nth-child(5){
    animation-delay:1.4s;
}



.flow-icon{

    width:48px;
    height:48px;

    border-radius:14px;

    background:
    rgba(255,255,255,.18);

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:1.4rem;

    color:#8ecbf5;

}



.flow-card strong{

    display:block;

    font-size:.95rem;

}


.flow-card small{

    display:block;

    color:rgba(255,255,255,.65);

    font-size:.75rem;

    margin-top:.2rem;

}



.flow-line{

    width:2px;

    height:35px;

    background:
    linear-gradient(
        to bottom,
        rgba(142,203,245,.2),
        #8ecbf5,
        rgba(142,203,245,.2)
    );

    position:relative;

    overflow:hidden;

}



.flow-line span{

    position:absolute;

    width:100%;

    height:15px;

    background:#fff;

    top:-20px;

    animation:jalanFlow 2s linear infinite;

}








@keyframes floatingCard{

    0%,100%{
        transform:translateY(0);
    }

    50%{
        transform:translateY(-8px);
    }

}



@keyframes jalanFlow{

    from{
        top:-20px;
    }

    to{
        top:50px;
    }

}



        /* ===== Sisi kanan: formulir ===== */
        .sisi-form {
            position: relative; overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            padding: 3rem 2.5rem;
            background: linear-gradient(160deg, #eaf2fb 0%, #f7fbff 55%, #eef4fb 100%);
        }
        .pola-titik-hias {
            position: absolute; width: 130px; height: 130px;
            background-image: radial-gradient(rgba(13,47,94,.14) 1.5px, transparent 1.5px);
            background-size: 14px 14px;
            pointer-events: none;
        }
        .pola-titik-hias.kanan-atas { top: 0; right: 0; opacity: .7; }
        .pola-titik-hias.kiri-bawah { bottom: 0; left: 0; opacity: .5; }

        .kotak-form {
            width: 100%; max-width: 420px; position: relative; z-index: 2;
            background: #fff; border-radius: 20px;
            padding: 2.6rem 2.5rem;
            box-shadow: 0 1.8rem 3.6rem rgba(13,47,94,.14);
        }

        .kotak-form h1 { font-size: 1.55rem; font-weight: 800; letter-spacing: -.03em; color: var(--biru-tua); margin: 0 0 .35rem; }
        .kotak-form .pengantar { color: var(--abu); font-size: .92rem; margin: 0 0 1.9rem; }

        .kelompok { margin-bottom: 1.05rem; }
        .kelompok label { display: block; font-size: .85rem; font-weight: 600; color: var(--tinta); margin-bottom: .42rem; }

        .kotak-isian { position: relative; display: flex; align-items: center; }
        .kotak-isian .ikon-kiri {
            position: absolute; left: .95rem; color: var(--abu-mud); font-size: .95rem; pointer-events: none;
        }
        .isian, .pilihan {
            width: 100%; padding: .78rem 1rem .78rem 2.6rem;
            border: 1.5px solid var(--garis); border-radius: 10px;
            font-family: var(--font); font-size: .94rem; color: var(--tinta);
            background: #fff; transition: border-color .2s, box-shadow .2s;
        }
        .isian.polos, .pilihan.polos { padding-left: 1rem; }
        .isian:focus, .pilihan:focus {
            outline: none; border-color: var(--biru-cerah);
            box-shadow: 0 0 0 3.5px rgba(43,143,214,.14);
        }
        .isian::placeholder { color: #b3bfcb; }
        .isian.salah, .pilihan.salah { border-color: #d9534f; }

        .lihat-sandi {
            position: absolute; right: .55rem;
            background: none; border: none; cursor: pointer;
            color: var(--abu-mud); padding: .45rem; font-size: 1rem; line-height: 1;
        }
        .lihat-sandi:hover { color: var(--biru); }

        .bantuan { font-size: .78rem; color: var(--abu-mud); margin-top: .4rem; }
        .pesan-salah { font-size: .8rem; color: #d9534f; margin-top: .35rem; }

        .centang { display: flex; align-items: center; gap: .5rem; margin: 1.2rem 0 1.5rem; }
        .centang input { width: 16px; height: 16px; accent-color: var(--biru); }
        .centang label { font-size: .88rem; color: var(--abu); margin: 0; font-weight: 500; }

        .btn-kirim {
            width: 100%; padding: .88rem; border: none; border-radius: 10px;
            background: var(--biru-tua); color: #fff;
            font-family: var(--font); font-weight: 700; font-size: .98rem; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            transition: background-color .2s, transform .2s, box-shadow .2s;
        }
        .btn-kirim:hover { background: var(--biru); transform: translateY(-1px); box-shadow: 0 .7rem 1.4rem rgba(13,47,94,.24); }

        .tautan-bawah { text-align: center; font-size: .9rem; color: var(--abu); margin-top: 1.4rem; }
        .tautan-bawah a { color: var(--biru); font-weight: 700; }
        .tautan-bawah a:hover { text-decoration: underline; }

        .kabar {
            padding: .8rem 1rem; border-radius: 10px;
            font-size: .87rem; margin-bottom: 1.3rem; line-height: 1.55;
        }
        .kabar.gagal { background: #fdf2f2; border: 1px solid #f5d3d3; color: #b0413e; }
        .kabar.sukses { background: #f0faf4; border: 1px solid #cbe9d8; color: #1a7f4f; }
        .kabar div + div { margin-top: .3rem; }

        /* ===== Responsif ===== */
        @media (max-width: 900px) {
            body { grid-template-columns: 1fr; }
            .panel { display: none; }
            .sisi-form { padding: 2.5rem 1.5rem; min-height: 100vh; }
            .kotak-form { max-width: 100%; box-shadow: none; padding: 0; }
            .merek-ponsel { display: flex !important; }
        }
        .merek-ponsel { display: none; align-items: center; gap: .75rem; margin-bottom: 2rem; }
        .merek-ponsel .logo-ekonsul-ponsel { height: 36px; width: auto; }
        .merek-ponsel .kotak {
            width: 40px; height: 40px; border-radius: 11px;
            background: linear-gradient(140deg, var(--biru-tua), var(--biru));
            color: var(--emas); display: flex; align-items: center; justify-content: center;
        }
        .merek-ponsel .nama { font-weight: 800; font-size: 1.1rem; color: var(--biru-tua); letter-spacing: -.02em; }
        @media (prefers-reduced-motion: reduce) {
            .apung-panel, .alir-titik { animation: none; }
        }
    </style>
</head>
<body>

    <aside class="panel">
        <div class="baris-identitas">
            <div class="identitas-instansi">
                @if (file_exists(public_path('assets/img/logo-ngawi.png')))
                    <img src="{{ asset('assets/img/logo-ngawi.png') }}" alt="Lambang Kabupaten Ngawi" class="lambang-kecil">
                @else
                    <div class="kotak"><i class="bi bi-shield-shaded"></i></div>
                @endif
                <div>
                    <div class="nama">Pemerintah Kabupaten Ngawi</div>
                    <div class="sub">Inspektorat Daerah</div>
                </div>
            </div>

            <span class="pemisah-vertikal" aria-hidden="true"></span>

            <div class="merek-ekonsul-panel">
                @if (file_exists(public_path('assets/img/logo-ekonsul-ikon.png')))
                    <img src="{{ asset('assets/img/logo-ekonsul-ikon.png') }}" alt="E-KONSUL" class="ikon-panel">
                @else
                    <div class="kotak"><i class="bi bi-shield-check"></i></div>
                @endif
                <div class="nama">E-KONSUL</div>
            </div>
        </div>

        {{-- Ilustrasi jaringan analitik --}}
        <div class="panggung-ilustrasi" role="img" aria-label="Ilustrasi jaringan data konsultasi yang saling terhubung">
        <div class="alur-konsultasi">

    <div class="flow-card masuk">
        <div class="flow-icon">
            <i class="bi bi-envelope-paper"></i>
        </div>
        <div>
            <strong>Surat Masuk</strong>
            <small>Pengajuan konsultasi</small>
        </div>
    </div>


    <div class="flow-line">
        <span></span>
    </div>


    <div class="flow-card proses">
        <div class="flow-icon">
            <i class="bi bi-shield-check"></i>
        </div>
        <div>
            <strong>Verifikasi</strong>
            <small>Dicek Inspektorat</small>
        </div>
    </div>


    <div class="flow-line">
        <span></span>
    </div>


    <div class="flow-card selesai">
        <div class="flow-icon">
            <i class="bi bi-chat-left-text"></i>
        </div>
        <div>
            <strong>Feedback</strong>
            <small>Jawaban diterima</small>
        </div>
    </div>


    <div class="flow-line">
        <span></span>
    </div>

    <div class="flow-card status">
        <div class="flow-icon">
            <i class="bi bi-clipboard-check"></i>
        </div>
        <div>
            <strong>Status Konsultasi</strong>
            <small>Pantau proses pengajuan Anda</small>
        </div>
    </div>

</div>{{-- end .alur-konsultasi --}}
        </div>{{-- end .panggung-ilustrasi --}}

        <div class="bagian-bawah-panel">
            <a href="{{ route('beranda') }}" class="balik">
                <i class="bi bi-arrow-left"></i> Kembali ke Beranda
            </a>
            <div class="hak">&copy; {{ date('Y') }} Inspektorat Kabupaten Ngawi</div>
        </div>

    </aside>

    <main class="sisi-form">
        <div class="pola-titik-hias kanan-atas" aria-hidden="true"></div>
        <div class="pola-titik-hias kiri-bawah" aria-hidden="true"></div>

        <div class="kotak-form">

            <a href="{{ route('beranda') }}" class="merek-ponsel">
                @if (file_exists(public_path('assets/img/logo-ekonsul-ikon.png')))
                    <img src="{{ asset('assets/img/logo-ekonsul-ikon.png') }}" alt="E-KONSUL" class="logo-ekonsul-ponsel">
                @else
                    <div class="kotak"><i class="bi bi-shield-check"></i></div>
                    <div class="nama">E-KONSUL</div>
                @endif
            </a>

            @yield('isi')
        </div>
    </main>

</body>
</html>
