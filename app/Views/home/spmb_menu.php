<?php 
$session = Session();
$is_logged_in = !empty($session->get('username_siswa'));
$nama_siswa = $session->get('nama');
?>
<?php if ($site->fitur_pendaftaran == 'On') { ?>
<section class="wrapper bg-light pt-4 pb-4">
  <div class="container">
    <div class="card border-0 shadow-sm" style="border-radius: 12px; background: #ffffff; border: 1px solid #e5e7eb !important; box-shadow: 0 4px 15px rgba(0,0,0,0.03) !important;">
      <div class="card-body p-4 py-4 px-md-5 py-md-4">
        <div class="row align-items-center gy-3">
          
          <!-- Sisi Kiri: Informasi PPDB -->
          <div class="col-lg-8 text-center text-lg-start">
            <div class="d-flex flex-column flex-lg-row align-items-center mb-1">
              <span class="badge text-white px-3 py-1.5 mb-2 mb-lg-0 me-lg-3 d-inline-block" style="background-color: #146a39; border-radius: 20px; font-size: 11.5px; font-weight: bold; letter-spacing: 0.5px;">
                INFO PPDB
              </span>
              <div class="text-dark font-weight-bold fs-17 mb-0">
                Penerimaan Peserta Didik Baru (PPDB) Online Telah Dibuka!
              </div>
            </div>
            <div class="text-muted fs-14 d-none d-lg-block">
              <?php if ($is_logged_in) { ?>
                Silakan masuk ke portal siswa untuk melengkapi berkas atau cek hasil kelulusan Anda.
              <?php } else { ?>
                Silakan lakukan pendaftaran online atau cek hasil kelulusan Anda di bawah ini.
              <?php } ?>
            </div>
          </div>
          
          <!-- Sisi Kanan: Kumpulan Tombol Aksi (Daftar / Portal Siswa & Cek Kelulusan) -->
          <div class="col-lg-4">
            <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-lg-end align-items-center">
              
              <?php if ($is_logged_in) { ?>
                <!-- Jika sudah login: Tombol Daftar berubah menjadi Portal Siswa -->
                <a href="<?php echo base_url('siswa/dasbor') ?>" class="btn text-white btn-sm px-4 py-2.5" style="background-color: #146a39; border-color: #146a39; border-radius: 8px; font-size: 14px; font-weight: bold; transition: all 0.2s;">
                  <i class="fa fa-user-circle me-1"></i> Portal Siswa
                </a>
              <?php } else { ?>
                <!-- Jika belum login: Tombol Daftar biasa -->
                <a href="<?php echo base_url('pendaftaran') ?>" class="btn text-white btn-sm px-4 py-2.5" style="background-color: #146a39; border-color: #146a39; border-radius: 8px; font-size: 14px; font-weight: bold; transition: all 0.2s;">
                  <i class="fa fa-user-plus me-1"></i> Daftar Online
                </a>
              <?php } ?>
              
              <a href="<?php echo base_url('check') ?>" class="btn btn-outline-warning-custom btn-sm px-4 py-2.5" style="border-radius: 8px; font-size: 14px; font-weight: bold; transition: all 0.2s;">
                <i class="fa fa-search me-1"></i> Cek Kelulusan
              </a>
              
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<style>
.btn-outline-warning-custom {
  color: #d97706 !important;
  border: 1.5px solid #d97706 !important;
  background-color: transparent !important;
}
.btn-outline-warning-custom:hover {
  color: #ffffff !important;
  background-color: #d97706 !important;
}
</style>
<?php } ?>
