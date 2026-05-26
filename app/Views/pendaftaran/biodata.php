
<!-- /section -->
<section class="wrapper bg-light">
  <div class="container pb-14 pb-md-16">
    <div class="row">
       <div class="col-lg-10 col-xl-10 col-xxl-10 mx-auto mt-n20">
        <div class="card">
          <div class="card-body p-5">

              <p class="lead mb-2 text-center">Halo <strong class="text-danger"><?php echo Session()->get('nama') ?></strong>, masukkan data Calon Siswa dengan benar dan lengkap.
                <br>Anda sedang mendaftar pada <strong><?php echo $gelombang->judul ?></strong> Tahun Ajaran <strong><?php echo $gelombang->tahun_ajaran ?></strong>.
              </p>

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
              <label class="col-md-3 text-dark">NIS dan NISN</label>
              <div class="col-md-4">
                <input type="text" name="nis" class="form-control" placeholder="Nomor Induk Siswa (NIS)" value="<?php echo set_value('nis') ?>">
                <small class="text-warning">Nomor Induk Siswa (NIS) atau kosongkan</small>
              </div>
              <div class="col-md-5">
                <input type="text" name="nisn" class="form-control" placeholder="Nomor Induk Siswa Nasional (NISN)" value="<?php echo set_value('nisn') ?>">
                <small class="text-warning">Nomor Induk Siswa Nasional (NISN) atau kosongkan</small>
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


            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Alamat<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <textarea name="alamat" placeholder="Alamat" class="form-control" required><?php echo set_value('alamat') ?></textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kode Pos</label>
              <div class="col-md-9">
                <input type="text" name="kode_pos" class="form-control" placeholder="Kode Pos" value="<?php echo set_value('kode_pos') ?>">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Telepon dan Email</label>
              <div class="col-md-4">
                <input type="text" name="telepon" class="form-control" placeholder="Telepon/HP" value="<?php echo set_value('telepon') ?>">
                <small class="text-warning">Telepon/HP</small>
              </div>
              <div class="col-md-5">
                <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo set_value('email') ?>" required>
                <small class="text-warning">Email (Username)</small>
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
            DATA PENERIMAAN DI SEKOLAH
          </div>
          <div class="card-body">

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Jenis Masuk Siswa<span class="text-danger">*</span></label>
              <div class="col-md-9">

                <!-- radio -->
                <div class="form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_siswa" value="Langsung"<?php if(set_value('jenis_siswa')=='Tidak') { echo 'checked'; }else{ echo 'checked'; } ?>>
                    <label class="form-check-label">Langsung</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_siswa" value="Pindahan" <?php if(set_value('jenis_siswa')=='Pindahan') { echo 'checked'; } ?>>
                    <label class="form-check-label">Pindahan</label>
                  </div>
                </div>

                
              </div>
            </div>

           

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Nama Sekolah Asal</label>
              <div class="col-md-9">
                <input type="text" name="asal_sekolah" class="form-control" placeholder="Nama Sekolah Asal" value="<?php echo set_value('asal_sekolah') ?>">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Alamat Sekolah Asal</label>
              <div class="col-md-9">
                <textarea name="alamat_sekolah_asal" class="form-control" placeholder="Alamat Sekolah Asal"><?php echo set_value('alamat_sekolah_asal') ?></textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tanggal Pindah (Sesuai Surat Pindah)</label>
              <div class="col-md-9">
                <input type="text" name="tanggal_pindah" class="form-control tanggal" placeholder="Tanggal pindah" value="<?php echo set_value('tanggal_pindah') ?>">
                <small class="text-secondary">Tanggal pindah (Jika siswa pindahan). Format: dd-mm-yyyy</small>
              </div>
            </div>

          </div>
          
        </div>

        <!-- data dasar siswa -->
        <div class="card mb-2">
          <div class="card-header bg-dark text-white mb-2">
            DATA KESEHATAN DAN INFORMASI SISWA LAINNYA
          </div>
          <div class="card-body">

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Golongan Darah Siswa</label>
              <div class="col-md-9">
                <select name="goldar_siswa" class="form-control  form-select" required>
                  <option value="">Pilih Golongan Darah</option>
                  <option value="A" <?php if(set_value('goldar_siswa')=='A') { echo 'selected'; } ?>>A</option>
                  <option value="B" <?php if(set_value('goldar_siswa')=='B') { echo 'selected'; } ?>>B</option>
                  <option value="AB" <?php if(set_value('goldar_siswa')=='AB') { echo 'selected'; } ?>>AB</option>
                  <option value="O" <?php if(set_value('goldar_siswa')=='O') { echo 'selected'; } ?>>O</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tinggi dan Berat Badan Siswa<span class="text-danger">*</span></label>
              <div class="col-md-4">
                <input type="number" name="tinggi" class="form-control" placeholder="Tinggi Badan" value="<?php echo set_value('tinggi') ?>" required>
                <small class="text-secondary">Tinggi Badan dalam Centimeter</small>
              </div>
              <div class="col-md-5">
                <input type="number" name="berat" class="form-control" placeholder="Berat Badan" value="<?php echo set_value('berat') ?>" required>
                <small class="text-secondary">Berat Badan dalam Kilogram</small>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Penyakit yang pernah/sedang diderita Siswa</label>
              <div class="col-md-9">
                <textarea name="penyakit_siswa" class="form-control" placeholder="Penyakit yang pernah/sedang diderita Siswa"><?php echo set_value('penyakit_siswa') ?></textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Hobi Siswa</label>
              <div class="col-md-9">
                <textarea name="hobi_siswa" class="form-control" placeholder="Hobi siswa"><?php echo set_value('hobi_siswa') ?></textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Apakah Siswa Berkebutuhan Khusus?<span class="text-danger">*</span></label>
              <div class="col-md-9">
                  <!-- radio -->
                  <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="berkebutuhan_khusus" value="Tidak"<?php if(set_value('berkebutuhan_khusus')=='Tidak') { echo 'checked'; }else{ echo 'checked'; } ?>>
                      <label class="form-check-label">Tidak</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="berkebutuhan_khusus" value="Ya" <?php if(set_value('berkebutuhan_khusus')=='Ya') { echo 'checked'; } ?>>
                      <label class="form-check-label">Ya</label>
                    </div>
                  </div>
                
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Deskripsi Ringkas Tentang Siswa</label>
              <div class="col-md-9">
                <textarea name="isi" class="form-control" placeholder="Deskripsi Ringkas Tentang Siswa"><?php echo set_value('isi') ?></textarea>
                <small class="text-secondary">Misal: Siswa ini berkebutuhan khusus</small>
              </div>
            </div>

          </div>
         
        </div>

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
                <small class="text-warning">Nama ayah</small>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Agama Ayah</label>
              <div class="col-md-9">
                <?php $agama = $m_agama->listing(); ?>
                <select name="id_agama_ayah" class="form-control  form-select">
                  <option value="">Pilih Agama</option>
                  <?php foreach($agama as $agama) { ?>
                    <option value="<?php echo $agama->id_agama ?>" <?php if(set_value('id_agama_ayah')==$agama->id_agama) { echo 'selected'; } ?>>
                      <?php echo $agama->nama_agama ?>
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
                  <?php foreach($pekerjaan as $pekerjaan) { ?>
                    <option value="<?php echo $pekerjaan->id_pekerjaan ?>" <?php if(set_value('id_pekerjaan_ayah')==$pekerjaan->id_pekerjaan) { echo 'selected'; } ?>>
                      <?php echo $pekerjaan->nama_pekerjaan ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Pendidikan Ayah</label>
              <div class="col-md-9">
                <?php $jenjang = $m_jenjang->listing(); ?>
                <select name="id_jenjang_ayah" class="form-control  form-select">
                  <option value="">Pilih Program Pendidikan</option>
                  <?php foreach($jenjang as $jenjang) { ?>
                    <option value="<?php echo $jenjang->id_jenjang ?>" <?php if(set_value('id_jenjang_ayah')==$jenjang->id_jenjang) { echo 'selected'; } ?>>
                      <?php echo $jenjang->nama_jenjang ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Alamat Ayah<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <textarea name="alamat_ayah" placeholder="Alamat Ayah" class="form-control"><?php echo set_value('alamat_ayah') ?></textarea>
              </div>
            </div>


            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Telepon/HP Ayah</label>
              <div class="col-md-9">
                <input type="text" name="telepon_ayah" class="form-control" placeholder="Telepon/HP Ayah" value="<?php echo set_value('telepon_ayah') ?>">
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
                <small class="text-warning">Nama ibu</small>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Agama Ibu</label>
              <div class="col-md-9">
                <?php $agama = $m_agama->listing(); ?>
                <select name="id_agama_ibu" class="form-control  form-select">
                  <option value="">Pilih Agama</option>
                  <?php foreach($agama as $agama) { ?>
                    <option value="<?php echo $agama->id_agama ?>" <?php if(set_value('id_agama_ibu')==$agama->id_agama) { echo 'selected'; } ?>>
                      <?php echo $agama->nama_agama ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Pekerjaan Ibu<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <?php $pekerjaan = $m_pekerjaan->listing(); ?>
                <select name="id_pekerjaan_ibu" class="form-control  form-select" required>
                  <option value="">Pilih Pekerjaan</option>
                  <?php foreach($pekerjaan as $pekerjaan) { ?>
                    <option value="<?php echo $pekerjaan->id_pekerjaan ?>" <?php if(set_value('id_pekerjaan_ibu')==$pekerjaan->id_pekerjaan) { echo 'selected'; } ?>>
                      <?php echo $pekerjaan->nama_pekerjaan ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Pendidikan Ibu</label>
              <div class="col-md-9">
                <?php $jenjang = $m_jenjang->listing(); ?>
                <select name="id_jenjang_ibu" class="form-control  form-select">
                  <option value="">Pilih Program Pendidikan</option>
                  <?php foreach($jenjang as $jenjang) { ?>
                    <option value="<?php echo $jenjang->id_jenjang ?>" <?php if(set_value('id_jenjang_ibu')==$jenjang->id_jenjang) { echo 'selected'; } ?>>
                      <?php echo $jenjang->nama_jenjang ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Alamat Ibu<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <textarea name="alamat_ibu" placeholder="Alamat Ibu" class="form-control"><?php echo set_value('alamat_ibu') ?></textarea>
              </div>
            </div>


            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Telepon/HP Ibu</label>
              <div class="col-md-9">
                <input type="text" name="telepon_ibu" class="form-control" placeholder="Telepon/HP Ibu" value="<?php echo set_value('telepon_ibu') ?>" >
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

                <!-- radio -->
                <div class="form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="identitas_wali" value="Ayah"  onclick="Ayah()" <?php if(set_value('identitas_wali')=='Ayah') { echo 'checked'; } ?> required>
                    <label class="form-check-label">Sama dengan Ayah</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="identitas_wali" value="Ibu" onclick="Ibu()" <?php if(set_value('identitas_wali')=='Ibu') { echo 'checked'; } ?> required>
                    <label class="form-check-label">Sama dengan Ibu</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="identitas_wali" value="Berbeda" <?php if(set_value('identitas_wali')=='Berbeda') { echo 'checked'; } ?> required>
                    <label class="form-check-label">Berbeda dengan Ayah dan Ibu</label>
                  </div>
                </div>

                

                
              </div>
            </div>

            <div id="myDIV">

              <div class="form-group row mb-3">
                <label class="col-md-3 text-dark">Nama Wali<span class="text-danger">*</span></label>
                <div class="col-md-9">
                  <input type="text" name="nama_wali" class="form-control" placeholder="Nama Wali" value="<?php echo set_value('nama_wali') ?>">
                  <small class="text-warning">Nama wali</small>
                </div>
              </div>

              <div class="form-group row mb-3">
                <label class="col-md-3 text-dark">Agama Wali</label>
                <div class="col-md-9">
                  <?php $agama = $m_agama->listing(); ?>
                  <select name="id_agama_wali" class="form-control form-select">
                    <option value="">Pilih Agama</option>
                    <?php foreach($agama as $agama) { ?>
                      <option value="<?php echo $agama->id_agama ?>" <?php if(set_value('id_agama_wali')==$agama->id_agama) { echo 'selected'; } ?>>
                        <?php echo $agama->nama_agama ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group row mb-3">
                <label class="col-md-3 text-dark">Pekerjaan Wali</label>
                <div class="col-md-9">
                  <?php $pekerjaan = $m_pekerjaan->listing(); ?>
                  <select name="id_pekerjaan_wali" class="form-control form-select">
                    <option value="">Pilih Pekerjaan</option>
                    <?php foreach($pekerjaan as $pekerjaan) { ?>
                      <option value="<?php echo $pekerjaan->id_pekerjaan ?>" <?php if(set_value('id_pekerjaan_wali')==$pekerjaan->id_pekerjaan) { echo 'selected'; } ?>>
                        <?php echo $pekerjaan->nama_pekerjaan ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group row mb-3">
                <label class="col-md-3 text-dark">Pendidikan Wali</label>
                <div class="col-md-9">
                  <?php $jenjang = $m_jenjang->listing(); ?>
                  <select name="id_jenjang_wali" class="form-control form-select">
                    <option value="">Pilih Program Pendidikan</option>
                    <?php foreach($jenjang as $jenjang) { ?>
                      <option value="<?php echo $jenjang->id_jenjang ?>"  <?php if(set_value('id_jenjang_wali')==$jenjang->id_jenjang) { echo 'selected'; } ?>>
                        <?php echo $jenjang->nama_jenjang ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group row mb-3">
                <label class="col-md-3 text-dark">Alamat Wali<span class="text-danger">*</span></label>
                <div class="col-md-9">
                  <textarea name="alamat_wali" placeholder="Alamat Wali" class="form-control"><?php echo set_value('alamat_wali') ?></textarea>
                </div>
              </div>


              <div class="form-group row mb-3">
                <label class="col-md-3 text-dark">Telepon/HP Wali<span class="text-danger">*</span></label>
                <div class="col-md-9">
                  <input type="text" name="telepon_wali" class="form-control" placeholder="Telepon/HP Wali" value="<?php echo set_value('telepon_wali') ?>" required>
                </div>
              </div>
            </div>

          </div>
          <div class="card-footer bg-light text-right border-top">
            <div class="form-group row mb-3">
                <label class="col-md-3 text-dark"></label>
                <div class="col-md-9">
                  <button type="submit" class="btn btn-success text-white"><i class="fa fa-save"></i>&nbsp;Simpan dan Lanjutkan Pendaftaran</button>
                </div>
              </div>
          </div>
        </div>

        <?php echo form_close(); ?>

        <script>
        function Ayah() {
          var x = document.getElementById("myDIV");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }

        function Ibu() {
          var x = document.getElementById("myDIV");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }

        function Berbeda() {
          var x = document.getElementById("myDIV");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }
        </script>