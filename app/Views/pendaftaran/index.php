<!-- /section -->
<section class="wrapper bg-light">
  <div class="container pb-14 pb-md-16">
    <div class="row">
      <div class="col-lg-12 col-xl-12 col-xxl-12 mx-auto mt-n20">
        <div class="card shadow-lg border-0" style="border-radius: 16px;">
          <div class="card-body p-4 p-md-6">

            <!-- Banner Informasi Akun / Sesi -->
            <div class="mb-5">
              <?php if (Session()->get('username_siswa') != '') { ?>
                <div class="alert alert-success border-0 shadow-sm" role="alert" style="background-color: #f0fdf4; border-left: 5px solid #22c55e !important; border-radius: 12px; padding: 16px 20px;">
                  <div class="d-flex align-items-start">
                    <div class="me-3 mt-1">
                      <span class="d-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm" style="width: 42px; height: 42px; min-width: 42px;">
                        <i class="fa fa-user-check text-success" style="font-size: 1.35rem;"></i>
                      </span>
                    </div>
                    <div class="flex-grow-1">
                      <h5 class="alert-heading alert-heading-responsive mb-1 font-weight-bold" style="color: #14532d;">Sesi Masuk Aktif</h5>
                      <div class="alert-text-responsive" style="color: #1e3a1e; line-height: 1.6;">
                        Halo <strong style="color: #14532d;"><?php echo Session()->get('nama') ?></strong>, Anda telah masuk ke sistem SPMB.
                        <p class="mb-0 mt-1">Silakan pilih salah satu gelombang aktif di bawah ini dan klik tombol <strong class="text-danger">Daftar Online</strong> untuk mulai melakukan pengisian data.</p>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } else { ?>
                <div class="alert alert-info border-0 shadow-sm" role="alert" style="background-color: #f0f9ff; border-left: 5px solid #0284c7 !important; border-radius: 12px; padding: 16px 20px;">
                  <div class="d-flex align-items-start">
                    <div class="me-3 mt-1">
                      <span class="d-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm" style="width: 42px; height: 42px; min-width: 42px;">
                        <i class="fa fa-info-circle" style="font-size: 1.35rem; color: #0284c7;"></i>
                      </span>
                    </div>
                    <div class="flex-grow-1">
                      <h5 class="alert-heading alert-heading-responsive mb-1 font-weight-bold" style="color: #0c4a6e;">Informasi Pendaftaran</h5>
                      <div class="alert-text-responsive" style="color: #1e293b; line-height: 1.6;">
                        <p class="mb-2">Selamat datang di portal SPMB. Sebelum memilih gelombang pendaftaran, silakan ikuti petunjuk berikut:</p>
                        <ul class="mb-0 ps-3">
                          <li class="mb-1">Sudah punya akun? Silakan <a href="<?php echo base_url('signin') ?>" class="text-primary font-weight-bold hover text-decoration-underline">Login ke Akun Anda</a>.</li>
                          <li class="mb-1">Belum punya akun? Silakan <a href="<?php echo base_url('pendaftaran/akun') ?>" class="text-success font-weight-bold hover text-decoration-underline">Buat Akun Baru</a> terlebih dahulu.</li>
                          <li>Tombol pendaftaran (<strong>Daftar Online</strong>) akan otomatis aktif setelah Anda berhasil masuk.</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>

            <!-- Bagian Navigasi Aksi Cepat -->
            <div class="d-flex flex-wrap gap-2 justify-content-start mb-5">
              <a href="<?php echo base_url() ?>" class="btn btn-outline-secondary px-4 py-2 border-light-subtle d-inline-flex align-items-center shadow-sm" style="border-radius: 8px;">
                <i class="fa fa-home me-2"></i> Beranda
              </a>
              <button type="button" class="btn btn-warning text-white px-4 py-2 d-inline-flex align-items-center shadow-sm" data-bs-toggle="modal" data-bs-target="#ModalSyarat" style="border-radius: 8px; background-color: #f59e0b; border-color: #f59e0b;">
                <i class="fa fa-info-circle me-2"></i> Rincian Syarat & Biaya
              </button>
            </div>

            <!-- Grid Konten Utama -->
            <div class="row">
              
              <!-- Kolom Kiri: Gelombang Pendaftaran -->
              <div class="col-lg-7 mb-4">
                <h4 class="mb-4 font-weight-bold d-flex align-items-center main-title-responsive" style="color: #2b303a;">
                  <span class="bg-success-subtle p-2 rounded-3 me-2 d-inline-flex align-items-center text-success" style="background-color: #d1fae5;">
                    <i class="fa fa-calendar-alt" style="font-size: 1.1rem;"></i>
                  </span>
                  Gelombang Pendaftaran SPMB
                </h4>

                <?php if (empty($gelombang2)) { ?>
                  <!-- Tampilan Kosong (Empty State) -->
                  <div class="text-center py-7 px-4 border border-dashed border-2 rounded-3 bg-light mb-4" style="border-color: #cbd5e1 !important; border-radius: 12px !important;">
                    <div class="mb-3">
                      <span class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm" style="width: 70px; height: 70px;">
                        <i class="fa fa-calendar-times text-danger" style="font-size: 2rem;"></i>
                      </span>
                    </div>
                    <h4 class="mb-2 font-weight-bold" style="color: #1e293b;">Pendaftaran Belum Dibuka</h4>
                    <p class="text-muted mx-auto mb-4" style="max-width: 500px; font-size: 0.9rem; line-height: 1.6;">
                      Mohon maaf, saat ini sedang tidak ada gelombang pendaftaran yang aktif. Silakan hubungi Panitia Seleksi Penerimaan Murid Baru (SPMB) kami untuk mendapatkan informasi resmi terkait pembukaan pendaftaran berikutnya.
                    </p>
                    <?php 
                    $waNum = !empty($konfigurasi->whatsapp_spmb) ? $konfigurasi->whatsapp_spmb : (!empty($konfigurasi->whatsapp) ? $konfigurasi->whatsapp : '');
                    if (!empty($waNum)) {
                      $cleanWa = preg_replace('/[^0-9]/', '', $waNum);
                      if (strpos($cleanWa, '0') === 0) {
                        $cleanWa = '62' . substr($cleanWa, 1);
                      }
                      $waUrl = 'https://wa.me/' . $cleanWa . '?text=' . urlencode('Halo Panitia SPMB ' . $konfigurasi->namaweb . ', saya ingin bertanya mengenai jadwal pendaftaran gelombang berikutnya.');
                    ?>
                      <a href="<?= $waUrl ?>" target="_blank" class="btn btn-success text-white px-4 py-2 shadow-sm d-inline-flex align-items-center" style="background-color: #25d366; border-color: #25d366; border-radius: 8px;">
                        <i class="fab fa-whatsapp me-2" style="font-size: 1.1rem;"></i> Hubungi Panitia via WhatsApp
                      </a>
                    <?php } ?>
                  </div>
                <?php } else { ?>
                  
                  <!-- Daftar Gelombang Aktif -->
                  <?php foreach($gelombang as $g) { ?>
                    <div class="card mb-3 border border-light-subtle shadow-sm" style="border-radius: 12px; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                      <div class="card-body p-4">
                        <div class="row g-4 align-items-center">
                          <div class="col-md-3 text-center">
                            <?php if ($g->gambar == "") { ?>
                              <img src="<?php echo $this->website->icon() ?>" class="img-fluid rounded-3 border p-1" style="max-height: 100px; object-fit: contain;">
                            <?php } else { ?>
                              <img src="<?php echo base_url('assets/upload/image/' . $g->gambar) ?>" class="img-fluid rounded-3 border p-1" style="max-height: 100px; object-fit: contain;">
                            <?php } ?>
                          </div>
                          <div class="col-md-9">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                              <h3 class="mb-0 font-weight-bold text-dark gelombang-title-responsive" style="font-size: 1.25rem;"><?php echo $g->judul ?></h3>
                              <span class="badge bg-success text-white px-2 py-1" style="font-size: 0.75rem; background-color: #16a34a !important; border-radius: 6px;">Aktif / Dibuka</span>
                            </div>
                            
                            <div class="row g-2 mb-3 text-muted" style="font-size: 0.85rem;">
                              <div class="col-sm-6">
                                <i class="fa fa-graduation-cap text-success me-2"></i>Tahun: <?php echo $g->tahun_ajaran ?>
                              </div>
                              <div class="col-sm-6">
                                <i class="fa fa-door-open text-success me-2"></i>Buka: <?php echo $this->website->hari($g->tanggal_buka) ?>
                              </div>
                              <div class="col-sm-6">
                                <i class="fa fa-door-closed text-danger me-2"></i>Tutup: <?php echo $this->website->hari($g->tanggal_tutup) ?>
                              </div>
                              <div class="col-sm-6">
                                <i class="fa fa-bullhorn text-info me-2"></i>Pengumuman: <?php echo $this->website->hari($g->tanggal_pengumuman) ?>
                              </div>
                            </div>
                            
                            <div class="d-flex flex-wrap gap-2">
                              <button type="button" class="btn btn-outline-primary btn-sm px-3 py-1.5" data-bs-toggle="modal" data-bs-target="#Gelombang<?php echo $g->id_gelombang ?>" style="border-radius: 6px;">
                                <i class="fa fa-eye me-1"></i> Lihat Detail
                              </button>
                              
                              <?php if (Session()->get('username_siswa') != '') { ?>
                                <a href="<?php echo base_url('siswa/pendaftaran/biodata/' . $g->id_gelombang) ?>" class="btn btn-danger btn-sm text-white px-3 py-1.5" style="border-radius: 6px; background-color: #dc2626; border-color: #dc2626;">
                                  <i class="fa fa-edit me-1"></i> Daftar Online
                                </a>
                              <?php } else { ?>
                                <a href="#" class="btn btn-secondary disabled btn-sm px-3 py-1.5 text-white" style="border-radius: 6px;">
                                  <i class="fa fa-edit me-1"></i> Daftar Online
                                </a>
                                <a href="<?php echo base_url('pendaftaran/akun') ?>" class="btn btn-success btn-sm text-white px-3 py-1.5" style="border-radius: 6px; background-color: #16a34a; border-color: #16a34a;">
                                  <i class="fa fa-user-plus me-1"></i> Buat Akun
                                </a>
                                <a href="<?php echo base_url('signin') ?>" class="btn btn-outline-info btn-sm px-3 py-1.5" style="border-radius: 6px;">
                                  <i class="fa fa-user-lock me-1"></i> Login
                                </a>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                  
                <?php } ?>
              </div>
              
              <!-- Kolom Kanan: Informasi Syarat & Biaya -->
              <div class="col-lg-5 mb-4">
                <h4 class="mb-4 font-weight-bold d-flex align-items-center main-title-responsive" style="color: #2b303a;">
                  <span class="bg-primary-subtle p-2 rounded-3 me-2 d-inline-flex align-items-center text-primary" style="background-color: #dbeafe;">
                    <i class="fa fa-info-circle" style="font-size: 1.1rem;"></i>
                  </span>
                  Syarat & Biaya Pendaftaran
                </h4>
                
                <div class="card border border-light-subtle shadow-sm" style="border-radius: 12px; background-color: #ffffff;">
                  <div class="card-body p-4">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bg mb-4" id="pendaftaranInlineTab" role="tablist" style="border-bottom: 2px solid #f1f5f9;">
                      <li class="nav-item" role="presentation" style="flex: 1;">
                        <button class="nav-link active w-100 font-weight-bold text-center py-2" id="inline-syarat-tab" data-bs-toggle="tab" data-bs-target="#inline-syarat" type="button" role="tab" aria-controls="inline-syarat" aria-selected="true" style="border-radius: 8px 8px 0 0; font-size: 0.85rem;">
                          <i class="fa fa-list-check d-block d-md-inline mb-1 mb-md-0 me-md-1 text-success"></i> Syarat
                        </button>
                      </li>
                      <li class="nav-item" role="presentation" style="flex: 1;">
                        <button class="nav-link w-100 font-weight-bold text-center py-2" id="inline-biaya-tab" data-bs-toggle="tab" data-bs-target="#inline-biaya" type="button" role="tab" aria-controls="inline-biaya" aria-selected="false" style="border-radius: 8px 8px 0 0; font-size: 0.85rem;">
                          <i class="fa fa-money-bill-wave d-block d-md-inline mb-1 mb-md-0 me-md-1 text-success"></i> Biaya
                        </button>
                      </li>
                    </ul>
                    
                    <!-- Tab Content -->
                    <div class="tab-content" id="pendaftaranInlineTabContent">
                      <div class="tab-pane fade show active" id="inline-syarat" role="tabpanel" aria-labelledby="inline-syarat-tab">
                        <div class="rich-text-container" style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                          <?php echo !empty($konfigurasi->syarat_pendaftaran) ? $konfigurasi->syarat_pendaftaran : '<p class="text-muted text-center py-4">Belum ada rincian persyaratan pendaftaran.</p>'; ?>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="inline-biaya" role="tabpanel" aria-labelledby="inline-biaya-tab">
                        <div class="rich-text-container" style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                          <?php echo !empty($konfigurasi->rincian_administrasi) ? $konfigurasi->rincian_administrasi : '<p class="text-muted text-center py-4">Belum ada rincian biaya pendaftaran.</p>'; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal Detail Gelombang -->
<?php foreach($gelombang2 as $g) { ?>
  <div class="modal fade" id="Gelombang<?php echo $g->id_gelombang ?>" tabindex="-1" aria-labelledby="modalTitle<?php echo $g->id_gelombang ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
        <div class="modal-header border-0 pb-0" style="background-color: #f8f9fa; border-radius: 14px 14px 0 0;">
          <h4 class="modal-title font-weight-bold text-dark" id="modalTitle<?php echo $g->id_gelombang ?>"><?php echo $g->judul ?></h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="row g-4">
            <div class="col-md-4 text-center">
              <?php if ($g->gambar == "") { ?>
                <img src="<?php echo $this->website->icon() ?>" class="img-fluid rounded border p-2" style="max-height: 150px; object-fit: contain;">
              <?php } else { ?>
                <img src="<?php echo base_url('assets/upload/image/' . $g->gambar) ?>" class="img-fluid rounded border p-2" style="max-height: 150px; object-fit: contain;">
              <?php } ?>
            </div>
            <div class="col-md-8">
              <div class="mb-3 text-muted" style="font-size: 0.9rem; line-height: 1.7;">
                <?php echo $g->isi ?>
              </div>
              
              <div class="p-3 bg-light rounded-3 mb-3 border border-light-subtle">
                <h6 class="font-weight-bold text-dark mb-2">Jadwal Penting:</h6>
                <table class="table table-sm table-borderless mb-0 text-muted" style="font-size: 0.85rem;">
                  <tr>
                    <td width="35%" class="p-1"><i class="fa fa-graduation-cap text-success me-2"></i>Tahun Ajaran</td>
                    <td class="p-1">: <strong><?php echo $g->tahun_ajaran ?></strong></td>
                  </tr>
                  <tr>
                    <td class="p-1"><i class="fa fa-door-open text-success me-2"></i>Tanggal Buka</td>
                    <td class="p-1">: <?php echo $this->website->hari($g->tanggal_buka) ?></td>
                  </tr>
                  <tr>
                    <td class="p-1"><i class="fa fa-door-closed text-danger me-2"></i>Tanggal Tutup</td>
                    <td class="p-1">: <?php echo $this->website->hari($g->tanggal_tutup) ?></td>
                  </tr>
                  <tr>
                    <td class="p-1"><i class="fa fa-bullhorn text-info me-2"></i>Pengumuman</td>
                    <td class="p-1">: <?php echo $this->website->hari($g->tanggal_pengumuman) ?></td>
                  </tr>
                </table>
              </div>
              
              <div>
                <?php if (Session()->get('username_siswa') != '') { ?>
                  <a href="<?php echo base_url('siswa/pendaftaran/biodata/' . $g->id_gelombang) ?>" class="btn btn-danger btn-sm text-white px-3 py-1.5" style="border-radius: 6px; background-color: #dc2626;">
                    <i class="fa fa-edit me-1"></i> Mulai Daftar Online
                  </a>
                <?php } else { ?>
                  <a href="<?php echo base_url('pendaftaran/akun') ?>" class="btn btn-success btn-sm text-white px-3 py-1.5" style="border-radius: 6px; background-color: #16a34a; border-color: #16a34a;">
                    <i class="fa fa-user-plus me-1"></i> Buat Akun Baru
                  </a>
                  <a href="<?php echo base_url('signin') ?>" class="btn btn-outline-info btn-sm px-3 py-1.5 ms-1" style="border-radius: 6px;">
                    <i class="fa fa-user-lock me-1"></i> Login
                  </a>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<!-- Modal Syarat & Biaya (Floating) -->
<div class="modal fade" id="ModalSyarat" tabindex="-1" aria-labelledby="modalSyaratLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 14px;">
      <div class="modal-header border-0 text-white py-3.5 px-4" style="background-color: #146a39; border-radius: 14px 14px 0 0;">
        <h5 class="modal-title font-weight-bold text-white d-flex align-items-center" id="modalSyaratLabel">
          <i class="fa fa-info-circle me-2"></i> Rincian Biaya & Persyaratan
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4" style="background-color: #f8f9fa;">
        
        <!-- Nav Tabs Modal -->
        <ul class="nav nav-tabs nav-tabs-bg mb-4 justify-content-center" id="syaratTab" role="tablist" style="border-bottom: 2px solid #dee2e6;">
          <li class="nav-item" role="presentation" style="flex: 1;">
            <button class="nav-link active w-100 font-weight-bold text-center py-2.5" id="modal-syarat-tab" data-bs-toggle="tab" data-bs-target="#modal-syarat" type="button" role="tab" aria-controls="modal-syarat" aria-selected="true" style="border-radius: 8px 8px 0 0; font-size: 0.9rem;">
              <i class="fa fa-list-check me-1 text-success"></i> Syarat Pendaftaran
            </button>
          </li>
          <li class="nav-item" role="presentation" style="flex: 1;">
            <button class="nav-link w-100 font-weight-bold text-center py-2.5" id="modal-biaya-tab" data-bs-toggle="tab" data-bs-target="#modal-biaya" type="button" role="tab" aria-controls="modal-biaya" aria-selected="false" style="border-radius: 8px 8px 0 0; font-size: 0.9rem;">
              <i class="fa fa-money-bill-wave me-1 text-success"></i> Rincian Biaya & Administrasi
            </button>
          </li>
        </ul>
        
        <!-- Tab Content Modal -->
        <div class="tab-content bg-white p-4 border rounded-3 shadow-sm" id="syaratTabContent" style="border-color: #dee2e6 !important;">
          <div class="tab-pane fade show active" id="modal-syarat" role="tabpanel" aria-labelledby="modal-syarat-tab">
            <div class="rich-text-container" style="max-height: 450px; overflow-y: auto;">
              <?php echo !empty($konfigurasi->syarat_pendaftaran) ? $konfigurasi->syarat_pendaftaran : '<p class="text-muted text-center py-4">Belum ada rincian persyaratan pendaftaran.</p>'; ?>
            </div>
          </div>
          <div class="tab-pane fade" id="modal-biaya" role="tabpanel" aria-labelledby="modal-biaya-tab">
            <div class="rich-text-container" style="max-height: 450px; overflow-y: auto;">
              <?php echo !empty($konfigurasi->rincian_administrasi) ? $konfigurasi->rincian_administrasi : '<p class="text-muted text-center py-4">Belum ada rincian biaya pendaftaran.</p>'; ?>
            </div>
          </div>
        </div>
        
      </div>
      <div class="modal-footer border-0 bg-white" style="border-radius: 0 0 14px 14px;">
        <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 8px;">Tutup</button>
      </div>
    </div>
  </div>
</div>

<style>
/* Styling khusus untuk Rich Text Editor (TinyMCE) Output */
.rich-text-container {
    color: #4b5563;
    font-size: 0.9rem;
    line-height: 1.65;
}
.rich-text-container p {
    margin-bottom: 0.75rem;
}
.rich-text-container h1, .rich-text-container h2, .rich-text-container h3, 
.rich-text-container h4, .rich-text-container h5, .rich-text-container h6 {
    color: #1f2937;
    font-weight: 700;
    margin-top: 1.25rem;
    margin-bottom: 0.5rem;
}
.rich-text-container h1 { font-size: 1.5rem; }
.rich-text-container h2 { font-size: 1.3rem; }
.rich-text-container h3 { font-size: 1.15rem; }
.rich-text-container h4 { font-size: 1.05rem; }

.rich-text-container ul, .rich-text-container ol {
    padding-left: 1.2rem;
    margin-bottom: 1rem;
}
.rich-text-container li {
    margin-bottom: 0.35rem;
}
.rich-text-container table {
    width: 100% !important;
    border-collapse: separate !important;
    border-spacing: 0 !important;
    margin-top: 1rem;
    margin-bottom: 1.25rem;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #e5e7eb !important;
    font-size: 0.85rem;
}
.rich-text-container table th, .rich-text-container table td {
    padding: 8px 12px !important;
    border-bottom: 1px solid #e5e7eb !important;
    border-right: 1px solid #e5e7eb !important;
    vertical-align: middle;
}
.rich-text-container table th {
    background-color: #f9fafb !important;
    font-weight: 700;
    color: #1f2937;
}
.rich-text-container table tr:last-child td {
    border-bottom: none !important;
}
.rich-text-container table td:last-child, .rich-text-container table th:last-child {
    border-right: none !important;
}

/* Custom Tabs (Clean & Professional) */
#pendaftaranInlineTab .nav-link, #syaratTab .nav-link {
    color: #6b7280;
    border: none;
    border-bottom: 2px solid transparent;
    background: none;
    transition: all 0.2s ease;
}
#pendaftaranInlineTab .nav-link.active, #syaratTab .nav-link.active {
    color: #146a39 !important;
    border-bottom: 2px solid #146a39;
    background: none;
}
#pendaftaranInlineTab .nav-link:hover:not(.active), #syaratTab .nav-link:hover:not(.active) {
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
}

/* Scrollbar styling */
.rich-text-container::-webkit-scrollbar {
    width: 6px;
}
.rich-text-container::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}
.rich-text-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
.rich-text-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Responsive Font Sizes and Padding */
.alert-heading-responsive {
    font-size: 1.1rem;
}
.alert-text-responsive {
    font-size: 0.95rem;
}
.main-title-responsive {
    font-size: 1.2rem;
}
.gelombang-title-responsive {
    font-size: 1.25rem;
}

@media (max-width: 768px) {
    .card-body.p-6, .card-body.p-4.p-md-6 {
        padding: 1.25rem !important;
    }
    .main-title-responsive {
        font-size: 1.1rem !important;
    }
    .gelombang-title-responsive {
        font-size: 1.1rem !important;
    }
    .alert-heading-responsive {
        font-size: 1.0rem !important;
    }
    .alert-text-responsive {
        font-size: 0.85rem !important;
        line-height: 1.5 !important;
    }
    .alert-text-responsive p {
        font-size: 0.85rem !important;
    }
    .alert-text-responsive li {
        font-size: 0.85rem !important;
        margin-bottom: 0.25rem !important;
    }
    .rich-text-container {
        font-size: 0.85rem !important;
    }
}

@media (max-width: 576px) {
    .card-body.p-6, .card-body.p-4.p-md-6 {
        padding: 1.0rem !important;
    }
    .main-title-responsive {
        font-size: 1.0rem !important;
    }
    .gelombang-title-responsive {
        font-size: 1.0rem !important;
    }
    .alert-heading-responsive {
        font-size: 0.9rem !important;
    }
    .alert-text-responsive {
        font-size: 0.8rem !important;
    }
    .alert-text-responsive p {
        font-size: 0.8rem !important;
    }
    .alert-text-responsive li {
        font-size: 0.8rem !important;
    }
}
</style>
