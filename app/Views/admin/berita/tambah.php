<p class="text-right">
	<a href="<?php echo base_url('admin/berita') ?>" class="btn btn-outline-info btn-sm">
		<i class="fa fa-arrow-left"></i> Kembali
	</a>
</p>
<hr>

<form action="<?php echo base_url('admin/berita/tambah') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<?php 
echo csrf_field(); 
?>

<div class="form-group row">
	<label class="col-md-2">Judul Berita <span class="text-danger">*</span></label>
	<div class="col-md-10">
		<input type="text" name="judul_berita" class="form-control" value="<?php echo set_value('judul_berita') ?>" required>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2">Upload Gambar Berita</label>
	<div class="col-md-10">
		<input type="file" name="gambar" class="form-control" value="<?php echo set_value('gambar') ?>">
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2">Kategori &amp; Status <span class="text-danger">*</span></label>
	<div class="col-md-3">
		<select name="id_kategori" class="form-control">
			<?php foreach($kategori as $kat) { 
				if (in_array(trim($kat->nama_kategori), ['Keunggulan', 'Profil'])) continue;
			?>
			<option value="<?php echo $kat->id_kategori ?>">
				<?php echo $kat->nama_kategori ?>
			</option>
			<?php } ?>
		</select>
		<small class="text-secondary">Kategori</small>
	</div>
	<input type="hidden" name="jenis_berita" value="Berita">
	<div class="col-md-3">
		<select name="status_berita" class="form-control">
			<option value="Publish">Publish</option>
			<option value="Draft">Draft</option>
		</select>
		<small class="text-secondary">Status publikasi</small>
	</div>
	<div class="col-md-3">
		<input type="text" name="icon" class="form-control" value="<?php echo set_value('icon') ?>">
		<small class="text-secondary">Icon <a href="https://fontawesome.com/icons" target="_blank">Fontawsome</a></small>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2">Tanggal, jam Publikasi &amp; Urutan</label>
	<div class="col-md-3">
		<input type="text" name="tanggal_publish" class="form-control tanggal" value="<?php if(isset($_POST['tanggal_publis'])) { echo set_value('tanggal_publish'); }else{ echo date('d-m-Y'); } ?>">
		<small class="text-secondary">Format <strong>dd-mm-yyyy</strong>. Misal: <?php echo date('d-m-Y') ?></small>
	</div>
	<div class="col-md-3">
		<input type="text" name="jam" class="form-control jam" value="<?php if(isset($_POST['jam'])) { echo set_value('jam'); }else{ echo date('H:i:s'); } ?>">
		<small class="text-secondary">Format <strong>HH:MM:SS</strong>. Misal: <?php echo date('H:i:s') ?></small>
	</div>
	<div class="col-md-3">
		<input type="number" name="urutan" class="form-control" value="<?php if(isset($_POST['urutan'])) { echo set_value('urutan'); }else{ echo 0; } ?>">
		<small class="text-secondary">Nomor urut tampil</small>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2">Ringkasan</label>
	<div class="col-md-10">
		<textarea name="ringkasan" class="form-control"><?php echo set_value('ringkasan') ?></textarea>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2">Isi Berita <span class="text-danger">*</span></label>
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
		<button type="button" class="btn btn-warning btn-sm mb-1" id="btn-ai-kembangkan">
			<i class="fa fa-magic"></i> ✨ Kembangkan Tulisan dengan AI
		</button>
		<textarea id="isi" name="isi" class="form-control konten"><?php echo set_value('isi') ?></textarea>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2">Keyword Berita (untuk SEO Google)</label>
	<div class="col-md-10">
		<textarea name="keywords" class="form-control"><?php echo set_value('keywords') ?></textarea>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-2"></label>
	<div class="col-md-10">
		<a href="<?php echo base_url('admin/berita') ?>" class="btn btn-outline-info">
			<i class="fa fa-arrow-left"></i> Kembali
		</a>
		<button type="reset" class="btn btn-secondary"><i class="fa fa-times"></i> Reset</button>
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
	</div>
</div>

<?php 
echo form_close(); 
include('media.php');
include('galeri.php');
include('download.php');
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const btnAi = document.getElementById('btn-ai-kembangkan');
    
    if(btnAi) {
        btnAi.addEventListener('click', function() {
            const judul = document.querySelector('input[name="judul_berita"]').value;
            // Dapatkan teks mentah (poin-poin) dari TinyMCE
            let draftIsi = '';
            if (typeof tinymce !== 'undefined' && tinymce.get('isi')) {
                draftIsi = tinymce.get('isi').getContent({format: 'text'});
            } else {
                draftIsi = document.getElementById('isi').value;
            }

            if(!draftIsi.trim()) {
                alert('Isi Berita (poin-poin di editor) tidak boleh kosong untuk dikembangkan oleh AI!');
                return;
            }

            // Ubah tombol jadi loading
            const originalText = btnAi.innerHTML;
            btnAi.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sedang menulis...';
            btnAi.disabled = true;

            const formData = new FormData();
            formData.append('judul', judul);
            formData.append('draft_isi', draftIsi);

            fetch('<?php echo base_url('admin/ai/kembangkanBerita') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                btnAi.innerHTML = originalText;
                btnAi.disabled = false;

                if(data.error) {
                    alert('Error AI: ' + data.error);
                } else if(data.success) {
                    // Set Judul dari AI
                    document.querySelector('input[name="judul_berita"]').value = data.judul;
                    // Set TinyMCE content
                    if (typeof tinymce !== 'undefined' && tinymce.get('isi')) {
                        tinymce.get('isi').setContent(data.isi);
                    } else {
                        document.getElementById('isi').value = data.isi;
                    }
                    // Set Ringkasan
                    document.querySelector('textarea[name="ringkasan"]').value = data.ringkasan;
                }
            })
            .catch(error => {
                btnAi.innerHTML = originalText;
                btnAi.disabled = false;
                alert('Terjadi kesalahan jaringan.');
            });
        });
    }
});
</script>