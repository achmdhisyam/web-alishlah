<?php 
$is_image = in_array(strtolower($check_dokumen->file_ext ?? ''), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
$file_path = base_url('assets/upload/pendaftaran/'.$check_dokumen->gambar);
?>
<div class="modal fade" id="modal-<?php echo $jd->id_jenis_dokumen ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
			
			<!-- Modal Header -->
			<div class="modal-header bg-light py-3 border-bottom d-flex align-items-center justify-content-between" style="border-top: 4px solid #007bff;">
				<h5 class="modal-title font-weight-bold text-dark mb-0" style="font-size: 15.5px;">
					<i class="fa fa-file-signature text-primary mr-1"></i> Pratinjau &amp; Verifikasi: <?php echo esc($jd->nama_jenis_dokumen) ?>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<!-- Modal Body -->
			<div class="modal-body p-4">
				<div class="row">
					<!-- Left Side: Preview Panel -->
					<div class="col-lg-8 mb-4 mb-lg-0">
						<div class="bg-light border rounded d-flex align-items-center justify-content-center position-relative shadow-inner" style="min-height: 480px; background-color: #f8fafc !important;">
							<?php if ($is_image): ?>
								<img src="<?php echo $file_path ?>" class="img-fluid rounded" style="max-height: 460px; object-fit: contain; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
							<?php else: ?>
								<iframe src="<?php echo $file_path ?>" style="width: 100%; height: 480px; border: none;" allowfullscreen webkitallowfullscreen></iframe>
							<?php endif; ?>
						</div>
					</div>
					
					<!-- Right Side: Action Panel -->
					<div class="col-lg-4 d-flex flex-column justify-content-between">
						<div>
							<div class="d-flex align-items-center mb-3">
								<div class="bg-primary-light text-primary rounded-circle mr-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: rgba(0, 123, 255, 0.1);">
									<i class="fa fa-clipboard-list" style="font-size: 14px;"></i>
								</div>
								<h6 class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Keputusan Verifikator</h6>
							</div>
							<p class="text-muted mb-4" style="font-size: 12.5px; line-height: 1.45;">
								Periksa keabsahan berkas di samping. Tentukan status validitas dokumen pendaftaran ini dan sertakan catatan perbaikan jika ditolak.
							</p>
							
							<?php echo form_open(base_url('admin/gelombang/dokumen/'.$siswa->slug_siswa), ['onsubmit' => 'return validateModalForm(this)']) ?>
							<?php echo csrf_field(); ?>
							<input type="hidden" name="id_dokumen" value="<?php echo $check_dokumen->id_dokumen ?>">
							
							<!-- Status Select -->
							<div class="form-group mb-3">
								<label class="form-label text-dark font-weight-bold" style="font-size: 13px;">Status Validasi Dokumen</label>
								<select name="status_verifikasi" class="form-control font-weight-bold text-dark" style="border-radius: 6px; height: 40px; font-size: 13.5px;" required>
									<option value="Menunggu" <?php if($check_dokumen->status_verifikasi == 'Menunggu') echo 'selected'; ?>>Menunggu Verifikasi</option>
									<option value="Disetujui" <?php if($check_dokumen->status_verifikasi == 'Disetujui') echo 'selected'; ?>>Setujui / Berkas Valid</option>
									<option value="Ditolak" <?php if($check_dokumen->status_verifikasi == 'Ditolak') echo 'selected'; ?>>Tolak / Perlu Revisi</option>
								</select>
							</div>

							<!-- Notes TextArea -->
							<div class="form-group mb-4">
								<label class="form-label text-dark font-weight-bold d-flex justify-content-between" style="font-size: 13px;">
									Catatan Revisi / Keterangan 
									<span class="text-danger font-weight-normal" style="font-size: 10.5px;">*(Wajib jika Ditolak)</span>
								</label>
								<textarea name="catatan_verifikasi" class="form-control" rows="5" placeholder="Tulis alasan penolakan berkas secara spesifik dan sopan..." style="border-radius: 6px; font-size: 13px; resize: none;"><?php echo esc($check_dokumen->catatan_verifikasi) ?></textarea>
							</div>
						</div>

						<!-- Submit Button -->
						<div>
							<button type="submit" name="verifikasi_dokumen" value="simpan" class="btn btn-primary btn-block font-weight-bold py-2 shadow-sm" style="border-radius: 6px; font-size: 14px;">
								<i class="fa fa-save mr-1"></i> Simpan Status Keputusan
							</button>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Modal Footer -->
			<div class="modal-footer bg-light py-2 border-top">
				<button type="button" class="btn btn-secondary btn-sm font-weight-bold" data-dismiss="modal" style="border-radius: 4px;">
					<i class="fa fa-times mr-1"></i> Tutup
				</button>
			</div>
		</div>
	</div>
</div>