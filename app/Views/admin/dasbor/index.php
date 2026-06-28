<div class="callout callout-info bg-light">
	Hai <strong><em class="text-success"><?php echo Session()->get('nama') ?></em></strong>, Selamat datang di <strong><?php echo $this->website->namasekolah() ?>. Semoga Anda senang.</strong>
</div>


<?php 
$akses = Session()->get('akses_level'); 
$IS_ADMIN  = ($akses === 'Admin');
$IS_USER   = ($akses === 'User');
$IS_SPMB   = ($akses === 'spmb');
$IS_KONTEN = ($akses === 'konten');
$SHOW_ALL  = ($IS_ADMIN || $IS_USER);
?> 

<?php if ($this->website->fitur_pendaftaran()=='On' && ($IS_ADMIN || $IS_USER || $IS_SPMB)): ?>
<?php
$db_stat = \Config\Database::connect();
$stat_total    = $db_stat->table('siswa')->countAllResults();
$stat_menunggu = $db_stat->table('siswa')->where('status_pendaftaran', 'Menunggu')->countAllResults();
$stat_diterima = $db_stat->table('siswa')->where('status_pendaftaran', 'Diterima')->countAllResults();
$stat_tolak    = $db_stat->table('siswa')->where('status_pendaftaran', 'Tidak-Diterima')->countAllResults();
$stat_periksa  = $db_stat->table('siswa')->where('status_pendaftaran', 'Diperiksa')->countAllResults();
// Ambil gelombang terbaru untuk link langsung ke filtered page
$gelombang_aktif = $db_stat->table('gelombang')->orderBy('id_gelombang','DESC')->limit(1)->get()->getRow();
$id_g = $gelombang_aktif ? $gelombang_aktif->id_gelombang : null;
?>
<div class="row mb-3">
  <div class="col-6 col-sm-3">
    <div class="small-box bg-info" style="cursor:pointer;" onclick="window.location='<?php echo base_url('admin/gelombang') ?>'">
      <div class="inner"><h3><?php echo number_format($stat_total) ?></h3><p>Total Pendaftar</p></div>
      <div class="icon"><i class="fas fa-user-check"></i></div>
      <a href="<?php echo base_url('admin/gelombang') ?>" class="small-box-footer">Kelola Gelombang <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-6 col-sm-3">
    <div class="small-box bg-warning" style="cursor:pointer;" onclick="window.location='<?php echo $id_g ? base_url('admin/gelombang/detail/'.$id_g.'/Menunggu/Semua') : base_url('admin/gelombang') ?>'">
      <div class="inner"><h3><?php echo number_format($stat_menunggu) ?></h3><p>Menunggu Verifikasi</p></div>
      <div class="icon"><i class="fas fa-clock"></i></div>
      <a href="<?php echo $id_g ? base_url('admin/gelombang/detail/'.$id_g.'/Menunggu/Semua') : base_url('admin/gelombang') ?>" class="small-box-footer">Lihat Pendaftar Menunggu <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-6 col-sm-3">
    <div class="small-box bg-success" style="cursor:pointer;" onclick="window.location='<?php echo $id_g ? base_url('admin/gelombang/detail/'.$id_g.'/Diterima/Semua') : base_url('admin/gelombang') ?>'">
      <div class="inner"><h3><?php echo number_format($stat_diterima) ?></h3><p>Diterima</p></div>
      <div class="icon"><i class="fas fa-check-circle"></i></div>
      <a href="<?php echo $id_g ? base_url('admin/gelombang/detail/'.$id_g.'/Diterima/Semua') : base_url('admin/gelombang') ?>" class="small-box-footer">Lihat Pendaftar Diterima <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-6 col-sm-3">
    <div class="small-box bg-danger" style="cursor:pointer;" onclick="window.location='<?php echo $id_g ? base_url('admin/gelombang/detail/'.$id_g.'/Tidak-Diterima/Semua') : base_url('admin/gelombang') ?>'">
      <div class="inner"><h3><?php echo number_format($stat_tolak) ?></h3><p>Tidak Diterima</p></div>
      <div class="icon"><i class="fas fa-times-circle"></i></div>
      <a href="<?php echo $id_g ? base_url('admin/gelombang/detail/'.$id_g.'/Tidak-Diterima/Semua') : base_url('admin/gelombang') ?>" class="small-box-footer">Lihat Pendaftar Ditolak <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Info boxes -->
<div class="row">

	<!-- 1. Log Aktivitas Admin -->
	<?php if ($IS_ADMIN) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-history"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Log Aktivitas Admin</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/log') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-history"></i> Lihat Log
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 2. Periode SPMB -->
	<?php if ($this->website->fitur_pendaftaran()=='On' && ($IS_ADMIN || $IS_USER || $IS_SPMB)) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-check"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Periode SPMB</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/gelombang') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-calendar-check"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 3. Data Berita -->
	<?php if ($IS_ADMIN || $IS_USER || $IS_KONTEN) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-newspaper"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Data Berita</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/berita') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-newspaper"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 4. Profil Sekolah -->
	<?php if ($IS_ADMIN || $IS_USER || $IS_KONTEN) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-teal elevation-1"><i class="fas fa-id-card"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Profil Sekolah</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/profil') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-id-card"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 5. Galeri Foto -->
	<?php if ($IS_ADMIN || $IS_USER || $IS_KONTEN) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-images"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Galeri Foto</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/galeri') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-images"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 6. Media Web -->
	<?php if ($IS_ADMIN || $IS_USER || $IS_KONTEN) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-indigo elevation-1"><i class="fas fa-desktop"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Media Web</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/slider') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-desktop"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 7. File & Download -->
	<?php if ($SHOW_ALL) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-upload"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">File &amp; Download</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/download') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-upload"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 8. Prestasi & Penghargaan -->
	<?php if ($IS_ADMIN || $IS_USER || $IS_KONTEN) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-purple elevation-1"><i class="fas fa-certificate"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Prestasi &amp; Penghargaan</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/prestasi') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-certificate"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 9. Video Youtube -->
	<?php if ($IS_ADMIN || $IS_USER || $IS_KONTEN) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-warning elevation-1"><i class="fab fa-youtube"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Video Youtube</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/video') ?>" class="btn btn-xs btn-outline-success">
						<i class="fab fa-youtube"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 10. Fasilitas -->
	<?php if ($SHOW_ALL) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-navy elevation-1"><i class="fas fa-home"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Fasilitas</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/fasilitas') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-home"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 11. Ekstrakurikuler -->
	<?php if ($SHOW_ALL) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-pink elevation-1"><i class="fas fa-futbol"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Ekstrakurikuler</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/ekstrakurikuler') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-futbol"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 12. Program Pendidikan -->
	<?php if ($SHOW_ALL) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-primary elevation-1"><i class="fas fa-graduation-cap"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Program Pendidikan</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/program_pendidikan') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-graduation-cap"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 13. Informasi Yayasan -->
	<?php if ($SHOW_ALL) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-olive elevation-1"><i class="fas fa-building"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Informasi Yayasan</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/yayasan') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-building"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 14. Guru & Staff -->
	<?php if ($SHOW_ALL) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-users"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Guru &amp; Staff</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/staff') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-users"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 15. Menu Website -->
	<?php if ($IS_ADMIN) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-orange elevation-1"><i class="fa fa-sitemap text-white"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Menu Website</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/menu') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-sitemap"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 16. Pengguna Sistem -->
	<?php if ($IS_ADMIN) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-user-lock"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Pengguna Sistem</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/user') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-user-lock"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

	<!-- 17. Setting Aplikasi -->
	<?php if ($IS_ADMIN) { ?>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-dark elevation-1"><i class="fas fa-cog"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Setting Aplikasi</span>
				<span class="info-box-number">
					<a href="<?php echo base_url('admin/konfigurasi') ?>" class="btn btn-xs btn-outline-success">
						<i class="fa fa-cog"></i> Lihat &amp; Kelola
					</a>
				</span>
			</div>
		</div>
	</div>
	<?php } ?>

</div>
<!-- /.row -->