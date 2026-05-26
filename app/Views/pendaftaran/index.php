

<!-- /section -->
<section class="wrapper bg-light">
  <div class="container pb-14 pb-md-16">
    <div class="row">
      <div class="col-lg-10 col-xl-10 col-xxl-10 mx-auto mt-n20">
        <div class="card">
          <div class="card-body p-5">

              <?php if (Session()->get('username_siswa') != '') { ?>
                <p class="text-center">Halo <strong class="text-danger"><?php echo Session()->get('nama') ?></strong>. Anda sudah berhasil login. 
                  <br>Silakan klik Tombol <strong class="text-danger">Daftar Online</strong> untuk melakukan Proses SMPB.</p>

                  
              <?php }else{ ?>
                 
                  <p class="text-center">Sudah punya Akun? <a href="<?php echo base_url('signin') ?>" class="hover">Login di sini</a>. <br>Jika Anda Belum Memiliki Akun, silakan <a href="<?php echo base_url('pendaftaran/akun') ?>">Buat Akun</a> terlebih dahulu.
                  <br>Tombol <strong>Daftar Online</strong> akan otomatis aktif jika Anda sudah melakukan login dengan akun yang sudah Anda miliki.</p>
                <?php } ?>

              <div class="text-center mb-4">
                  <a href="<?php echo base_url() ?>" class="btn btn-secondary text-white mb-2">
                      <i class="fa fa-home"></i> Kembali ke Beranda
                  </a>
                  <button type="button" class="btn btn-warning text-white mb-2" data-bs-toggle="modal" data-bs-target="#ModalSyarat">
                      <i class="fa fa-info-circle"></i> Lihat Rincian Biaya & Persyaratan
                  </button>
              </div>

              <?php foreach($gelombang as $gelombang) { ?> <!-- Gunakan $gelombang agar tidak konflik -->
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <?php if ($gelombang->gambar == "") { ?>
                                    <img src="<?php echo $this->website->icon() ?>" class="img img-thumbnail">
                                <?php } else { ?>
                                    <img src="<?php echo base_url('assets/upload/image/' . $gelombang->gambar) ?>" class="img img-thumbnail">
                                <?php } ?>
                            </div>
                            <div class="col-md-9">
                                <h2><?php echo $gelombang->judul ?></h2>
                                <p>
                                    <span class="text-secondary">Tahun:</span> <?php echo $gelombang->tahun_ajaran ?>
                                    <br><span class="text-secondary">Pembukaan:</span> <?php echo $this->website->hari($gelombang->tanggal_buka) ?>
                                    <br><span class="text-secondary">Penutupan:</span> <?php echo $this->website->hari($gelombang->tanggal_tutup) ?>
                                    <br><span class="text-secondary">Pengumuman:</span> <?php echo $this->website->hari($gelombang->tanggal_pengumuman) ?>
                                </p>
                                <p>
                                    <button type="button" class="btn btn-primary btn-sm rounded text-white mb-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#Gelombang<?php echo $gelombang->id_gelombang ?>">
                                        Lihat Detail &nbsp;<i class="fa fa-eye"></i>
                                    </button>
                                    <?php if (Session()->get('username_siswa') != '') { ?>
                                        <a href="<?php echo base_url('siswa/pendaftaran/biodata/' . $gelombang->id_gelombang) ?>" 
                                           class="btn btn-danger btn-sm text-white mb-1">
                                           <i class="fa fa-edit"></i>&nbsp; Daftar Online
                                        </a>
                                    <?php } else { ?>
                                      <a href="#" class="btn btn-secondary disabled btn-sm text-white mb-1">
                                            <i class="fa fa-edit"></i>&nbsp; Daftar Online
                                        </a>

                                        <a href="<?php echo base_url('pendaftaran/akun') ?>" class="btn btn-success btn-sm text-white mb-1">
                                            <i class="fa fa-user-edit"></i>&nbsp; Buat akun
                                        </a>
                                        <a href="<?php echo base_url('signin') ?>" class="btn btn-info btn-sm text-white mb-1">
                                            <i class="fa fa-user-lock"></i>&nbsp; Login
                                        </a>
                                        
                                        
                                        
                                    <?php } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                
            <?php } ?>

                
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php foreach($gelombang2 as $gelombang) { ?>
<!-- Modal -->
                <div class="modal fade" id="Gelombang<?php echo $gelombang->id_gelombang ?>" tabindex="10700" 
                     aria-labelledby="modalTitle<?php echo $gelombang->id_gelombang ?>" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                    
                            <div class="modal-body">
                              <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              <h2 class="modal-title mb-2" id="modalTitle<?php echo $gelombang->id_gelombang ?>">
                                    <?php echo $gelombang->judul ?>
                                </h2>
                              <div class="row">
                                <div class="col-md-3">
                                    <?php if ($gelombang->gambar == "") { ?>
                                        <img src="<?php echo $this->website->icon() ?>" class="img img-thumbnail">
                                    <?php } else { ?>
                                        <img src="<?php echo base_url('assets/upload/image/' . $gelombang->gambar) ?>" class="img img-thumbnail">
                                    <?php } ?>
                                </div>
                                <div class="col-md-9">
                                  <?php echo $gelombang->isi ?>
                               
                                  <p>
                                    <?php if (Session()->get('username_siswa') != '') { ?>
                                        <a href="<?php echo base_url('siswa/pendaftaran/biodata/' . $gelombang->id_gelombang) ?>" 
                                           class="btn btn-success btn-sm text-white mb-1">
                                           <i class="fa fa-edit"></i>&nbsp; Daftar
                                        </a>
                                    <?php } else { ?>
                                        <a href="#" class="btn btn-secondary disabled btn-sm text-white mb-1">
                                            <i class="fa fa-edit"></i>&nbsp; Daftar Online
                                        </a>
                                        <a href="<?php echo base_url('pendaftaran/akun') ?>" class="btn btn-success btn-sm text-white mb-1">
                                            <i class="fa fa-user-edit"></i>&nbsp; Buat akun
                                        </a>
                                        <a href="<?php echo base_url('signin') ?>" class="btn btn-info btn-sm text-white mb-1">
                                            <i class="fa fa-user-lock"></i>&nbsp; Login
                                        </a>
                                    <?php } ?>
                                  </p>
                                </div>
                              </div>
                            </div>                      
                        </div>
                    </div>
                </div>
<?php } ?>

<!-- Modal Syarat -->
<div class="modal fade" id="ModalSyarat" tabindex="-1" aria-labelledby="modalSyaratLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header bg-warning text-white">
              <h5 class="modal-title" id="modalSyaratLabel"><i class="fa fa-info-circle"></i> Rincian Biaya & Persyaratan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <?php echo $konfigurasi->syarat_pendaftaran; ?>
              <hr>
              <?php echo $konfigurasi->rincian_administrasi; ?>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
      </div>
  </div>
</div>
