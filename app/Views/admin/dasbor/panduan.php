<table class="tabelku table-sm" id="example2">
	<thead>
		<tr class="text-left bg-light">
			<th class="text-center" width="5%">No</th>
			<th width="35%">Judul</th>
			<th width="35%">Deskripsi</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $no=1; foreach($download as $download) { ?>
		<tr>
			<td class="text-center"><?php echo $no ?></td>
			
			<td><?php echo $download->judul_download ?></td>
			<td><?php echo $download->isi ?></td>
			<td>
					
					<button type="button" class="btn btn-info btn-sm mt-1" data-toggle="modal" data-target="#modal-<?php echo $download->id_download ?>">
	                  <i class="fa fa-eye"></i> Lihat
	                </button>

					<a href="<?php echo base_url('admin/download/unduh/'.$download->id_download) ?>" class="btn btn-success btn-sm mt-1" target="_blank"><i class="fa fa-download"></i> Unduh</a>

					<div class="modal fade" id="modal-<?php echo $download->id_download ?>">
						<div class="modal-dialog modal-xl">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title"><?php echo $download->judul_download ?></h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">

									 <iframe src="<?php echo base_url('assets/upload/file/'.$download->gambar) ?>"  height="500" style="width:100%;" allowfullscreen webkitallowfullscreen></iframe>

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
				
			</td>
		</tr>
		<?php $no++; } ?>
	</tbody>
</table>