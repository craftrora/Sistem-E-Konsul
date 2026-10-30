<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Identitas Instansi
    |--------------------------------------------------------------------------
    */
    'nama_aplikasi' => env('EKONSUL_NAMA', 'E-KONSUL'),
    'nama_instansi' => env('EKONSUL_INSTANSI', 'Inspektorat Kabupaten Ngawi'),
    'nama_daerah'   => env('EKONSUL_DAERAH', 'Kabupaten Ngawi'),

    /*
    |--------------------------------------------------------------------------
    | Pendaftaran Mandiri OPD
    |--------------------------------------------------------------------------
    */
    'pendaftaran' => [
        'dibuka'     => env('EKONSUL_PENDAFTARAN_DIBUKA', true),
        'wajib_kode' => env('EKONSUL_PENDAFTARAN_WAJIB_KODE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Penomoran Tiket
    |--------------------------------------------------------------------------
    | Format akhir: EKS-2026-000001
    */
    'prefix_tiket'  => env('EKONSUL_PREFIX_TIKET', 'EKS'),
    'panjang_nomor' => 6,

    /*
    |--------------------------------------------------------------------------
    | Lampiran
    |--------------------------------------------------------------------------
    | Disimpan pada disk privat, tidak diletakkan di folder publik.
    */
    'lampiran' => [
        'disk'           => 'local',
        'folder'         => 'lampiran',
        'maks_ukuran_kb' => 5120,
        'ekstensi'       => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png'],
        'mime'           => [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'image/jpeg',
            'image/png',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notifikasi Surel
    |--------------------------------------------------------------------------
    | Bila dimatikan, notifikasi dalam aplikasi tetap berjalan namun surel
    | tidak dikirim. Berguna saat pengembangan agar tidak membebani SMTP.
    |
    | Kegagalan pengiriman surel tidak pernah membatalkan proses tiket;
    | galat hanya dicatat pada berkas log.
    */
    'surel' => [
        'aktif' => env('EKONSUL_SUREL_AKTIF', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Tampilan
    |--------------------------------------------------------------------------
    */
    'per_halaman' => 15,
];
