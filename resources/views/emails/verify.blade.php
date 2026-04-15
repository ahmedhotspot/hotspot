<!doctype html>
<html lang="{{ $isAr ? 'ar' : 'en' }}" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $isAr ? 'تأكيد البريد' : 'Verify Email' }}</title>
</head>
<body style="margin:0;padding:0;background:#f5f7fb;font-family:Tahoma,Arial,sans-serif;color:#1e2333;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f7fb;padding:30px 0;">
        <tr><td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 18px rgba(0,0,0,.06);">
                <tr><td style="background:linear-gradient(135deg,#FF4040 0%,#FF6B6B 100%);padding:28px 30px;color:#fff;">
                    <h1 style="margin:0;font-size:22px;">{{ $isAr ? 'مرحباً بك في هوت سبوت' : 'Welcome to Hotspot' }}</h1>
                </td></tr>
                <tr><td style="padding:30px;">
                    <p style="font-size:16px;margin:0 0 14px;">{{ $isAr ? 'مرحباً' : 'Hi' }} {{ $name }},</p>
                    <p style="font-size:15px;line-height:1.7;color:#374151;margin:0 0 22px;">
                        {{ $isAr
                            ? 'شكراً لتسجيلك في هوت سبوت. الرجاء تأكيد بريدك الإلكتروني عبر الزر التالي لتفعيل حسابك.'
                            : 'Thanks for signing up to Hotspot. Please verify your email address by clicking the button below to activate your account.' }}
                    </p>
                    <p style="text-align:center;margin:30px 0;">
                        <a href="{{ $verifyUrl }}"
                           style="background:#FF4040;color:#fff;padding:14px 32px;text-decoration:none;border-radius:8px;display:inline-block;font-weight:700;font-size:15px;">
                            {{ $isAr ? 'تأكيد البريد الإلكتروني' : 'Verify Email' }}
                        </a>
                    </p>
                    <p style="font-size:13px;color:#6b7280;line-height:1.7;margin:0 0 6px;">
                        {{ $isAr ? 'أو انسخ الرابط التالي في متصفحك:' : 'Or copy this link into your browser:' }}
                    </p>
                    <p style="font-size:12px;color:#0d6efd;word-break:break-all;margin:0 0 22px;">{{ $verifyUrl }}</p>
                    <p style="font-size:12px;color:#9ca3af;margin:0;">
                        {{ $isAr ? 'إذا لم تقم بالتسجيل، يمكنك تجاهل هذه الرسالة.' : "If you didn't register, you can safely ignore this email." }}
                    </p>
                </td></tr>
                <tr><td style="background:#fafbff;padding:18px 30px;border-top:1px solid #eef0f5;font-size:12px;color:#6b7280;text-align:center;">
                    © {{ date('Y') }} Hotspot. {{ $isAr ? 'جميع الحقوق محفوظة.' : 'All rights reserved.' }}
                </td></tr>
            </table>
        </td></tr>
    </table>
</body>
</html>
