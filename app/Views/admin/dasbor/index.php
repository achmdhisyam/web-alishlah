<div class="callout callout-info bg-light">
	Hai <strong><em class="text-success"><?php echo Session()->get('nama') ?></em></strong>, Selamat datang di <strong><?php echo $this->website->namasekolah() ?>. Semoga Anda senang.</strong>
</div>


<?php $akses = Session()->get('akses_level'); ?> 

<!-- Info boxes -->
<div class="row">
	<!-- div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-question"></i></span>

			<div class="info-box-content">
				<span class="info-box-text">Panduan Penggunaan</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/dasbor/panduan') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-eye"></i> Baca Panduan
					</a>
				</span>
			</div>
			<!-- /.info-box-content 
		</div>
		<!-- /.info-box 
	</div>

	<!-- col -->
	   <!-- Periode SPMB -->
 	<?php if ($akses == 'Admin' || $akses == 'User' || $akses == 'spmb') { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-check"></i></span>

			<div class="info-box-content">
				<span class="info-box-text">Periode SPMB</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/gelombang') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-calendar-check"></i> Lihat dan Kelola
					</a>
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
		<!-- /.info-box -->
	</div>
	<?php } ?>

	<!-- /.col -->
  <!-- Artikel dan Berita -->
  <?php if ($akses == 'Admin' || $akses == 'User' || $akses == 'berita') { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box mb-3">
			<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-newspaper"></i></span>

			<div class="info-box-content">
				<span class="info-box-text">Berita dan Profil </span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/berita') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-check-circle"></i> Lihat dan Kelola
					</a>
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
		<!-- /.info-box -->
	</div>
	<?php } ?>
	<!-- /.col -->
	<?php if(Session()->get('akses_level')=='Admin') { ?>
		<div class="col-12 col-sm-6 col-md-3">
			<div class="info-box">
				<span class="info-box-icon bg-success elevation-1"><i class="fas fa-image"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Banner dan Galeri</span>
					<span class="info-box-number">
						<a href="<?php echo base_url('admin/galeri') ?>" class="btn btn-xs btn-outline-success">
							<i class="fa fa-users"></i> Lihat dan Kelola
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
				<span class="info-box-icon bg-primary elevation-1"><i class="fas fa-graduation-cap"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Guru dan Staff</span>
					<span class="info-box-number">
						<a href="<?php echo base_url('admin/staff') ?>" class="btn btn-xs btn-outline-success">
							<i class="fa fa-graduation-cap"></i> Lihat dan Kelola
						</a>
					</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->
		<div class="col-12 col-sm-6 col-md-3">
			<div class="info-box">
				<span class="info-box-icon bg-warning elevation-1"><i class="fab fa-youtube"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Video Youtube</span>
					<span class="info-box-number">
						<a href="<?php echo base_url('admin/video') ?>" class="btn btn-xs btn-outline-success">
							<i class="fa fa-eye"></i> Lihat dan Kelola
						</a>
					</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->
		<div class="col-12 col-sm-6 col-md-3">
			<div class="info-box">
				<span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-user-lock"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Pengguna Website</span>
					<span class="info-box-number">
						<a href="<?php echo base_url('admin/user') ?>" class="btn btn-xs btn-outline-success">
							<i class="fa fa-user-lock"></i> Lihat dan Kelola
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
				<span class="info-box-icon bg-dark elevation-1"><i class="fas fa-home"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Informasi Sekolah</span>
					<span class="info-box-number">
						<a href="<?php echo base_url('admin/konfigurasi/sekolah') ?>" class="btn btn-xs btn-outline-success">
							<i class="fa fa-home"></i> Lihat dan Kelola
						</a>
					</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->
	<?php } ?>
</div>
        <!-- /.row -->