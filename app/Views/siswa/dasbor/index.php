<div class="callout callout-success">
	Hai <strong><?php echo Session()->get('nama_siswa') ?></strong>, 
	Selamat datang di <strong><?php echo $this->website->namaweb() ?></strong>
</div>

<!-- Info boxes -->
<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1">
      	<i class="fas fa-calendar-check"></i>
      </span>

      <div class="info-box-content">
        <span class="info-box-text">Periode SMPB</span>
        <span class="info-box-number">
          <a href="<?php echo base_url('siswa/gelombang') ?>" class="btn btn-info btn-xs">
          	<i class="fa fa-eye"></i> Lihat Periode
          </a>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1">
      	<i class="fas fa-user-check"></i>
      </span>

      <div class="info-box-content">
        <span class="info-box-text">Data Pendaftaran Saya</span>
        <span class="info-box-number">
        	<a href="<?php echo base_url('siswa/pendaftaran') ?>" class="btn btn-info btn-xs">
          	<i class="fa fa-eye"></i> Kelola Pendaftaran
          </a>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1">
      	<i class="fas fa-user-lock"></i>
      </span>

      <div class="info-box-content">
        <span class="info-box-text">Akun Saya</span>
        <span class="info-box-number">
        	<a href="<?php echo base_url('siswa/akun') ?>" class="btn btn-info btn-xs">
          	<i class="fa fa-eye"></i> Kelola Akun
          </a>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1">
      	<i class="fas fa-home"></i>
      </span>

      <div class="info-box-content">
        <span class="info-box-text">Beranda Website</span>
        <span class="info-box-number">
        	<a href="<?php echo base_url() ?>" class="btn btn-info btn-xs" target="_blank">
          	<i class="fa fa-eye"></i> Kembali ke Beranda
          </a>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
