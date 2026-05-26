<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pendaftaran Berhasil</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333; margin: 0; padding: 20px; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; border: 1px solid #dddddd; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 style="color: #2c3e50; text-align: center; border-bottom: 2px solid #3498db; padding-bottom: 15px; margin-top: 0;">Pendaftaran Anda Berhasil!</h2>
        
        <p>Halo <strong><?= esc($nama_siswa) ?></strong>,</p>
        
        <p>Terima kasih telah melengkapi biodata dan mengunggah dokumen pendukung untuk seleksi Penerimaan Peserta Didik Baru di <strong><?= esc($namaweb) ?></strong>.</p>
        
        <div style="background-color: #ebf5fb; border-left: 4px solid #3498db; padding: 15px; margin: 20px 0; border-radius: 4px;">
            <p style="margin: 0; font-size: 16px;"><strong>KODE PENDAFTARAN ANDA:</strong></p>
            <p style="margin: 5px 0 0 0; font-size: 24px; font-weight: bold; color: #2c3e50; letter-spacing: 2px;"><?= esc($kode_siswa) ?></p>
        </div>

        <p>Simpan kode pendaftaran di atas dengan baik. Kode ini akan digunakan untuk memeriksa status kelulusan/pengumuman hasil seleksi.</p>

        <h3 style="color: #2c3e50; margin-top: 25px;">Detail Pendaftaran:</h3>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #eeeeee; font-weight: bold; width: 40%;">Program Pendidikan</td>
                <td style="padding: 8px; border-bottom: 1px solid #eeeeee;"><?= esc($program) ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #eeeeee; font-weight: bold;">Periode / Gelombang</td>
                <td style="padding: 8px; border-bottom: 1px solid #eeeeee;"><?= esc($gelombang) ?></td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #eeeeee; font-weight: bold;">Tanggal Pengumuman</td>
                <td style="padding: 8px; border-bottom: 1px solid #eeeeee;"><?= esc($tgl_pengumuman) ?></td>
            </tr>
        </table>

        <div style="text-align: center; margin: 30px 0 10px 0;">
            <a href="<?= esc($link_login) ?>" style="background-color: #3498db; color: #ffffff; padding: 12px 25px; text-decoration: none; font-weight: bold; border-radius: 4px; display: inline-block;">Masuk ke Dashboard Siswa</a>
        </div>

        <hr style="border: 0; border-top: 1px solid #eeeeee; margin: 30px 0;">
        <p style="font-size: 12px; color: #7f8c8d; text-align: center; margin-bottom: 0;">
            Email ini dikirim secara otomatis oleh sistem SPMB <?= esc($namaweb) ?>. Harap tidak membalas email ini.
        </p>
    </div>
</body>
</html>
