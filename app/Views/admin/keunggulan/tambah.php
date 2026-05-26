<p class="text-right">
	<a href="<?php echo base_url('admin/keunggulan') ?>" class="btn btn-outline-info btn-sm">
		<i class="fa fa-arrow-left"></i> Kembali
	</a>
</p>
<hr>

<form action="<?php echo base_url('admin/keunggulan/tambah') ?>" method="post" accept-charset="utf-8">
<?php 
echo csrf_field(); 
?>

<input type="hidden" name="tanggal_publish" value="<?php echo date('d-m-Y') ?>">
<input type="hidden" name="jam" value="<?php echo date('H:i:s') ?>">
<input type="hidden" name="isi" value="-">

<div class="form-group row">
	<label class="col-md-2">Nama Keunggulan <span class="text-danger">*</span></label>
	<div class="col-md-10">
		<input type="text" name="judul_keunggulan" class="form-control" placeholder="Contoh: Terakreditasi A, Lulusan Berprestasi" value="<?php echo set_value('judul_keunggulan') ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2">Deskripsi Keunggulan <span class="text-danger">*</span></label>
	<div class="col-md-10">
		<textarea name="ringkasan" class="form-control" rows="4" placeholder="Masukkan penjelasan singkat tentang keunggulan ini..." required><?php echo set_value('ringkasan') ?></textarea>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2">Status Publikasi <span class="text-danger">*</span></label>
	<div class="col-md-3">
		<select name="status_keunggulan" class="form-control">
			<option value="Publish">Publish</option>
			<option value="Draft">Draft</option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2"></label>
	<div class="col-md-10">
		<a href="<?php echo base_url('admin/keunggulan') ?>" class="btn btn-outline-info">
			<i class="fa fa-arrow-left"></i> Kembali
		</a>
		<button type="reset" class="btn btn-secondary"><i class="fa fa-times"></i> Reset</button>
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
	</div>
</div>

<?php 
echo form_close(); 
?>
