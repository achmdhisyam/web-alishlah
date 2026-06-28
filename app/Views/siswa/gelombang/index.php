<?php
$db = \Config\Database::connect();
$id_akun = Session()->get('id_akun');
$siswa = $db->table('siswa')->where('id_akun', $id_akun)->get()->getRow();
$pct = 0;
if ($siswa) {
    $total_wajib = $db->table('jenis_dokumen')->where('status_jenis_dokumen', 'Wajib')->countAllResults();
    $sudah_upload = $db->table('dokumen')->where('id_siswa', $siswa->id_siswa)->countAllResults();
    $pct = $total_wajib > 0 ? min(100, round(($sudah_upload / $total_wajib) * 100)) : 0;
}

$status_pend = $siswa ? ($siswa->status_pendaftaran ?? null) : null;

// Hitung persentase alur pendaftaran keseluruhan
$overall_pct = 0; 
if (!$siswa) {
    $overall_pct = 25; // Baru buat akun, belum isi biodata
} else {
    $overall_pct = 50; // Sudah isi biodata
    if ($pct >= 100) {
        $overall_pct = 83; // Sudah unggah semua dokumen wajib
        if (in_array($status_pend, ['Diterima', 'Tidak-Diterima'])) {
            $overall_pct = 100; // Sudah ada keputusan kelulusan
        }
    } else {
        $overall_pct = 50 + round($pct * 0.33); // Progress dokumen
    }
}
?>

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
      <?php 
        $step2_active = !empty($siswa); 
        $step2_class = $step2_active ? 'bg-success text-white border-white' : 'bg-white text-secondary border';
        $step2_text_class = $step2_active ? 'text-success font-weight-bold' : 'text-muted';
      ?>
      <div class="text-center position-relative" style="z-index: 2; width: 90px;">
        <div class="rounded-circle <?php echo $step2_class ?> d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 44px; height: 44px; font-size: 14px; font-weight: bold; border-color: #dee2e6 !important;">
          <i class="fa fa-file-alt"></i>
        </div>
        <span class="<?php echo $step2_text_class ?>" style="font-size: 11px; display: block; line-height: 1.2;">2. Isi Biodata</span>
      </div>
      
      <!-- Step 3: Unggah Dokumen -->
      <?php 
        $step3_active = ($siswa && $pct >= 100);
        $step3_in_progress = ($siswa && $pct > 0 && $pct < 100);
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

<?php if (Session()->get('username_siswa') != '') { ?>
                <p class="text-center">Halo <strong class="text-danger"><?php echo Session()->get('nama') ?></strong>. Anda sudah berhasil login. 
                  <?php if (!empty($gelombang2)) { ?>
                    <br>Silakan klik Tombol <strong class="text-danger">Daftar Online</strong> untuk melakukan Proses SMPB.
                  <?php } ?>
                </p>

                  
              <?php }else{ ?>
                 
                  <p class="text-center">Sudah punya Akun? <a href="<?php echo base_url('signin') ?>" class="hover">Login di sini</a>. <br>Jika Anda Belum Memiliki Akun, silakan <a href="<?php echo base_url('pendaftaran/akun') ?>">Buat Akun</a> terlebih dahulu.
                  <?php if (!empty($gelombang2)) { ?>
                    <br>Tombol <strong>Daftar Online</strong> akan otomatis aktif jika Anda sudah melakukan login dengan akun yang sudah Anda miliki.
                  <?php } ?>
                  </p>
                <?php } ?>

              <?php if (empty($gelombang2)) { 
                $db = \Config\Database::connect();
                $konfigurasi = $db->table('konfigurasi')->get()->getRow();
                $waNum = !empty($konfigurasi->whatsapp_spmb) ? $konfigurasi->whatsapp_spmb : (!empty($konfigurasi->whatsapp) ? $konfigurasi->whatsapp : '');
              ?>
                <!-- Tampilan Kosong (Empty State) -->
                <div class="text-center py-5 px-4 border border-dashed border-2 rounded bg-light mb-4" style="border-color: #cbd5e1 !important; border-radius: 12px !important; border-style: dashed !important;">
                  <div class="mb-3">
                    <span class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm" style="width: 70px; height: 70px; display: inline-flex !important;">
                      <i class="fa fa-calendar-times text-danger" style="font-size: 2rem;"></i>
                    </span>
                  </div>
                  <h4 class="mb-2 font-weight-bold" style="color: #1e293b;">Pendaftaran Belum Dibuka</h4>
                  <p class="text-muted mx-auto mb-4" style="max-width: 500px; font-size: 0.9rem; line-height: 1.6;">
                    Mohon maaf, saat ini sedang tidak ada gelombang pendaftaran yang aktif. Silakan hubungi Panitia Seleksi Penerimaan Murid Baru (SPMB) kami untuk mendapatkan informasi resmi terkait pembukaan pendaftaran berikutnya.
                  </p>
                  <?php 
                  if (!empty($waNum)) {
                    $cleanWa = preg_replace('/[^0-9]/', '', $waNum);
                    if (strpos($cleanWa, '0') === 0) {
                      $cleanWa = '62' . substr($cleanWa, 1);
                    }
                    $waUrl = 'https://wa.me/' . $cleanWa . '?text=' . urlencode('Halo Panitia SPMB ' . $konfigurasi->namaweb . ', saya ingin bertanya mengenai jadwal pendaftaran gelombang berikutnya.');
                  ?>
                    <a href="<?= $waUrl ?>" target="_blank" class="btn btn-success text-white px-4 py-2 shadow-sm d-inline-flex align-items-center" style="background-color: #25d366; border-color: #25d366; border-radius: 8px; text-decoration: none !important;">
                      <i class="fab fa-whatsapp me-2" style="font-size: 1.1rem;"></i> Hubungi Panitia via WhatsApp
                    </a>
                  <?php } ?>
                </div>
              <?php } else { ?>
                <?php foreach($gelombang2 as $g) { ?>
                  <div class="card mb-2">
                      <div class="card-body">
                          <div class="row">
                              <div class="col-md-3">
                                  <?php if ($g->gambar == "") { ?>
                                      <img src="<?php echo $this->website->icon() ?>" class="img img-thumbnail">
                                  <?php } else { ?>
                                      <img src="<?php echo base_url('assets/upload/image/' . $g->gambar) ?>" class="img img-thumbnail">
                                  <?php } ?>
                              </div>
                              <div class="col-md-9">
                                  <h2><?php echo $g->judul ?></h2>
                                  <p>
                                      <span class="text-secondary">Tahun:</span> <?php echo $g->tahun_ajaran ?>
                                      <br><span class="text-secondary">Pembukaan:</span> <?php echo $this->website->hari($g->tanggal_buka) ?>
                                      <br><span class="text-secondary">Penutupan:</span> <?php echo $this->website->hari($g->tanggal_tutup) ?>
                                      <br><span class="text-secondary">Pengumuman:</span> <?php echo $this->website->hari($g->tanggal_pengumuman) ?>
                                  </p>
                                  <p>
                                      <button type="button" class="btn btn-primary btn-sm rounded text-white mb-1" 
                                              data-toggle="modal" 
                                              data-target="#Gelombang<?php echo $g->id_gelombang ?>">
                                          Lihat Detail &nbsp;<i class="fa fa-eye"></i>
                                      </button>
                                      <?php if (Session()->get('username_siswa') != '') { ?>
                                          <a href="<?php echo base_url('siswa/pendaftaran/biodata/' . $g->id_gelombang) ?>" 
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
              <?php } ?>

              <?php foreach($gelombang2 as $g) { ?>
<!-- Modal -->
                <div class="modal fade" id="Gelombang<?php echo $g->id_gelombang ?>" tabindex="10700" 
                     aria-labelledby="modalTitle<?php echo $g->id_gelombang ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><?php echo $g->judul ?></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                             
                              <div class="row">
                                <div class="col-md-3">
                                    <?php if ($g->gambar == "") { ?>
                                        <img src="<?php echo $this->website->icon() ?>" class="img img-thumbnail">
                                    <?php } else { ?>
                                        <img src="<?php echo base_url('assets/upload/image/' . $g->gambar) ?>" class="img img-thumbnail">
                                    <?php } ?>
                                </div>
                                <div class="col-md-9">
                                  <?php echo $g->isi ?>
                               
                                  <p>
                                    <?php if (Session()->get('username_siswa') != '') { ?>
                                        <a href="<?php echo base_url('siswa/pendaftaran/biodata/' . $g->id_gelombang) ?>" 
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
                            <div class="modal-header justify-content-end border-top-0 pt-0">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            </div>                    
                        </div>
                    </div>
                </div>
<?php } ?>
