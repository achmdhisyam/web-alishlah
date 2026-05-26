<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Permintaan Reset Password</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow: hidden;">
        <tr>
            <td style="background-color: #dc3545; padding: 30px; text-align: center; color: #ffffff;">
                <h1 style="margin: 0; font-size: 24px;">Reset Password</h1>
                <p style="margin: 10px 0 0; font-size: 16px; opacity: 0.9;">Permintaan pengaturan ulang kata sandi</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 40px 30px;">
                <p style="font-size: 16px; color: #333333; margin-top: 0;">Hai <strong><?= esc($nama) ?></strong>,</p>
                <p style="font-size: 16px; color: #555555; line-height: 1.6;">Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda. Silakan klik tombol di bawah ini untuk membuat kata sandi baru:</p>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 30px 0;">
                    <tr>
                        <td align="center">
                            <a href="<?= esc($link_reset) ?>" style="display: inline-block; background-color: #dc3545; color: #ffffff; text-decoration: none; font-size: 16px; font-weight: bold; padding: 14px 30px; border-radius: 5px; box-shadow: 0 2px 5px rgba(220,53,69,0.3);">Reset Password Sekarang</a>
                        </td>
                    </tr>
                </table>
                
                <p style="font-size: 14px; color: #888888; line-height: 1.5; margin-bottom: 0;"><strong>Penting:</strong> Link reset password ini hanya berlaku sementara. Jika Anda merasa tidak meminta pengaturan ulang kata sandi, harap abaikan pesan ini. Akun Anda akan tetap aman.</p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f8f9fa; padding: 20px 30px; text-align: center; border-top: 1px solid #eeeeee;">
                <p style="margin: 0; font-size: 14px; color: #777777;">Hormat kami,</p>
                <p style="margin: 5px 0 0; font-size: 14px; color: #333333; font-weight: bold;">Tim <?= esc($namaweb) ?></p>
            </td>
        </tr>
    </table>
</body>
</html>
