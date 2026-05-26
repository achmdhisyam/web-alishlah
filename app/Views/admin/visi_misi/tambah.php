<p class="text-right">
	<a href="<?php echo base_url('admin/visi_misi') ?>" class="btn btn-outline-info btn-sm">
		<i class="fa fa-arrow-left"></i> Kembali
	</a>
</p>
<hr>

<form action="<?php echo base_url('admin/visi_misi/tambah') ?>" method="post" accept-charset="utf-8">
<?php 
echo csrf_field(); 
?>

<input type="hidden" name="judul_visi_misi" value="Visi &amp; Misi">
<input type="hidden" name="tanggal_publish" value="<?php echo date('d-m-Y') ?>">
<input type="hidden" name="jam" value="<?php echo date('H:i:s') ?>">

<div class="form-group row">
	<label class="col-md-2">Visi Sekolah <span class="text-danger">*</span></label>
	<div class="col-md-10">
		<textarea name="ringkasan" class="form-control" rows="3" placeholder="Masukkan visi sekolah..." required><?php echo set_value('ringkasan') ?></textarea>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2">Misi Sekolah <span class="text-danger">*</span></label>
	<div class="col-md-10">
		<textarea id="isi" name="isi" class="form-control konten" rows="8" placeholder="Masukkan misi sekolah..." required><?php echo set_value('isi') ?></textarea>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2">Status Publikasi <span class="text-danger">*</span></label>
	<div class="col-md-3">
		<select name="status_visi_misi" class="form-control">
			<option value="Publish">Publish</option>
			<option value="Draft">Draft</option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2"></label>
	<div class="col-md-10">
		<a href="<?php echo base_url('admin/visi_misi') ?>" class="btn btn-outline-info">
			<i class="fa fa-arrow-left"></i> Kembali
		</a>
		<button type="reset" class="btn btn-secondary"><i class="fa fa-times"></i> Reset</button>
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
	</div>
</div>

<?php 
echo form_close(); 
?>
