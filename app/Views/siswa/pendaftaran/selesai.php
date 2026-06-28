<?php
$db = \Config\Database::connect();
$total_wajib = $db->table('jenis_dokumen')->where('status_jenis_dokumen', 'Wajib')->countAllResults();
$sudah_upload = $db->table('dokumen')->where('id_siswa', $siswa->id_siswa)->countAllResults();
$pct = $total_wajib > 0 ? min(100, round(($sudah_upload/$total_wajib)*100)) : 0;

if ($pct >= 100) {
?>
<div class="alert alert-success border-0 shadow-sm mb-4 p-4 bg-white" style="border-left: 5px solid #28a745 !important;">
  <div class="d-flex align-items-start">
    <div class="mr-3 mt-1" style="font-size: 28px; color: #28a745;">
      <i class="fas fa-check-circle"></i>
    </div>
    <div>
      <h5 class="alert-heading font-weight-bold mb-2 text-dark" style="font-size: 16px;">Selamat! Pendaftaran Berhasil Diselesaikan</h5>
      <p class="mb-3 text-secondary" style="font-size: 13.5px; line-height: 1.5;">
        Seluruh biodata dan berkas persyaratan wajib Anda telah lengkap dan berhasil disimpan ke sistem.
        <br><strong class="text-danger">PERHATIAN:</strong> Anda <strong>diwajibkan untuk mengunduh dan mencetak Bukti Pendaftaran</strong> di bawah ini. Dokumen tersebut wajib dibawa sebagai kartu peserta saat tahap verifikasi berkas fisik dan seleksi di sekolah.
      </p>
      <div class="d-flex flex-wrap" style="gap: 8px;">
        <a href="<?php echo base_url('siswa/pendaftaran/cetak/'.$siswa->slug_siswa) ?>" class="btn btn-danger font-weight-bold" target="_blank" style="text-decoration: none !important;">
          <i class="fa fa-file-pdf mr-1"></i> Cetak Bukti Pendaftaran
        </a>
        <a href="<?php echo base_url('siswa/dasbor') ?>" class="btn btn-primary font-weight-bold" style="text-decoration: none !important;">
          <i class="fa fa-home mr-1"></i> Kembali ke Dasbor
        </a>
      </div>
    </div>
  </div>
</div>
<?php } else { ?>
<div class="alert alert-warning border-0 shadow-sm mb-4 p-4 bg-white" style="border-left: 5px solid #ffc107 !important;">
  <div class="d-flex align-items-start">
    <div class="mr-3 mt-1" style="font-size: 28px; color: #ffc107;">
      <i class="fas fa-exclamation-triangle"></i>
    </div>
    <div>
      <h5 class="alert-heading font-weight-bold mb-2 text-dark" style="font-size: 16px;">Biodata Tersimpan (Pendaftaran Belum Lengkap)</h5>
      <p class="mb-3 text-secondary" style="font-size: 13.5px; line-height: 1.5;">
        Biodata pendaftaran Anda telah berhasil disimpan. Namun, <strong>pendaftaran Anda belum selesai</strong> karena Anda belum mengunggah seluruh dokumen berkas persyaratan wajib.
        <br>Silakan lengkapi berkas dokumen Anda terlebih dahulu agar panitia dapat memproses pendaftaran Anda.
      </p>
      <div class="d-flex flex-wrap" style="gap: 8px;">
        <a href="<?php echo base_url('siswa/pendaftaran/dokumen/'.$siswa->slug_siswa) ?>" class="btn btn-primary font-weight-bold" style="color: #ffffff !important; text-decoration: none !important;">
          <i class="fa fa-upload mr-1"></i> Unggah Dokumen Persyaratan
        </a>
        <a href="<?php echo base_url('siswa/dasbor') ?>" class="btn btn-secondary font-weight-bold" style="color: #ffffff !important; text-decoration: none !important;">
          <i class="fa fa-home mr-1"></i> Kembali ke Dasbor
        </a>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<p class="lead mb-3 text-start font-weight-bold" style="font-size: 15px; color: #343a40;">Berikut adalah data pendaftaran Anda:</p>

  <table class="table table-bordered table-sm printer">
    <thead>
      <tr>
        <th colspan="2" class="bg-secondary text-white text-center">DATA DASAR SISWA</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="font-bold" width="35%">Nama lengkap</td>
        <td><?php echo strtoupper($siswa->nama_siswa) ?></td>
      </tr>
      <tr>
        <td class="font-bold">Nama panggilan</td>
        <td><?php echo $siswa->nama_panggilan ?></td>
      </tr>
      <tr>
        <td class="font-bold">NIS / NISN</td>
        <td><?php echo $siswa->nis ?> / <?php echo $siswa->nisn ?></td>
      </tr>
      <tr>
        <td class="font-bold">Jenis Kelamin</td>
        <td><?php if($siswa->jenis_kelamin=='L') { echo 'Laki-laki'; }else{ echo 'Perempuan'; } ?></td>
      </tr>
      <tr>
        <td class="font-bold">Tempat, tanggal lahir</td>
        <td><?php echo $siswa->tempat_lahir ?>, <?php echo $this->website->tanggal_id($siswa->tanggal_lahir) ?></td>
      </tr>
      <tr>
        <td class="font-bold">Agama & Kewarganegaraan</td>
        <td><?php echo $siswa->nama_agama ?> / <?php echo $siswa->status_wn ?> <?php echo ($siswa->status_wn == 'WNA') ? '('.$siswa->negara_asal.')' : ''; ?></td>
      </tr>
      <tr>
        <td class="font-bold">Kode Pendaftaran</td>
        <td><?php echo $siswa->kode_siswa ?></td>
      </tr>
      <tr>
        <td class="font-bold">Periode Pendaftaran</td>
        <td><?php echo $siswa->judul ?></td>
      </tr>
      <tr>
        <td class="font-bold">Tahun Ajaran</td>
        <td><?php echo $siswa->tahun_ajaran ?></td>
      </tr>
      <tr>
        <td class="font-bold">Program/Jenjang</td>
        <td><?php echo $siswa->judul_program_pendidikan ?></td>
      </tr>
      <tr>
        <td class="font-bold">Status Anak</td>
        <td><?php echo $siswa->nama_hubungan ?></td>
      </tr>
      <tr>
        <td class="font-bold">Anak ke</td>
        <td><?php echo $siswa->anak_ke ?> dari <?php echo $siswa->jumlah_saudara ?> Saudara</td>
      </tr>
      <tr>
        <td class="font-bold">Alamat</td>
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
          <?php echo (!empty($siswa->kode_pos)) ? '(Kode Pos: ' . $siswa->kode_pos . ')' : ''; ?>
        </td>
      </tr>
      <tr>
        <td class="font-bold">Telepon</td>
        <td><?php echo $siswa->telepon ?></td>
      </tr>
      <tr>
        <td class="font-bold">Email</td>
        <td><?php echo $siswa->email ?></td>
      </tr>
      <?php if(!empty($siswa->ukuran_seragam)) { ?>
      <tr>
        <td class="font-bold">Ukuran Seragam</td>
        <td><?php echo $siswa->ukuran_seragam ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  
   <table class="table table-bordered table-sm printer mt-2">
    <thead>
      <tr>
        <th colspan="2" class="bg-secondary text-white text-center">PENDIDIKAN SEBELUMNYA</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="font-bold" width="35%">Nama Sekolah Asal (Tamatan Dari)</td>
        <td><?php echo $siswa->asal_sekolah ?></td>
      </tr>
    </tbody>
  </table>

  <table class="table table-bordered table-sm printer mt-2">
    <thead>
      <tr>
        <th colspan="2" class="bg-secondary text-white text-center">DATA ORANG TUA SISWA - AYAH</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="font-bold" width="35%">Nama Ayah</td>
        <td><?php echo $siswa->nama_ayah ?></td>
      </tr>
      <tr>
        <td class="font-bold">Agama Ayah</td>
        <td><?php echo $siswa->agama_ayah ?></td>
      </tr>
      <tr>
        <td class="font-bold">Pekerjaan Ayah</td>
        <td><?php echo $siswa->nama_pekerjaan ?></td>
      </tr>
      <tr>
        <td class="font-bold">Pendidikan Ayah</td>
        <td><?php echo $siswa->jenjang_ayah ?></td>
      </tr>
      <tr>
        <td class="font-bold">Alamat Ayah</td>
        <td><?php echo $siswa->alamat_ayah ?></td>
      </tr>
      <tr>
        <td class="font-bold">Telepon/HP Ayah</td>
        <td><?php echo $siswa->telepon_ayah ?></td>
      </tr>
    </tbody>
  </table>

  <table class="table table-bordered table-sm printer mt-2">
    <thead>
      <tr>
        <th colspan="2" class="bg-secondary text-white text-center">DATA ORANG TUA SISWA - IBU</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="font-bold" width="35%">Nama Ibu</td>
        <td><?php echo $siswa->nama_ibu ?></td>
      </tr>
      <tr>
        <td class="font-bold">Agama Ibu</td>
        <td><?php echo $siswa->agama_ibu ?></td>
      </tr>
      <tr>
        <td class="font-bold">Pekerjaan Ibu</td>
        <td><?php echo $siswa->pekerjaan_ibu ?></td>
      </tr>
      <tr>
        <td class="font-bold">Pendidikan Ibu</td>
        <td><?php echo $siswa->jenjang_ibu ?></td>
      </tr>
      <tr>
        <td class="font-bold">Alamat Ibu</td>
        <td><?php echo $siswa->alamat_ibu ?></td>
      </tr>
      <tr>
        <td class="font-bold">Telepon/HP Ibu</td>
        <td><?php echo $siswa->telepon_ibu ?></td>
      </tr>
    </tbody>
  </table>

  <?php if($siswa->identitas_wali != 'Ayah' && $siswa->identitas_wali != 'Ibu') { ?>
  <table class="table table-bordered table-sm printer mt-2">
    <thead>
      <tr>
        <th colspan="2" class="bg-secondary text-white text-center">DATA ORANG TUA SISWA - WALI (BERBEDA DENGAN AYAH/IBU)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="font-bold" width="35%">Nama Wali</td>
        <td><?php echo $siswa->nama_wali ?></td>
      </tr>
      <tr>
        <td class="font-bold">Agama Wali</td>
        <td><?php echo $siswa->agama_wali ?></td>
      </tr>
      <tr>
        <td class="font-bold">Pekerjaan Wali</td>
        <td><?php echo $siswa->pekerjaan_wali ?></td>
      </tr>
      <tr>
        <td class="font-bold">Pendidikan Wali</td>
        <td><?php echo $siswa->jenjang_wali ?></td>
      </tr>
      <tr>
        <td class="font-bold">Alamat Wali</td>
        <td><?php echo $siswa->alamat_wali ?></td>
      </tr>
      <tr>
        <td class="font-bold">Telepon/HP Wali</td>
        <td><?php echo $siswa->telepon_wali ?></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>
