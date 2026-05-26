<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header bg-light">
        DETAIL CALON SISWA
      </div>
      <div class="card-body">
        <?php include('selesai.php') ?>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="card">
      <div class="card-header bg-light">
        UNGGAH DOKUMEN PENDUKUNG
      </div>
      <div class="card-body">
        
        <table class="tabelku table-sm mb-2">
          <thead>
            <tr>
              <th width="25%">Kode Pendaftaran</th>
              <th><?php echo $siswa->kode_siswa ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Status Pendaftaran</td>
              <td>
                <?php if($siswa->status_pendaftaran=='Menunggu') { ?>
                    <span class="badge badge-warning"><i class="fa fa-clock"></i>&nbsp;<?php echo $siswa->status_pendaftaran ?></span>
                  <?php }elseif($siswa->status_pendaftaran=='Diterima') { ?>
                    <span class="badge badge-success"><i class="fa fa-check-circle"></i>&nbsp;<?php echo $siswa->status_pendaftaran ?></span>
                  <?php }elseif($siswa->status_pendaftaran=='Tidak-Diterima') { ?>
                    <span class="badge badge-danger"><i class="fa fa-times-circle"></i>&nbsp;<?php echo $siswa->status_pendaftaran ?></span>
                  <?php }else{ ?>
                    <span class="badge badge-info"><i class="fa fa-tasks"></i>&nbsp;<?php echo $siswa->status_pendaftaran ?></span>
                  <?php } ?>
              </td>
            </tr>
          </tbody>
        </table>

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

         

      <table class="table tabelku table-sm">
        <thead>
          <tr>
            <th width="5%" class="text-left">No</th>
            <th width="35%" class="text-left">Nama Dokumen</th>
            <th width="15%">Wajib?</th>
            <th width="15%">Unggah</th>
            <th></th>
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
                    <span class="badge bg-success"><i class="fa fa-check-circle"></i> Disetujui</span>
                  <?php } elseif($check_dokumen->status_verifikasi == 'Ditolak') { ?>
                    <span class="badge bg-danger"><i class="fa fa-times-circle"></i> Ditolak</span>
                    <?php if(!empty($check_dokumen->catatan_verifikasi)) { ?>
                      <div class="text-danger mt-1" style="font-size: 11px;">
                        <strong>Catatan:</strong> <?php echo esc($check_dokumen->catatan_verifikasi) ?>
                      </div>
                    <?php } ?>
                  <?php } else { ?>
                    <span class="badge bg-warning"><i class="fa fa-clock"></i> Menunggu</span>
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
                <button type="button" class="btn btn-secondary btn-xs mb-1" data-toggle="modal" data-target="#modal-<?php echo $jenis_dokumen->id_jenis_dokumen ?>">
                  <i class="fa fa-eye"></i> Lihat
                </button>
                <a class="btn btn-secondary btn-xs mb-1" href="<?php echo base_url('admin/gelombang/unduh/'.$check_dokumen->kode_dokumen.'/'.$siswa->slug_siswa) ?>" target="_blank">
                  <i class="fa fa-download"></i>
                </a>
                <a class="btn btn-secondary btn-xs mb-1 delete-link" href="<?php echo base_url('admin/gelombang/hapus/'.$check_dokumen->kode_dokumen.'/'.$siswa->slug_siswa) ?>">
                  <i class="fa fa-trash"></i>
                </a>

              <?php include('lihat.php');
            }else{ ?>
                <?php 
                echo form_open_multipart(base_url('admin/gelombang/dokumen/'.$siswa->slug_siswa));
                echo csrf_field(); 
                ?>

                <input type="hidden" name="id_jenis_dokumen" value="<?php echo $jenis_dokumen->id_jenis_dokumen ?>">

                <div class="row">
                  <div class="col-md-8">
                    <input type="file" name="gambar" class="form-control form-control-sm" placeholder="Unggah" value="" required>
                  </div>
                  <div class="col-md-4">
                    <button type="submit" name="submit" value="Unggah" class="btn btn-success btn-sm mb-1">
                      <i class="fa fa-upload"></i> Unggah
                    </button>
                
                  </div>
                </div>

                <?php echo form_close();} ?>
            </td>
          </tr>
          <?php $no++; } ?>
        </tbody>
        <tfoot>
          <tr class="bg-secondary">
            <td colspan="5" class="text-right">

              <?php echo form_open(base_url('admin/gelombang/dokumen/'.$siswa->slug_siswa)) ?>
            <div class="input-group">
              <span class="input-group-append">
               <a href="<?php echo base_url('admin/gelombang/detail/'.$siswa->id_gelombang.'/Semua/Semua') ?>" class="btn btn-warning">
                <i class="fa fa-arrow-left"></i> Kembali
              </a>
            </span>
           <select name="status_pendaftaran" class="form-control">
                  <option value="Menunggu">Menunggu</option>
                  <option value="Diterima" <?php if(set_value('status_pendaftaran')=='Diterima' || $siswa->status_pendaftaran=='Diterima') { echo 'selected'; } ?>>Diterima</option>
                  <option value="Tidak-Diterima" <?php if(set_value('status_pendaftaran')=='Tidak-Diterima' || $siswa->status_pendaftaran=='Tidak-Diterima') { echo 'selected'; } ?>>Tidak Diterima</option>
                  <option value="Diperiksa" <?php if(set_value('status_pendaftaran')=='Diperiksa' || $siswa->status_pendaftaran=='Diperiksa') { echo 'selected'; } ?>>Diperiksa</option>
                </select>
          <span class="input-group-append">
            
             
              <?php if($no==$data_total) { ?>
                 <button type="submit" class="btn btn-success" name="status" value="update"><i class="fa fa-save"></i> Update Status SPMB</button>
              <?php }else{ ?>
                  <div class="alert alert-info">
                    Dokumen masih kurang, silakan lengkapi.
                  </div>
              <?php } ?>
            </span>
          </div>
              <?php echo form_close(); ?>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
</div>
