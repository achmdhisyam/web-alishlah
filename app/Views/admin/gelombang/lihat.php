<div class="modal fade" id="modal-<?php echo $jenis_dokumen->id_jenis_dokumen ?>">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Pratinjau &amp; Verifikasi: <?php echo $jenis_dokumen->nama_jenis_dokumen ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-7">
						<iframe src="<?php echo base_url('assets/upload/pendaftaran/'.$check_dokumen->gambar) ?>" height="450" style="width:100%; border: none;" allowfullscreen webkitallowfullscreen></iframe>
					</div>
					<div class="col-md-5">
						<h5>Form Verifikasi Dokumen</h5>
						<hr>
						<?php echo form_open(base_url('admin/gelombang/dokumen/'.$siswa->slug_siswa)) ?>
						<?php echo csrf_field(); ?>
						<input type="hidden" name="id_dokumen" value="<?php echo $check_dokumen->id_dokumen ?>">
						
						<div class="form-group mb-3">
							<label class="form-label text-dark font-weight-bold">Status Verifikasi</label>
							<select name="status_verifikasi" class="form-control form-select" required>
								<option value="Menunggu" <?php if($check_dokumen->status_verifikasi == 'Menunggu') echo 'selected'; ?>>Menunggu Verifikasi</option>
								<option value="Disetujui" <?php if($check_dokumen->status_verifikasi == 'Disetujui') echo 'selected'; ?>>Disetujui / Valid</option>
								<option value="Ditolak" <?php if($check_dokumen->status_verifikasi == 'Ditolak') echo 'selected'; ?>>Ditolak / Perlu Diperbaiki</option>
							</select>
						</div>

						<div class="form-group mb-3">
							<label class="form-label text-dark font-weight-bold">Catatan Revisi / Keterangan</label>
							<textarea name="catatan_verifikasi" class="form-control" rows="4" placeholder="Tulis catatan jika dokumen ditolak atau memerlukan revisi..."><?php echo $check_dokumen->catatan_verifikasi ?></textarea>
						</div>

						<button type="submit" name="verifikasi_dokumen" value="simpan" class="btn btn-primary w-100"><i class="fa fa-save"></i> Simpan Verifikasi</button>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-end">
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->