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
	<label class="col-3">Email Admin Penerima Notifikasi SPMB</label>
	<div class="col-6">
		<input type="email" name="email_admin_spmb" class="form-control" placeholder="admin.spmb@sekolah.sch.id" value="<?php echo $konfigurasi->email_admin_spmb ?? '' ?>">
		<small class="text-secondary">Email yang akan menerima notifikasi otomatis ketika ada pendaftar baru.</small>
	</div>
</div>

<div class="form-group row">
	<label class="col-3">Nomor Whatsapp Admin SPMB <i class="fab fa-whatsapp text-success"></i></label>
	<div class="col-6">
		<input type="text" name="whatsapp_spmb" class="form-control" placeholder="628123456789" value="<?php echo $konfigurasi->whatsapp_spmb ?? '' ?>">
		<small class="text-secondary">Nomor WhatsApp khusus untuk penerima konfirmasi pendaftaran dari siswa (gunakan format kode negara, contoh: 628123456789).</small>
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