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
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <!-- Dashboard -->
        <li class="nav-item">
          <a href="<?php echo base_url('admin/dasbor') ?>" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <?php if ($IS_ADMIN) { ?>
        <!-- Log Aktivitas -->
        <li class="nav-item">
          <a href="<?php echo base_url('admin/log') ?>" class="nav-link <?php if($uri->getSegment(2)=="log"){echo 'active';}?>">
            <i class="nav-icon fas fa-history text-danger"></i>
            <p>Log Aktivitas Admin</p>
          </a>
        </li>
        <?php } ?>

        <!-- ================== SPMB ================== -->
        <?php if ($this->website->fitur_pendaftaran()=='On' && ($IS_ADMIN || $IS_USER || $IS_SPMB)) { 
          $spmb_segments = ['gelombang', 'pendaftar', 'akun_pendaftar', 'jenis_dokumen', 'analisis'];
          $is_spmb_active = in_array($uri->getSegment(2), $spmb_segments) || ($uri->getSegment(2) == 'konfigurasi' && in_array($uri->getSegment(3), ['pendaftaran', 'pembayaran']));
        ?>
        <li class="nav-item <?php if($is_spmb_active){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($is_spmb_active){echo 'active';}?>">
            <i class="nav-icon fas fa-graduation-cap"></i>
            <p>SPMB Online <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/analisis') ?>" class="nav-link <?php if($uri->getSegment(2)=="analisis"){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon text-info"></i>
                <p>Analisis Statistik SPMB</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/gelombang') ?>" class="nav-link <?php if($uri->getSegment(2)=="gelombang"){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Periode SPMB</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/konfigurasi/pendaftaran') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Buka/Tutup SPMB</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/konfigurasi/pembayaran') ?>" class="nav-link <?php if($uri->getSegment(3)=="pembayaran"){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Biaya & Persyaratan</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="<?php echo base_url('admin/pendaftar') ?>" class="nav-link" >
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Data Pendaftar</p>
              </a>
            </li> -->
            <li class="nav-item">
              <a href="<?php echo base_url('admin/akun_pendaftar') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Akun Calon Siswa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/jenis_dokumen') ?>" class="nav-link <?php if($uri->getSegment(2)=="jenis_dokumen"){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Jenis Dokumen SPMB</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>

        <!-- ================== BERITA ================== -->
        <?php if ($IS_ADMIN || $IS_USER || $IS_KONTEN) { ?>
        <li class="nav-item <?php if($uri->getSegment(2)=="berita" || $uri->getSegment(2)=="kategori"){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($uri->getSegment(2)=="berita" || $uri->getSegment(2)=="kategori"){echo 'active';}?>">
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

        <!-- ================== PROFIL (Sejarah, Visi Misi, Sambutan, Keunggulan) ================== -->
        <li class="nav-item <?php if(in_array($uri->getSegment(2), ['profil','keunggulan','visi_misi','sambutan'])){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if(in_array($uri->getSegment(2), ['profil','keunggulan','visi_misi','sambutan'])){echo 'active';}?>">
            <i class="nav-icon fas fa-id-card"></i>
            <p>Profil <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/profil') ?>" class="nav-link <?php if($uri->getSegment(2)=='profil'){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Profil &amp; Sejarah Sekolah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/visi_misi') ?>" class="nav-link <?php if($uri->getSegment(2)=='visi_misi'){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Visi &amp; Misi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/sambutan') ?>" class="nav-link <?php if($uri->getSegment(2)=='sambutan'){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Sambutan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/keunggulan') ?>" class="nav-link <?php if($uri->getSegment(2)=='keunggulan'){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Keunggulan</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>

        <!-- ================== GALERI FOTO ================== -->
        <?php if ($IS_ADMIN || $IS_USER || $IS_KONTEN) { ?>
        <li class="nav-item <?php if($uri->getSegment(2)=="galeri" || $uri->getSegment(2)=="kategori_galeri"){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($uri->getSegment(2)=="galeri" || $uri->getSegment(2)=="kategori_galeri"){echo 'active';}?>">
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

        <!-- ================== MEDIA WEB (SLIDER & POP UP) ================== -->
        <li class="nav-item <?php if(in_array($uri->getSegment(2), ['slider', 'popup'])){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if(in_array($uri->getSegment(2), ['slider', 'popup'])){echo 'active';}?>">
            <i class="nav-icon fas fa-desktop"></i>
            <p>Media Web <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/slider') ?>" class="nav-link <?php if($uri->getSegment(2)=="slider"){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Slider Homepage</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/popup') ?>" class="nav-link <?php if($uri->getSegment(2)=="popup"){echo 'active';}?>">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Pop Up</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>


        <!-- ================== DOWNLOAD ================== -->
        <?php if ($SHOW_ALL) { ?>
        <li class="nav-item <?php if($uri->getSegment(2)=="download" || $uri->getSegment(2)=="kategori_download"){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($uri->getSegment(2)=="download" || $uri->getSegment(2)=="kategori_download"){echo 'active';}?>">
            <i class="nav-icon fas fa-upload"></i>
            <p>File &amp; Download<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/download') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Data File &amp; Download</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/download/tambah') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Tambah File &amp; Download</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/kategori_download') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Kategori File &amp; Download</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>

        <!-- ================== PRESTASI & PENGHARGAAN ================== -->
        <?php if ($IS_ADMIN || $IS_USER || $IS_KONTEN) { ?>
        <li class="nav-item <?php if($uri->getSegment(2)=="prestasi" || $uri->getSegment(2)=="kategori_prestasi"){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($uri->getSegment(2)=="prestasi" || $uri->getSegment(2)=="kategori_prestasi"){echo 'active';}?>">
            <i class="nav-icon fas fa-certificate"></i>
            <p>Prestasi &amp; Penghargaan <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/prestasi') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Data Prestasi Penghargaan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/prestasi/tambah') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Tambah Prestasi Penghargaan</p>
              </a>
            </li>
            <?php if ($IS_ADMIN || $IS_USER) { ?>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/kategori_prestasi') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Kategori Prestasi Penghargaan</p>
              </a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <?php } ?>

        <!-- ================== EVENT (tetap sesuai aslinya: commented) ================== -->
         <!--<li class="nav-item <?php if($uri->getSegment(2)=="agenda" || $uri->getSegment(2)=="kategori_agenda"){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($uri->getSegment(2)=="agenda" || $uri->getSegment(2)=="kategori_agenda"){echo 'active';}?>">
            <i class="nav-icon fas fa-calendar-check"></i>
            <p>Event &amp; Agenda <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/agenda') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Data Event &amp; Agenda</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/agenda/tambah') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Tambah Event &amp; Agenda</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/kategori_agenda') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Kategori Event &amp; Agenda</p>
              </a>
            </li>
          </ul>
        </li> -->

        <!-- ================== VIDEO ================== -->
        <?php if ($IS_ADMIN || $IS_USER || $IS_KONTEN) { ?>
        <li class="nav-item">
          <a href="<?php echo base_url('admin/video') ?>" class="nav-link <?php if($uri->getSegment(2)=="video"){echo 'active';}?>">
            <i class="nav-icon fab fa-youtube"></i>
            <p>Video Youtube</p>
          </a>
        </li>
        <?php } ?>

        <!-- ================== PORTFOLIO (tetap sesuai aslinya: commented) ================== -->
        <!-- li class="nav-item <?php if($uri->getSegment(2)=="portfolio" || $uri->getSegment(2)=="kategori_portfolio"){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($uri->getSegment(2)=="portfolio" || $uri->getSegment(2)=="kategori_portfolio"){echo 'active';}?>">
            <i class="nav-icon fas fa-tasks"></i>
            <p>Karya &amp; Portfolio <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/portfolio') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Data Karya &amp; Portfolio</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/portfolio/tambah') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Tambah Karya &amp; Portfolio</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/kategori_portfolio') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Kategori Karya &amp; Portfolio</p>
              </a>
            </li>
          </ul>
        </li> -->

        <!-- ================== FASILITAS ================== -->
        <?php if ($SHOW_ALL) { ?>
        <li class="nav-item <?php if($uri->getSegment(2)=="fasilitas" || $uri->getSegment(2)=="kategori_fasilitas"){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($uri->getSegment(2)=="fasilitas" || $uri->getSegment(2)=="kategori_fasilitas"){echo 'active';}?>">
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

        <!-- ================== EKSTRAKURIKULER ================== -->
        <?php if ($SHOW_ALL) { ?>
        <li class="nav-item <?php if($uri->getSegment(2)=="ekstrakurikuler" || $uri->getSegment(2)=="kategori_ekstrakurikuler"){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($uri->getSegment(2)=="ekstrakurikuler" || $uri->getSegment(2)=="kategori_ekstrakurikuler"){echo 'active';}?>">
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

        <!-- ================== PROGRAM PENDIDIKAN (konten) ================== -->
        <?php if ($SHOW_ALL) { ?>
        <li class="nav-item <?php if($uri->getSegment(2)=="program_pendidikan"){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($uri->getSegment(2)=="program_pendidikan"){echo 'active';}?>">
            <i class="nav-icon fas fa-graduation-cap"></i>
            <p>Program Pendidikan <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/program_pendidikan') ?>" class="nav-link" >
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Data Program Pendidikan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/program_pendidikan/tambah') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Tambah Program Pendidikan</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item <?php if($uri->getSegment(2)=="yayasan"){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($uri->getSegment(2)=="yayasan"){echo 'active';}?>">
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
                <p>Tambah Yayasan</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>

        <!-- ================== AKADEMIK (tetap sesuai aslinya: commented) ================== -->
        <!-- 
        <li class="nav-item <?php if($uri->getSegment(2)=="siswa" || $uri->getSegment(2)=="rombel" || $uri->getSegment(2)=="tahun" || $uri->getSegment(2)=="kelas"){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($uri->getSegment(2)=="siswa" || $uri->getSegment(2)=="rombel" || $uri->getSegment(2)=="tahun" || $uri->getSegment(2)=="kelas"){echo 'active';}?>">
            <i class="nav-icon fas fa-graduation-cap"></i>
            <p>Manajemen Siswa <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/siswa') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Master Siswa</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo base_url('admin/rombel') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Rombongan Belajar</p>
              </a>
            </li>
            
            <li class="nav-item">
              <a href="<?php echo base_url('admin/tahun') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Master Tahun Ajaran</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/kelas') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Master Kelas</p>
              </a>
            </li>
          </ul>
        </li>
        -->

        <!-- ================== CLIENT (tetap sesuai aslinya: commented) ================== -->
        <!-- li class="nav-item <?php if($uri->getSegment(2)=="client" || $uri->getSegment(2)=="kategori_client"){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($uri->getSegment(2)=="client" || $uri->getSegment(2)=="kategori_client"){echo 'active';}?>">
            <i class="nav-icon fas fa-user-check"></i>
            <p>Data Client &amp; Mitra <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('admin/client') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Data Client &amp; Mitra</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/client/tambah') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Tambah Client &amp; Mitra</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/kategori_client') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Kategori Client &amp; Mitra</p>
              </a>
            </li>
          </ul>
        </li> -->

        <!-- ================== TEAM & STAFF ================== -->
        <?php if ($SHOW_ALL) { ?>
        <li class="nav-item <?php if($uri->getSegment(2)=="staff" || $uri->getSegment(2)=="kategori_staff"){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($uri->getSegment(2)=="staff" || $uri->getSegment(2)=="kategori_staff"){echo 'active';}?>">
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
                <p>Tambah Guru &amp; Staff</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/kategori_staff') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Kategori Guru &amp; Staff</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>

        <!-- ================== MASTER DATA ================== -->
        <?php if ($SHOW_ALL || $IS_SPMB) { ?>
        <li class="nav-item <?php if($uri->getSegment(2)=="link_website" || $uri->getSegment(2)=="jenjang" || $uri->getSegment(2)=="hubungan" || $uri->getSegment(2)=="pekerjaan" || $uri->getSegment(2)=="agama"){echo 'menu-open';}?>">
          <a href="#" class="nav-link <?php if($uri->getSegment(2)=="link_website" || $uri->getSegment(2)=="jenjang" || $uri->getSegment(2)=="hubungan" || $uri->getSegment(2)=="pekerjaan" || $uri->getSegment(2)=="agama"){echo 'active';}?>">
            <i class="nav-icon fas fa-table"></i>
            <p>Master Data <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <?php if ($SHOW_ALL) { ?>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/link_website') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Link Website</p>
              </a>
            </li>
            <?php } ?>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/jenjang') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Jenjang Pendidikan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/hubungan') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Hubungan Keluarga</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/pekerjaan') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Jenis Pekerjaan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('admin/agama') ?>" class="nav-link">
                <i class="fa fa-arrow-right nav-icon"></i>
                <p>Agama</p>
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>

        <!-- ================== ADMIN-ONLY ================== -->
        <?php if ($IS_ADMIN) { ?>

          <!-- Menu Website -->
          <li class="nav-item">
            <a href="<?php echo base_url('admin/menu') ?>" class="nav-link <?php if($uri->getSegment(2)=="menu"){echo 'active';}?>">
              <i class="nav-icon fa fa-sitemap"></i>
              <p>Menu Website</p>
            </a>
          </li>

          <!-- Pengguna Sistem -->
          <li class="nav-item">
            <a href="<?php echo base_url('admin/user') ?>" class="nav-link <?php if($uri->getSegment(2)=="user"){echo 'active';}?>">
              <i class="nav-icon fas fa-user-lock"></i>
              <p>Pengguna Sistem</p>
            </a>
          </li>

          <!-- Setting Aplikasi -->
          <li class="nav-item <?php if($uri->getSegment(2)=="konfigurasi"){echo 'menu-open';}?>">
            <a href="#" class="nav-link <?php if($uri->getSegment(2)=="konfigurasi"){echo 'active';}?>">
              <i class="nav-icon fas fa-cog"></i>
              <p>Setting Aplikasi <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url('admin/konfigurasi') ?>" class="nav-link <?php if($uri->getSegment(2)=="konfigurasi" && $uri->getSegment(3)==""){echo 'active';}?>">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Setting Aplikasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/konfigurasi/email') ?>" class="nav-link <?php if($uri->getSegment(3)=="email"){echo 'active';}?>">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Setting Email</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url('admin/konfigurasi/banner') ?>" class="nav-link <?php if($uri->getSegment(3)=="banner"){echo 'active';}?>">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>About Us &amp; Banner</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/konfigurasi/logo') ?>" class="nav-link <?php if($uri->getSegment(3)=="logo"){echo 'active';}?>">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Ganti Logo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/konfigurasi/chatbot') ?>" class="nav-link <?php if($uri->getSegment(3)=="chatbot"){echo 'active';}?>">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Ikon Chatbot</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/konfigurasi/icon') ?>" class="nav-link <?php if($uri->getSegment(3)=="icon"){echo 'active';}?>">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Ganti Icon</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/konfigurasi/login') ?>" class="nav-link <?php if($uri->getSegment(3)=="login"){echo 'active';}?>">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Background Login</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/jenis_dokumen') ?>" class="nav-link <?php if($uri->getSegment(2)=="jenis_dokumen"){echo 'active';}?>">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Jenis Dokumen Pendaftaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/konfigurasi/sekolah') ?>" class="nav-link <?php if($uri->getSegment(3)=="sekolah"){echo 'active';}?>">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Informasi Sekolah</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('admin/konfigurasi/seo') ?>" class="nav-link <?php if($uri->getSegment(3)=="seo"){echo 'active';}?>">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>SEO dan Google Webmaster</p>
                </a>
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
