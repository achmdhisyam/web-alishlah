<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengumuman Hasil Seleksi SPMB</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333; margin: 0; padding: 20px; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; border: 1px solid #dddddd; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        
        <?php if ($status_pendaftaran == 'Diterima') : ?>
            <h2 style="color: #27ae60; text-align: center; border-bottom: 2px solid #27ae60; padding-bottom: 15px; margin-top: 0;">Selamat! Anda Diterima</h2>
        <?php else : ?>
            <h2 style="color: #c0392b; text-align: center; border-bottom: 2px solid #c0392b; padding-bottom: 15px; margin-top: 0;">Pengumuman Hasil Seleksi</h2>
        <?php endif; ?>
        
        <p>Halo <strong><?= esc($nama_siswa) ?></strong>,</p>
        
        <p>Panitia Penerimaan Siswa Baru <strong><?= esc($namaweb) ?></strong> telah selesai melakukan seleksi berkas dan kriteria penerimaan untuk pendaftaran Anda.</p>
        
        <div style="background-color: #f9f9f9; padding: 20px; border-radius: 6px; margin: 20px 0; border: 1px solid #eeeeee;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 6px 0; font-weight: bold; width: 40%;">Nama Lengkap</td>
                    <td style="padding: 6px 0;"><?= esc($nama_siswa) ?></td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; font-weight: bold;">Kode Pendaftaran</td>
                    <td style="padding: 6px 0; font-weight: bold; color: #2980b9;"><?= esc($kode_siswa) ?></td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; font-weight: bold;">Program Pendidikan</td>
                    <td style="padding: 6px 0;"><?= esc($program) ?></td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; font-weight: bold;">Status Penerimaan</td>
                    <td style="padding: 6px 0;">
                        <?php if ($status_pendaftaran == 'Diterima') : ?>
                            <span style="background-color: #d4edda; color: #155724; padding: 5px 10px; border-radius: 4px; font-weight: bold; font-size: 14px;">Diterima / Lolos Seleksi</span>
                        <?php else : ?>
                            <span style="background-color: #f8d7da; color: #721c24; padding: 5px 10px; border-radius: 4px; font-weight: bold; font-size: 14px;">Tidak Diterima</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>

        <?php if ($status_pendaftaran == 'Diterima') : ?>
            <p>Selamat bergabung menjadi bagian dari keluarga besar <strong><?= esc($namaweb) ?></strong>. Silakan segera melakukan registrasi ulang dan administrasi lanjutan sesuai petunjuk di portal pendaftaran.</p>
        <?php else : ?>
            <p>Mohon maaf, berdasarkan kuota pendaftaran dan hasil seleksi administratif, saat ini Anda dinyatakan <strong>tidak lolos seleksi</strong>. Terima kasih telah mendaftar dan menaruh minat yang besar pada sekolah kami. Tetap semangat!</p>
        <?php endif; ?>

        <div style="text-align: center; margin: 30px 0 10px 0;">
            <a href="<?= esc($link_login) ?>" style="background-color: #2980b9; color: #ffffff; padding: 12px 25px; text-decoration: none; font-weight: bold; border-radius: 4px; display: inline-block;">Lihat Portal SPMB</a>
        </div>

        <hr style="border: 0; border-top: 1px solid #eeeeee; margin: 30px 0;">
        <p style="font-size: 12px; color: #7f8c8d; text-align: center; margin-bottom: 0;">
            Email ini dikirim secara otomatis oleh sistem SPMB <?= esc($namaweb) ?>. Harap tidak membalas email ini.
        </p>
    </div>
</body>
</html>
