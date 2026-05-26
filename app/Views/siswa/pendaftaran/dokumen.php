<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header bg-light">
        DETAIL CALON SISWA
      </div>
      <div class="card-body">
        <table class="tabelku table-sm">
    <thead>
      <tr>
        <th colspan="2" class="bg-secondary text-white text-center">DATA DASAR SISWA</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="font-bold" width="35%">Nama</td>
        <td><?php echo strtoupper($siswa->nama_siswa) ?></td>
      </tr>
      <tr>
        <td class="font-bold">Panggilan</td>
        <td><?php echo $siswa->nama_panggilan ?></td>
      </tr>
      <tr>
        <td class="font-bold">NIS / NISN</td>
        <td><?php echo $siswa->nis ?> / <?php echo $siswa->nisn ?></td>
      </tr>
      <tr>
        <td class="font-bold">L/P</td>
        <td><?php if($siswa->jenis_kelamin=='L') { echo 'Laki-laki'; }else{ echo 'Perempuan'; } ?></td>
      </tr>
      <tr>
        <td class="font-bold">TTL</td>
        <td><?php echo $siswa->tempat_lahir ?>, <?php echo $this->website->tanggal_id($siswa->tanggal_lahir) ?></td>
      </tr>
      <tr>
        <td class="font-bold">Kode</td>
        <td><?php echo $siswa->kode_siswa ?></td>
      </tr>
      <tr>
        <td class="font-bold">Periode</td>
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
        <td><?php echo nl2br($siswa->alamat) ?></td>
      </tr>
      
      <tr>
        <td class="font-bold">Telepon</td>
        <td><?php echo $siswa->telepon ?></td>
      </tr>
       <tr>
        <td class="font-bold">Email</td>
        <td><?php echo $siswa->email ?></td>
      </tr>
    </tbody>
  </table>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="card">
      <div class="card-header bg-light">
        UNGGAH DOKUMEN PENDUKUNG
      </div>
      <div class="card-body">
    <p class="lead mb-6 text-start">Masukkan data Anda dengan benar dan lengkap.</p>

          <?php 
          $validation = \Config\Services::validation();
              $errors = $validation->getErrors();
              if(!empty($errors))
              {
                  echo '<span class="text-danger">'.$validation->listErrors().'</span>';
              }
          if (session('msg')) : 
          ?>
               <div class="alert alert-info alert-dismissible">
                   <?= session('msg') ?>
                   <button type="button" class="close" data-dismiss="alert"><span>x</span></button>
               </div>
           <?php endif ?>

         

      <div class="table-responsive">
      <table class="table tabelku table-sm">
        <thead>
          <tr>
            <th width="5%" class="text-left">No</th>
            <th width="30%" class="text-left">Nama Dokumen</th>
            <th width="10%" class="text-center">Status Wajib</th>
            <th width="20%" class="text-center">Status Unggah</th>
            <th class="text-center">Unggah</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $id_siswa     = $siswa->id_siswa;
          $no           = 1; 
          $data_total   = 1;
          foreach($jenis_dokumen as $jenis_dokumen) { 
            $id_jenis_dokumen     = $jenis_dokumen->id_jenis_dokumen;
            $check_dokumen        = $m_dokumen->check($id_siswa,$id_jenis_dokumen);
            if($jenis_dokumen->status_jenis_dokumen=='Wajib') {
                if($check_dokumen) {
                  $data_id = 1;
                }else{
                  $data_id = 0;
                }
            }else{
                $data_id = 1;
            }
            $data_total+=$data_id;
          ?>
          <tr data-id="<?php echo $data_id ?>">
            <td class="text-center"><?php echo $no ?></td>
            
            <td><?php echo $jenis_dokumen->nama_jenis_dokumen ?>
              <small>
                <br><?php echo $jenis_dokumen->keterangan ?>
              </small>
              <?php if($check_dokumen) { ?>
                <div class="mt-1" style="font-size: 12px;">
                  <strong>Verifikasi:</strong> 
                  <?php if($check_dokumen->status_verifikasi == 'Disetujui') { ?>
                    <span class="text-success font-weight-bold"><i class="fa fa-check-circle"></i> Disetujui</span>
                  <?php } elseif($check_dokumen->status_verifikasi == 'Ditolak') { ?>
                    <span class="text-danger font-weight-bold"><i class="fa fa-times-circle"></i> Ditolak</span>
                    <?php if(!empty($check_dokumen->catatan_verifikasi)) { ?>
                      <div class="alert alert-danger p-1 mt-1 mb-0" style="font-size: 11px; line-height: 1.3;">
                        <strong>Revisi:</strong> <?php echo esc($check_dokumen->catatan_verifikasi) ?>
                      </div>
                    <?php } ?>
                  <?php } else { ?>
                    <span class="text-warning font-weight-bold"><i class="fa fa-clock"></i> Menunggu Verifikasi</span>
                  <?php } ?>
                </div>
              <?php } ?>
            </td>
            <td>
              <?php if($jenis_dokumen->status_jenis_dokumen=='Wajib') { ?>
                <span class="badge bg-info">
                  <i class="fa fa-check-circle"></i> <?php echo $jenis_dokumen->status_jenis_dokumen ?>
                </span>
              <?php }else{ ?>
                <span class="badge bg-secondary">
                  <i class="fa fa-times-circle"></i> <?php echo $jenis_dokumen->status_jenis_dokumen ?>
                </span>
              <?php } ?>
            </td>
            <td>
                 
              <?php if($check_dokumen) { ?>
                <span class="badge bg-info">
                  <i class="fa fa-check-circle"></i> Sudah
                </span>
              <?php }else{ ?>
                <span class="badge bg-secondary">
                  <i class="fa fa-times-circle"></i> Belum
                </span>
              <?php } ?>
            </td>                
            <td>
              <?php if($check_dokumen) { ?>
                <a class="btn btn-dark btn-xs mb-1" href="<?php echo base_url('siswa/pendaftaran/unduh/'.$check_dokumen->kode_dokumen.'/'.$siswa->slug_siswa) ?>" target="_blank">
                  <i class="fa fa-download"></i>&nbsp;  Unduh
                </a>
                <a class="btn btn-secondary btn-xs mb-1 delete-link" href="<?php echo base_url('siswa/pendaftaran/hapus/'.$check_dokumen->kode_dokumen.'/'.$siswa->slug_siswa) ?>">
                  <i class="fa fa-trash"></i>&nbsp;  Hapus
                </a>
              <?php }else{ ?>
                <?php 
                echo form_open_multipart(base_url('siswa/pendaftaran/dokumen/'.$siswa->slug_siswa));
                echo csrf_field(); 
                ?>

                <input type="hidden" name="id_jenis_dokumen" value="<?php echo $jenis_dokumen->id_jenis_dokumen ?>">

                <div class="form-group">
                  <div class="mb-2">
                    <input type="file" name="gambar" class="form-control" onchange="document.getElementById('file-name-<?php echo $id_jenis_dokumen ?>').innerText = this.files[0].name" required>
                    <small class="text-muted d-block mt-1">File: <span id="file-name-<?php echo $id_jenis_dokumen ?>" class="text-primary font-weight-bold">Belum dipilih</span></small>
                  </div>
                  <button type="submit" name="submit" value="Cari" class="btn btn-success btn-block w-100">
                    <i class="fa fa-upload"></i>&nbsp; Unggah Sekarang
                  </button>
                </div>

                <?php echo form_close();} ?>
            </td>
          </tr>
          <?php $no++; } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5" class="text-right">
              <a href="<?php echo base_url('siswa/pendaftaran') ?>" class="btn btn-outline-info">
                <i class="fa fa-arrow-left"></i> Kembali
              </a>
              <?php if($no==$data_total) { ?>
                  <a href="<?php echo base_url('siswa/pendaftaran/selesai/'.$siswa->slug_siswa) ?>" class="btn btn-danger text-white">
                    Simpan dan Selesaikan Pendaftaran&nbsp;<i class="fa fa-arrow-right"></i>
                  </a>
              <?php }else{ ?>
                  <div class="alert alert-info">
                    Dokumen masih kurang, silakan lengkapi.
                  </div>
              <?php } ?>
            </td>
          </tr>
        </tfoot>
      </table>
      </div>
    </div>
  </div>
</div>
</div>
