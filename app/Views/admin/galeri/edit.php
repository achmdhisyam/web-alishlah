<p class="text-right">
	<a href="<?php echo base_url('admin/galeri') ?>" class="btn btn-outline-info btn-sm">
		<i class="fa fa-arrow-left"></i> Kembali
	</a>
</p>
<hr>

<form action="<?php echo base_url('admin/galeri/edit/'.$galeri->id_galeri) ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<?php 
echo csrf_field(); 
?>

<div class="form-group row">
	<label class="col-md-3">Judul Galeri</label>
	<div class="col-md-9">
		<input type="text" name="judul_galeri" class="form-control" value="<?php echo $galeri->judul_galeri ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3">Upload Gambar Galeri</label>
	<div class="col-md-8">
		<input type="file" name="gambar" class="form-control" value="<?php echo $galeri->gambar ?>">
	</div>
	<div class="col-md-1">
		<img src="<?php echo base_url('assets/upload/image/thumbs/'.$galeri->gambar) ?>" class="img img-thumbnail">
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3">Kategori</label>
	<div class="col-md-9">
		<select name="id_kategori_galeri" class="form-control">
			<?php foreach($kategori_galeri as $kategori_galeri) { 
				if (strtolower(trim($kategori_galeri->nama_kategori_galeri)) === 'banner website') continue;
			?>
			<option value="<?php echo $kategori_galeri->id_kategori_galeri ?>" <?php if($galeri->id_kategori_galeri==$kategori_galeri->id_kategori_galeri) { echo 'selected'; } ?>>
				<?php echo $kategori_galeri->nama_kategori_galeri ?>
			</option>
			<?php } ?>
		</select>
		<input type="hidden" name="jenis_galeri" value="Galeri">
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3">Isi Galeri</label>
	<div class="col-md-9">
		<textarea id="isi" name="isi" class="form-control konten"><?php echo $galeri->isi ?></textarea>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3"></label>
	<div class="col-md-9">
		<a href="<?php echo base_url('admin/galeri') ?>" class="btn btn-outline-info">
			<i class="fa fa-arrow-left"></i> Kembali
		</a>
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
	</div>
</div>

<?php echo form_close(); ?>