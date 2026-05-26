
<form action="<?php echo base_url('admin/gelombang/tambah') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
	<?php 
	$tahun_ajaran = (date('Y')+1)."/".(date('Y')+2);
	echo csrf_field(); 
	?>


	<div class="form-group row">
		<label class="col-3">Nama Periode SPMB</label>
		<div class="col-9">
			<input type="text" name="judul" class="form-control" placeholder="Nama Periode SPMB" value="<?php if(isset($_POST['judul'])) {  echo set_value('judul'); }else{ echo $nama_gelombang; } ?>" required>
			<small class="text-secondary">Nama Periode SPMB. <span class="text-danger">Anda dapat menggantinya sesuai kebutuhan.</span> Misal: <strong><?php echo $nama_gelombang ?></strong></small>
		</div>

	</div>

	<div class="form-group row">

		<label class="col-3">Tahun ajaran dan status</label>

		<div class="col-3">
			<input type="number" name="tahun" value="<?php if(isset($_POST['tahun'])) { echo set_value('tahun'); }else{ echo date('Y')+1; } ?>" placeholder="Tahun" class="form-control" required>
			<small class="text-secondary">Tahun: <?php echo date('Y') ?></small>
		</div>

		<div class="col-3">
			<input type="text" name="tahun_ajaran" value="<?php if(isset($_POST['tahun_ajaran'])) { echo set_value('tahun_ajaran'); }else{ echo $tahun_ajaran; } ?>" placeholder="Tahun ajaran" class="form-control" required>
			<small class="text-secondary">Tahun Ajaran: <?php echo date('Y') ?>/<?php echo date('Y')+1; ?></small>
		</div>

		<div class="col-3">
			<select name="status_gelombang" class="form-control">
				<option value="Buka">Buka</option>
				<option value="Tutup">Tutup</option>
			</select>
			<small class="text-secondary">Status Periode</small>
		</div>
	</div>

	

	<div class="form-group row">
		<label class="col-3">Gambar / Banner</label>
		
		<div class="col-9">
			<input type="file" name="gambar" class="form-control" placeholder="Gambar? logo" value="<?php echo set_value('gambar') ?>">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-3">Keterangan</label>
		<div class="col-9">
			<button type="button" class="btn btn-secondary btn-sm mb-1" data-toggle="modal" data-target="#modal-media">
				<i class="fa fa-plus-circle"></i> Upload &amp; Kelola Media/File
			</button>
			<button type="button" class="btn btn-secondary btn-sm mb-1" data-toggle="modal" data-target="#modal-galeri">
				<i class="fa fa-image"></i> Lihat Galeri
			</button>
			<button type="button" class="btn btn-secondary btn-sm mb-1" data-toggle="modal" data-target="#modal-download">
				<i class="fa fa-download"></i> Lihat File
			</button>
			<textarea id="isi" name="isi" placeholder="Keterangan" class="form-control konten"><?php echo set_value('isi') ?></textarea>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-3">Tanggal buka, tutup, dan pengumuman SMPB</label>

		<div class="col-3">
			<input type="text" name="tanggal_buka" class="form-control tanggal" placeholder="dd-mm-yyyy" value="<?php echo set_value('tanggal_buka') ?>">
			<small class="text-secondary">Tanggal buka pendaftaran</small>
		</div>
		
		<div class="col-3">
			<input type="text" name="tanggal_tutup" class="form-control tanggal" placeholder="dd-mm-yyyy" value="<?php echo set_value('tanggal_tutup') ?>">
			<small class="text-secondary">Tanggal tutup pendaftaran</small>
		</div>

		<div class="col-3">
			<input type="text" name="tanggal_pengumuman" class="form-control tanggal" placeholder="dd-mm-yyyy" value="<?php echo set_value('tanggal_pengumuman') ?>">
			<small class="text-secondary">Tanggal pengumuman pendaftaran</small>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-3"></label>

		<div class="col-9">
			<a href="<?php echo base_url('admin/gelombang') ?>" class="btn btn-default" >
				<i class="fa fa-arrow-left"></i> Kembali
			</a>
			<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
		</div>
	</div>
<?php echo form_close(); 
echo view('admin/berita/media');
echo view('admin/berita/download');
echo view('admin/berita/galeri');
?>