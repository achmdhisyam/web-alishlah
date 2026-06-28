<?php 
$akses = Session()->get('akses_level');
$uri   = service('uri');
$IS_ADMIN  = ($akses === 'Admin');
$IS_USER   = ($akses === 'User');
$IS_SPMB   = ($akses === 'spmb');
$IS_KONTEN = ($akses === 'konten');
$SHOW_ALL  = ($IS_ADMIN || $IS_USER); // User seperti admin, kecuali 3 menu admin-only
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-lightblue elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo base_url('admin/dasbor') ?>" class="brand-link">
    <img src="<?php echo $this->website->icon() ?>" alt="<?php echo $this->website->namaweb() ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><?php echo $this->website->singkatan() ?></span>
  </a>

  <style type="text/css" media="screen">
    nav ul li ul li i {
      color: yellow;
      margin-left: 10px;
    }
  </style>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <?php
      $seg2 = $uri->getSegment(2);
      $seg3 = $uri->getSegment(3);

      $active_dasbor = in_array($seg2, ['dasbor', 'log', 'analisis']);
      $active_ppdb   = in_array($seg2, ['gelombang', 'akun_pendaftar', 'jenis_dokumen']) || ($seg2 == 'konfigurasi' && in_array($seg3, ['pendaftaran', 'pembayaran']));
      $active_konten = in_array($seg2, ['berita', 'kategori', 'profil', 'keunggulan', 'visi_misi', 'sambutan', 'galeri', 'kategori_galeri', 'slider', 'popup', 'download', 'kategori_download', 'prestasi', 'kategori_prestasi', 'video', 'fasilitas', 'kategori_fasilitas', 'ekstrakurikuler', 'kategori_ekstrakurikuler', 'program_pendidikan', 'yayasan', 'link_website']);
      $active_config = in_array($seg2, ['menu', 'user', 'jenjang', 'hubungan', 'pekerjaan', 'agama']) || ($seg2 == 'konfigurasi' && !in_array($seg3, ['pendaftaran', 'pembayaran']));
      ?>
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <!-- ================== CATEGORY 1: DASBOR & ANALITIS ================== -->
        <li class="nav-item <?php if($active_dasbor){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($active_dasbor){echo 'active';}?>">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>
              Dasbor &amp; Analitis
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/dasbor') ?>" class="nav-link <?php if($seg2=='dasbor'){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Dashboard Utama</p>
              </a>
            </li>
            <?php if ($IS_ADMIN) { ?>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/log') ?>" class="nav-link <?php if($seg2=="log"){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon text-danger"></i>
                <p>Log Aktivitas Admin</p>
              </a>
            </li>
            <?php } ?>
            <?php if ($this->website->fitur_pendaftaran()=='On' && ($IS_ADMIN || $IS_USER || $IS_SPMB)) { ?>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/analisis') ?>" class="nav-link <?php if($seg2=="analisis"){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon text-info"></i>
                <p>Statistik SPMB</p>
              </a>
            </li>
            <?php } ?>
          </ul>
        </li>

        <!-- ================== CATEGORY 2: OPERASIONAL PPDB ================== -->
        <?php if ($this->website->fitur_pendaftaran()=='On' && ($IS_ADMIN || $IS_USER || $IS_SPMB)) { ?>
        <li class="nav-item <?php if($active_ppdb){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($active_ppdb){echo 'active';}?>">
            <i class="nav-icon fas fa-graduation-cap"></i>
            <p>
              Operasional PPDB
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/gelombang') ?>" class="nav-link <?php if($seg2=="gelombang"){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Periode Gelombang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/konfigurasi/pendaftaran') ?>" class="nav-link <?php if($seg2=='konfigurasi' && $seg3=='pendaftaran'){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Buka/Tutup Pendaftaran</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/konfigurasi/pembayaran') ?>" class="nav-link <?php if($seg2=='konfigurasi' && $seg3=='pembayaran'){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Biaya &amp; Syarat</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/akun_pendaftar') ?>" class="nav-link <?php if($seg2=='akun_pendaftar'){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Akun Calon Siswa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/jenis_dokumen') ?>" class="nav-link <?php if($seg2=="jenis_dokumen"){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Jenis Dokumen Syarat</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>

        <!-- ================== CATEGORY 3: MANAJEMEN KONTEN ================== -->
        <?php if ($IS_ADMIN || $IS_USER || $IS_KONTEN) { ?>
        <li class="nav-item <?php if($active_konten){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($active_konten){echo 'active';}?>">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Manajemen Konten
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <!-- Berita Sub-menu -->
            <li class="nav-item <?php if($seg2=="berita" || $seg2=="kategori"){echo 'menu-open';}?>">
              <a href="#" class="nav-link <?php if($seg2=="berita" || $seg2=="kategori"){echo 'active';}?>">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>Berita <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/berita') ?>" class="nav-link" >
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Data Berita</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/berita/tambah') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Tambah Berita</p>
                  </a>
                </li>
                <?php if ($IS_ADMIN || $IS_USER) { ?>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/kategori') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Kategori Berita</p>
                  </a>
                </li>
                <?php } ?>
              </ul>
            </li>

            <!-- Profil Sub-menu -->
            <li class="nav-item <?php if(in_array($seg2, ['profil','keunggulan','visi_misi','sambutan'])){echo 'menu-open';}?>">
              <a href="#" class="nav-link <?php if(in_array($seg2, ['profil','keunggulan','visi_misi','sambutan'])){echo 'active';}?>">
                <i class="nav-icon fas fa-id-card"></i>
                <p>Profil Sekolah <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/profil') ?>" class="nav-link <?php if($seg2=='profil'){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Sejarah Sekolah</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/visi_misi') ?>" class="nav-link <?php if($seg2=='visi_misi'){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Visi &amp; Misi</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/sambutan') ?>" class="nav-link <?php if($seg2=='sambutan'){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Sambutan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/keunggulan') ?>" class="nav-link <?php if($seg2=='keunggulan'){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Keunggulan</p>
                  </a>
                </li>
              </ul>
            </li>

            <!-- Galeri Foto -->
            <li class="nav-item <?php if($seg2=="galeri" || $seg2=="kategori_galeri"){echo 'menu-open';}?>">
              <a href="#" class="nav-link <?php if($seg2=="galeri" || $seg2=="kategori_galeri"){echo 'active';}?>">
                <i class="nav-icon fas fa-images"></i>
                <p>Galeri Foto <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/galeri') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Data Galeri Foto</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/galeri/tambah') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Tambah Foto Galeri</p>
                  </a>
                </li>
                <?php if ($IS_ADMIN || $IS_USER) { ?>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/kategori_galeri') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Kategori Galeri</p>
                  </a>
                </li>
                <?php } ?>
              </ul>
            </li>

            <!-- Media Web -->
            <li class="nav-item <?php if(in_array($seg2, ['slider', 'popup'])){echo 'menu-open';}?>">
              <a href="#" class="nav-link <?php if(in_array($seg2, ['slider', 'popup'])){echo 'active';}?>">
                <i class="nav-icon fas fa-desktop"></i>
                <p>Media Web <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/slider') ?>" class="nav-link <?php if($seg2=="slider"){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Slider Homepage</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/popup') ?>" class="nav-link <?php if($seg2=="popup"){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Pop Up Promo</p>
                  </a>
                </li>
              </ul>
            </li>

            <!-- File & Download -->
            <?php if ($SHOW_ALL) { ?>
            <li class="nav-item <?php if($seg2=="download" || $seg2=="kategori_download"){echo 'menu-open';}?>">
              <a href="#" class="nav-link <?php if($seg2=="download" || $seg2=="kategori_download"){echo 'active';}?>">
                <i class="nav-icon fas fa-upload"></i>
                <p>File &amp; Download <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/download') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Data File Download</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/download/tambah') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Tambah File</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/kategori_download') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Kategori File</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php } ?>

            <!-- Prestasi & Penghargaan -->
            <li class="nav-item <?php if($seg2=="prestasi" || $seg2=="kategori_prestasi"){echo 'menu-open';}?>">
              <a href="#" class="nav-link <?php if($seg2=="prestasi" || $seg2=="kategori_prestasi"){echo 'active';}?>">
                <i class="nav-icon fas fa-certificate"></i>
                <p>Prestasi <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/prestasi') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Data Prestasi</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/prestasi/tambah') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Tambah Prestasi</p>
                  </a>
                </li>
                <?php if ($IS_ADMIN || $IS_USER) { ?>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/kategori_prestasi') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Kategori Prestasi</p>
                  </a>
                </li>
                <?php } ?>
              </ul>
            </li>

            <!-- Video Youtube -->
            <li class="nav-item">
              <a href="<?php echo base_url('admin/video') ?>" class="nav-link <?php if($seg2=="video"){echo 'active';}?>">
                <i class="nav-icon fab fa-youtube"></i>
                <p>Video Youtube</p>
              </a>
            </li>

            <!-- Fasilitas -->
            <?php if ($SHOW_ALL) { ?>
            <li class="nav-item <?php if($seg2=="fasilitas" || $seg2=="kategori_fasilitas"){echo 'menu-open';}?>">
              <a href="#" class="nav-link <?php if($seg2=="fasilitas" || $seg2=="kategori_fasilitas"){echo 'active';}?>">
                <i class="nav-icon fas fa-home"></i>
                <p>Fasilitas <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/fasilitas') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Data Fasilitas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/fasilitas/tambah') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Tambah Fasilitas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/kategori_fasilitas') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Kategori Fasilitas</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php } ?>

            <!-- Ekstrakurikuler -->
            <?php if ($SHOW_ALL) { ?>
            <li class="nav-item <?php if($seg2=="ekstrakurikuler" || $seg2=="kategori_ekstrakurikuler"){echo 'menu-open';}?>">
              <a href="#" class="nav-link <?php if($seg2=="ekstrakurikuler" || $seg2=="kategori_ekstrakurikuler"){echo 'active';}?>">
                <i class="nav-icon fas fa-futbol"></i>
                <p>Ekstrakurikuler <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/ekstrakurikuler') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Data Ekstrakurikuler</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/ekstrakurikuler/tambah') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Tambah Ekstrakurikuler</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/kategori_ekstrakurikuler') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Kategori Ekstrakurikuler</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php } ?>

            <!-- Program Pendidikan -->
            <?php if ($SHOW_ALL) { ?>
            <li class="nav-item <?php if($seg2=="program_pendidikan"){echo 'menu-open';}?>">
              <a href="#" class="nav-link <?php if($seg2=="program_pendidikan"){echo 'active';}?>">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p>Program Pendidikan <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/program_pendidikan') ?>" class="nav-link" >
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Data Program</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/program_pendidikan/tambah') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Tambah Program</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php } ?>

            <!-- Yayasan -->
            <?php if ($SHOW_ALL) { ?>
            <li class="nav-item <?php if($seg2=="yayasan"){echo 'menu-open';}?>">
              <a href="#" class="nav-link <?php if($seg2=="yayasan"){echo 'active';}?>">
                <i class="nav-icon fas fa-building"></i>
                <p>Informasi Yayasan <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/yayasan') ?>" class="nav-link" >
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Data Yayasan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/yayasan/tambah') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Tambah Informasi</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php } ?>

            <!-- Guru & Staff -->
            <?php if ($SHOW_ALL) { ?>
            <li class="nav-item <?php if($seg2=="staff" || $seg2=="kategori_staff"){echo 'menu-open';}?>">
              <a href="#" class="nav-link <?php if($seg2=="staff" || $seg2=="kategori_staff"){echo 'active';}?>">
                <i class="nav-icon fas fa-chair"></i>
                <p>Guru &amp; Staff <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/staff') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Data Guru &amp; Staff</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/staff/tambah') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Tambah Staff</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/kategori_staff') ?>" class="nav-link">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Kategori Guru/Staff</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php } ?>

            <!-- Link Website -->
            <?php if ($SHOW_ALL) { ?>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/link_website') ?>" class="nav-link <?php if($seg2=="link_website"){echo 'active';}?>">
                <i class="nav-icon fas fa-link"></i>
                <p>Link Website</p>
              </a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>

        <!-- ================== CATEGORY 4: PENGATURAN SISTEM ================== -->
        <?php if ($IS_ADMIN || $SHOW_ALL || $IS_SPMB) { ?>
        <li class="nav-item <?php if($active_config){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($active_config){echo 'active';}?>">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Pengaturan Sistem
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <!-- Menu Website (Admin only) -->
            <?php if ($IS_ADMIN) { ?>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/menu') ?>" class="nav-link <?php if($seg2=="menu"){echo 'active';}?>">
                <i class="fa fa-sitemap nav-icon"></i>
                <p>Menu Website</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/user') ?>" class="nav-link <?php if($seg2=="user"){echo 'active';}?>">
                <i class="fas fa-user-lock nav-icon"></i>
                <p>Pengguna Sistem</p>
              </a>
            </li>
            <?php } ?>

            <!-- Setting Aplikasi Sub-menu -->
            <?php if ($IS_ADMIN) { ?>
            <li class="nav-item <?php if($seg2=="konfigurasi" && !in_array($seg3, ['pendaftaran', 'pembayaran'])){echo 'menu-open';}?>">
              <a href="#" class="nav-link <?php if($seg2=="konfigurasi" && !in_array($seg3, ['pendaftaran', 'pembayaran'])){echo 'active';}?>">
                <i class="nav-icon fas fa-cog"></i>
                <p>Konfigurasi Web <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/konfigurasi') ?>" class="nav-link <?php if($seg2=="konfigurasi" && $seg3==""){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Setting Utama</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/konfigurasi/email') ?>" class="nav-link <?php if($seg3=="email"){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Setting Email SMTP</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/konfigurasi/banner') ?>" class="nav-link <?php if($seg3=="banner"){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>About Us &amp; Banner</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/konfigurasi/logo') ?>" class="nav-link <?php if($seg3=="logo"){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Ganti Logo</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/konfigurasi/chatbot') ?>" class="nav-link <?php if($seg3=="chatbot"){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Ikon Chatbot</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/konfigurasi/icon') ?>" class="nav-link <?php if($seg3=="icon"){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Ganti Icon</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/konfigurasi/login') ?>" class="nav-link <?php if($seg3=="login"){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Background Login</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/konfigurasi/sekolah') ?>" class="nav-link <?php if($seg3=="sekolah"){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Informasi Sekolah</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/konfigurasi/seo') ?>" class="nav-link <?php if($seg3=="seo"){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>SEO &amp; Webmaster</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php } ?>

            <!-- Master Data Sub-menu -->
            <li class="nav-item <?php if(in_array($seg2, ['jenjang', 'hubungan', 'pekerjaan', 'agama'])){echo 'menu-open';}?>">
              <a href="#" class="nav-link <?php if(in_array($seg2, ['jenjang', 'hubungan', 'pekerjaan', 'agama'])){echo 'active';}?>">
                <i class="nav-icon fas fa-table"></i>
                <p>Master Referensi <i class="right fas fa-angle-left"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/jenjang') ?>" class="nav-link <?php if($seg2=='jenjang'){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Jenjang Pendidikan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/hubungan') ?>" class="nav-link <?php if($seg2=='hubungan'){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Hubungan Keluarga</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/pekerjaan') ?>" class="nav-link <?php if($seg2=='pekerjaan'){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Jenis Pekerjaan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?php echo base_url('admin/agama') ?>" class="nav-link <?php if($seg2=='agama'){echo 'active';}?>">
                    <i class="fa fa-arrow-right nav-icon"></i>
                    <p>Agama</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <?php } ?>

      </ul>
      <br><br><br>
      <br><br><br>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1><?php echo $title ?></h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Default box -->
          <div class="card">
            <!-- <div class="card-header">
              <h3 class="card-title"><?php echo $title ?></h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div> -->
            <div class="card-body pt-4" style="min-height: 400px;">

              <?php 
              $validation = \Config\Services::validation();
              $errors = $validation->getErrors();
              if(!empty($errors))
              {
                  echo '<span class="text-danger">'.$validation->listErrors().'</span>';
              }
              ?>

              <?= session()->getFlashdata('error') ?>
              <?= validation_list_errors() ?>

              <?php if (session('msg')) : ?>
                <div class="alert alert-info alert-dismissible">
                    <?= session('msg') ?>
                    <button type="button" class="close" data-dismiss="alert"><span>x</span></button>
                </div>
              <?php endif ?>
