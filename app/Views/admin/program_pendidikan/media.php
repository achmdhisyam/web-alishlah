<div class="modal fade" id="modal-media">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Unggah dan Kelola Media</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

        
        <form action="<?php echo base_url('admin/media/unggah') ?>" class="dropzone rounded-3 p-2 text-center bg-light border border-primary rounded border-dashed" id="mediaDropzone">
			    <div class="dz-message text-primary fw-bold">
			        <i class="fas fa-cloud-upload-alt fa-3x mb-3"></i><br>
			        Seret & Lepas file di sini atau klik untuk mengunggah. 
                    <br><small class="text-secondary">File diizinkan: <em>.jpg,.jpeg,.png,.gif,.zip,.rar,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.mp4,.avi,.mkv</em></small>
			    </div>
			</form>

      	<div class="clearfix mt-2"></div>
        <table id="mediaTable" class="table table-bordered mt-2" width="100%">
            <thead>
                <tr>
                    <th width="10%">Preview</th>
                    <th width="70%">URL</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    

    <script>
        Dropzone.options.mediaDropzone = {
            paramName: "file",
            maxFilesize: 24,
            acceptedFiles: ".jpg,.jpeg,.png,.gif,.zip,.rar,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.mp4,.avi,.mkv",
            success: function () {
                $('#mediaTable').DataTable().ajax.reload();
            }
        };

        $(document).ready(function () {
            var table = $('#mediaTable').DataTable({
            		autoWidth: false,
                ajax: "<?php echo base_url('admin/media/show') ?>",
                columns: [
                    {
                        data: "gambar",
                        width: "10%",
                        render: function (data, type, row) {
                            if (['jpg', 'jpeg', 'png', 'gif'].includes(row.file_ext)) {
                                return `<img src="<?= base_url('assets/upload/file/') ?>${data}" class="img img-thumbnail">`;
                            } else {
                                return `<span>${row.file_ext.toUpperCase()} (${row.file_size} MB)</span>`;
                            }
                        }
                    },
                    {
                        data: "gambar",
                        width: "70%",
                        render: function (data) {
                            return `<input type="text" class="form-control" value="<?= base_url('assets/upload/file/') ?>${data}" readonly>`;
                        }
                    },
                    {
                        data: "gambar",
                        width: "20%",
                        render: function (data) {
                            return `<button class="btn btn-primary btn-sm btn-copy" data-url="<?= base_url('assets/upload/file/') ?>${data}"><i class="fa fa-copy"></i> Salin Link</button>`;
                        }
                    }
                ]
            });

            $(document).on('click', '.btn-copy', function () {
                var url = $(this).data('url');
                navigator.clipboard.writeText(url).then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'URL berhasil disalin!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            });

        });
    </script>

			</div>
			<!-- modal body -->
			<div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Tutup</button>
            </div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
