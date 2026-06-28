<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>📢 Ada Calon Siswa Baru Terdaftar!</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6; color: #333; background-color: #f4f6f9; padding: 20px; margin: 0;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #e9ecef;">
        <div style="text-align: center; border-bottom: 2px solid #28a745; padding-bottom: 20px; margin-bottom: 25px;">
            <span style="font-size: 36px;">📢</span>
            <h2 style="color: #28a745; margin: 10px 0 0 0; font-size: 20px;">Ada Calon Siswa Baru Terdaftar!</h2>
        </div>
        
        <p>Halo Admin SPMB,</p>
        <p>Sistem mendeteksi adanya calon pendaftar baru yang telah berhasil mengisi biodata pendaftaran. Berikut ringkasan informasinya:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0; background-color: #f8f9fa; border-radius: 6px; overflow: hidden;">
            <tr>
                <td style="padding: 12px 15px; border-bottom: 1px solid #dee2e6; font-weight: bold; color: #495057;" width="35%">Nama Lengkap</td>
                <td style="padding: 12px 15px; border-bottom: 1px solid #dee2e6; color: #212529;"><?= esc($nama_siswa) ?></td>
            </tr>
            <tr>
                <td style="padding: 12px 15px; border-bottom: 1px solid #dee2e6; font-weight: bold; color: #495057;">NISN</td>
                <td style="padding: 12px 15px; border-bottom: 1px solid #dee2e6; color: #212529;"><?= esc($nisn) ?></td>
            </tr>
            <tr>
                <td style="padding: 12px 15px; border-bottom: 1px solid #dee2e6; font-weight: bold; color: #495057;">Program/Jenjang</td>
                <td style="padding: 12px 15px; border-bottom: 1px solid #dee2e6; color: #212529;"><?= esc($program) ?></td>
            </tr>
            <tr>
                <td style="padding: 12px 15px; border-bottom: 1px solid #dee2e6; font-weight: bold; color: #495057;">No. Telepon</td>
                <td style="padding: 12px 15px; border-bottom: 1px solid #dee2e6; color: #212529;"><?= esc($telepon) ?></td>
            </tr>
        </table>
        
        <p style="margin-top: 25px;">Silakan klik tautan di bawah ini untuk memeriksa berkas persyaratan dan memproses status pendaftaran calon siswa tersebut:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="<?= $link_kelola ?>" target="_blank" style="background-color: #28a745; color: #ffffff; padding: 12px 30px; text-decoration: none; font-weight: bold; border-radius: 4px; display: inline-block; box-shadow: 0 2px 5px rgba(40, 167, 69, 0.3);">
                Periksa Berkas & Kelola
            </a>
        </div>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin-top: 30px; margin-bottom: 20px;">
        <p style="font-size: 11px; color: #868e96; text-align: center; margin: 0;">
            Email ini dikirim secara otomatis oleh Sistem SPMB <?= esc($namaweb) ?>.
        </p>
    </div>
</body>
</html>
