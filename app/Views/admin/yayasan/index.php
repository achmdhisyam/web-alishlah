<div class="row">
	<div class="col-md-6">
		<?php echo form_open(base_url('admin/yayasan'), ' method="get"') ?>
		<div class="input-group">
          <input type="text" name="keywords" class="form-control" placeholder="Keywords..." value="<?php if(isset($_GET['keywords'])) { echo $_GET['keywords']; } ?>" required>
          <span class="input-group-append">
            <button type="submit" name="submit" value="Cari" class="btn btn-secondary btn-flat">
            	<i class="fa fa-search"></i> Cari
            </button>
            <a href="<?php echo base_url('admin/yayasan/tambah') ?>" class="btn btn-info">
				<i class="fa fa-plus"></i> Tambah Baru
			</a>
            <a href="<?php echo base_url('admin/yayasan/import') ?>" class="btn btn-success">
				<i class="fa fa-file-excel"></i> Import Excel
			</a>
          </span>
        </div>
        <?php echo form_close() ?>
	</div>
	<div class="col-md-6">
			<?php if(isset($pagination)) { echo str_replace('index.php/','',$pagination); } ?>
	</div>
</div>
<hr>

<?php echo form_open(base_url('admin/yayasan/proses')) ?>
<input type="hidden" name="pengalihan" value="<?php echo str_replace('index.php','',CURRENT_URL()) ?>">
<div class="mailbox-controls">

	<button type="submit" name="submit" value="Delete" class="btn btn-secondary btn-sm" title="Hapus Informasi Yayasan">
		<i class="fa fa-trash"></i>
	</button>
	<button type="submit" name="submit" value="Draft" class="btn btn-secondary btn-sm" title="Jangan Publikasikan">
		<i class="fa fa-eye-slash"></i> Jangan Publikasikan
	</button>
	<button type="submit" name="submit" value="Publish" class="btn btn-dark btn-sm" title="Publikasikan">
		<i class="fa fa-eye"></i> Publikasikan
	</button>



<div class="table-responsive mailbox-messages mt-1">		

<table class="tabelku table-sm" id="example2">
	<thead>
		<tr class="text-left bg-light">
			<th width="5%" class="text-center">
				<button type="button" class="btn btn-default btn-sm checkbox-toggle">
					<i class="far fa-square"></i>
        </button>
			</th>
			<th width="8%">Gambar</th>
			<th width="50%">Judul Informasi</th>
			<th width="20%">Penulis</th>
			<th width="10%">Status</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $no=1; foreach($yayasan as $item) { ?>
		<tr>
			<td class="text-center">
				<div class="icheck-primary">
          <input type="checkbox" name="id_yayasan[]" value="<?php echo $item->id_yayasan ?>" id="check_<?php echo $no ?>">
          <label for="check_<?php echo $no ?>"></label>
        </div>
				<?php echo $no ?>
			</td>
			<td>
				<?php if($item->gambar=="") { echo '-'; }else{ ?>
					<img src="<?php echo base_url('assets/upload/image/thumbs/'.$item->gambar) ?>" class="img img-thumbnail">
				<?php } ?>
			</td>
			<td><a href="<?php echo base_url('admin/yayasan/edit/'.$item->id_yayasan) ?>">
					<?php echo $item->judul_yayasan ?>
				</a>
				<small>
					<br><i class="fa fa-calendar-check"></i> <?php echo $this->website->tanggal_bulan_menit($item->tanggal_publish) ?>
					<br><i class="fa fa-calendar-plus"></i> <?php echo $this->website->tanggal_bulan_menit($item->tanggal_post) ?>
					<br><i class="fa fa-eye"></i> <?php echo $item->hits ?> | <i class="fa fa-sort-numeric-up"></i> <?php echo $item->urutan ?> | <i class="<?php echo $item->icon ?>"></i> <?php echo $item->icon ?>
				</small>
			</td>
			<td><small>
				<i class="fa fa-user"></i> <a href="<?php echo base_url('admin/yayasan/author/'.$item->id_user) ?>">
						<?php echo $item->nama ?>
					</a>
			</small>
			</td>
			<td>
				<a href="<?php echo base_url('admin/yayasan/status_yayasan/'.$item->status_yayasan) ?>">
				<?php if($item->status_yayasan=='Publish') { ?>
					<span class="badge bg-info">
						<i class="fa fa-eye"></i> <?php echo $item->status_yayasan ?>
					</span>
				<?php }else{ ?>
					<span class="badge bg-secondary">
						<i class="fa fa-eye-slash"></i> Not Published
					</span>
				<?php } ?>
				</a>
			</td>
			<td>
				<a href="<?php echo base_url('yayasan/read/'.$item->slug_yayasan) ?>" class="btn btn-secondary btn-xs mt-1" target="_blank" title="Baca"><i class="fa fa-eye"></i></a>
				<a href="<?php echo base_url('admin/yayasan/edit/'.$item->id_yayasan) ?>" class="btn btn-secondary btn-xs mt-1" title="Edit"><i class="fa fa-edit"></i></a>
				<a href="<?php echo base_url('admin/yayasan/delete/'.$item->id_yayasan) ?>" class="btn btn-secondary btn-xs mt-1 delete-link" title="Hapus"><i class="fa fa-trash"></i></a>
			</td>
		</tr>
		<?php $no++; } ?>
	</tbody>
</table>
</div>
</div>
<?php echo form_close(); ?>
