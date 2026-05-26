<div class="row">
	<div class="col-md-6">
		<?php echo form_open(base_url('admin/sambutan'), ' method="get"') ?>
		<div class="input-group">
          <input type="text" name="keywords" class="form-control" placeholder="Keywords..." value="<?php if(isset($_GET['keywords'])) { echo $_GET['keywords']; } ?>" required>
          <span class="input-group-append">
            <button type="submit" name="submit" value="Cari" class="btn btn-secondary btn-flat">
            	<i class="fa fa-search"></i> Cari
            </button>
            <a href="<?php echo base_url('admin/sambutan/tambah') ?>" class="btn btn-info">
				<i class="fa fa-plus"></i> Tambah Baru
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

<?php echo form_open(base_url('admin/sambutan/proses')) ?>
<input type="hidden" name="pengalihan" value="<?php echo str_replace('index.php','',CURRENT_URL()) ?>">
<div class="mailbox-controls">

	<button type="submit" name="submit" value="Delete" class="btn btn-secondary btn-sm" title="Hapus Sambutan">
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
			<th width="50%">Judul Sambutan</th>
			<th width="20%">Penulis</th>
			<th width="10%">Status</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $no=1; foreach($sambutan as $item) { ?>
		<tr>
			<td class="text-center">
				<div class="icheck-primary">
          <input type="checkbox" name="id_sambutan[]" value="<?php echo $item->id_sambutan ?>" id="check_<?php echo $no ?>">
          <label for="check_<?php echo $no ?>"></label>
        </div>
				<?php echo $no ?>
			</td>
			<td>
				<?php if($item->gambar=="") { echo '-'; }else{ ?>
					<img src="<?php echo base_url('assets/upload/image/thumbs/'.$item->gambar) ?>" class="img img-thumbnail">
				<?php } ?>
			</td>
			<td><a href="<?php echo base_url('admin/sambutan/edit/'.$item->id_sambutan) ?>">
					<?php echo $item->judul_sambutan ?>
				</a>
				<small>
					<br><i class="fa fa-calendar-check"></i> <?php echo $this->website->tanggal_bulan_menit($item->tanggal_publish) ?>
					<br><i class="fa fa-calendar-plus"></i> <?php echo $this->website->tanggal_bulan_menit($item->tanggal_post) ?>
					<br><i class="fa fa-eye"></i> <?php echo $item->hits ?>
				</small>
			</td>
			<td><small>
				<i class="fa fa-user"></i> <a href="<?php echo base_url('admin/sambutan/author/'.$item->id_user) ?>">
						<?php echo $item->nama ?>
					</a>
			</small>
			</td>
			<td>
				<a href="<?php echo base_url('admin/sambutan/status_sambutan/'.$item->status_sambutan) ?>">
				<?php if($item->status_sambutan=='Publish') { ?>
					<span class="badge bg-info">
						<i class="fa fa-eye"></i> <?php echo $item->status_sambutan ?>
					</span>
				<?php }else{ ?>
					<span class="badge bg-secondary">
						<i class="fa fa-eye-slash"></i> Not Published
					</span>
				<?php } ?>
				</a>
			</td>
			<td>
				<a href="<?php echo base_url('admin/sambutan/edit/'.$item->id_sambutan) ?>" class="btn btn-secondary btn-xs mt-1" title="Edit"><i class="fa fa-edit"></i></a>
				<a href="<?php echo base_url('admin/sambutan/delete/'.$item->id_sambutan) ?>" class="btn btn-secondary btn-xs mt-1 delete-link" title="Hapus"><i class="fa fa-trash"></i></a>
			</td>
		</tr>
		<?php $no++; } ?>
	</tbody>
</table>
</div>
</div>
<?php echo form_close(); ?>
