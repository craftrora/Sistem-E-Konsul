<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judul-surel', 'E-KONSUL')</title>
</head>
<body style="margin:0; padding:0; background-color:#f1f5f9; font-family:Arial, Helvetica, sans-serif; color:#16202b;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9; padding:28px 12px;">
        <tr>
            <td align="center">

                <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                       style="max-width:560px; background-color:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #e2e8f0;">

                    {{-- Kepala --}}
                    <tr>
                        <td style="background-color:#0d2f5e; padding:22px 28px;">
                            <div style="color:#ffffff; font-size:19px; font-weight:bold; letter-spacing:-0.3px;">E-KONSUL</div>
                            <div style="color:rgba(255,255,255,0.7); font-size:12px; margin-top:3px;">
                                Inspektorat Kabupaten Ngawi
                            </div>
                        </td>
                    </tr>

                    {{-- Isi --}}
                    <tr>
                        <td style="padding:30px 28px;">
                            @yield('isi-surel')
                        </td>
                    </tr>

                    {{-- Kaki --}}
                    <tr>
                        <td style="background-color:#f8fafc; padding:18px 28px; border-top:1px solid #e2e8f0;">
                            <p style="margin:0; font-size:11px; color:#8695a5; line-height:1.6;">
                                Surel ini dikirim otomatis oleh sistem E-KONSUL. Mohon tidak membalas surel ini.
                                Untuk pertanyaan lebih lanjut, hubungi Sekretariat Inspektorat Kabupaten Ngawi
                                pada nomor (0351) 749016.
                            </p>
                        </td>
                    </tr>

                </table>

                <p style="margin:16px 0 0; font-size:11px; color:#8695a5;">
                    &copy; {{ date('Y') }} Inspektorat Kabupaten Ngawi
                </p>

            </td>
        </tr>
    </table>

</body>
</html>
