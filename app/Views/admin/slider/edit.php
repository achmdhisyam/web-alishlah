<p class="text-right">
	<a href="<?php echo base_url('admin/slider') ?>" class="btn btn-outline-info btn-sm">
		<i class="fa fa-arrow-left"></i> Kembali
	</a>
</p>
<hr>

<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<form action="<?php echo base_url('admin/slider/edit/'.$slider->id_slider) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<?php 
echo csrf_field(); 
?>

<div class="form-group row">
	<label class="col-md-3">Judul Slider</label>
	<div class="col-md-9">
		<input type="text" name="judul_slider" class="form-control" value="<?php echo $slider->judul_slider ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3">Upload Gambar Slider</label>
	<div class="col-md-8">
		<input type="file" name="gambar" class="form-control" value="<?php echo $slider->gambar ?>">
		<small class="text-muted">Kosongkan jika tidak ingin mengganti gambar. Rekomendasi ukuran: 1920x800 piksel</small>
	</div>
	<div class="col-md-1">
		<img src="<?php echo base_url('assets/upload/image/thumbs/'.$slider->gambar) ?>" class="img img-thumbnail w-100">
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3">Status Teks &amp; Aktif</label>
	<div class="col-md-9">
		<select name="status_text" class="form-control">
			<option value="Ya" <?php if($slider->status_text=="Ya") { echo 'selected'; } ?>>Aktif (Tampilkan Teks)</option>
			<option value="Tidak" <?php if($slider->status_text=="Tidak") { echo 'selected'; } ?>>Tidak Aktif (Sembunyikan Teks)</option>
		</select>
		<small class="text-secondary">Apakah teks & tombol akan ditampilkan di atas gambar slider</small>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3">Isi / Deskripsi Slider</label>
	<div class="col-md-9">
		<textarea id="isi" name="isi" class="form-control konten"><?php echo $slider->isi ?></textarea>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3">Teks untuk Tombol Link</label>
	<div class="col-md-9">
		<input type="text" name="text_website" class="form-control" value="<?php echo $slider->text_website ?>" placeholder="Contoh: Selengkapnya, Info Pendaftaran, dll">
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3">Link/URL Slider</label>
	<div class="col-md-9">
		<input type="text" name="website" class="form-control" value="<?php echo $slider->website ?>" placeholder="Contoh: https://example.com/spmb">
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3"></label>
	<div class="col-md-9">
		<a href="<?php echo base_url('admin/slider') ?>" class="btn btn-outline-info">
			<i class="fa fa-arrow-left"></i> Kembali
		</a>
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
	</div>
</div>

<?php echo form_close(); ?>
