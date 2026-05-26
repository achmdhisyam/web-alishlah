<p class="text-right">
	<a href="<?php echo base_url('admin/yayasan') ?>" class="btn btn-outline-info btn-sm">
		<i class="fa fa-arrow-left"></i> Kembali
	</a>
</p>

<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-header bg-secondary text-center">
				<strong>TEMPLATE IMPORT</strong>
			</div>
			<div class="card-body text-center bg-light">
				<p><strong class="text-danger">
						<i class="fa fa-exclamation-circle"></i> Perhatian
					</strong>
				<hr>
				Pastikan Anda mengimpor data dengan benar. Silakan unduh template impor Informasi Yayasan di bawah ini. Jangan mengubah baris pertama (header) yang ada pada template. Baca baik-baik petunjuk data contoh sebelum mengimpor.
			</p>
			<p>
				<a href="<?php echo base_url('admin/yayasan/template') ?>" class="btn btn-info btn-sm">
					<i class="fa fa-file-excel"></i> Unduh Template Impor
				</a>
			</p>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card">
			<div class="card-header bg-light">
				<strong>FORMULIR IMPORT INFORMASI YAYASAN</strong>
			</div>
			<div class="card-body">
				<?php echo form_open_multipart(base_url('admin/yayasan/import')); ?>
				
				<div class="form-group">
					<label>Pilih file excel</label>
					<input type="file" name="file_excel" class="form-control" required>
					<small class="text-danger">Format: xls, xlsx, csv dengan ukuran maksimal 4MB</small>
				</div>

				<div class="form-group mt-3">
					<button type="submit" class="btn btn-success" name="submit" value="submit">
						<i class="fa fa-upload"></i> Upload dan Import
					</button>
					<a href="<?php echo base_url('admin/yayasan') ?>" class="btn btn-outline-info">
						<i class="fa fa-arrow-left"></i> Kembali
					</a>
				</div>
				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</div>
