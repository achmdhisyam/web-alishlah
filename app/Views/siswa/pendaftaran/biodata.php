<style>
/* Custom round checkbox style */
input[type="checkbox"].round-chk {
    appearance: none;
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    border: 2px solid #ccc;
    border-radius: 50% !important;
    outline: none;
    cursor: pointer;
    vertical-align: middle;
    display: inline-block;
    position: relative;
    margin-right: 6px;
}
input[type="checkbox"].round-chk:checked {
    background-color: #28a745;
    border-color: #28a745;
}
input[type="checkbox"].round-chk:checked::after {
    content: '';
    position: absolute;
    width: 6px;
    height: 6px;
    background: white;
    border-radius: 50%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.round-chk-container {
    cursor: pointer;
    user-select: none;
    display: inline-block;
}
.round-chk-container label {
    cursor: pointer;
}
.select2-hidden-accessible[required] {
    display: block !important;
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    opacity: 0 !important;
    padding: 0 !important;
    margin: 0 !important;
    border: 0 !important;
    clip: rect(0 0 0 0) !important;
    overflow: hidden !important;
}
.select2-container {
    width: 100% !important;
}
@media (max-width: 576px) {
    .step-indicator span {
        font-size: 10px !important;
        display: block;
        max-width: 75px;
        margin: 0 auto;
        line-height: 1.2;
    }
    .step-indicator .rounded-circle {
        width: 32px !important;
        height: 32px !important;
        font-size: 11px !important;
        line-height: 28px !important;
    }
}
@media (max-width: 400px) {
    .step-indicator span {
        font-size: 8.5px !important;
        max-width: 60px !important;
    }
    .step-indicator .rounded-circle {
        width: 26px !important;
        height: 26px !important;
        font-size: 10px !important;
        line-height: 22px !important;
    }
    .step-progress-wrapper {
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
}
@media (max-width: 767px) {
    .form-group .col-md-4,
    .form-group .col-md-5,
    .form-group .col-md-3,
    .form-group .col-md-9 {
        margin-bottom: 10px;
    }
    .form-group .col-md-4:last-child,
    .form-group .col-md-5:last-child,
    .form-group .col-md-9:last-child {
        margin-bottom: 0;
    }
}
</style>
<p class="lead mb-2 text-center">Halo <strong class="text-danger"><?php echo Session()->get('nama') ?></strong>, masukkan data Calon Siswa dengan benar dan lengkap.
                <br>Anda sedang mendaftar pada <strong><?php echo $gelombang->judul ?></strong> Tahun Ajaran <strong><?php echo $gelombang->tahun_ajaran ?></strong>.
              </p>

              <!-- Step Progress Bar (Roadmap) -->
              <div class="row mb-5 mt-4 text-center">
                <div class="col-12">
                  <div class="d-flex justify-content-between align-items-center position-relative mx-auto step-progress-wrapper" style="max-width: 600px;">
                    <!-- Progress line background -->
                    <div class="position-absolute start-0 end-0 top-50 translate-middle-y" style="height: 4px; background-color: #e9ecef; z-index: 1;">
                      <div id="stepProgressBar" style="height: 100%; width: 0%; background-color: #28a745; transition: width 0.3s ease;"></div>
                    </div>
                    <!-- Step 1 -->
                    <div class="text-center position-relative step-indicator active" data-step="1" style="z-index: 2;">
                      <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm border border-white" style="width: 40px; height: 40px; font-weight: bold;">1</div>
                      <span class="text-success font-weight-bold" style="font-size: 13px;">Data Dasar</span>
                    </div>
                    <!-- Step 2 -->
                    <div class="text-center position-relative step-indicator" data-step="2" style="z-index: 2;">
                      <div class="rounded-circle bg-white text-secondary border d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; font-weight: bold; border-color: #dee2e6 !important;">2</div>
                      <span class="text-muted" style="font-size: 13px;">Alamat & Kontak</span>
                    </div>
                    <!-- Step 3 -->
                    <div class="text-center position-relative step-indicator" data-step="3" style="z-index: 2;">
                      <div class="rounded-circle bg-white text-secondary border d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; font-weight: bold; border-color: #dee2e6 !important;">3</div>
                      <span class="text-muted" style="font-size: 13px;">Orang Tua / Wali</span>
                    </div>
                    <!-- Step 4 -->
                    <div class="text-center position-relative step-indicator" data-step="4" style="z-index: 2;">
                      <div class="rounded-circle bg-white text-secondary border d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; font-weight: bold; border-color: #dee2e6 !important;">4</div>
                      <span class="text-muted" style="font-size: 13px;">Konfirmasi</span>
                    </div>
                  </div>
                </div>
              </div>

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

              <?php 
        use App\Models\Agama_model;
        use App\Models\Jenjang_model;
        use App\Models\Pekerjaan_model;
        use App\Models\Hubungan_model;
        use App\Models\Kelas_model;
        use App\Models\Tahun_model;
        use App\Models\Program_pendidikan_model;
        $m_agama    = new Agama_model();
        $m_jenjang    = new Jenjang_model();
        $m_pekerjaan  = new Pekerjaan_model();
        $m_hubungan   = new Hubungan_model();
        $m_tahun    = new Tahun_model();
        $m_kelas    = new Kelas_model();
        $m_program_pendidikan   = new Program_pendidikan_model();

        echo form_open_multipart(base_url('siswa/pendaftaran/biodata/'.$gelombang->id_gelombang));
        echo csrf_field(); 
        ?>
        <p><span class="text-danger">*</span> Wajib diisi</p>
        
        <div class="step-container" id="step-1">
        <!-- data dasar siswa -->
        <div class="card mb-2">
          <div class="card-header bg-dark text-white mb-2">
            DATA DASAR SISWA
          </div>
          <div class="card-body">


            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Program<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <?php $program_pendidikan   = $m_program_pendidikan->main(); ?>
                <select name="id_program_pendidikan" class="form-control  form-select" required>
                  <option value="">Pilih Program Pendidikan</option>
                  <?php foreach($program_pendidikan as $jp) { ?>
                    <?php if($jp->jenis_program_pendidikan == 'Program Pendidikan') { ?> 
                      <option value="<?php echo $jp->id_program_pendidikan ?>" 
                        <?php if(set_value('id_program_pendidikan')==$jp->id_program_pendidikan) { echo 'selected'; } ?>>
                        <?php echo $jp->judul_program_pendidikan; ?>
                      </option>
                    <?php } ?>
                  <?php } ?>

                </select>
                <small class="text-secondary">Status Anak</small>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Nama Lengkap<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <input type="text" name="nama_siswa" class="form-control form-control-lg" placeholder="Nama lengkap siswa" value="<?php echo set_value('nama_siswa') ?>" required>
                <small class="text-warning">Nama lengkap Siswa</small>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Nama Panggilan<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <input type="text" name="nama_panggilan" class="form-control" placeholder="Nama panggilan" value="<?php echo set_value('nama_panggilan') ?>" required>
                <small class="text-warning">Nama panggilan</small>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">NIS dan NISN<span class="text-danger">*</span></label>
              <div class="col-md-4">
                <input type="text" name="nis" class="form-control" placeholder="Nomor Induk Siswa (NIS)" value="<?php echo set_value('nis') ?>">
                <small class="text-warning">Nomor Induk Siswa (NIS) atau kosongkan</small>
              </div>
              <div class="col-md-5">
                <input type="text" name="nisn" class="form-control" placeholder="Nomor Induk Siswa Nasional (NISN)" value="<?php echo set_value('nisn') ?>" required>
                <small class="text-warning">Nomor Induk Siswa Nasional (NISN)</small>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Agama &amp; Status Kewarganegaraan<span class="text-danger">*</span></label>
              <div class="col-md-3">
                <?php $agama = $m_agama->listing(); ?>
                <select name="id_agama" class="form-control form-select" required>
                  <?php foreach($agama as $agama) { ?>
                    <option value="<?php echo $agama->id_agama ?>" <?php if(set_value('id_agama')==$agama->id_agama) { echo 'selected'; } ?>>
                      <?php echo $agama->nama_agama ?>
                    </option>
                  <?php } ?>
                </select>
                <small class="text-secondary">Agama Siswa</small>
              </div>
              <div class="col-md-3">
                <select name="status_wn" class="form-control form-select" required>
                  <option value="WNI">WNI</option>
                  <option value="WNA" <?php if(set_value('status_wn')=='WNA') { echo 'selected'; } ?>>WNA</option>
                </select>
              </div>
              <div class="col-md-3">
                <input type="text" name="negara_asal" class="form-control" value="<?php echo set_value('negara_asal') ?>" placeholder="Negara asal (jika WNA)">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Jenis Kelamin<span class="text-danger">*</span></label>
              <div class="col-md-9">
                  <select name="jenis_kelamin" class="form-control form-select" required>
                    <option value="">Jenis Kelamin</option>
                    <option value="L" <?php if(set_value('jenis_kelamin')=='L') { echo 'checked'; } ?>>Laki-laki</option>
                    <option value="P" <?php if(set_value('jenis_kelamin')=='P') { echo 'selected'; } ?>>Perempuan</option>
                  </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Status/Hubungan Anak dengan Wali<span class="text-danger">*</span></label>
              <div class="col-md-3">
                <?php $hubungan = $m_hubungan->listing(); ?>
                <select name="id_hubungan" class="form-control  form-select" required>
                  <?php foreach($hubungan as $hubungan) { ?>
                    <option value="<?php echo $hubungan->id_hubungan ?>" <?php if(set_value('id_hubungan')==$hubungan->id_hubungan) { echo 'selected'; } ?>>
                      <?php echo $hubungan->nama_hubungan ?>
                    </option>
                  <?php } ?>
                </select>
                <small class="text-secondary">Status Anak</small>
              </div>
              <div class="col-md-3">
                <input type="number" name="anak_ke" class="form-control" placeholder="Anak nomor ke?" value="<?php echo set_value('anak_ke') ?>" required>
                <small class="text-secondary">Anak nomor ke</small>
              </div>
              <div class="col-md-3">
                <input type="number" name="jumlah_saudara" class="form-control" placeholder="Jumlah saudara" value="<?php echo set_value('jumlah_saudara') ?>" required>
                <small class="text-secondary">Jumlah saudara</small>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tempat dan Tanggal Lahir<span class="text-danger">*</span></label>
              <div class="col-md-5">
                <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat lahir" value="<?php echo set_value('tempat_lahir') ?>" required>
                <small class="text-warning">Tempat lahir</small>
              </div>
              <div class="col-md-4">
                <input type="text" name="tanggal_lahir" class="form-control tanggal" placeholder="dd-mm-yyyy" value="<?php echo set_value('tanggal_lahir') ?>" required>
                <small class="text-warning">Tanggal lahir</small>
              </div>
            </div>
            <!-- End of Step 1: Data Dasar Siswa -->
            <div class="d-flex justify-content-end mt-3 mb-4">
              <button type="button" class="btn btn-primary rounded-pill px-4" onclick="nextStep()">Lanjutkan &nbsp;<i class="fa fa-arrow-right"></i></button>
            </div>
          </div><!-- end card-body -->
        </div><!-- end card -->
        </div><!-- end step-1 -->

        <div class="step-container" id="step-2" style="display: none;">
        <div class="card mb-2">
          <div class="card-header bg-dark text-white mb-2">
            ALAMAT &amp; KONTAK SISWA
          </div>
          <div class="card-body">

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Alamat Jalan / Kelurahan<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <textarea name="alamat" placeholder="Nama Jalan, Blok, No. Rumah, Kelurahan/Desa" class="form-control" rows="2" required><?php echo set_value('alamat') ?></textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">RT / RW<span class="text-danger">*</span></label>
              <div class="col-md-4">
                <input type="text" name="rt" class="form-control" placeholder="RT (contoh: 001)" value="<?php echo set_value('rt') ?>" required>
              </div>
              <div class="col-md-5">
                <input type="text" name="rw" class="form-control" placeholder="RW (contoh: 002)" value="<?php echo set_value('rw') ?>" required>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Provinsi<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <select name="provinsi" id="provinsi" class="form-control form-select select2" required>
                  <option value="">Pilih Provinsi</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kab/Kota &amp; Kecamatan<span class="text-danger">*</span></label>
              <div class="col-md-5">
                <select name="kabupaten" id="kabupaten" class="form-control form-select select2" required>
                  <option value="">Pilih Kabupaten / Kota</option>
                </select>
              </div>
              <div class="col-md-4">
                <select name="kecamatan" id="kecamatan" class="form-control form-select select2" required>
                  <option value="">Pilih Kecamatan</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kelurahan / Desa<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <select name="kelurahan" id="kelurahan" class="form-control form-select select2" required>
                  <option value="">Pilih Kelurahan / Desa</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kode Pos</label>
              <div class="col-md-9">
                <input type="text" name="kode_pos" class="form-control" placeholder="" value="<?php echo set_value('kode_pos') ?>">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Telepon dan Email<span class="text-danger">*</span></label>
              <div class="col-md-4">
                <input type="text" name="telepon" class="form-control" placeholder="Telepon/HP" value="<?php echo set_value('telepon') ?>" required>
                <small class="text-warning">Telepon/HP</small>
              </div>
              <div class="col-md-5">
                <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo set_value('email') ?>" required>
                <small class="text-warning">Email (Username)</small>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Ukuran Seragam</label>
              <div class="col-md-9">
                <select name="ukuran_seragam" class="form-control form-select" onchange="checkSeragam(this.value)">
                    
                    <option value="">Pilih Ukuran Seragam</option>
                    <option value="M" <?php if(set_value('ukuran_seragam')=='M') { echo 'selected'; } ?>>M</option>
                    <option value="L" <?php if(set_value('ukuran_seragam')=='L') { echo 'selected'; } ?>>L</option>
                    <option value="XL" <?php if(set_value('ukuran_seragam')=='XL') { echo 'selected'; } ?>>XL</option>
                    <option value="Lainnya" <?php if(set_value('ukuran_seragam')=='Lainnya') { echo 'selected'; } ?>>Lainnya</option>
        
                </select>
                
                <input type="text" name="ukuran_seragam_lainnya" id="ukuran_seragam_lainnya" class="form-control mt-2" placeholder="Ketik ukuran manual..." style="display: none;">
        
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Gambar/Foto</label>
              
              <div class="col-md-9">
                <input type="file" name="gambar" class="form-control" placeholder="Gambar/Foto" value="<?php echo set_value('gambar') ?>">
              </div>
            </div>
            

          </div>
          
        </div>
        <!-- data dasar siswa -->

        
        <!-- data dasar siswa -->
        <div class="card mb-2">
          <div class="card-header bg-dark text-white mb-2">
            PENDIDIKAN SEBELUMNYA
          </div>
          <div class="card-body">
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tamatan Dari</label>
              <div class="col-md-9">
                <input type="text" name="asal_sekolah" class="form-control" placeholder="Nama Sekolah Asal (Tamatan Dari)" value="<?php echo set_value('asal_sekolah') ?>">
              </div>
            </div>
            
          </div>
        </div>
        <div class="d-flex justify-content-between mt-3 mb-4">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="prevStep()"><i class="fa fa-arrow-left"></i> Kembali</button>
          <button type="button" class="btn btn-primary rounded-pill px-4" onclick="nextStep()">Lanjutkan &nbsp;<i class="fa fa-arrow-right"></i></button>
        </div>
        </div> <!-- Close Step 2 -->

        <div class="step-container" id="step-3" style="display: none;">
        <!-- data ayah -->
        <div class="card mb-2">
          
          <div class="card-header bg-dark text-white mb-2">
            DATA ORANG TUA SISWA - AYAH
          </div>
          <div class="card-body">
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Nama Ayah<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <input type="text" name="nama_ayah" class="form-control" placeholder="Nama Ayah" value="<?php echo set_value('nama_ayah') ?>" required>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Agama Ayah</label>
              <div class="col-md-9">
                <?php $agama = $m_agama->listing(); ?>
                <select name="id_agama_ayah" class="form-control form-select">
                  <option value="">Pilih Agama</option>
                  <?php foreach($agama as $ag) { ?>
                    <option value="<?php echo $ag->id_agama ?>" <?php if(set_value('id_agama_ayah')==$ag->id_agama ) { echo 'selected'; } ?>>
                      <?php echo $ag->nama_agama ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tempat & Tanggal Lahir Ayah</label>
              <div class="col-md-5">
                <input type="text" name="tempat_lahir_ayah" class="form-control" placeholder="Tempat lahir ayah" value="<?php echo set_value('tempat_lahir_ayah') ?>">
              </div>
              <div class="col-md-4">
                <input type="text" name="tanggal_lahir_ayah" class="form-control tanggal" placeholder="dd-mm-yyyy" value="<?php echo set_value('tanggal_lahir_ayah') ?>">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kewarganegaraan Ayah</label>
              <div class="col-md-9">
                <select name="status_wn_ayah" class="form-control form-select">
                  <option value="WNI" <?php if(set_value('status_wn_ayah')=='WNI') { echo 'selected'; } ?>>WNI</option>
                  <option value="WNA" <?php if(set_value('status_wn_ayah')=='WNA') { echo 'selected'; } ?>>WNA</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Pendidikan Ayah</label>
              <div class="col-md-9">
                <?php $jenjang = $m_jenjang->listing(); ?>
                <select name="id_jenjang_ayah" class="form-control form-select">
                  <option value="">Pilih Jenjang Pendidikan</option>
                  <?php foreach($jenjang as $jg) { ?>
                    <option value="<?php echo $jg->id_jenjang ?>" <?php if(set_value('id_jenjang_ayah')==$jg->id_jenjang ) { echo 'selected'; } ?>>
                      <?php echo $jg->nama_jenjang ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Pekerjaan Ayah<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <?php $pekerjaan = $m_pekerjaan->listing(); ?>
                <select name="id_pekerjaan_ayah" class="form-control form-select" required>
                  <option value="">Pilih Pekerjaan</option>
                  <?php foreach($pekerjaan as $pk) { ?>
                    <option value="<?php echo $pk->id_pekerjaan ?>" <?php if(set_value('id_pekerjaan_ayah')==$pk->id_pekerjaan ) { echo 'selected'; } ?>>
                      <?php echo $pk->nama_pekerjaan ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Penghasilan per Bulan Ayah</label>
              <div class="col-md-9">
                <input type="text" name="penghasilan_ayah" class="form-control" placeholder="Rp." value="<?php echo set_value('penghasilan_ayah') ?>">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Status Ayah</label>
              <div class="col-md-9">
                <select name="status_hidup_ayah" class="form-control form-select">
                  <option value="Hidup" <?php if(set_value('status_hidup_ayah')=='Hidup') { echo 'selected'; } ?>>Masih Hidup</option>
                  <option value="Meninggal" <?php if(set_value('status_hidup_ayah')=='Meninggal') { echo 'selected'; } ?>>Sudah Meninggal</option>
                </select>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Alamat Jalan / Kelurahan Ayah<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <div class="round-chk-container mb-2">
                  <input class="round-chk" type="checkbox" id="sama_alamat_ayah">
                  <label class="text-secondary font-weight-bold" for="sama_alamat_ayah">
                    Sama dengan Alamat Siswa <small class="text-info">(Klik untuk menyamakan alamat secara otomatis)</small>
                  </label>
                </div>
                <textarea name="alamat_ayah" id="alamat_ayah" placeholder="Nama Jalan, Blok, No. Rumah, Kelurahan/Desa" class="form-control" rows="2" required><?php if(isset($_POST['submit'])) { echo set_value('alamat_ayah'); }else{ echo isset($siswa) ? $siswa->alamat_ayah : ''; } ?></textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">RT / RW Ayah<span class="text-danger">*</span></label>
              <div class="col-md-4">
                <input type="text" name="rt_ayah" id="rt_ayah" class="form-control" placeholder="RT (contoh: 001)" value="<?php if(isset($_POST['submit'])) { echo set_value('rt_ayah'); }else{ echo isset($siswa) ? $siswa->rt_ayah : ''; } ?>" required>
              </div>
              <div class="col-md-5">
                <input type="text" name="rw_ayah" id="rw_ayah" class="form-control" placeholder="RW (contoh: 002)" value="<?php if(isset($_POST['submit'])) { echo set_value('rw_ayah'); }else{ echo isset($siswa) ? $siswa->rw_ayah : ''; } ?>" required>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Provinsi Ayah<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <select name="provinsi_ayah" id="provinsi_ayah" class="form-control form-select select2" required>
                  <option value="">Pilih Provinsi</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kab/Kota &amp; Kecamatan Ayah<span class="text-danger">*</span></label>
              <div class="col-md-5">
                <select name="kabupaten_ayah" id="kabupaten_ayah" class="form-control form-select select2" required>
                  <option value="">Pilih Kabupaten / Kota</option>
                </select>
              </div>
              <div class="col-md-4">
                <select name="kecamatan_ayah" id="kecamatan_ayah" class="form-control form-select select2" required>
                  <option value="">Pilih Kecamatan</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kelurahan / Desa Ayah<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <select name="kelurahan_ayah" id="kelurahan_ayah" class="form-control form-select select2" required>
                  <option value="">Pilih Kelurahan / Desa</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kode Pos Ayah</label>
              <div class="col-md-9">
                <input type="text" id="kode_pos_ayah" name="kode_pos_ayah" class="form-control" placeholder="" value="<?php if(isset($_POST['submit'])) { echo set_value('kode_pos_ayah'); }else{ echo isset($siswa) ? $siswa->kode_pos_ayah : ''; } ?>">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Telepon/HP Ayah<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <input type="text" name="telepon_ayah" class="form-control" placeholder="Telepon/HP Ayah" value="<?php echo set_value('telepon_ayah') ?>" required>
              </div>
            </div>
            
          </div>
        </div>
        <!-- data ibu -->
        <div class="card mb-2">
          
          <div class="card-header bg-dark text-white mb-2">
            DATA ORANG TUA SISWA - IBU
          </div>
          <div class="card-body">
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Nama Ibu<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <input type="text" name="nama_ibu" class="form-control" placeholder="Nama Ibu" value="<?php echo set_value('nama_ibu') ?>" required>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Agama Ibu</label>
              <div class="col-md-9">
                <?php $agama = $m_agama->listing(); ?>
                <select name="id_agama_ibu" class="form-control form-select">
                  <option value="">Pilih Agama</option>
                  <?php foreach($agama as $ag) { ?>
                    <option value="<?php echo $ag->id_agama ?>" <?php if(set_value('id_agama_ibu')==$ag->id_agama ) { echo 'selected'; } ?>>
                      <?php echo $ag->nama_agama ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tempat & Tanggal Lahir Ibu</label>
              <div class="col-md-5">
                <input type="text" name="tempat_lahir_ibu" class="form-control" placeholder="Tempat lahir ibu" value="<?php echo set_value('tempat_lahir_ibu') ?>">
              </div>
              <div class="col-md-4">
                <input type="text" name="tanggal_lahir_ibu" class="form-control tanggal" placeholder="dd-mm-yyyy" value="<?php echo set_value('tanggal_lahir_ibu') ?>">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kewarganegaraan Ibu</label>
              <div class="col-md-9">
                <select name="status_wn_ibu" class="form-control form-select">
                  <option value="WNI" <?php if(set_value('status_wn_ibu')=='WNI') { echo 'selected'; } ?>>WNI</option>
                  <option value="WNA" <?php if(set_value('status_wn_ibu')=='WNA') { echo 'selected'; } ?>>WNA</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Pendidikan Ibu</label>
              <div class="col-md-9">
                <?php $jenjang = $m_jenjang->listing(); ?>
                <select name="id_jenjang_ibu" class="form-control form-select">
                  <option value="">Pilih Jenjang Pendidikan</option>
                  <?php foreach($jenjang as $jg) { ?>
                    <option value="<?php echo $jg->id_jenjang ?>" <?php if(set_value('id_jenjang_ibu')==$jg->id_jenjang ) { echo 'selected'; } ?>>
                      <?php echo $jg->nama_jenjang ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Pekerjaan Ibu<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <?php $pekerjaan = $m_pekerjaan->listing(); ?>
                <select name="id_pekerjaan_ibu" class="form-control form-select" required>
                  <option value="">Pilih Pekerjaan</option>
                  <?php foreach($pekerjaan as $pk) { ?>
                    <option value="<?php echo $pk->id_pekerjaan ?>" <?php if(set_value('id_pekerjaan_ibu')==$pk->id_pekerjaan ) { echo 'selected'; } ?>>
                      <?php echo $pk->nama_pekerjaan ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Penghasilan per Bulan Ibu</label>
              <div class="col-md-9">
                <input type="text" name="penghasilan_ibu" class="form-control" placeholder="Rp." value="<?php echo set_value('penghasilan_ibu') ?>">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Status Ibu</label>
              <div class="col-md-9">
                <select name="status_hidup_ibu" class="form-control form-select">
                  <option value="Hidup" <?php if(set_value('status_hidup_ibu')=='Hidup') { echo 'selected'; } ?>>Masih Hidup</option>
                  <option value="Meninggal" <?php if(set_value('status_hidup_ibu')=='Meninggal') { echo 'selected'; } ?>>Sudah Meninggal</option>
                </select>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Alamat Jalan / Kelurahan Ibu<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <div class="round-chk-container mb-2">
                  <input class="round-chk" type="checkbox" id="sama_alamat_ibu">
                  <label class="text-secondary font-weight-bold" for="sama_alamat_ibu">
                    Sama dengan Alamat Siswa <small class="text-info">(Klik untuk menyamakan alamat secara otomatis)</small>
                  </label>
                </div>
                <textarea name="alamat_ibu" id="alamat_ibu" placeholder="Nama Jalan, Blok, No. Rumah, Kelurahan/Desa" class="form-control" rows="2" required><?php if(isset($_POST['submit'])) { echo set_value('alamat_ibu'); }else{ echo isset($siswa) ? $siswa->alamat_ibu : ''; } ?></textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">RT / RW Ibu<span class="text-danger">*</span></label>
              <div class="col-md-4">
                <input type="text" name="rt_ibu" id="rt_ibu" class="form-control" placeholder="RT (contoh: 001)" value="<?php if(isset($_POST['submit'])) { echo set_value('rt_ibu'); }else{ echo isset($siswa) ? $siswa->rt_ibu : ''; } ?>" required>
              </div>
              <div class="col-md-5">
                <input type="text" name="rw_ibu" id="rw_ibu" class="form-control" placeholder="RW (contoh: 002)" value="<?php if(isset($_POST['submit'])) { echo set_value('rw_ibu'); }else{ echo isset($siswa) ? $siswa->rw_ibu : ''; } ?>" required>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Provinsi Ibu<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <select name="provinsi_ibu" id="provinsi_ibu" class="form-control form-select select2" required>
                  <option value="">Pilih Provinsi</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kab/Kota &amp; Kecamatan Ibu<span class="text-danger">*</span></label>
              <div class="col-md-5">
                <select name="kabupaten_ibu" id="kabupaten_ibu" class="form-control form-select select2" required>
                  <option value="">Pilih Kabupaten / Kota</option>
                </select>
              </div>
              <div class="col-md-4">
                <select name="kecamatan_ibu" id="kecamatan_ibu" class="form-control form-select select2" required>
                  <option value="">Pilih Kecamatan</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kelurahan / Desa Ibu<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <select name="kelurahan_ibu" id="kelurahan_ibu" class="form-control form-select select2" required>
                  <option value="">Pilih Kelurahan / Desa</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kode Pos Ibu</label>
              <div class="col-md-9">
                <input type="text" id="kode_pos_ibu" name="kode_pos_ibu" class="form-control" placeholder="" value="<?php if(isset($_POST['submit'])) { echo set_value('kode_pos_ibu'); }else{ echo isset($siswa) ? $siswa->kode_pos_ibu : ''; } ?>">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Telepon/HP Ibu<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <input type="text" name="telepon_ibu" class="form-control" placeholder="Telepon/HP Ibu" value="<?php echo set_value('telepon_ibu') ?>" required>
              </div>
            </div>
            
          </div>
        </div>
        <!-- data wali -->
        <div class="card">
          
          <div class="card-header bg-dark text-white mb-2">
            DATA ORANG TUA SISWA - WALI MURID
          </div>
          <div class="card-body">
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Identitas Wali Murid<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <div class="form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="identitas_wali" value="Ayah" onclick="Ayah()" <?php if(set_value('identitas_wali')=='Ayah' ) { echo 'checked'; } ?> required>
                    <label class="form-check-label">Sama dengan Ayah</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="identitas_wali" value="Ibu" onclick="Ibu()" <?php if(set_value('identitas_wali')=='Ibu' ) { echo 'checked'; } ?> required>
                    <label class="form-check-label">Sama dengan Ibu</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="identitas_wali" value="Berbeda" onclick="Berbeda()" <?php if(set_value('identitas_wali')=='Berbeda' ) { echo 'checked'; } ?> required>
                    <label class="form-check-label">Berbeda dengan Ayah dan Ibu</label>
                  </div>
                </div>
              </div>
            </div>
            <div id="myDIV" style="display: <?php if(set_value('identitas_wali') == 'Ayah' || set_value('identitas_wali') == 'Ibu') { echo 'none'; }else{ echo 'block'; } ?>;">
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Nama Wali<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <input type="text" name="nama_wali" class="form-control" placeholder="Nama Wali" value="<?php echo set_value('nama_wali') ?>" >
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Agama Wali</label>
              <div class="col-md-9">
                <?php $agama = $m_agama->listing(); ?>
                <select name="id_agama_wali" class="form-control form-select">
                  <option value="">Pilih Agama</option>
                  <?php foreach($agama as $ag) { ?>
                    <option value="<?php echo $ag->id_agama ?>" <?php if(set_value('id_agama_wali')==$ag->id_agama ) { echo 'selected'; } ?>>
                      <?php echo $ag->nama_agama ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tempat & Tanggal Lahir Wali</label>
              <div class="col-md-5">
                <input type="text" name="tempat_lahir_wali" class="form-control" placeholder="Tempat lahir wali" value="<?php echo set_value('tempat_lahir_wali') ?>">
              </div>
              <div class="col-md-4">
                <input type="text" name="tanggal_lahir_wali" class="form-control tanggal" placeholder="dd-mm-yyyy" value="<?php echo set_value('tanggal_lahir_wali') ?>">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kewarganegaraan Wali</label>
              <div class="col-md-9">
                <select name="status_wn_wali" class="form-control form-select">
                  <option value="WNI" <?php if(set_value('status_wn_wali')=='WNI') { echo 'selected'; } ?>>WNI</option>
                  <option value="WNA" <?php if(set_value('status_wn_wali')=='WNA') { echo 'selected'; } ?>>WNA</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Pendidikan Wali</label>
              <div class="col-md-9">
                <?php $jenjang = $m_jenjang->listing(); ?>
                <select name="id_jenjang_wali" class="form-control form-select">
                  <option value="">Pilih Jenjang Pendidikan</option>
                  <?php foreach($jenjang as $jg) { ?>
                    <option value="<?php echo $jg->id_jenjang ?>" <?php if(set_value('id_jenjang_wali')==$jg->id_jenjang ) { echo 'selected'; } ?>>
                      <?php echo $jg->nama_jenjang ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Pekerjaan Wali</label>
              <div class="col-md-9">
                <?php $pekerjaan = $m_pekerjaan->listing(); ?>
                <select name="id_pekerjaan_wali" class="form-control form-select" >
                  <option value="">Pilih Pekerjaan</option>
                  <?php foreach($pekerjaan as $pk) { ?>
                    <option value="<?php echo $pk->id_pekerjaan ?>" <?php if(set_value('id_pekerjaan_wali')==$pk->id_pekerjaan ) { echo 'selected'; } ?>>
                      <?php echo $pk->nama_pekerjaan ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Penghasilan per Bulan Wali</label>
              <div class="col-md-9">
                <input type="text" name="penghasilan_wali" class="form-control" placeholder="Rp." value="<?php echo set_value('penghasilan_wali') ?>">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Alamat Jalan / Kelurahan Wali<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <div class="round-chk-container mb-2">
                  <input class="round-chk" type="checkbox" id="sama_alamat_wali">
                  <label class="text-secondary font-weight-bold" for="sama_alamat_wali">
                    Sama dengan Alamat Siswa <small class="text-info">(Klik untuk menyamakan alamat secara otomatis)</small>
                  </label>
                </div>
                <textarea name="alamat_wali" id="alamat_wali" placeholder="Nama Jalan, Blok, No. Rumah, Kelurahan/Desa" class="form-control" rows="2"><?php if(isset($_POST['submit'])) { echo set_value('alamat_wali'); }else{ echo isset($siswa) ? $siswa->alamat_wali : ''; } ?></textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">RT / RW Wali<span class="text-danger">*</span></label>
              <div class="col-md-4">
                <input type="text" name="rt_wali" id="rt_wali" class="form-control" placeholder="RT (contoh: 001)" value="<?php if(isset($_POST['submit'])) { echo set_value('rt_wali'); }else{ echo isset($siswa) ? $siswa->rt_wali : ''; } ?>">
              </div>
              <div class="col-md-5">
                <input type="text" name="rw_wali" id="rw_wali" class="form-control" placeholder="RW (contoh: 002)" value="<?php if(isset($_POST['submit'])) { echo set_value('rw_wali'); }else{ echo isset($siswa) ? $siswa->rw_wali : ''; } ?>">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Provinsi Wali<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <select name="provinsi_wali" id="provinsi_wali" class="form-control form-select select2">
                  <option value="">Pilih Provinsi</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kab/Kota &amp; Kecamatan Wali<span class="text-danger">*</span></label>
              <div class="col-md-5">
                <select name="kabupaten_wali" id="kabupaten_wali" class="form-control form-select select2">
                  <option value="">Pilih Kabupaten / Kota</option>
                </select>
              </div>
              <div class="col-md-4">
                <select name="kecamatan_wali" id="kecamatan_wali" class="form-control form-select select2">
                  <option value="">Pilih Kecamatan</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kelurahan / Desa Wali<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <select name="kelurahan_wali" id="kelurahan_wali" class="form-control form-select select2">
                  <option value="">Pilih Kelurahan / Desa</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kode Pos Wali</label>
              <div class="col-md-9">
                <input type="text" id="kode_pos_wali" name="kode_pos_wali" class="form-control" placeholder="" value="<?php if(isset($_POST['submit'])) { echo set_value('kode_pos_wali'); }else{ echo isset($siswa) ? $siswa->kode_pos_wali : ''; } ?>">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Telepon/HP Wali<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <input type="text" name="telepon_wali" class="form-control" placeholder="Telepon/HP Wali" value="<?php echo set_value('telepon_wali') ?>" >
              </div>
            </div>
            
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-between mt-3 mb-4">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="prevStep()"><i class="fa fa-arrow-left"></i> Kembali</button>
          <button type="button" class="btn btn-primary rounded-pill px-4" onclick="nextStep()">Lanjutkan &nbsp;<i class="fa fa-arrow-right"></i></button>
        </div>
        </div> <!-- Close Step 3 -->

        <div class="step-container" id="step-4" style="display: none;">
          <div class="card mb-2">
            <div class="card-header bg-success text-white mb-2">
              KONFIRMASI &amp; REVIEW BIODATA
            </div>
            <div class="card-body">
              <p class="lead text-center text-dark fw-bold">Tinjau kembali data pendaftaran Anda sebelum menyimpan secara permanen.</p>
              <table class="table table-bordered table-striped text-dark">
                <tr>
                  <th width="35%">Nama Lengkap</th>
                  <td id="summary-nama">-</td>
                </tr>
                <tr>
                  <th>NISN</th>
                  <td id="summary-nisn">-</td>
                </tr>
                <tr>
                  <th>Telepon/HP</th>
                  <td id="summary-telepon">-</td>
                </tr>
                <tr>
                  <th>Alamat Jalan</th>
                  <td id="summary-alamat">-</td>
                </tr>
                <tr>
                  <th>Nama Ayah / Ibu</th>
                  <td><span id="summary-ayah">-</span> / <span id="summary-ibu">-</span></td>
                </tr>
              </table>
              
              <div class="form-check mt-4 p-3 bg-light border rounded">
                <input class="form-check-input" type="checkbox" id="checkAgree" style="width: 20px; height: 20px; cursor: pointer;" required>
                <label class="form-check-label text-dark font-weight-bold" for="checkAgree" style="margin-left: 10px; cursor: pointer; padding-top: 2px;">
                  Saya menyatakan bahwa data yang diisi di atas adalah benar, sah, dan sesuai dengan dokumen aslinya.
                </label>
              </div>
            </div>
            <div class="card-footer bg-light border-top">
              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" onclick="prevStep()"><i class="fa fa-arrow-left"></i> Kembali</button>
                <button type="submit" id="btnSubmitForm" class="btn btn-success text-white rounded-pill px-4" disabled><i class="fa fa-save"></i>&nbsp;Simpan dan Lanjutkan Pendaftaran</button>
              </div>
            </div>
          </div>
        </div> <!-- Close Step 4 -->

        <?php echo form_close(); ?>

        <script>
          function Ayah() {
            document.getElementById("myDIV").style.display = "none"; // Karena sama dengan Ayah
            document.getElementsByName("nama_wali")[0].removeAttribute("required");
            document.getElementsByName("alamat_wali")[0].removeAttribute("required");
            document.getElementsByName("telepon_wali")[0].removeAttribute("required");
            updateParentAlamat('wali');
          }

          function Ibu() {
            document.getElementById("myDIV").style.display = "none"; // Karena sama dengan Ibu
            document.getElementsByName("nama_wali")[0].removeAttribute("required");
            document.getElementsByName("alamat_wali")[0].removeAttribute("required");
            document.getElementsByName("telepon_wali")[0].removeAttribute("required");
            updateParentAlamat('wali');
          }

          function Berbeda() {
            document.getElementById("myDIV").style.display = "block"; // Karena berbeda, harus isi form
            document.getElementsByName("nama_wali")[0].setAttribute("required", "required");
            document.getElementsByName("alamat_wali")[0].setAttribute("required", "required");
            document.getElementsByName("telepon_wali")[0].setAttribute("required", "required");
            updateParentAlamat('wali');
          }
          
          // Initial dynamic validation on page load
          window.addEventListener('DOMContentLoaded', (event) => {
            const checkedRadio = document.querySelector('input[name="identitas_wali"]:checked');
            if (checkedRadio) {
              if (checkedRadio.value === 'Ayah') Ayah();
              else if (checkedRadio.value === 'Ibu') Ibu();
              else if (checkedRadio.value === 'Berbeda') Berbeda();
            }
          });
        </script>
<script>
function checkSeragam(val) {
  if(val == 'Lainnya') {
    document.getElementById('ukuran_seragam_lainnya').style.display = 'block';
  } else {
    document.getElementById('ukuran_seragam_lainnya').style.display = 'none';
  }
}

function copyDropdownOptions(srcSelector, destSelector) {
    var $src = $(srcSelector);
    var $dest = $(destSelector);
    $dest.empty();
    $src.find('option').each(function() {
        var $opt = $(this).clone();
        $dest.append($opt);
    });
    $dest.val($src.val()).trigger('change.select2');
}

function updateParentAlamat(type) {
    var isChecked = $('#sama_alamat_' + type).is(':checked');
    if (isChecked) {
        $('[name="alamat_' + type + '"]').val($('[name="alamat"]').val()).attr('readonly', true).removeAttr('required');
        $('[name="rt_' + type + '"]').val($('[name="rt"]').val()).attr('readonly', true).removeAttr('required');
        $('[name="rw_' + type + '"]').val($('[name="rw"]').val()).attr('readonly', true).removeAttr('required');
        $('[name="kode_pos_' + type + '"]').val($('[name="kode_pos"]').val()).attr('readonly', true);
        
        copyDropdownOptions('#provinsi', '#provinsi_' + type);
        copyDropdownOptions('#kabupaten', '#kabupaten_' + type);
        copyDropdownOptions('#kecamatan', '#kecamatan_' + type);
        copyDropdownOptions('#kelurahan', '#kelurahan_' + type);
        
        $('#provinsi_' + type + ', #kabupaten_' + type + ', #kecamatan_' + type + ', #kelurahan_' + type)
            .removeAttr('required')
            .next('.select2-container').css({'pointer-events': 'none', 'opacity': '0.7'});
    } else {
        var isRequired = true;
        if (type === 'wali') {
            var identitas = $('input[name="identitas_wali"]:checked').val();
            if (identitas === 'Ayah' || identitas === 'Ibu') {
                isRequired = false;
            }
        }
        
        if (isRequired) {
            $('[name="alamat_' + type + '"]').attr('readonly', false).attr('required', 'required');
            $('[name="rt_' + type + '"]').attr('readonly', false).attr('required', 'required');
            $('[name="rw_' + type + '"]').attr('readonly', false).attr('required', 'required');
            $('#provinsi_' + type + ', #kabupaten_' + type + ', #kecamatan_' + type + ', #kelurahan_' + type).attr('required', 'required');
        } else {
            $('[name="alamat_' + type + '"]').attr('readonly', false).removeAttr('required');
            $('[name="rt_' + type + '"]').attr('readonly', false).removeAttr('required');
            $('[name="rw_' + type + '"]').attr('readonly', false).removeAttr('required');
            $('#provinsi_' + type + ', #kabupaten_' + type + ', #kecamatan_' + type + ', #kelurahan_' + type).removeAttr('required');
        }
        $('[name="kode_pos_' + type + '"]').attr('readonly', false);
        
        $('#provinsi_' + type + ', #kabupaten_' + type + ', #kecamatan_' + type + ', #kelurahan_' + type)
            .next('.select2-container').css({'pointer-events': 'auto', 'opacity': '1'});
    }
}

function initRegionDropdowns(suffix, preselected) {
    var baseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';
    var $prov = $('#provinsi' + suffix);
    var $kab = $('#kabupaten' + suffix);
    var $kec = $('#kecamatan' + suffix);
    var $kel = $('#kelurahan' + suffix);
    var $kodepos = $('#kode_pos' + suffix);

    // Fetch Provinces
    $.getJSON(baseUrl + '/provinces.json', function(provinces) {
        $prov.empty().append('<option value="">Pilih Provinsi</option>');
        $.each(provinces, function(i, item) {
            $prov.append($('<option>', {
                value: item.name,
                text: item.name,
                'data-id': item.id
            }));
        });
        $prov.trigger('change');
        if (preselected.provinsi) {
            $prov.find('option').each(function() {
                if ($(this).val().toUpperCase() === preselected.provinsi.toUpperCase()) {
                    $prov.val($(this).val()).trigger('change');
                    return false;
                }
            });
        }
    });

    // Province -> Regency
    $prov.on('change', function() {
        if ($('#sama_alamat' + suffix).is(':checked')) return;
        var provId = $(this).find(':selected').data('id');
        $kab.empty().append('<option value="">Pilih Kabupaten / Kota</option>').trigger('change');
        $kec.empty().append('<option value="">Pilih Kecamatan</option>').trigger('change');
        if (!provId) return;

        $.getJSON(baseUrl + '/regencies/' + provId + '.json', function(regencies) {
            $.each(regencies, function(i, item) {
                $kab.append($('<option>', {
                    value: item.name,
                    text: item.name,
                    'data-id': item.id
                }));
            });
            $kab.trigger('change');
            if (preselected.kabupaten) {
                $kab.find('option').each(function() {
                    if ($(this).val().toUpperCase() === preselected.kabupaten.toUpperCase()) {
                        $kab.val($(this).val()).trigger('change');
                        return false;
                    }
                });
                preselected.kabupaten = '';
            }
        });
    });

    // Regency -> District
    $kab.on('change', function() {
        if ($('#sama_alamat' + suffix).is(':checked')) return;
        var kabId = $(this).find(':selected').data('id');
        $kec.empty().append('<option value="">Pilih Kecamatan</option>').trigger('change');
        $kel.empty().append('<option value="">Pilih Kelurahan / Desa</option>').trigger('change');
        if (!kabId) return;

        $.getJSON(baseUrl + '/districts/' + kabId + '.json', function(districts) {
            $.each(districts, function(i, item) {
                $kec.append($('<option>', {
                    value: item.name,
                    text: item.name,
                    'data-id': item.id
                }));
            });
            $kec.trigger('change');
            if (preselected.kecamatan) {
                $kec.find('option').each(function() {
                    if ($(this).val().toUpperCase() === preselected.kecamatan.toUpperCase()) {
                        $kec.val($(this).val()).trigger('change');
                        return false;
                    }
                });
                preselected.kecamatan = '';
            }
        });
    });

    // District -> Village
    $kec.on('change', function() {
        if ($('#sama_alamat' + suffix).is(':checked')) return;
        var kecId = $(this).find(':selected').data('id');
        $kel.empty().append('<option value="">Pilih Kelurahan / Desa</option>').trigger('change');
        if (!kecId) return;

        $.getJSON(baseUrl + '/villages/' + kecId + '.json', function(villages) {
            $.each(villages, function(i, item) {
                $kel.append($('<option>', {
                    value: item.name,
                    text: item.name,
                    'data-id': item.id
                }));
            });
            $kel.trigger('change');
            if (preselected.kelurahan) {
                $kel.find('option').each(function() {
                    if ($(this).val().toUpperCase() === preselected.kelurahan.toUpperCase()) {
                        $kel.val($(this).val()).trigger('change');
                        return false;
                    }
                });
                preselected.kelurahan = '';
            }
        });
    });

    // Village -> Kode Pos
    $kel.on('change', function() {
        if ($('#sama_alamat' + suffix).is(':checked')) return;
        var kelName = $(this).val();
        if (!kelName) return;
        $.getJSON('https://kodepos.vercel.app/search/?q=' + encodeURIComponent(kelName), function(data) {
            if (data && data.data && data.data.length > 0) {
                $kodepos.val(data.data[0].code);
            }
        });
    });
}

function checkInitMatching(type) {
    var match = true;
    var fields = ['alamat', 'rt', 'rw', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'kode_pos'];
    fields.forEach(function(f) {
        var sVal = $('[name="' + f + '"]').val() || '';
        var pVal = $('[name="' + f + '_' + type + '"]').val() || '';
        if (sVal.trim().toUpperCase() !== pVal.trim().toUpperCase()) {
            match = false;
        }
    });
    var allEmpty = true;
    fields.forEach(function(f) {
        if (($('[name="' + f + '"]').val() || '').trim() !== '') {
            allEmpty = false;
        }
    });
    if (match && !allEmpty) {
        $('#sama_alamat_' + type).prop('checked', true);
        updateParentAlamat(type);
    }
}

$(document).ready(function() {
    $(document).on('select2:open', function(e) {
        setTimeout(function() {
            var searchField = document.querySelector('.select2-container--open .select2-search__field');
            if (searchField) {
                searchField.focus();
            }
        }, 50);
    });

    $('#sama_alamat_ayah').on('change', function() { updateParentAlamat('ayah'); });
    $('#sama_alamat_ibu').on('change', function() { updateParentAlamat('ibu'); });
    $('#sama_alamat_wali').on('change', function() { updateParentAlamat('wali'); });
    
    $('textarea[name="alamat"], [name="rt"], [name="rw"], #provinsi, #kabupaten, #kecamatan, #kelurahan, #kode_pos').on('input change', function() {
        updateParentAlamat('ayah');
        updateParentAlamat('ibu');
        updateParentAlamat('wali');
    });

    var preselectedProv = "<?php echo isset($siswa) ? esc($siswa->provinsi) : (set_value('provinsi') ?: ''); ?>".trim();
    var preselectedKab = "<?php echo isset($siswa) ? esc($siswa->kabupaten) : (set_value('kabupaten') ?: ''); ?>".trim();
    var preselectedKec = "<?php echo isset($siswa) ? esc($siswa->kecamatan) : (set_value('kecamatan') ?: ''); ?>".trim();
    var preselectedKel = "<?php echo isset($siswa) ? esc($siswa->kelurahan) : (set_value('kelurahan') ?: ''); ?>".trim();

    initRegionDropdowns('', {
        provinsi: preselectedProv,
        kabupaten: preselectedKab,
        kecamatan: preselectedKec,
        kelurahan: preselectedKel
    });

    var preselectedProvAyah = "<?php echo isset($siswa) ? esc($siswa->provinsi_ayah) : (set_value('provinsi_ayah') ?: ''); ?>".trim();
    var preselectedKabAyah = "<?php echo isset($siswa) ? esc($siswa->kabupaten_ayah) : (set_value('kabupaten_ayah') ?: ''); ?>".trim();
    var preselectedKecAyah = "<?php echo isset($siswa) ? esc($siswa->kecamatan_ayah) : (set_value('kecamatan_ayah') ?: ''); ?>".trim();
    var preselectedKelAyah = "<?php echo isset($siswa) ? esc($siswa->kelurahan_ayah) : (set_value('kelurahan_ayah') ?: ''); ?>".trim();

    initRegionDropdowns('_ayah', {
        provinsi: preselectedProvAyah,
        kabupaten: preselectedKabAyah,
        kecamatan: preselectedKecAyah,
        kelurahan: preselectedKelAyah
    });

    var preselectedProvIbu = "<?php echo isset($siswa) ? esc($siswa->provinsi_ibu) : (set_value('provinsi_ibu') ?: ''); ?>".trim();
    var preselectedKabIbu = "<?php echo isset($siswa) ? esc($siswa->kabupaten_ibu) : (set_value('kabupaten_ibu') ?: ''); ?>".trim();
    var preselectedKecIbu = "<?php echo isset($siswa) ? esc($siswa->kecamatan_ibu) : (set_value('kecamatan_ibu') ?: ''); ?>".trim();
    var preselectedKelIbu = "<?php echo isset($siswa) ? esc($siswa->kelurahan_ibu) : (set_value('kelurahan_ibu') ?: ''); ?>".trim();

    initRegionDropdowns('_ibu', {
        provinsi: preselectedProvIbu,
        kabupaten: preselectedKabIbu,
        kecamatan: preselectedKecIbu,
        kelurahan: preselectedKelIbu
    });

    var preselectedProvWali = "<?php echo isset($siswa) ? esc($siswa->provinsi_wali) : (set_value('provinsi_wali') ?: ''); ?>".trim();
    var preselectedKabWali = "<?php echo isset($siswa) ? esc($siswa->kabupaten_wali) : (set_value('kabupaten_wali') ?: ''); ?>".trim();
    var preselectedKecWali = "<?php echo isset($siswa) ? esc($siswa->kecamatan_wali) : (set_value('kecamatan_wali') ?: ''); ?>".trim();
    var preselectedKelWali = "<?php echo isset($siswa) ? esc($siswa->kelurahan_wali) : (set_value('kelurahan_wali') ?: ''); ?>".trim();

    initRegionDropdowns('_wali', {
        provinsi: preselectedProvWali,
        kabupaten: preselectedKabWali,
        kecamatan: preselectedKecWali,
        kelurahan: preselectedKelWali
    });

    setTimeout(function() {
        checkInitMatching('ayah');
        checkInitMatching('ibu');
        checkInitMatching('wali');
    }, 1500);
});
</script>

<!-- Wizard Step Navigation Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    var currentStep = 1;
    var totalSteps = 4;

    function showStep(step) {
        // Hide all steps
        document.querySelectorAll('.step-container').forEach(function(el) {
            el.style.display = 'none';
        });
        // Show current step
        document.getElementById('step-' + step).style.display = 'block';

        // Update progress indicators
        document.querySelectorAll('.step-indicator').forEach(function(indicator) {
            var indicatorStep = parseInt(indicator.getAttribute('data-step'));
            var circle = indicator.querySelector('.rounded-circle');
            var text = indicator.querySelector('span');
            
            if (indicatorStep === step) {
                indicator.classList.add('active');
                circle.className = 'rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm border border-white';
                text.className = 'text-success font-weight-bold';
            } else if (indicatorStep < step) {
                indicator.classList.remove('active');
                circle.className = 'rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm border border-white';
                text.className = 'text-success';
            } else {
                indicator.classList.remove('active');
                circle.className = 'rounded-circle bg-white text-secondary border d-flex align-items-center justify-content-center mx-auto mb-2';
                text.className = 'text-muted';
            }
        });

        // Update progress bar width
        var progressPercent = ((step - 1) / (totalSteps - 1)) * 100;
        var progressBar = document.getElementById('stepProgressBar');
        if (progressBar) {
            progressBar.style.width = progressPercent + '%';
        }

        // Fill review summary at Step 4
        if (step === 4) {
            var namaVal = document.getElementsByName('nama_siswa')[0] ? document.getElementsByName('nama_siswa')[0].value : '';
            var nisnVal = document.getElementsByName('nisn')[0] ? document.getElementsByName('nisn')[0].value : '';
            var telpVal = document.getElementsByName('telepon')[0] ? document.getElementsByName('telepon')[0].value : '';
            var AlamatVal = document.getElementsByName('alamat')[0] ? document.getElementsByName('alamat')[0].value : '';
            var ayahVal = document.getElementsByName('nama_ayah')[0] ? document.getElementsByName('nama_ayah')[0].value : '';
            var ibuVal = document.getElementsByName('nama_ibu')[0] ? document.getElementsByName('nama_ibu')[0].value : '';

            document.getElementById('summary-nama').innerText = namaVal || '-';
            document.getElementById('summary-nisn').innerText = nisnVal || '-';
            document.getElementById('summary-telepon').innerText = telpVal || '-';
            document.getElementById('summary-alamat').innerText = AlamatVal || '-';
            document.getElementById('summary-ayah').innerText = ayahVal || '-';
            document.getElementById('summary-ibu').innerText = ibuVal || '-';
        }

        // Scroll to top of card/page
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    window.nextStep = function() {
        if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        }
    };

    window.prevStep = function() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    };

    function validateStep(step) {
        var valid = true;
        var container = document.getElementById('step-' + step);
        var inputs = container.querySelectorAll('input[required], select[required], textarea[required]');
        for (var i = 0; i < inputs.length; i++) {
            var input = inputs[i];
            
            // Skip validation if the input is disabled
            if (input.disabled) continue;

            // Skip validation if the input is hidden (not visible to user)
            var isHidden = false;
            if (input.classList.contains('select2-hidden-accessible')) {
                var select2Container = $(input).next('.select2-container');
                if (select2Container.length > 0 && select2Container.is(':hidden')) {
                    isHidden = true;
                }
            } else {
                isHidden = $(input).is(':hidden') || (input.offsetWidth === 0 && input.offsetHeight === 0);
            }
            if (isHidden) continue;

            // Special handling for Select2
            if (input.classList.contains('select2-hidden-accessible')) {
                if (!input.value) {
                    valid = false;
                    $(input).select2('open');
                    
                    // Highlight Select2 border in red
                    var select2Container = $(input).next('.select2-container');
                    select2Container.css('border', '1px solid #dc3545');
                    setTimeout(function() {
                        select2Container.css('border', '');
                    }, 3000);
                    break;
                }
            } else {
                // Regular inputs
                if (!input.checkValidity()) {
                    input.reportValidity();
                    valid = false;
                    break;
                }
            }
        }
        return valid;
    }

    // Agree checkbox handler
    var checkAgree = document.getElementById('checkAgree');
    var btnSubmit = document.getElementById('btnSubmitForm');
    if (checkAgree && btnSubmit) {
        checkAgree.addEventListener('change', function() {
            btnSubmit.disabled = !this.checked;
        });
    }

    // Initialize step 1
    showStep(currentStep);
});
</script>
