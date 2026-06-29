<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pendaftaran Akun Berhasil</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow: hidden;">
        <tr>
            <td style="background-color: #1a73e8; padding: 30px; text-align: center; color: #ffffff;">
                <h1 style="margin: 0; font-size: 24px;">Selamat Datang!</h1>
                <p style="margin: 10px 0 0; font-size: 16px; opacity: 0.9;">Pendaftaran Akun Anda Berhasil</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 40px 30px;">
                <p style="font-size: 16px; color: #333333; margin-top: 0;">Hai <strong><?= esc($nama) ?></strong>,</p>
                <p style="font-size: 16px; color: #555555; line-height: 1.6;">Terima kasih telah mendaftar. Akun Anda telah berhasil dibuat. Berikut adalah detail pendaftaran Anda:</p>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 25px 0; background-color: #f8f9fa; border-radius: 5px; border-left: 4px solid #1a73e8;">
                    <tr>
                        <td style="padding: 15px;">
                            <p style="margin: 0 0 5px; font-size: 14px; color: #777777;">Nama Lengkap</p>
                            <p style="margin: 0 0 15px; font-size: 16px; color: #333333; font-weight: bold;"><?= esc($nama) ?></p>
                            <p style="margin: 0 0 5px; font-size: 14px; color: #777777;">Email / Username</p>
                            <p style="margin: 0; font-size: 16px; color: #333333; font-weight: bold;"><?= esc($email) ?></p>
                        </td>
                    </tr>
                </table>

                <p style="font-size: 16px; color: #555555; line-height: 1.6;">Untuk melanjutkan proses pendaftaran (memilih periode dan mengisi biodata), silakan masuk ke dashboard pendaftaran Anda melalui tombol di bawah ini:</p>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 30px 0;">
                    <tr>
                        <td align="center">
                            <a href="<?= esc($link_login) ?>" style="display: inline-block; background-color: #1a73e8; color: #ffffff; text-decoration: none; font-size: 16px; font-weight: bold; padding: 14px 30px; border-radius: 5px; box-shadow: 0 2px 5px rgba(26,115,232,0.3);">Masuk ke Dashboard</a>
                        </td>
                    </tr>
                </table>
                
                <p style="font-size: 14px; color: #888888; line-height: 1.5; margin-bottom: 0;">Jika Anda merasa tidak melakukan pendaftaran ini, abaikan saja email ini.</p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f8f9fa; padding: 20px 30px; text-align: center; border-top: 1px solid #eeeeee;">
                <p style="margin: 0; font-size: 14px; color: #777777;">Terima kasih,</p>
                <p style="margin: 5px 0 0; font-size: 14px; color: #333333; font-weight: bold;">Tim <?= esc($namaweb) ?></p>
            </td>
        </tr>
    </table>
</body>
</html>
