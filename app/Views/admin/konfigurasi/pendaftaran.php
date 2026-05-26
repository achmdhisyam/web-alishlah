<?php 
echo form_open(base_url('admin/konfigurasi/pendaftaran')); 
echo csrf_field(); 
?>

<div class="form-group row">
	<label class="col-3">Fitur Website untuk Pendaftaran Online</label>
	<div class="col-6">
		<select name="fitur_pendaftaran" class="form-control">
			<option value="Off">Off - Non Aktif</option>
			<option value="On" <?php if($konfigurasi->fitur_pendaftaran=='On') { echo 'selected'; } ?>>On - Aktif</option>
		</select>
	</div>
</div>

<div class="form-group row">
	<label class="col-3">Periode Pendaftaran Online</label>
	<div class="col-2">
		<input type="text" name="mulai_pendaftaran" placeholder="dd-mm-yyyy" class="form-control tanggal" value="<?php echo $this->website->tanggal_id($konfigurasi->mulai_pendaftaran) ?>">
		<small class="text-secondary">Tanggal mulai</small>
	</div>
	<div class="col-2">
		<input type="text" name="selesai_pendaftaran" placeholder="dd-mm-yyyy" class="form-control tanggal" value="<?php echo $this->website->tanggal_id($konfigurasi->selesai_pendaftaran) ?>">
		<small class="text-secondary">Tanggal selesai</small>
	</div>
	<div class="col-2">
		<input type="text" name="pengumuman_pendaftaran" placeholder="dd-mm-yyyy" class="form-control tanggal" value="<?php echo $this->website->tanggal_id($konfigurasi->pengumuman_pendaftaran) ?>">
		<small class="text-secondary">Tanggal pengumuman</small>
	</div>
</div>

<div class="form-group row">
	<label class="col-3">Informasi pendaftaran</label>
	<div class="col-9">
		<textarea id="isi" name="keterangan_pendaftaran" class="form-control konten" rows="5"><?php echo $konfigurasi->keterangan_pendaftaran ?></textarea>
	</div>
</div>

<div class="form-group row">
	<label class="col-3"></label>
	<div class="col-9">
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
	</div>
</div>

<?php echo form_close(); ?>