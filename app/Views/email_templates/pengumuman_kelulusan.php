<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengumuman Hasil Seleksi SPMB</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow: hidden;">
        <tr>
            <td style="background-color: <?= ($status_pendaftaran == 'Diterima') ? '#27ae60' : '#c0392b' ?>; padding: 30px; text-align: center; color: #ffffff;">
                <h1 style="margin: 0; font-size: 24px;">
                    <?= ($status_pendaftaran == 'Diterima') ? 'Selamat! Anda Diterima' : 'Pengumuman Hasil Seleksi' ?>
                </h1>
                <p style="margin: 10px 0 0; font-size: 16px; opacity: 0.9;">Hasil Seleksi Penerimaan Siswa Baru</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 40px 30px;">
                <p style="font-size: 16px; color: #333333; margin-top: 0;">Hai <strong><?= esc($nama_siswa) ?></strong>,</p>
                <p style="font-size: 16px; color: #555555; line-height: 1.6;">
                    Panitia Penerimaan Siswa Baru <strong><?= esc($namaweb) ?></strong> telah selesai melakukan seleksi berkas dan kriteria penerimaan untuk pendaftaran Anda. Berikut rincian keputusan hasil seleksi:
                </p>
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 25px 0; background-color: #f8f9fa; border-radius: 5px; border-left: 4px solid <?= ($status_pendaftaran == 'Diterima') ? '#27ae60' : '#c0392b' ?>;">
                    <tr>
                        <td style="padding: 15px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="4" style="font-size: 15px; color: #555555;">
                                <tr>
                                    <td width="40%" style="font-weight: bold;">Nama Lengkap</td>
                                    <td><?= esc($nama_siswa) ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Kode Pendaftaran</td>
                                    <td style="font-weight: bold; color: #1a73e8;"><?= esc($kode_siswa) ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Program Pendidikan</td>
                                    <td><?= esc($program) ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding-top: 8px;">Status Penerimaan</td>
                                    <td style="padding-top: 8px;">
                                        <?php if ($status_pendaftaran == 'Diterima') : ?>
                                            <span style="background-color: #d4edda; color: #155724; padding: 4px 10px; border-radius: 4px; font-weight: bold; font-size: 13px;">Diterima / Lolos Seleksi</span>
                                        <?php else : ?>
                                            <span style="background-color: #f8d7da; color: #721c24; padding: 4px 10px; border-radius: 4px; font-weight: bold; font-size: 13px;">Tidak Diterima</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <?php if ($status_pendaftaran == 'Diterima') : ?>
                    <p style="font-size: 16px; color: #555555; line-height: 1.6;">
                        Selamat bergabung menjadi bagian dari keluarga besar <strong><?= esc($namaweb) ?></strong>. Silakan segera melakukan registrasi ulang dan administrasi lanjutan sesuai petunjuk di portal pendaftaran.
                    </p>
                <?php else : ?>
                    <p style="font-size: 16px; color: #555555; line-height: 1.6;">
                        Mohon maaf, berdasarkan kuota pendaftaran dan hasil seleksi administratif, saat ini Anda dinyatakan <strong>tidak lolos seleksi</strong>. Terima kasih telah mendaftar dan menaruh minat yang besar pada madrasah kami. Tetap semangat!
                    </p>
                <?php endif; ?>


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
