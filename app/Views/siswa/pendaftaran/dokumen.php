<?php
$db = \Config\Database::connect();
$total_wajib = $db->table('jenis_dokumen')->where('status_jenis_dokumen', 'Wajib')->countAllResults();
$sudah_upload = $db->table('dokumen')->where('id_siswa', $siswa->id_siswa)->countAllResults();
$pct = $total_wajib > 0 ? min(100, round(($sudah_upload/$total_wajib)*100)) : 0;

$overall_pct = 50;
if ($pct >= 100) {
    $overall_pct = 83;
    if (in_array($siswa->status_pendaftaran, ['Diterima', 'Tidak-Diterima'])) {
        $overall_pct = 100;
    }
} else {
    $overall_pct = 50 + round($pct * 0.33);
}

$ditolak_docs = [];
if ($siswa) {
    $ditolak_docs = $db->table('dokumen')
        ->select('dokumen.*, jenis_dokumen.nama_jenis_dokumen')
        ->join('jenis_dokumen', 'jenis_dokumen.id_jenis_dokumen = dokumen.id_jenis_dokumen')
        ->where('dokumen.id_siswa', $siswa->id_siswa)
        ->where('dokumen.status_verifikasi', 'Ditolak')
        ->get()->getResult();
}
?>
<style>
.dropzone-area {
    border: 2px dashed #007bff;
    border-radius: 8px;
    padding: 15px 10px;
    text-align: center;
    background: #f8f9fa;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}
.dropzone-area:hover {
    background: #e9ecef;
    border-color: #0056b3;
}
.dropzone-area input[type=file] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}
.dropzone-icon {
    font-size: 22px;
    margin-bottom: 5px;
}
.dropzone-text {
    font-size: 12px;
    color: #495057;
}
</style>

<!-- STEPPER ROADMAP PENDAFTARAN -->
<div class="card shadow-sm mb-4 border-0" style="border-radius: 4px;">
  <div class="card-body p-4">
    <h5 class="font-weight-bold mb-4 text-dark" style="font-size: 15px;">
      <i class="fa fa-route text-primary mr-1"></i> Alur Proses Pendaftaran Anda
    </h5>
    
    <div class="d-flex justify-content-between align-items-center position-relative mx-auto" style="max-width: 750px; padding: 10px 0;">
      <!-- Progress Bar Background Line -->
      <div class="position-absolute" style="height: 4px; background-color: #e9ecef; left: 40px; right: 40px; top: 32px; z-index: 1;">
        <div style="height: 100%; width: <?php echo $overall_pct ?>%; background-color: #28a745; transition: width 0.4s ease;"></div>
      </div>
      
      <!-- Step 1: Registrasi Akun -->
      <div class="text-center position-relative" style="z-index: 2; width: 90px;">
        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm border border-white" style="width: 44px; height: 44px; font-size: 14px; font-weight: bold;">
          <i class="fa fa-user-plus"></i>
        </div>
        <span class="font-weight-bold text-success" style="font-size: 11px; display: block; line-height: 1.2;">1. Buat Akun</span>
      </div>
      
      <!-- Step 2: Isi Biodata -->
      <div class="text-center position-relative" style="z-index: 2; width: 90px;">
        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm border border-white" style="width: 44px; height: 44px; font-size: 14px; font-weight: bold;">
          <i class="fa fa-file-alt"></i>
        </div>
        <span class="font-weight-bold text-success" style="font-size: 11px; display: block; line-height: 1.2;">2. Isi Biodata</span>
      </div>
      
      <!-- Step 3: Unggah Dokumen -->
      <?php 
        $step3_active = ($pct >= 100);
        $step3_in_progress = ($pct > 0 && $pct < 100);
        $step3_class = $step3_active ? 'bg-success text-white border-white' : ($step3_in_progress ? 'bg-info text-white border-white' : 'bg-white text-secondary border');
        $step3_text_class = $step3_active ? 'text-success font-weight-bold' : ($step3_in_progress ? 'text-info font-weight-bold' : 'text-muted');
      ?>
      <div class="text-center position-relative" style="z-index: 2; width: 90px;">
        <div class="rounded-circle <?php echo $step3_class ?> d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 44px; height: 44px; font-size: 14px; font-weight: bold; border-color: #dee2e6 !important;">
          <i class="fa fa-upload"></i>
        </div>
        <span class="<?php echo $step3_text_class ?>" style="font-size: 11px; display: block; line-height: 1.2;">3. Unggah Berkas</span>
      </div>
      
      <!-- Step 4: Kelulusan / Seleksi -->
      <?php 
        $status_pend = $siswa ? ($siswa->status_pendaftaran ?? null) : null;
        $step4_done = ($siswa && in_array($status_pend, ['Diterima', 'Tidak-Diterima']));
        $step4_in_progress = ($siswa && $pct >= 100 && in_array($status_pend, ['Menunggu', 'Diperiksa']));
        $step4_class = $step4_done ? ($status_pend == 'Diterima' ? 'bg-success text-white border-white' : 'bg-danger text-white border-white') : ($step4_in_progress ? 'bg-info text-white border-white' : 'bg-white text-secondary border');
        $step4_text_class = $step4_done ? ($status_pend == 'Diterima' ? 'text-success font-weight-bold' : 'text-danger font-weight-bold') : ($step4_in_progress ? 'text-info font-weight-bold' : 'text-muted');
      ?>
      <div class="text-center position-relative" style="z-index: 2; width: 90px;">
        <div class="rounded-circle <?php echo $step4_class ?> d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 44px; height: 44px; font-size: 14px; font-weight: bold; border-color: #dee2e6 !important;">
          <i class="fa fa-award"></i>
        </div>
        <span class="<?php echo $step4_text_class ?>" style="font-size: 11px; display: block; line-height: 1.2;">4. Pengumuman</span>
      </div>
      
    </div>
  </div>
</div>

<?php if (!empty($ditolak_docs)) : ?>
  <div class="alert shadow-sm mb-4 border-0" role="alert" style="border-radius: 8px; background-color: #fff5f5; border-left: 5px solid #e53e3e !important; border-top: 1px solid #feb2b2 !important; border-right: 1px solid #feb2b2 !important; border-bottom: 1px solid #feb2b2 !important; padding: 20px;">
    <div class="d-flex align-items-start">
      <div class="mr-3 text-danger" style="font-size: 24px; margin-top: 2px;">
        <i class="fas fa-exclamation-triangle"></i>
      </div>
      <div class="w-100">
        <h5 class="alert-heading font-weight-bold mb-2" style="color: #c53030; font-size: 16px;">Perhatian: Ada Dokumen yang Ditolak</h5>
        <p class="mb-3 text-dark font-weight-normal" style="font-size: 14px; line-height: 1.5; color: #2d3748 !important;">Beberapa dokumen pendaftaran Anda memerlukan revisi. Silakan unggah kembali dokumen berikut:</p>
        
        <div class="p-3 bg-white rounded border mb-3" style="border-color: #fed7d7 !important;">
          <ul class="mb-0 pl-3" style="font-size: 13.5px; line-height: 1.8; color: #2d3748;">
            <?php foreach ($ditolak_docs as $doc) : ?>
              <li class="mb-2" style="list-style-type: square;">
                <strong class="text-dark" style="font-size: 14px;"><?= esc($doc->nama_jenis_dokumen) ?></strong>
                <?php if (!empty($doc->catatan_verifikasi)) : ?>
                  <div class="mt-1 p-2 rounded" style="background-color: #fff5f5; border: 1px dashed #feb2b2; display: block; width: 100%; max-width: 600px;">
                    <span class="text-danger font-weight-bold" style="font-size: 12.5px;">
                      <i class="fa fa-info-circle mr-1"></i> Catatan Revisi: <span class="text-dark font-weight-normal"><?= esc($doc->catatan_verifikasi) ?></span>
                    </span>
                  </div>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<div class="row">
  <div class="col-md-4">
    <!-- Kartu Profil Ringkas Premium -->
    <div class="card shadow-sm mb-4 border-0 text-center" style="border-radius: 8px; background: #fff;">
      <div class="card-body p-4">
        <div class="mb-3 position-relative d-inline-block">
          <?php if (!empty($siswa->gambar)): ?>
            <img src="<?php echo base_url('assets/upload/image/thumbs/' . $siswa->gambar) ?>" class="img-thumbnail rounded-circle mx-auto" style="width: 80px; height: 80px; object-fit: cover; border: 2px solid #28a745;">
          <?php else: ?>
            <div style="width: 80px; height: 80px; border-radius: 50%; background: #f0fdf4; display: flex; align-items: center; justify-content: center; margin: 0 auto; border: 2px solid #28a745;">
              <i class="fa fa-user-graduate text-success" style="font-size: 36px;"></i>
            </div>
          <?php endif; ?>
        </div>
        <h5 class="font-weight-bold text-dark mb-1" style="font-size: 16px;"><?php echo strtoupper($siswa->nama_siswa) ?></h5>
        <p class="text-muted mb-2" style="font-size: 12.5px;"><i class="fa fa-id-card mr-1"></i> Kode: <strong><?php echo $siswa->kode_siswa ?></strong></p>
        
        <div class="dropdown-divider my-3"></div>
        
        <div class="text-left" style="font-size: 13px;">
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Program:</span>
            <span class="font-weight-bold text-dark"><?php echo $siswa->judul_program_pendidikan ?></span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Gelombang:</span>
            <span class="text-dark"><?php echo $siswa->judul ?></span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Tahun Ajaran:</span>
            <span class="text-dark"><?php echo $siswa->tahun_ajaran ?></span>
          </div>
        </div>
        
        <div class="mt-3">
          <button class="btn btn-outline-primary btn-sm btn-block font-weight-bold" type="button" data-toggle="collapse" data-target="#collapseDetailBiodata" aria-expanded="false" aria-controls="collapseDetailBiodata">
            <i class="fa fa-list-alt mr-1"></i> Lihat Biodata Lengkap
          </button>
        </div>
      </div>
    </div>

    <!-- Detail Biodata Lengkap (Collapsible) -->
    <div class="collapse mb-4" id="collapseDetailBiodata">
      <div class="card shadow-sm border-0" style="border-radius: 8px;">
        <div class="card-header bg-light py-2">
          <strong style="font-size: 13px;">BIODATA LENGKAP</strong>
        </div>
        <div class="card-body p-0">
          <table class="tabelku table-sm w-100" style="font-size: 12.5px;">
            <tbody>
              <tr>
                <td class="font-bold" width="35%">Panggilan</td>
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
                </td>
              </tr>
              <tr>
                <td class="font-bold">Telepon</td>
                <td><?php echo $siswa->telepon ?></td>
              </tr>
              <tr>
                <td class="font-bold">Email</td>
                <td><?php echo $siswa->email ?: $siswa->email_akun ?></td>
              </tr>
            </tbody>
          </table>
        </div>
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
                <div class="upload-container" data-id-jenis="<?php echo $id_jenis_dokumen ?>">
                  <div class="dropzone-area py-2" style="position: relative;">
                    <div class="dropzone-icon" style="font-size: 16px; margin-bottom: 2px;">
                      <i class="fa fa-upload text-primary"></i>
                    </div>
                    <div class="dropzone-text" style="font-size: 11px;">
                      <strong>Pilih Berkas</strong>
                    </div>
                    <input type="file" class="dropzone-input document-file-input" 
                           data-id-jenis="<?php echo $id_jenis_dokumen ?>" 
                           data-nama-dokumen="<?php echo esc($jenis_dokumen->nama_jenis_dokumen) ?>"
                           data-wajib="<?php echo $jenis_dokumen->status_jenis_dokumen=='Wajib' ? '1' : '0' ?>"
                           onchange="fileSelected(this, '<?php echo $id_jenis_dokumen ?>')" 
                           required style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                  </div>
                  <small class="text-muted d-block mt-1" style="font-size: 11px;">
                    File: <span id="file-name-<?php echo $id_jenis_dokumen ?>" class="text-primary font-weight-bold">Belum dipilih</span>
                    <span id="cancel-btn-<?php echo $id_jenis_dokumen ?>" class="text-danger ml-2 font-weight-bold" style="display: none; cursor: pointer;" onclick="clearFileSelection('<?php echo $id_jenis_dokumen ?>')">
                      <i class="fa fa-times-circle"></i> Batal
                    </span>
                  </small>
                  <span class="badge bg-warning text-dark mt-1" style="font-size: 10px;"><i class="fa fa-info-circle"></i> Maks. 2MB (PDF, JPG, PNG)</span>
                  <div class="upload-progress-container mt-1" id="progress-container-<?php echo $id_jenis_dokumen ?>" style="display: none;">
                    <div class="progress" style="height: 6px; margin-bottom: 2px;">
                      <div class="progress-bar bg-success" id="progress-bar-<?php echo $id_jenis_dokumen ?>" style="width: 0%"></div>
                    </div>
                    <small class="text-secondary" style="font-size: 10px;" id="progress-text-<?php echo $id_jenis_dokumen ?>">Mengunggah...</small>
                  </div>
                </div>
              <?php } ?>
            </td>
          </tr>
          <?php $no++; } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5" class="text-right">
              <input type="hidden" id="csrf_token" name="<?php echo csrf_token() ?>" value="<?php echo csrf_hash() ?>">
              <a href="<?php echo base_url('siswa/dasbor') ?>" class="btn btn-outline-info">
                <i class="fa fa-arrow-left"></i> Kembali
              </a>
              <button id="btnUploadAll" class="btn btn-primary ml-2 mr-2" style="display: none;" onclick="uploadAllFiles()">
                <i class="fa fa-cloud-upload-alt"></i> Unggah Semua Berkas Pilihan
              </button>
              <?php if($no==$data_total) { ?>
                  <a href="<?php echo base_url('siswa/pendaftaran/selesai/'.$siswa->slug_siswa) ?>" class="btn btn-success text-white">
                    Simpan dan Selesaikan Pendaftaran&nbsp;<i class="fa fa-arrow-right"></i>
                  </a>
              <?php }else{ ?>
                  <div class="alert alert-info mt-3 text-start">
                    Dokumen masih kurang, silakan pilih berkas lalu klik <strong>Unggah Semua Berkas Pilihan</strong> di atas.
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

<script>
function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length === 2) return parts.pop().split(";").shift();
}

function fileSelected(input, idJenis) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        document.getElementById('file-name-' + idJenis).innerText = file.name;
        document.getElementById('cancel-btn-' + idJenis).style.display = 'inline';
        
        // Ganti gaya visual dropzone area saat file dipilih
        var dropzone = input.closest('.dropzone-area');
        if (dropzone) {
            dropzone.style.borderColor = '#28a745';
            dropzone.style.background = '#f0fdf4';
            
            var dropzoneText = dropzone.querySelector('.dropzone-text');
            var dropzoneIcon = dropzone.querySelector('.dropzone-icon');
            
            // Hapus preview gambar lama jika ada
            var oldImg = dropzone.querySelector('.dropzone-img-preview');
            if (oldImg) oldImg.remove();
            
            var fileExt = file.name.split('.').pop().toLowerCase();
            var isImg = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].indexOf(fileExt) !== -1;
            
            if (isImg) {
                var img = document.createElement('img');
                img.className = 'dropzone-img-preview';
                img.src = URL.createObjectURL(file);
                img.style = 'max-width: 100%; max-height: 55px; object-fit: contain; border-radius: 4px; margin-bottom: 5px;';
                dropzone.insertBefore(img, dropzone.firstChild);
                
                dropzoneIcon.style.display = 'none';
                dropzoneText.innerHTML = '<strong style="color: #28a745; font-size: 11px;">' + file.name + '</strong>';
            } else {
                dropzoneIcon.style.display = 'block';
                var iconEl = dropzoneIcon.querySelector('i');
                dropzoneIcon.style.fontSize = '20px';
                
                if (fileExt === 'pdf') {
                    if (iconEl) iconEl.className = 'fa fa-file-pdf text-danger';
                    dropzoneText.innerHTML = '<span class="text-danger font-weight-bold">PDF</span><br><small class="text-dark d-block text-truncate" style="max-width: 140px; margin: 0 auto; font-size: 10px;">' + file.name + '</small>';
                } else if (['doc', 'docx'].indexOf(fileExt) !== -1) {
                    if (iconEl) iconEl.className = 'fa fa-file-word text-primary';
                    dropzoneText.innerHTML = '<span class="text-primary font-weight-bold">Word</span><br><small class="text-dark d-block text-truncate" style="max-width: 140px; margin: 0 auto; font-size: 10px;">' + file.name + '</small>';
                } else if (['xls', 'xlsx'].indexOf(fileExt) !== -1) {
                    if (iconEl) iconEl.className = 'fa fa-file-excel text-success';
                    dropzoneText.innerHTML = '<span class="text-success font-weight-bold">Excel</span><br><small class="text-dark d-block text-truncate" style="max-width: 140px; margin: 0 auto; font-size: 10px;">' + file.name + '</small>';
                } else if (['zip', 'rar'].indexOf(fileExt) !== -1) {
                    if (iconEl) iconEl.className = 'fa fa-file-archive text-warning';
                    dropzoneText.innerHTML = '<span class="text-warning font-weight-bold">Arsip</span><br><small class="text-dark d-block text-truncate" style="max-width: 140px; margin: 0 auto; font-size: 10px;">' + file.name + '</small>';
                } else {
                    if (iconEl) iconEl.className = 'fa fa-file text-secondary';
                    dropzoneText.innerHTML = '<span class="text-secondary font-weight-bold">Berkas</span><br><small class="text-dark d-block text-truncate" style="max-width: 140px; margin: 0 auto; font-size: 10px;">' + file.name + '</small>';
                }
            }
        }
        checkSelectedFiles();
    }
}

function clearFileSelection(idJenis) {
    var input = document.querySelector('.document-file-input[data-id-jenis="' + idJenis + '"]');
    if (input) {
        input.value = ''; // Reset input
        document.getElementById('file-name-' + idJenis).innerText = 'Belum dipilih';
        document.getElementById('cancel-btn-' + idJenis).style.display = 'none';
        
        var dropzone = input.closest('.dropzone-area');
        if (dropzone) {
            dropzone.style.borderColor = '#007bff';
            dropzone.style.background = '#f8f9fa';
            
            var oldImg = dropzone.querySelector('.dropzone-img-preview');
            if (oldImg) oldImg.remove();
            
            var iconContainer = dropzone.querySelector('.dropzone-icon');
            iconContainer.style.display = 'block';
            iconContainer.style.fontSize = '16px';
            var iconEl = iconContainer.querySelector('i');
            if (iconEl) iconEl.className = 'fa fa-upload text-primary';
            
            var textContainer = dropzone.querySelector('.dropzone-text');
            textContainer.innerHTML = '<strong>Pilih Berkas</strong>';
        }
        checkSelectedFiles();
    }
}

function checkSelectedFiles() {
    var hasFiles = false;
    var inputs = document.querySelectorAll('.document-file-input');
    inputs.forEach(function(input) {
        if (input.files && input.files.length > 0) {
            hasFiles = true;
        }
    });
    
    var btnUpload = document.getElementById('btnUploadAll');
    if (btnUpload) {
        if (hasFiles) {
            btnUpload.style.display = 'inline-block';
        } else {
            btnUpload.style.display = 'none';
        }
    }
}

function uploadAllFiles() {
    var inputs = document.querySelectorAll('.document-file-input');
    var filesToUpload = [];
    inputs.forEach(function(input) {
        if (input.files && input.files.length > 0) {
            filesToUpload.push(input);
        }
    });

    if (filesToUpload.length === 0) return;

    var btnUpload = document.getElementById('btnUploadAll');
    if (btnUpload) {
        btnUpload.disabled = true;
        btnUpload.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sedang Mengunggah...';
    }

    var total = filesToUpload.length;
    var failedFiles = [];
    var totalWajibMissing = document.querySelectorAll('.document-file-input[data-wajib="1"]').length;
    var uploadedWajibCount = 0;

    // Create a beautiful premium overlay modal
    var overlay = document.createElement('div');
    overlay.id = 'upload-overlay';
    overlay.style = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(30, 41, 59, 0.75); z-index: 9999; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(6px); transition: all 0.3s ease;';
    
    // Build files queue list HTML
    var queueHtml = '';
    filesToUpload.forEach(function(input, idx) {
        var docName = input.getAttribute('data-nama-dokumen');
        var fileName = input.files[0].name;
        queueHtml += `
            <div id="upload-row-${idx}" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; margin-bottom: 8px; font-family: sans-serif; font-size: 12.5px; transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; max-width: 80%;">
                    <div id="upload-icon-${idx}" style="margin-right: 12px; font-size: 16px; color: #94a3b8; width: 20px; text-align: center;">
                        <i class="fa fa-clock"></i>
                    </div>
                    <div style="text-align: left;">
                        <div style="font-weight: 700; color: #1e293b; line-height: 1.2;">${docName}</div>
                        <div style="color: #64748b; font-size: 11px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 260px; margin-top: 1px;">${fileName}</div>
                    </div>
                </div>
                <div id="upload-status-${idx}" style="font-weight: 600; color: #64748b; font-size: 11px;">Antre</div>
            </div>
        `;
    });

    overlay.innerHTML = `
        <div style="background: #fff; padding: 35px; border-radius: 16px; width: 90%; max-width: 480px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); text-align: center; border: 1px solid #e2e8f0;">
            <div id="overlay-icon-container" class="mb-3" style="display: inline-block;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: #e0f2fe; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);">
                    <i class="fa fa-cloud-upload-alt text-primary" style="font-size: 28px;"></i>
                </div>
            </div>
            <h4 style="margin-bottom: 8px; font-weight: 700; color: #1e293b; font-family: sans-serif;" id="overlay-title">Mengunggah Berkas</h4>
            <p style="color: #64748b; font-size: 14px; margin-bottom: 20px; font-family: sans-serif;" id="overlay-status">Menyiapkan berkas untuk diunggah...</p>
            
            <div id="upload-files-list" style="margin: 20px 0; max-height: 200px; overflow-y: auto; padding-right: 5px; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; padding-top: 15px; padding-bottom: 10px;">
                ${queueHtml}
            </div>

            <div style="background: #f1f5f9; border-radius: 9999px; height: 10px; width: 100%; overflow: hidden; margin-bottom: 12px; border: 1px solid #e2e8f0;">
                <div id="overlay-progressbar" style="background: linear-gradient(90deg, #3b82f6, #2563eb); height: 100%; width: 0%; transition: width 0.1s linear; border-radius: 9999px;"></div>
            </div>
            <div style="font-size: 13px; color: #64748b; font-weight: 600; font-family: sans-serif;" id="overlay-count">0 dari ${total} berkas selesai</div>
            <div id="overlay-error-list" style="display: none; text-align: left; max-height: 120px; overflow-y: auto; background: #fff1f2; border: 1px solid #fecdd3; border-radius: 8px; padding: 12px; margin-top: 15px; font-size: 13px; color: #be123c;"></div>
            <div id="overlay-actions" style="margin-top: 25px; display: none;">
                <button id="overlay-btn-action" class="btn btn-primary px-4 py-2 rounded-pill font-weight-bold" style="min-width: 120px; font-size: 14px;"></button>
            </div>
        </div>
    `;
    document.body.appendChild(overlay);

    function updateOverlayProgress(fileIndex, filePercent) {
        var overallPercent = ((fileIndex + (filePercent / 100)) / total) * 100;
        document.getElementById('overlay-progressbar').style.width = overallPercent + '%';
    }

    function uploadNext(index) {
        if (index >= total) {
            // Check if there are failures
            var iconContainer = document.getElementById('overlay-icon-container');
            var overlayTitle = document.getElementById('overlay-title');
            var overlayStatus = document.getElementById('overlay-status');
            var overlayActions = document.getElementById('overlay-actions');
            var overlayBtn = document.getElementById('overlay-btn-action');

            if (failedFiles.length > 0) {
                iconContainer.innerHTML = `
                    <div style="width: 60px; height: 60px; border-radius: 50%; background: #fee2e2; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 0 15px rgba(239, 68, 68, 0.2);">
                        <i class="fa fa-times text-danger" style="font-size: 28px;"></i>
                    </div>
                `;
                overlayTitle.innerText = "Unggah Berkas Selesai";
                overlayStatus.innerText = "Beberapa berkas gagal diunggah. Silakan tinjau daftar di atas.";
                
                var errorList = document.getElementById('overlay-error-list');
                errorList.innerHTML = "<strong>Gagal diunggah:</strong><ul style='margin: 5px 0 0 15px; padding: 0;'>" + 
                    failedFiles.map(function(f) { return "<li>" + f + "</li>"; }).join("") + "</ul>";
                errorList.style.display = "block";

                overlayBtn.innerText = "Tutup & Muat Ulang";
                overlayBtn.className = "btn btn-danger px-4 py-2 rounded-pill font-weight-bold";
                overlayBtn.onclick = function() {
                    window.location.reload();
                };
                overlayActions.style.display = "block";
            } else {
                iconContainer.innerHTML = `
                    <div style="width: 60px; height: 60px; border-radius: 50%; background: #dcfce7; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 0 15px rgba(34, 197, 94, 0.2);">
                        <i class="fa fa-check text-success" style="font-size: 28px;"></i>
                    </div>
                `;
                overlayTitle.innerText = "Berhasil Diunggah!";
                overlayStatus.innerText = "Semua berkas pilihan Anda berhasil disimpan di sistem.";
                document.getElementById('overlay-count').innerText = `${total} dari ${total} berkas selesai`;

                // Check if all required (Wajib) documents are now complete
                var isAllWajibUploaded = (uploadedWajibCount === totalWajibMissing);
                if (isAllWajibUploaded) {
                    overlayBtn.innerText = "Selesai & Lanjutkan";
                    overlayBtn.className = "btn btn-success px-4 py-2 rounded-pill font-weight-bold text-white shadow-sm";
                    overlayBtn.style.border = "none";
                    overlayBtn.style.backgroundColor = "#28a745";
                    overlayBtn.onclick = function() {
                        window.location.href = '<?php echo base_url('siswa/pendaftaran/selesai/' . $siswa->slug_siswa) ?>';
                    };
                } else {
                    overlayBtn.innerText = "Selesai & Muat Ulang";
                    overlayBtn.className = "btn btn-primary px-4 py-2 rounded-pill font-weight-bold text-white shadow-sm";
                    overlayBtn.style.border = "none";
                    overlayBtn.style.backgroundColor = "#007bff";
                    overlayBtn.onclick = function() {
                        window.location.reload();
                    };
                }
                overlayActions.style.display = 'block';
            }
            return;
        }

        var input = filesToUpload[index];
        var file = input.files[0];
        var idJenis = input.getAttribute('data-id-jenis');
        var isWajib = input.getAttribute('data-wajib') === '1';
        
        var progressBar = document.getElementById('progress-bar-' + idJenis);
        var progressContainer = document.getElementById('progress-container-' + idJenis);
        var progressText = document.getElementById('progress-text-' + idJenis);
        
        if (progressContainer) progressContainer.style.display = 'block';
        
        document.getElementById('overlay-status').innerText = 'Mengunggah: ' + file.name;
        document.getElementById('overlay-count').innerText = index + ' dari ' + total + ' berkas selesai';

        // Update list status visually
        var activeRow = document.getElementById('upload-row-' + index);
        if (activeRow) {
            activeRow.style.backgroundColor = '#eff6ff';
            activeRow.style.borderColor = '#bfdbfe';
        }
        var activeIcon = document.getElementById('upload-icon-' + index);
        if (activeIcon) {
            activeIcon.innerHTML = '<i class="fa fa-spinner fa-spin text-primary"></i>';
        }
        var activeStatus = document.getElementById('upload-status-' + index);
        if (activeStatus) {
            activeStatus.innerHTML = '<span class="text-primary font-weight-bold">Unggah...</span>';
        }

        var formData = new FormData();
        formData.append('id_jenis_dokumen', idJenis);
        formData.append('gambar', file);

        // CSRF Token
        var csrfName = document.getElementById('csrf_token').getAttribute('name');
        var csrfHash = document.getElementById('csrf_token').value;
        formData.append(csrfName, csrfHash);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo base_url('siswa/pendaftaran/dokumen/' . $siswa->slug_siswa) ?>', true);

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                var percentComplete = (e.loaded / e.total) * 100;
                if (progressBar) progressBar.style.width = percentComplete + '%';
                if (progressText) progressText.innerText = 'Mengunggah... ' + Math.round(percentComplete) + '%';
                updateOverlayProgress(index, percentComplete);
                
                if (activeStatus) {
                    activeStatus.innerHTML = '<span class="text-primary font-weight-bold">' + Math.round(percentComplete) + '%</span>';
                }
            }
        };

        xhr.onload = function() {
            if (xhr.status === 200 || xhr.status === 302) {
                if (progressText) progressText.innerHTML = '<span class="text-success font-weight-bold"><i class="fa fa-check-circle"></i> Berhasil!</span>';
                
                if (activeRow) {
                    activeRow.style.backgroundColor = '#f0fdf4';
                    activeRow.style.borderColor = '#bbf7d0';
                }
                if (activeIcon) {
                    activeIcon.innerHTML = '<i class="fa fa-check-circle text-success"></i>';
                }
                if (activeStatus) {
                    activeStatus.innerHTML = '<span class="text-success font-weight-bold">Sukses</span>';
                }

                if (isWajib) {
                    uploadedWajibCount++;
                }

                // Update CSRF token for next request
                var csrfCookie = getCookie('csrf_cookie_name');
                if (csrfCookie) {
                    document.getElementById('csrf_token').value = csrfCookie;
                } else {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(xhr.responseText, 'text/html');
                    var newTokenEl = doc.getElementById('csrf_token');
                    if (newTokenEl) {
                        document.getElementById('csrf_token').value = newTokenEl.value;
                    }
                }
            } else {
                if (progressText) progressText.innerHTML = '<span class="text-danger font-weight-bold"><i class="fa fa-times-circle"></i> Gagal!</span>';
                
                if (activeRow) {
                    activeRow.style.backgroundColor = '#fff5f5';
                    activeRow.style.borderColor = '#fecaca';
                }
                if (activeIcon) {
                    activeIcon.innerHTML = '<i class="fa fa-times-circle text-danger"></i>';
                }
                if (activeStatus) {
                    activeStatus.innerHTML = '<span class="text-danger font-weight-bold">Gagal</span>';
                }

                failedFiles.push(file.name);
            }
            updateOverlayProgress(index + 1, 0);
            setTimeout(function() {
                uploadNext(index + 1);
            }, 600);
        };

        xhr.onerror = function() {
            if (progressText) progressText.innerHTML = '<span class="text-danger font-weight-bold"><i class="fa fa-times-circle"></i> Gagal!</span>';
            
            if (activeRow) {
                activeRow.style.backgroundColor = '#fff5f5';
                activeRow.style.borderColor = '#fecaca';
            }
            if (activeIcon) {
                activeIcon.innerHTML = '<i class="fa fa-times-circle text-danger"></i>';
            }
            if (activeStatus) {
                activeStatus.innerHTML = '<span class="text-danger font-weight-bold">Gagal</span>';
            }

            failedFiles.push(file.name);
            updateOverlayProgress(index + 1, 0);
            setTimeout(function() {
                uploadNext(index + 1);
            }, 600);
        };

        xhr.send(formData);
    }

    // Start sequential uploads
    uploadNext(0);
}

// Drag and drop border highlights setup
document.addEventListener('DOMContentLoaded', function() {
    var fileInputs = document.querySelectorAll('.document-file-input');
    fileInputs.forEach(function(input) {
        var zone = input.closest('.dropzone-area');
        if (!zone) return;
        
        input.addEventListener('dragenter', function() {
            if (input.value === '') {
                zone.style.borderColor = '#28a745';
                zone.style.background = '#e9ecef';
            }
        });
        
        input.addEventListener('dragover', function() {
            if (input.value === '') {
                zone.style.borderColor = '#28a745';
                zone.style.background = '#e9ecef';
            }
        });
        
        input.addEventListener('dragleave', function() {
            if (input.value === '') {
                zone.style.borderColor = '#007bff';
                zone.style.background = '#f8f9fa';
            } else {
                zone.style.borderColor = '#28a745';
                zone.style.background = '#f0fdf4';
            }
        });
        
        input.addEventListener('drop', function() {
            if (input.value === '') {
                zone.style.borderColor = '#007bff';
                zone.style.background = '#f8f9fa';
            }
        });
    });
});
</script>
