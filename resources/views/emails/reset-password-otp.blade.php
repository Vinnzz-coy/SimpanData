<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode OTP Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">
    <div style="max-width:500px; margin:auto; background:#ffffff; padding:25px; border-radius:8px; border:1px solid #e0e0e0;">

        <div style="text-align:center; margin-bottom:25px;">
            <div style="font-size:32px; color:#dc2626; margin-bottom:10px;">
                🔐
            </div>
            <h2 style="color:#333; margin:0; font-size:22px;">
                Reset Password Anda
            </h2>
            <p style="color:#666; font-size:14px; margin-top:8px;">
                Permintaan reset password diterima untuk akun Anda
            </p>
        </div>

        <p style="color:#333; line-height:1.6; margin-bottom:20px;">
            Halo,<br>
            Gunakan kode OTP berikut untuk melanjutkan proses reset password akun Anda:
        </p>

        <div style="
            font-size:28px;
            font-weight:bold;
            letter-spacing:6px;
            background:#fef2f2;
            color:#dc2626;
            padding:20px;
            text-align:center;
            border-radius:6px;
            margin:25px 0;
            border:2px dashed #fecaca;
            font-family:'Courier New', monospace;
        ">
            {{ $otp }}
        </div>

        <div style="
            background:#f0f9ff;
            border:1px solid #bae6fd;
            border-radius:6px;
            padding:12px;
            margin-bottom:25px;
            text-align:center;
        ">
            <p style="color:#0369a1; margin:0; font-size:13px;">
                ⏰ Kode ini akan kedaluwarsa dalam: <strong style="color:#dc2626;">5 menit</strong>
            </p>
        </div>

        <div style="
            background:#fff7ed;
            border:1px solid #fed7aa;
            border-radius:6px;
            padding:12px;
            margin-bottom:25px;
        ">
            <p style="color:#92400e; font-size:12px; margin:0; line-height:1.5;">
                ⚠️ <strong>Peringatan:</strong> Jangan membagikan kode OTP ini kepada siapa pun,
                termasuk kepada pihak yang mengaku dari tim support kami.
            </p>
        </div>

        <div style="text-align:center; padding-top:20px; border-top:1px solid #e0e0e0;">
            <p style="color:#666; font-size:13px; margin-bottom:20px;">
                Email ini dikirim secara otomatis sebagai respons permintaan reset password.
                <br>Jangan membalas email ini.
            </p>

            <p style="color:#999; font-size:12px; margin:0;">
                © {{ date('Y') }} SimpanData. All rights reserved.
            </p>
        </div>

    </div>
</body>
</html>
