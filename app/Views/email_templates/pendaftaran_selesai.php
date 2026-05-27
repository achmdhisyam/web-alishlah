<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pendaftaran Berhasil</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow: hidden;">
        <tr>
            <td style="background-color: #1a73e8; padding: 30px; text-align: center; color: #ffffff;">
                <h1 style="margin: 0; font-size: 24px;">Pendaftaran Berhasil!</h1>
                <p style="margin: 10px 0 0; font-size: 16px; opacity: 0.9;">Biodata & Dokumen Anda Telah Diterima</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 40px 30px;">
                <p style="font-size: 16px; color: #333333; margin-top: 0;">Hai <strong><?= esc($nama_siswa) ?></strong>,</p>
                <p style="font-size: 16px; color: #555555; line-height: 1.6;">Terima kasih telah melengkapi biodata dan mengunggah dokumen pendukung untuk seleksi Penerimaan Peserta Didik Baru di <strong><?= esc($namaweb) ?></strong>.</p>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 25px 0; background-color: #ebf5fb; border-radius: 5px; border-left: 4px solid #1a73e8;">
                    <tr>
                        <td style="padding: 15px;">
                            <p style="margin: 0 0 5px; font-size: 14px; color: #555555;">KODE PENDAFTARAN ANDA</p>
                            <p style="margin: 0; font-size: 22px; color: #1a73e8; font-weight: bold; letter-spacing: 1px;"><?= esc($kode_siswa) ?></p>
                        </td>
                    </tr>
                </table>

                <p style="font-size: 16px; color: #555555; line-height: 1.6;">Simpan kode pendaftaran di atas dengan baik. Kode ini akan digunakan untuk memeriksa status kelulusan dan hasil seleksi Anda.</p>

                <h3 style="color: #333333; margin-top: 25px; font-size: 18px; border-bottom: 1px solid #eeeeee; padding-bottom: 8px;">Detail Pendaftaran:</h3>
                <table width="100%" border="0" cellspacing="0" cellpadding="8" style="font-size: 15px; color: #555555;">
                    <tr>
                        <td width="40%" style="font-weight: bold; border-bottom: 1px solid #f1f1f1;">Program Pendidikan</td>
                        <td style="border-bottom: 1px solid #f1f1f1;"><?= esc($program) ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; border-bottom: 1px solid #f1f1f1;">Periode / Gelombang</td>
                        <td style="border-bottom: 1px solid #f1f1f1;"><?= esc($gelombang) ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; border-bottom: 1px solid #f1f1f1;">Tanggal Pengumuman</td>
                        <td style="border-bottom: 1px solid #f1f1f1;"><?= esc($tgl_pengumuman) ?></td>
                    </tr>
                </table>

                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 30px 0;">
                    <tr>
                        <td align="center">
                            <a href="<?= esc($link_pengumuman) ?>" style="display: inline-block; background-color: #1a73e8; color: #ffffff; text-decoration: none; font-size: 16px; font-weight: bold; padding: 14px 30px; border-radius: 5px; box-shadow: 0 2px 5px rgba(26,115,232,0.3);">Cek Status Pengumuman</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f8f9fa; padding: 20px 30px; text-align: center; border-top: 1px solid #eeeeee;">
                <p style="margin: 0; font-size: 12px; color: #777777;">
                    Email ini dikirim secara otomatis oleh sistem SPMB <?= esc($namaweb) ?>. Harap tidak membalas email ini.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
