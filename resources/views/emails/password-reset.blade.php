@component('mail::layout')
    @slot('header')
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="padding:16px 24px;text-align:center;background:#0e7a3a;">
                    <p style="color:#fff;font-size:16px;font-weight:600;margin:0;">Puskesmas Sukaraja</p>
                </td>
            </tr>
        </table>
    @endslot

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:32px 0;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;background:#fff;border-radius:20px;padding:32px;border:1px solid #e2e8f0;">
                    <tr>
                        <td style="font-family:'Inter',Arial,sans-serif;color:#0f172a;font-size:18px;font-weight:600;padding-bottom:12px;">
                            Hai {{ $user->nama_lengkap ?? $user->username }},
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:'Inter',Arial,sans-serif;color:#475569;font-size:14px;line-height:1.7;padding-bottom:24px;">
                            Kami menerima permintaan untuk mengatur ulang kata sandi akun Puskesmas Sukaraja Anda. Klik tombol di bawah untuk melanjutkan proses reset.
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-bottom:24px;">
                            <a href="{{ $resetUrl }}" style="display:inline-block;padding:14px 26px;border-radius:999px;background:#0e7a3a;color:#fff;font-weight:600;font-size:15px;text-decoration:none;">
                                Reset Kata Sandi
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:'Inter',Arial,sans-serif;color:#475569;font-size:13px;line-height:1.7;padding-bottom:16px;">
                            Tautan ini akan kedaluwarsa dalam <strong>{{ $minutes }} menit</strong>. Jika Anda tidak meminta reset kata sandi, abaikan email ini dan akun Anda akan tetap aman.
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:'Inter',Arial,sans-serif;color:#94a3b8;font-size:12px;line-height:1.7;">
                            Jika tombol di atas tidak berfungsi, salin dan tempel URL berikut ke peramban Anda:
                            <br>
                            <span style="display:inline-block;margin-top:8px;color:#0e7a3a;word-break:break-all;">{{ $resetUrl }}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    @slot('footer')
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="padding:16px 24px;text-align:center;font-size:12px;color:#94a3b8;">
                    © {{ now()->year }} Puskesmas Sukaraja. Semua hak dilindungi.
                </td>
            </tr>
        </table>
    @endslot
@endcomponent
