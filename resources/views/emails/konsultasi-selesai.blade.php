@extends('emails.tata-letak')

@section('judul-surel', 'Konsultasi Telah Selesai')

@section('isi-surel')
    <p style="margin:0 0 18px; font-size:15px; line-height:1.7;">
        Konsultasi Anda telah dinyatakan selesai oleh Inspektorat Kabupaten Ngawi.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
           style="background-color:#f6f9fc; border:1px solid #e2e8f0; border-radius:10px; margin-bottom:22px;">
        <tr>
            <td style="padding:16px 18px;">
                <div style="font-size:11px; color:#8695a5; text-transform:uppercase; letter-spacing:0.6px;">Nomor Register</div>
                <div style="font-size:17px; font-weight:bold; color:#0d2f5e; font-family:'Courier New', monospace; margin-top:3px;">{{ $kode }}</div>

                <div style="font-size:11px; color:#8695a5; text-transform:uppercase; letter-spacing:0.6px; margin-top:14px;">Perihal</div>
                <div style="font-size:14px; margin-top:3px;">{{ $judul }}</div>
            </td>
        </tr>
    </table>

    <p style="margin:0 0 22px; font-size:14px; line-height:1.7; color:#5b6b7c;">
        Seluruh percakapan tersimpan sebagai arsip dan tetap dapat dibuka kembali
        sewaktu-waktu melalui menu Riwayat. Terima kasih telah menggunakan layanan E-KONSUL.
    </p>

    <table role="presentation" cellpadding="0" cellspacing="0">
        <tr>
            <td style="background-color:#0d2f5e; border-radius:8px;">
                <a href="{{ route('login') }}"
                   style="display:inline-block; padding:12px 26px; color:#ffffff; font-size:14px; font-weight:bold; text-decoration:none;">
                    Buka E-KONSUL
                </a>
            </td>
        </tr>
    </table>
@endsection
