<?php if (Session()->get('username_siswa') != '') { ?>
                <p class="text-center">Halo <strong class="text-danger"><?php echo Session()->get('nama') ?></strong>. Anda sudah berhasil login. 
                  <br>Silakan klik Tombol <strong class="text-danger">Daftar Online</strong> untuk melakukan Proses SMPB.</p>

                  
              <?php }else{ ?>
                 
                  <p class="text-center">Sudah punya Akun? <a href="<?php echo base_url('signin') ?>" class="hover">Login di sini</a>. <br>Jika Anda Belum Memiliki Akun, silakan <a href="<?php echo base_url('pendaftaran/akun') ?>">Buat Akun</a> terlebih dahulu.
                  <br>Tombol <strong>Daftar Online</strong> akan otomatis aktif jika Anda sudah melakukan login dengan akun yang sudah Anda miliki.</p>
                <?php } ?>

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
                                            data-toggle="modal" 
                                            data-target="#Gelombang<?php echo $gelombang->id_gelombang ?>">
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

            <?php foreach($gelombang2 as $gelombang) { ?>
<!-- Modal -->
                <div class="modal fade" id="Gelombang<?php echo $gelombang->id_gelombang ?>" tabindex="10700" 
                     aria-labelledby="modalTitle<?php echo $gelombang->id_gelombang ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><?php echo $gelombang->judul ?></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                             
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
                            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>                    
                        </div>
                    </div>
                </div>
<?php } ?>
