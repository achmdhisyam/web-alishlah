<p class="text-right">
	<a href="<?php echo base_url('admin/popup') ?>" class="btn btn-outline-info btn-sm">
		<i class="fa fa-arrow-left"></i> Kembali
	</a>
</p>
<hr>

<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<form action="<?php echo base_url('admin/popup/edit/'.$popup->id_popup) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<?php 
echo csrf_field(); 
?>

<div class="form-group row">
	<label class="col-md-3">Judul Pop Up</label>
	<div class="col-md-9">
		<input type="text" name="judul_popup" class="form-control" value="<?php echo $popup->judul_popup ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3">Upload Gambar Pop Up</label>
	<div class="col-md-8">
		<input type="file" name="gambar" class="form-control" value="<?php echo $popup->gambar ?>">
		<small class="text-muted">Kosongkan jika tidak ingin mengganti gambar. Rekomendasi: 800x800 piksel</small>
	</div>
	<div class="col-md-1">
		<img src="<?php echo base_url('assets/upload/image/thumbs/'.$popup->gambar) ?>" class="img img-thumbnail w-100">
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3">Status Pop Up</label>
	<div class="col-md-9">
		<select name="status_text" class="form-control">
			<option value="Ya" <?php if($popup->status_text=="Ya") { echo 'selected'; } ?>>Aktif (Tampilkan Pop Up)</option>
			<option value="Tidak" <?php if($popup->status_text=="Tidak") { echo 'selected'; } ?>>Tidak Aktif (Sembunyikan Pop Up)</option>
		</select>
		<small class="text-secondary">Pilih aktif jika ingin pop up langsung muncul saat website diakses</small>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3">Isi / Keterangan Pop Up</label>
	<div class="col-md-9">
		<textarea id="isi" name="isi" class="form-control konten"><?php echo $popup->isi ?></textarea>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3">Link/URL Tautan Banner</label>
	<div class="col-md-9">
		<input type="text" name="website" class="form-control" value="<?php echo $popup->website ?>" placeholder="Contoh: https://example.com/daftar-sekarang">
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3"></label>
	<div class="col-md-9">
		<a href="<?php echo base_url('admin/popup') ?>" class="btn btn-outline-info">
			<i class="fa fa-arrow-left"></i> Kembali
		</a>
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
	</div>
</div>

<?php echo form_close(); ?>
