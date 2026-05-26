<p class="lead mb-2 text-center">Halo <strong class="text-danger"><?php echo Session()->get('nama_siswa') ?></strong>, masukkan data Calon Siswa dengan benar dan lengkap.</p>
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

        echo form_open_multipart(base_url('siswa/pendaftaran/edit/'.$siswa->slug_siswa));
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
              <label class="col-md-3 text-dark">Status Pendaftaran</label>
              <div class="col-md-9">
                <select name="status_pendaftaran" class="form-control" disabled>
                  <option value="Menunggu">Menunggu</option>
                  <option value="Diterima" <?php if(set_value('status_pendaftaran')=='Diterima' || $siswa->status_pendaftaran=='Diterima') { echo 'selected'; } ?>>Diterima</option>
                  <option value="Tidak-Diterima" <?php if(set_value('status_pendaftaran')=='Tidak-Diterima' || $siswa->status_pendaftaran=='Tidak-Diterima') { echo 'selected'; } ?>>Tidak Diterima</option>
                  <option value="Diperiksa" <?php if(set_value('status_pendaftaran')=='Diperiksa' || $siswa->status_pendaftaran=='Diperiksa') { echo 'selected'; } ?>>Diperiksa</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Program<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <?php $program_pendidikan   = $m_program_pendidikan->main(); ?>
                <select name="id_program_pendidikan" class="form-control  form-select" required>
                  <option value="">Pilih Program Pendidikan</option>
                  <?php foreach($program_pendidikan as $jp) { ?>
                    <?php if($jp->jenis_program_pendidikan == 'Program Pendidikan') { ?> 
                      <option value="<?php echo $jp->id_program_pendidikan ?>" 
                        <?php if(set_value('id_program_pendidikan')==$jp->id_program_pendidikan || $siswa->id_program_pendidikan == $jp->id_program_pendidikan) { echo 'selected'; } ?>>
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
                <input type="text" name="nama_siswa" class="form-control form-control-lg" placeholder="Nama lengkap siswa" value="<?php if(isset($_POST['submit'])) { echo set_value('nama_siswa'); }else{ echo $siswa->nama_siswa; } ?>" required>
                <small class="text-warning">Nama lengkap Siswa</small>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Nama Panggilan<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <input type="text" name="nama_panggilan" class="form-control" placeholder="Nama panggilan" value="<?php if(isset($_POST['submit'])) { echo set_value('nama_panggilan'); }else{ echo $siswa->nama_panggilan; } ?>" required>
                <small class="text-warning">Nama panggilan</small>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">NIS dan NISN</label>
              <div class="col-md-4">
                <input type="text" name="nis" class="form-control" placeholder="Nomor Induk Siswa (NIS)" value="<?php if(isset($_POST['submit'])) { echo set_value('nis'); }else{ echo $siswa->nis; } ?>">
                <small class="text-warning">Nomor Induk Siswa (NIS) atau kosongkan</small>
              </div>
              <div class="col-md-5">
                <input type="text" name="nisn" class="form-control" placeholder="Nomor Induk Siswa Nasional (NISN)" value="<?php if(isset($_POST['submit'])) { echo set_value('nisn'); }else{ echo $siswa->nisn; } ?>">
                <small class="text-warning">Nomor Induk Siswa Nasional (NISN) atau kosongkan</small>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Agama &amp; Status Kewarganegaraan<span class="text-danger">*</span></label>
              <div class="col-md-3">
                <?php $agama = $m_agama->listing(); ?>
                <select name="id_agama" class="form-control form-select" required>
                  <?php foreach($agama as $agama) { ?>
                    <option value="<?php echo $agama->id_agama ?>" <?php if(set_value('id_agama')==$agama->id_agama) { echo 'selected'; }elseif($agama->id_agama==$siswa->id_agama) { echo 'selected'; } ?>>
                      <?php echo $agama->nama_agama ?>
                    </option>
                  <?php } ?>
                </select>
                <small class="text-secondary">Agama Siswa</small>
              </div>
              <div class="col-md-3">
                <select name="status_wn" class="form-control form-select" required>
                  <option value="WNI">WNI</option>
                  <option value="WNA" <?php if(set_value('status_wn')=='WNA') { echo 'selected'; }elseif($siswa->status_wn=='WNA') { echo 'selected'; } ?>>WNA</option>
                </select>
              </div>
              <div class="col-md-3">
                <input type="text" name="negara_asal" class="form-control" value="<?php if(isset($_POST['submit'])) { echo set_value('negara_asal'); }else{ echo $siswa->negara_asal; } ?>" placeholder="Negara asal (jika WNA)">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Jenis Kelamin<span class="text-danger">*</span></label>
              <div class="col-md-9">
                  <select name="jenis_kelamin" class="form-control form-select" required>
                    <option value="">Jenis Kelamin</option>
                    <option value="L" <?php if(set_value('jenis_kelamin')=='L') { echo 'checked'; }elseif($siswa->jenis_kelamin=='L') { echo 'selected'; } ?>>Laki-laki</option>
                    <option value="P" <?php if(set_value('jenis_kelamin')=='P') { echo 'selected'; }elseif($siswa->jenis_kelamin=='P') { echo 'selected'; } ?>>Perempuan</option>
                  </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Status/Hubungan Anak dengan Wali<span class="text-danger">*</span></label>
              <div class="col-md-3">
                <?php $hubungan = $m_hubungan->listing(); ?>
                <select name="id_hubungan" class="form-control  form-select" required>
                  <?php foreach($hubungan as $hubungan) { ?>
                    <option value="<?php echo $hubungan->id_hubungan ?>" <?php if(set_value('id_hubungan')==$hubungan->id_hubungan || $siswa->id_hubungan == $hubungan->id_hubungan) { echo 'selected'; } ?>>
                      <?php echo $hubungan->nama_hubungan ?>
                    </option>
                  <?php } ?>
                </select>
                <small class="text-secondary">Status Anak</small>
              </div>
              <div class="col-md-3">
                <input type="number" name="anak_ke" class="form-control" placeholder="Anak nomor ke?" value="<?php if(isset($_POST['submit'])) { echo set_value('anak_ke'); }else{ echo $siswa->anak_ke; } ?>" required>
                <small class="text-secondary">Anak nomor ke</small>
              </div>
              <div class="col-md-3">
                <input type="number" name="jumlah_saudara" class="form-control" placeholder="Jumlah saudara" value="<?php if(isset($_POST['submit'])) { echo set_value('jumlah_saudara'); }else{ echo $siswa->jumlah_saudara; } ?>" required>
                <small class="text-secondary">Jumlah saudara</small>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tempat dan Tanggal Lahir<span class="text-danger">*</span></label>
              <div class="col-md-5">
                <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat lahir" value="<?php if(isset($_POST['submit'])) { echo set_value('tempat_lahir'); }else{ echo $siswa->tempat_lahir; } ?>" required>
                <small class="text-warning">Tempat lahir</small>
              </div>
              <div class="col-md-4">
                <input type="text" name="tanggal_lahir" class="form-control tanggal" placeholder="dd-mm-yyyy" value="<?php if(isset($_POST['submit'])) { echo set_value('tanggal_lahir'); }else{ echo $this->website->tanggal_id($siswa->tanggal_lahir); } ?>" required>
                <small class="text-warning">Tanggal lahir</small>
              </div>
            </div>


            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Alamat<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <textarea name="alamat" placeholder="Alamat" class="form-control" required><?php if(isset($_POST['submit'])) { echo set_value('alamat'); }else{ echo $siswa->alamat; } ?></textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kode Pos</label>
              <div class="col-md-9">
                <input type="text" name="kode_pos" class="form-control" placeholder="Kode Pos" value="<?php if(isset($_POST['submit'])) { echo set_value('kode_pos'); }else{ echo $siswa->kode_pos; } ?>">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Telepon dan Email<span class="text-danger">*</span></label>
              <div class="col-md-4">
                <input type="text" name="telepon" class="form-control" placeholder="Telepon/HP" value="<?php if(isset($_POST['submit'])) { echo set_value('telepon'); }else{ echo $siswa->telepon; } ?>" >
                <small class="text-warning">Telepon/HP</small>
              </div>
              <div class="col-md-5">
                <input type="email" name="email" class="form-control" placeholder="Email" value="<?php if(isset($_POST['submit'])) { echo set_value('email'); }else{ echo $siswa->email; } ?>" required>
                <small class="text-warning">Email (Username)</small>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Ukuran Seragam</label>
              <div class="col-md-9">
                <select name="ukuran_seragam" class="form-control form-select" onchange="checkSeragam(this.value)">
                    
                    <option value="">Pilih Ukuran Seragam</option>
                    <option value="M" <?php if(set_value('ukuran_seragam')=='M' || $siswa->ukuran_seragam == 'M') { echo 'selected'; } ?>>M</option>
                    <option value="L" <?php if(set_value('ukuran_seragam')=='L' || $siswa->ukuran_seragam == 'L') { echo 'selected'; } ?>>L</option>
                    <option value="XL" <?php if(set_value('ukuran_seragam')=='XL' || $siswa->ukuran_seragam == 'XL') { echo 'selected'; } ?>>XL</option>
                    <option value="Lainnya" <?php if(set_value('ukuran_seragam')=='Lainnya' || (!in_array($siswa->ukuran_seragam, ['M','L','XL','']) && $siswa->ukuran_seragam != null)) { echo 'selected'; } ?>>Lainnya</option>
        
                </select>
                
                <input type="text" name="ukuran_seragam_lainnya" id="ukuran_seragam_lainnya" class="form-control mt-2" placeholder="Ketik ukuran manual..." value="<?php echo (!in_array($siswa->ukuran_seragam, ['M','L','XL',''])) ? $siswa->ukuran_seragam : ''; ?>" style="display: <?php echo (!in_array($siswa->ukuran_seragam, ['M','L','XL','']) && $siswa->ukuran_seragam != null) ? 'block' : 'none'; ?>;">
        
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Gambar/Foto</label>
              
              <div class="col-md-9">
                <input type="file" name="gambar" class="form-control" placeholder="Gambar/Foto" value="<?php if(isset($_POST['submit'])) { echo set_value('gambar'); }else{ echo $siswa->gambar; } ?>">
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
                <input type="text" name="asal_sekolah" class="form-control" placeholder="Nama Sekolah Asal (Tamatan Dari)" value="<?php if(isset($_POST['submit'])) { echo set_value('asal_sekolah'); }else{ echo $siswa->asal_sekolah; } ?>">
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
                <input type="text" name="nama_ayah" class="form-control" placeholder="Nama Ayah" value="<?php if(isset($_POST['submit'])) { echo set_value('nama_ayah'); }else{ echo $siswa->nama_ayah; } ?>" required>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Agama Ayah</label>
              <div class="col-md-9">
                <?php $agama = $m_agama->listing(); ?>
                <select name="id_agama_ayah" class="form-control form-select">
                  <option value="">Pilih Agama</option>
                  <?php foreach($agama as $ag) { ?>
                    <option value="<?php echo $ag->id_agama ?>" <?php if(set_value('id_agama_ayah')==$ag->id_agama || $siswa->id_agama_ayah == $ag->id_agama) { echo 'selected'; } ?>>
                      <?php echo $ag->nama_agama ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tempat & Tanggal Lahir Ayah</label>
              <div class="col-md-5">
                <input type="text" name="tempat_lahir_ayah" class="form-control" placeholder="Tempat lahir ayah" value="<?php if(isset($_POST['submit'])) { echo set_value('tempat_lahir_ayah'); }else{ echo $siswa->tempat_lahir_ayah; } ?>">
              </div>
              <div class="col-md-4">
                <input type="text" name="tanggal_lahir_ayah" class="form-control tanggal" placeholder="dd-mm-yyyy" value="<?php if(isset($_POST['submit'])) { echo set_value('tanggal_lahir_ayah'); }else{ echo $siswa->tanggal_lahir_ayah; } ?>">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kewarganegaraan Ayah</label>
              <div class="col-md-9">
                <select name="status_wn_ayah" class="form-control form-select">
                  <option value="WNI" <?php if(set_value('status_wn_ayah')=='WNI' || $siswa->status_wn_ayah == 'WNI') { echo 'selected'; } ?>>WNI</option>
                  <option value="WNA" <?php if(set_value('status_wn_ayah')=='WNA' || $siswa->status_wn_ayah == 'WNA') { echo 'selected'; } ?>>WNA</option>
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
                    <option value="<?php echo $jg->id_jenjang ?>" <?php if(set_value('id_jenjang_ayah')==$jg->id_jenjang || $siswa->id_jenjang_ayah == $jg->id_jenjang) { echo 'selected'; } ?>>
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
                    <option value="<?php echo $pk->id_pekerjaan ?>" <?php if(set_value('id_pekerjaan_ayah')==$pk->id_pekerjaan || $siswa->id_pekerjaan_ayah == $pk->id_pekerjaan) { echo 'selected'; } ?>>
                      <?php echo $pk->nama_pekerjaan ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Penghasilan per Bulan Ayah</label>
              <div class="col-md-9">
                <input type="text" name="penghasilan_ayah" class="form-control" placeholder="Rp." value="<?php if(isset($_POST['submit'])) { echo set_value('penghasilan_ayah'); }else{ echo $siswa->penghasilan_ayah; } ?>">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Status Ayah</label>
              <div class="col-md-9">
                <select name="status_hidup_ayah" class="form-control form-select">
                  <option value="Hidup" <?php if(set_value('status_hidup_ayah')=='Hidup' || $siswa->status_hidup_ayah == 'Hidup') { echo 'selected'; } ?>>Masih Hidup</option>
                  <option value="Meninggal" <?php if(set_value('status_hidup_ayah')=='Meninggal' || $siswa->status_hidup_ayah == 'Meninggal') { echo 'selected'; } ?>>Sudah Meninggal</option>
                </select>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Alamat Ayah<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <textarea name="alamat_ayah" placeholder="Alamat Ayah" class="form-control" required><?php if(isset($_POST['submit'])) { echo set_value('alamat_ayah'); }else{ echo $siswa->alamat_ayah; } ?></textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Telepon/HP Ayah<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <input type="text" name="telepon_ayah" class="form-control" placeholder="Telepon/HP Ayah" value="<?php if(isset($_POST['submit'])) { echo set_value('telepon_ayah'); }else{ echo $siswa->telepon_ayah; } ?>" required>
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
                <input type="text" name="nama_ibu" class="form-control" placeholder="Nama Ibu" value="<?php if(isset($_POST['submit'])) { echo set_value('nama_ibu'); }else{ echo $siswa->nama_ibu; } ?>" required>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Agama Ibu</label>
              <div class="col-md-9">
                <?php $agama = $m_agama->listing(); ?>
                <select name="id_agama_ibu" class="form-control form-select">
                  <option value="">Pilih Agama</option>
                  <?php foreach($agama as $ag) { ?>
                    <option value="<?php echo $ag->id_agama ?>" <?php if(set_value('id_agama_ibu')==$ag->id_agama || $siswa->id_agama_ibu == $ag->id_agama) { echo 'selected'; } ?>>
                      <?php echo $ag->nama_agama ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tempat & Tanggal Lahir Ibu</label>
              <div class="col-md-5">
                <input type="text" name="tempat_lahir_ibu" class="form-control" placeholder="Tempat lahir ibu" value="<?php if(isset($_POST['submit'])) { echo set_value('tempat_lahir_ibu'); }else{ echo $siswa->tempat_lahir_ibu; } ?>">
              </div>
              <div class="col-md-4">
                <input type="text" name="tanggal_lahir_ibu" class="form-control tanggal" placeholder="dd-mm-yyyy" value="<?php if(isset($_POST['submit'])) { echo set_value('tanggal_lahir_ibu'); }else{ echo $siswa->tanggal_lahir_ibu; } ?>">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kewarganegaraan Ibu</label>
              <div class="col-md-9">
                <select name="status_wn_ibu" class="form-control form-select">
                  <option value="WNI" <?php if(set_value('status_wn_ibu')=='WNI' || $siswa->status_wn_ibu == 'WNI') { echo 'selected'; } ?>>WNI</option>
                  <option value="WNA" <?php if(set_value('status_wn_ibu')=='WNA' || $siswa->status_wn_ibu == 'WNA') { echo 'selected'; } ?>>WNA</option>
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
                    <option value="<?php echo $jg->id_jenjang ?>" <?php if(set_value('id_jenjang_ibu')==$jg->id_jenjang || $siswa->id_jenjang_ibu == $jg->id_jenjang) { echo 'selected'; } ?>>
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
                    <option value="<?php echo $pk->id_pekerjaan ?>" <?php if(set_value('id_pekerjaan_ibu')==$pk->id_pekerjaan || $siswa->id_pekerjaan_ibu == $pk->id_pekerjaan) { echo 'selected'; } ?>>
                      <?php echo $pk->nama_pekerjaan ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Penghasilan per Bulan Ibu</label>
              <div class="col-md-9">
                <input type="text" name="penghasilan_ibu" class="form-control" placeholder="Rp." value="<?php if(isset($_POST['submit'])) { echo set_value('penghasilan_ibu'); }else{ echo $siswa->penghasilan_ibu; } ?>">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Status Ibu</label>
              <div class="col-md-9">
                <select name="status_hidup_ibu" class="form-control form-select">
                  <option value="Hidup" <?php if(set_value('status_hidup_ibu')=='Hidup' || $siswa->status_hidup_ibu == 'Hidup') { echo 'selected'; } ?>>Masih Hidup</option>
                  <option value="Meninggal" <?php if(set_value('status_hidup_ibu')=='Meninggal' || $siswa->status_hidup_ibu == 'Meninggal') { echo 'selected'; } ?>>Sudah Meninggal</option>
                </select>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Alamat Ibu<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <textarea name="alamat_ibu" placeholder="Alamat Ibu" class="form-control" required><?php if(isset($_POST['submit'])) { echo set_value('alamat_ibu'); }else{ echo $siswa->alamat_ibu; } ?></textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Telepon/HP Ibu<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <input type="text" name="telepon_ibu" class="form-control" placeholder="Telepon/HP Ibu" value="<?php if(isset($_POST['submit'])) { echo set_value('telepon_ibu'); }else{ echo $siswa->telepon_ibu; } ?>" required>
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
                    <input class="form-check-input" type="radio" name="identitas_wali" value="Ayah" onclick="Ayah()" <?php if(set_value('identitas_wali')=='Ayah' || $siswa->identitas_wali=="Ayah") { echo 'checked'; } ?> required>
                    <label class="form-check-label">Sama dengan Ayah</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="identitas_wali" value="Ibu" onclick="Ibu()" <?php if(set_value('identitas_wali')=='Ibu' || $siswa->identitas_wali=="Ibu") { echo 'checked'; } ?> required>
                    <label class="form-check-label">Sama dengan Ibu</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="identitas_wali" value="Berbeda" onclick="Berbeda()" <?php if(set_value('identitas_wali')=='Berbeda' || $siswa->identitas_wali=="Berbeda") { echo 'checked'; } ?> required>
                    <label class="form-check-label">Berbeda dengan Ayah dan Ibu</label>
                  </div>
                </div>
              </div>
            </div>
            <div id="myDIV">
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Nama Wali</label>
              <div class="col-md-9">
                <input type="text" name="nama_wali" class="form-control" placeholder="Nama Wali" value="<?php if(isset($_POST['submit'])) { echo set_value('nama_wali'); }else{ echo $siswa->nama_wali; } ?>" >
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Agama Wali</label>
              <div class="col-md-9">
                <?php $agama = $m_agama->listing(); ?>
                <select name="id_agama_wali" class="form-control form-select">
                  <option value="">Pilih Agama</option>
                  <?php foreach($agama as $ag) { ?>
                    <option value="<?php echo $ag->id_agama ?>" <?php if(set_value('id_agama_wali')==$ag->id_agama || $siswa->id_agama_wali == $ag->id_agama) { echo 'selected'; } ?>>
                      <?php echo $ag->nama_agama ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tempat & Tanggal Lahir Wali</label>
              <div class="col-md-5">
                <input type="text" name="tempat_lahir_wali" class="form-control" placeholder="Tempat lahir wali" value="<?php if(isset($_POST['submit'])) { echo set_value('tempat_lahir_wali'); }else{ echo $siswa->tempat_lahir_wali; } ?>">
              </div>
              <div class="col-md-4">
                <input type="text" name="tanggal_lahir_wali" class="form-control tanggal" placeholder="dd-mm-yyyy" value="<?php if(isset($_POST['submit'])) { echo set_value('tanggal_lahir_wali'); }else{ echo $siswa->tanggal_lahir_wali; } ?>">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kewarganegaraan Wali</label>
              <div class="col-md-9">
                <select name="status_wn_wali" class="form-control form-select">
                  <option value="WNI" <?php if(set_value('status_wn_wali')=='WNI' || $siswa->status_wn_wali == 'WNI') { echo 'selected'; } ?>>WNI</option>
                  <option value="WNA" <?php if(set_value('status_wn_wali')=='WNA' || $siswa->status_wn_wali == 'WNA') { echo 'selected'; } ?>>WNA</option>
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
                    <option value="<?php echo $jg->id_jenjang ?>" <?php if(set_value('id_jenjang_wali')==$jg->id_jenjang || $siswa->id_jenjang_wali == $jg->id_jenjang) { echo 'selected'; } ?>>
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
                    <option value="<?php echo $pk->id_pekerjaan ?>" <?php if(set_value('id_pekerjaan_wali')==$pk->id_pekerjaan || $siswa->id_pekerjaan_wali == $pk->id_pekerjaan) { echo 'selected'; } ?>>
                      <?php echo $pk->nama_pekerjaan ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Penghasilan per Bulan Wali</label>
              <div class="col-md-9">
                <input type="text" name="penghasilan_wali" class="form-control" placeholder="Rp." value="<?php if(isset($_POST['submit'])) { echo set_value('penghasilan_wali'); }else{ echo $siswa->penghasilan_wali; } ?>">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Alamat Wali</label>
              <div class="col-md-9">
                <textarea name="alamat_wali" placeholder="Alamat Wali" class="form-control" ><?php if(isset($_POST['submit'])) { echo set_value('alamat_wali'); }else{ echo $siswa->alamat_wali; } ?></textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Telepon/HP Wali</label>
              <div class="col-md-9">
                <input type="text" name="telepon_wali" class="form-control" placeholder="Telepon/HP Wali" value="<?php if(isset($_POST['submit'])) { echo set_value('telepon_wali'); }else{ echo $siswa->telepon_wali; } ?>" >
              </div>
            </div>
            
            </div>
          </div>
        </div>
        <div class="card-footer bg-light text-right border-top">
            <div class="form-group row mb-3">
                <label class="col-md-3 text-dark"></label>
                <div class="col-md-9">
                  <button type="submit" class="btn btn-success text-white" name="submit" value="submit"><i class="fa fa-save"></i>&nbsp;Simpan dan Lanjutkan Pendaftaran</button>
                </div>
              </div>
          </div>
        </div>


        <?php echo form_close(); ?>

        <script>
          function Ayah() {
            document.getElementById("myDIV").style.display = "none"; // Karena sama dengan Ayah
          }

          function Ibu() {
            document.getElementById("myDIV").style.display = "none"; // Karena sama dengan Ibu
          }

          function Berbeda() {
            document.getElementById("myDIV").style.display = "block"; // Karena berbeda, harus isi form
          }
        </script>
<script>
function checkSeragam(val) {
  if(val == 'Lainnya') {
    document.getElementById('ukuran_seragam_lainnya').style.display = 'block';
  } else {
    document.getElementById('ukuran_seragam_lainnya').style.display = 'none';
  }
}
</script>
