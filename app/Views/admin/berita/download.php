<div class="modal fade" id="modal-download">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">File Download</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="callout callout-info p-2">
					Anda dapat mengelola data file download di <a href="<?php echo base_url('admin/download') ?>">Kelola File Download</a>. <br>Silakan copy link gambar di bawah ini untuk menggunakan link download.
				</div>

				<table class="table table-bordered table-sm" id="downloadListing">
				    <thead>
				        <tr class="text-center bg-secondary">
				        	<th width="10%">FILE</th>
							<th width="70%">LINK DOWNLOAD</th>
							<th width="20%">SALIN LINK</th>
				        </tr>
				    </thead>
				    <tbody id="listDownload">                    
				    </tbody>
				</table>

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

<script>
$(document).ready(function(){
    listDownload();		
    
    var table = $('#downloadListing').dataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "order": [[ 0, "desc" ]]
    }); 

    // List all downloads in datatable
    function listDownload(){
        $.ajax({
            type  : 'ajax',
            url   : '<?php echo base_url("admin/download/show") ?>',
            async : false,
            type  : "get",
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success : function(data){
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    var fileUrl = '<?php echo base_url("download/unduh/") ?>' + data[i].id_download;
                    html += '<tr id="'+data[i].id_download+'">'+
                            '<td class="text-center text-uppercase">'+data[i].file_ext+' ('+data[i].file_size+' MB)</td>'+
                            '<td>'+data[i].judul_download+'<br>'+
                            '<input readonly class="form-control form-control-sm" value="'+fileUrl+'"></td>'+
                            '<td class="text-center">'+
                            '<button class="btn btn-primary btn-sm btn-copy" data-url="'+fileUrl+'">'+
                            '<i class="fa fa-copy"></i> Salin URL</button></td>'+
                            '</tr>';
                }
                $('#listDownload').html(html);					
            }
        });
    }

    // Event listener untuk tombol salin URL
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