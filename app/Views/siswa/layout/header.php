<?php 
use App\Models\Konfigurasi_model;
$session = \Config\Services::session();
$konfigurasi  = new Konfigurasi_model;
$site         = $konfigurasi->listing();
?>
<!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item d-flex align-items-center">
        <a href="<?php echo base_url('siswa/dasbor') ?>" class="navbar-brand font-weight-bold text-primary mr-2 mr-sm-3" style="font-size: 1.15rem; text-decoration: none !important;">
          <i class="fa fa-graduation-cap mr-1"></i><span class="d-none d-sm-inline"><?php echo esc($site->singkatan) ?></span>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo base_url('siswa/dasbor') ?>" class="nav-link font-weight-bold" style="text-decoration: none !important;">
          <i class="fa fa-tachometer-alt mr-1"></i>Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a href="<?php echo base_url() ?>" class="nav-link" target="_blank" style="text-decoration: none !important;">
          <i class="fa fa-globe mr-1"></i>Beranda
        </a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    
      <li class="nav-item d-none d-md-inline-block">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      
      <li class="nav-item">
        <a href="<?php echo base_url('siswa/akun') ?>" class="nav-link">
          <i class="fa fa-user mr-1"></i><span class="d-none d-sm-inline"><?php echo Session()->get('nama_siswa') ?></span></a>
      </li>
      <li class="nav-item">
        <a href="<?php echo base_url('signin/logout') ?>" class="nav-link text-danger">
          <i class="fa fa-sign-out-alt"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->