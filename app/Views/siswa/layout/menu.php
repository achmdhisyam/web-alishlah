<?php 
use App\Models\Konfigurasi_model;
$session = \Config\Services::session();
$konfigurasi  = new Konfigurasi_model;
$site         = $konfigurasi->listing();
?>
<style type="text/css" media="screen">
  /* Sembunyikan sidebar kiri */
  .main-sidebar {
    display: none !important;
  }
  /* Set margin-left ke 0 agar full-width */
  .main-header,
  .content-wrapper {
    margin-left: 0 !important;
  }
  /* Sembunyikan tombol pushmenu hamburger */
  [data-widget="pushmenu"] {
    display: none !important;
  }
  /* Center the layout maximum width for readability on wide screens */
  .content-wrapper > .content {
    max-width: 1000px;
    margin: 0 auto;
    padding: 15px;
  }
  .content-wrapper > .content-header {
    max-width: 1000px;
    margin: 0 auto;
  }
  @media (max-width: 576px) {
    .main-header .nav-link {
      padding-left: 0.5rem !important;
      padding-right: 0.5rem !important;
      font-size: 13px !important;
    }
    .main-header .navbar-brand {
      margin-right: 0.5rem !important;
      font-size: 1.05rem !important;
    }
  }
</style>

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
            <div class="card">

              <!-- /.card-header -->
              <div class="card-body" style="min-height: 500px;">


<?php 
$validation = \Config\Services::validation();
    $errors = $validation->getErrors();
    if(!empty($errors))
    {
        echo '<span class="text-danger">'.$validation->listErrors().'</span>';
    }
?>

<?php if (session('msg')) : ?>
     <div class="alert alert-info alert-dismissible">
         <?= session('msg') ?>
         <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
     </div>
 <?php endif ?>