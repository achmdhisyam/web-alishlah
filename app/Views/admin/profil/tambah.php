<p class="text-right">
	<a href="<?php echo base_url('admin/profil') ?>" class="btn btn-outline-info btn-sm">
		<i class="fa fa-arrow-left"></i> Kembali
	</a>
</p>
<hr>

<form action="<?php echo base_url('admin/profil/tambah') ?>" method="post" accept-charset="utf-8">
<?php 
echo csrf_field(); 
?>

<input type="hidden" name="tanggal_publish" value="<?php echo date('d-m-Y') ?>">
<input type="hidden" name="jam" value="<?php echo date('H:i:s') ?>">
<input type="hidden" name="ringkasan" value="-">

<div class="form-group row">
	<label class="col-md-2">Judul Halaman <span class="text-danger">*</span></label>
	<div class="col-md-10">
		<input type="text" name="judul_profil" class="form-control" placeholder="Contoh: Sejarah Singkat Sekolah" value="<?php echo set_value('judul_profil') ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2">Isi Konten Sejarah <span class="text-danger">*</span></label>
	<div class="col-md-10">
		<button type="button" class="btn btn-secondary btn-sm mb-1" data-toggle="modal" data-target="#modal-media">
			<i class="fa fa-plus-circle"></i> Upload &amp; Kelola Media/File
		</button>
		<button type="button" class="btn btn-secondary btn-sm mb-1" data-toggle="modal" data-target="#modal-galeri">
			<i class="fa fa-image"></i> Lihat Galeri
		</button>
		<button type="button" class="btn btn-secondary btn-sm mb-1" data-toggle="modal" data-target="#modal-download">
			<i class="fa fa-download"></i> Lihat File
		</button>
		<textarea id="isi" name="isi" class="form-control konten" rows="12"><?php echo set_value('isi') ?></textarea>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2">Status Publikasi <span class="text-danger">*</span></label>
	<div class="col-md-3">
		<select name="status_profil" class="form-control">
			<option value="Publish">Publish</option>
			<option value="Draft">Draft</option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2"></label>
	<div class="col-md-10">
		<a href="<?php echo base_url('admin/profil') ?>" class="btn btn-outline-info">
			<i class="fa fa-arrow-left"></i> Kembali
		</a>
		<button type="reset" class="btn btn-secondary"><i class="fa fa-times"></i> Reset</button>
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
	</div>
</div>

<?php 
echo form_close(); 
include(APPPATH . 'Views/admin/program_pendidikan/media.php');
include(APPPATH . 'Views/admin/program_pendidikan/galeri.php');
include(APPPATH . 'Views/admin/program_pendidikan/download.php');
?>
