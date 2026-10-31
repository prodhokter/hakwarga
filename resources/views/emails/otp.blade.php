<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Kode Masuk Kinerja</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f8fafc; color: #0f172a; padding: 32px 16px; margin: 0;">
    <div style="max-width: 480px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 32px;">
        <div style="margin-bottom: 24px;">
            <span style="font-size: 20px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">Kinerja</span>
            <span style="font-size: 11px; font-weight: 700; background-color: #e6ff94; color: #0f172a; padding: 2px 8px; border-radius: 99px; margin-left: 8px;">PUBLIK</span>
        </div>

        <p style="font-size: 14px; color: #334155; line-height: 1.5; margin-bottom: 20px;">
            Gunakan kode sekali pakai (OTP) berikut untuk masuk ke akun Anda. Kode ini berlaku selama 10 menit.
        </p>

        <div style="background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 12px; padding: 18px; text-align: center; margin: 24px 0;">
            <span style="font-family: 'Courier New', monospace; font-size: 32px; font-weight: 800; letter-spacing: 6px; color: #0f172a;">
                {{ $otp }}
            </span>
        </div>

        <p style="font-size: 12px; color: #64748b; line-height: 1.4; margin-top: 24px;">
            Jika Anda tidak meminta kode ini, abaikan surel ini. Jangan berikan kode ini kepada siapa pun.
        </p>
    </div>
</body>
</html>
