<?php
// Function to format phone number
if (!function_exists('format_phone_wa')) {
    function format_phone_wa($phone) {
        if (empty($phone)) return '';
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strpos($phone, '0') === 0) {
            $phone = '62' . substr($phone, 1);
        } elseif (strpos($phone, '8') === 0) {
            $phone = '62' . $phone;
        }
        return $phone;
    }
}

// Function to generate WA link
if (!function_exists('get_wa_link')) {
    function get_wa_link($phone, $tipe, $siswa, $website) {
        $formatted = format_phone_wa($phone);
        if (empty($formatted)) return '#';
        
        $status_pendaftaran_raw = $siswa->status_pendaftaran ?? 'Menunggu';
        $status_pendaftaran_txt = 'Menunggu Verifikasi';
        $langkah_selanjutnya = '';

        if ($status_pendaftaran_raw == 'Diterima') {
            $status_pendaftaran_txt = 'DITERIMA (LULUS)';
            $langkah_selanjutnya = "Selamat! Berkas pendaftaran telah diverifikasi dan dinyatakan Diterima. Silakan masuk ke dasbor pendaftaran siswa untuk mencetak Bukti Kelulusan dan mengikuti alur daftar ulang selanjutnya.";
        } elseif ($status_pendaftaran_raw == 'Tidak-Diterima') {
            $status_pendaftaran_txt = 'TIDAK DITERIMA (TIDAK LULUS)';
            $langkah_selanjutnya = "Mohon maaf, pendaftaran Anda saat ini dinyatakan Belum Diterima. Terima kasih banyak atas minat dan partisipasi Bapak/Ibu.";
        } elseif ($status_pendaftaran_raw == 'Diperiksa') {
            $status_pendaftaran_txt = 'SEDANG DIPERIKSA';
            $langkah_selanjutnya = "Berkas pendaftaran Anda saat ini sedang diperiksa secara detail oleh tim verifikator kami. Mohon untuk memantau dasbor pendaftaran siswa secara berkala.";
        } else {
            $status_pendaftaran_txt = 'MENUNGGU VERIFIKASI';
            $langkah_selanjutnya = "Berkas pendaftaran Anda telah tersimpan dan berada dalam antrean Menunggu Verifikasi. Kami akan segera memeriksa berkas Anda. Mohon pastikan data dan berkas yang diunggah sudah lengkap dan benar.";
        }

        $pesan = "Assalamu'alaikum Wr. Wb.\n\n"
               . "Yth. Bapak/Ibu Orang Tua/Wali (" . $tipe . ") dari calon siswa *" . $siswa->nama_siswa . "* (No. Pendaftaran: *" . $siswa->kode_siswa . "*).\n\n"
               . "Kami dari Panitia SPMB " . $website->namaweb() . " menginformasikan bahwa berkas pendaftaran online saat ini berstatus: *" . $status_pendaftaran_txt . "*.\n\n"
               . "*Langkah Selanjutnya*:\n"
               . $langkah_selanjutnya . "\n\n"
               . "Silakan pantau perkembangan pendaftaran secara berkala melalui akun dasbor siswa Anda.\n"
               . "Terima kasih atas perhatiannya.\n\n"
               . "Salam hangat,\n"
               . "Panitia SPMB " . $website->namaweb();
               
        return "https://api.whatsapp.com/send?phone=" . $formatted . "&text=" . urlencode($pesan);
    }
}
?>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <h5 class="text-dark font-weight-bold mb-2"><i class="fa fa-user-check text-primary mr-1"></i> Detail Calon Siswa</h5>
  <div class="mb-2">
	<a href="<?php echo base_url('admin/siswa/edit/'.$siswa->id_siswa) ?>" class="btn btn-outline-success btn-sm font-weight-bold mr-1">
		<i class="fa fa-edit"></i> Edit Data
	</a>
	<a href="<?php echo base_url('admin/siswa/cetak/'.$siswa->id_siswa) ?>" class="btn btn-outline-dark btn-sm font-weight-bold mr-1" target="_blank">
		<i class="fa fa-print"></i> Cetak
	</a>
	<a href="<?php echo base_url('admin/siswa/unduh/'.$siswa->id_siswa) ?>" class="btn btn-outline-danger btn-sm font-weight-bold mr-1" target="_blank">
		<i class="fa fa-file-pdf"></i> Unduh PDF
	</a>
	<a href="<?php echo base_url('admin/siswa') ?>" class="btn btn-outline-info btn-sm font-weight-bold">
		<i class="fa fa-arrow-left"></i> Kembali ke Daftar
	</a>
  </div>
</div>





<div class="row">
	<div class="col-md-3">
		<div class="card">
			<div class="card-header bg-light text-center">
				FOTO SISWA
			</div>
			<div class="card-body text-center">
				<?php if($siswa->gambar=='') { ?>
					<div class="alert alert-info">
						Belum Ada foto
					</div>
				<?php }else{ ?>
					<img src="<?php echo base_url('assets/upload/image/'.$siswa->gambar) ?>" class="img img-thumbnail">
				<?php } ?>
				<hr>
				<?php echo $siswa->nama_siswa ?>
				<hr>
				<?php echo $siswa->nis ?>/<?php echo $siswa->nisn ?>
				<hr>
				<?php echo $siswa->status_siswa ?>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="card">
			<div class="card-header bg-light text-center">
				DATA DASAR SISWA
			</div>
			<div class="card-body">
				<table class="table table-bordered printer">
					<tbody>
						<tr>
							<td class="bg-light" width="25%">Nama lengkap</td>
							<td><?php echo $siswa->nama_siswa ?></td>
						</tr>
						<tr>
							<td class="bg-light">Nama panggilan</td>
							<td><?php echo $siswa->nama_panggilan ?></td>
						</tr>
						<tr>
							<td class="bg-light">Jenis Kelamin</td>
							<td><?php echo $siswa->jenis_kelamin ?></td>
						</tr>
						<tr>
							<td class="bg-light">Tempat, tanggal lahir</td>
							<td><?php echo $siswa->tempat_lahir ?>, <?php echo $this->website->tanggal_id($siswa->tanggal_lahir) ?></td>
						</tr>
						<tr>
							<td class="bg-light">Alamat</td>
							<td>
								<?php 
								if(!empty($siswa->rt) || !empty($siswa->rw) || !empty($siswa->kecamatan)) {
									$full = $siswa->alamat;
									if(!empty($siswa->rt) || !empty($siswa->rw)) { $full .= ', RT '.$siswa->rt.' / RW '.$siswa->rw; }
									if(!empty($siswa->kelurahan)) { $full .= ', Kel. '.$siswa->kelurahan; }
									if(!empty($siswa->kecamatan)) { $full .= ', Kec. '.$siswa->kecamatan; }
									if(!empty($siswa->kabupaten)) { $full .= ', '.$siswa->kabupaten; }
									if(!empty($siswa->provinsi)) { $full .= ', '.$siswa->provinsi; }
									echo nl2br($full);
								} else {
									echo nl2br($siswa->alamat);
								}
								?>
								<?php if(!empty($siswa->kode_pos)) { echo " (Kode Pos: ".$siswa->kode_pos.")"; } ?>
							</td>
						</tr>
						<tr>
							<td class="bg-light">Telepon &amp; Email</td>
							<td><?php echo $siswa->telepon ?> / <?php echo $siswa->email ?></td>
						</tr>
						<tr>
							<td class="bg-light">Ayah</td>
							<td>
								<strong><?php echo $siswa->nama_ayah ?></strong><br>
								Alamat: <?php echo $siswa->alamat_ayah ?><br>
								Telepon/HP: <?php echo $siswa->telepon_ayah ?>
								<?php if (!empty($siswa->telepon_ayah)) { ?>
									<a href="<?php echo get_wa_link($siswa->telepon_ayah, 'Ayah', $siswa, $this->website) ?>" class="btn btn-success btn-xs ml-2 font-weight-bold" target="_blank">
										<i class="fab fa-whatsapp"></i> Hubungi via WA
									</a>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="bg-light">Ibu</td>
							<td>
								<strong><?php echo $siswa->nama_ibu ?></strong><br>
								Alamat: <?php echo $siswa->alamat_ibu ?><br>
								Telepon/HP: <?php echo $siswa->telepon_ibu ?>
								<?php if (!empty($siswa->telepon_ibu)) { ?>
									<a href="<?php echo get_wa_link($siswa->telepon_ibu, 'Ibu', $siswa, $this->website) ?>" class="btn btn-success btn-xs ml-2 font-weight-bold" target="_blank">
										<i class="fab fa-whatsapp"></i> Hubungi via WA
									</a>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td class="bg-light">Wali</td>
							<td>
								<strong><?php echo $siswa->nama_wali ?></strong><br>
								Alamat: <?php echo $siswa->alamat_wali ?><br>
								Telepon/HP: <?php echo $siswa->telepon_wali ?>
								<?php if (!empty($siswa->telepon_wali)) { ?>
									<a href="<?php echo get_wa_link($siswa->telepon_wali, 'Wali', $siswa, $this->website) ?>" class="btn btn-success btn-xs ml-2 font-weight-bold" target="_blank">
										<i class="fab fa-whatsapp"></i> Hubungi via WA
									</a>
								<?php } ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>