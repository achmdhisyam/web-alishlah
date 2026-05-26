
<!-- /section -->
<section class="wrapper bg-light">
  <div class="container pb-14 pb-md-16">
    <div class="row">
       <div class="col-lg-10 col-xl-10 col-xxl-10 mx-auto mt-n20">
        <div class="card">
          <div class="card-body p-5">

            <h2 class="mb-3 text-start">Unggah dokumen pendukung</h2>
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
                       <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
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
                </td>
                <td class="text-center">
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
                <td class="text-center">
                     
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
                    <a class="btn btn-dark btn-sm mb-1" href="<?php echo base_url('pendaftaran/unduh/'.$check_dokumen->kode_dokumen.'/'.$siswa->slug_siswa) ?>" target="_blank">
                      <i class="fa fa-download"></i>&nbsp;  Unduh
                    </a>
                    <a class="btn btn-secondary btn-sm mb-1 delete-link" href="<?php echo base_url('pendaftaran/hapus/'.$check_dokumen->kode_dokumen.'/'.$siswa->slug_siswa) ?>">
                      <i class="fa fa-trash"></i>&nbsp;  Hapus
                    </a>
                  <?php }else{ ?>
                    <?php 
                    echo form_open_multipart(base_url('pendaftaran/dokumen/'.$siswa->slug_siswa));
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
                <td colspan="4"></td>
                <td>
                  <?php if($no==$data_total) { ?>
                      <a href="<?php echo base_url('pendaftaran/selesai/'.$siswa->slug_siswa) ?>" class="btn btn-success float-right text-white">
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
  </div>
</section>

