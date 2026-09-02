<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
</head>

<body style="margin:0; padding:0; background-color:#f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

    <!-- Preheader (teks preview di inbox, disembunyikan dari tampilan) -->
    <div style="display:none; max-height:0; overflow:hidden; opacity:0;">
        Satu langkah lagi — verifikasi alamat email Anda untuk mengaktifkan akun {{ config('app.name', 'Project-S') }}.
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9; padding: 32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:480px; margin:0 auto;">

                    <!-- Brand header -->
                    <tr>
                        <td align="center" style="padding-bottom:24px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto;">
                                <tr>
                                    <td valign="middle" style="padding-right:8px;">
                                        <!-- bi-building (Bootstrap Icons), inline SVG -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="#1f2937" style="display:block;">
                                            <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z" />
                                            <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z" />
                                        </svg>
                                    </td>
                                    <td valign="middle">
                                        <span style="font-size:18px; font-weight:700; color:#1f2937;">
                                            {{ config('app.name', 'Project-S') }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Card -->
                    <tr>
                        <td style="background-color:#ffffff; border-radius:12px; padding:40px 32px; box-shadow:0 1px 3px rgba(0,0,0,0.08); border:1px solid #e5e7eb;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding-bottom:20px;">
                                        <!-- Icon circle: bi-envelope-check-fill (Bootstrap Icons), inline SVG -->
                                        <table role="presentation" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="72" height="72" align="center" valign="middle" style="background-color:#dcfce7; border-radius:50%;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16" fill="#16a34a">
                                                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.026A2 2 0 0 0 2 14h6.256A4.5 4.5 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586zM16 4.697v4.974A4.5 4.5 0 0 0 12.5 8a4.5 4.5 0 0 0-1.965.45l-.338-.207z" />
                                                        <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686" />
                                                    </svg>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" style="padding-bottom:12px;">
                                        <h1 style="margin:0; font-size:20px; line-height:1.4; color:#1f2937; font-weight:700;">
                                            Verifikasi Alamat Email Anda
                                        </h1>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" style="padding-bottom:28px;">
                                        <p style="margin:0; font-size:14px; line-height:1.6; color:#6b7280;">
                                            Halo, <strong style="color:#374151;">{{ $userName }}</strong>. Terima kasih sudah mendaftar
                                            di {{ config('app.name', 'Project-S') }}. Klik tombol di bawah untuk
                                            mengonfirmasi bahwa alamat email ini benar milik Anda dan mengaktifkan akun.
                                        </p>
                                    </td>
                                </tr>

                                <!-- Button -->
                                <tr>
                                    <td align="center" style="padding-bottom:28px;">
                                        <table role="presentation" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center" style="background-color:#2563eb; border-radius:8px;">
                                                    <a href="{{ $verificationUrl }}"
                                                        style="display:inline-block; padding:12px 28px; font-size:14px; font-weight:600; color:#ffffff; text-decoration:none; border-radius:8px;">
                                                        Verifikasi Email Saya
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border-top:1px solid #e5e7eb; padding-top:20px;">
                                        <p style="margin:0 0 6px 0; font-size:12px; line-height:1.6; color:#9ca3af;">
                                            Kalau tombol di atas tidak bisa diklik, salin dan tempel link berikut ke browser Anda:
                                        </p>
                                        <p style="margin:0; font-size:12px; line-height:1.6; word-break:break-all;">
                                            <a href="{{ $verificationUrl }}" style="color:#2563eb; text-decoration:underline;">{{ $verificationUrl }}</a>
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding-top:20px;">
                                        <p style="margin:0; font-size:12px; line-height:1.6; color:#9ca3af;">
                                            Kalau Anda tidak merasa membuat akun ini, abaikan saja email ini — tidak ada
                                            tindakan lebih lanjut yang diperlukan.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding-top:24px;">
                            <p style="margin:0; font-size:12px; color:#9ca3af;">
                                &copy; {{ date('Y') }} {{ config('app.name', 'Project-S') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>