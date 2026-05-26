<?php 
echo form_open(base_url('admin/konfigurasi/pembayaran')); 
echo csrf_field(); 
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="card-title text-white">Edit Rincian Administrasi</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <strong>Perhatian:</strong> Gunakan editor di bawah ini untuk mengubah rincian administrasi. Anda dapat mengubah teks, angka, maupun menambah/menghapus baris tabel sesuai kebutuhan.
                </div>

                <div class="form-group row">
                    <label class="col-12">Rincian Administrasi & Pembayaran</label>
                    <div class="col-12 mt-2">
                        <textarea id="isi" name="rincian_administrasi" class="form-control konten" rows="20"><?php echo $konfigurasi->rincian_administrasi ?></textarea>
                    </div>
                </div>

                <div class="form-group row mt-4">
                    <label class="col-12">Persyaratan Pendaftaran</label>
                    <div class="col-12 mt-2">
                        <textarea id="isi2" name="syarat_pendaftaran" class="form-control konten" rows="15"><?php echo $konfigurasi->syarat_pendaftaran ?></textarea>
                    </div>
                </div>

                <div class="form-group row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo form_close(); ?>
