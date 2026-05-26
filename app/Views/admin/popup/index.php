<div class="row">
	<div class="col-md-6">
		<?php echo form_open(base_url('admin/popup'), ' method="get"') ?>
		<div class="input-group">
          <input type="text" name="keywords" class="form-control" placeholder="Cari popup..." value="<?php if(isset($_GET['keywords'])) { echo $_GET['keywords']; } ?>" required>
          <span class="input-group-append">
            <button type="submit" name="submit" value="Cari" class="btn btn-secondary btn-flat">
            	<i class="fa fa-search"></i> Cari
            </button>
            <a href="<?php echo base_url('admin/popup/tambah') ?>" class="btn btn-info">
				<i class="fa fa-plus"></i> Tambah Pop Up
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

<div class="mailbox-controls">
<div class="table-responsive mailbox-messages mt-1">		

<table class="tabelku table-sm" id="example2">
	<thead>
		<tr class="text-left bg-light">
			<th width="5%" class="text-center">No</th>
			<th width="15%">Gambar</th>
			<th width="45%">Judul &amp; Informasi Pop Up</th>
			<th width="15%">Status Pop Up</th>
			<th width="15%">Author</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $no=1; foreach($popup as $p) { ?>
		<tr>
			<td class="text-center"><?php echo $no ?></td>
			<td>
				<?php if($p->gambar=="") { echo '-'; }else{ ?>
					<img src="<?php echo base_url('assets/upload/image/thumbs/'.$p->gambar) ?>" class="img img-thumbnail w-100">
				<?php } ?>
			</td>
			<td>
				<strong><?php echo $p->judul_popup ?></strong>
				<small class="text-muted d-block mt-1">
					<?php echo strip_tags($p->isi) ?>
				</small>
				<small class="d-block mt-2">
					<br><i class="fa fa-link"></i> Link Banner/Tautan: <?php echo $p->website ?: '-' ?>
					<textarea title="Copy link gambar popup ini" class="form-control mt-1" rows="1"><?php echo base_url('assets/upload/image/'.$p->gambar) ?></textarea>
				</small>
			</td>
			<td>
				<?php if($p->status_text == 'Ya') { ?>
					<span class="badge badge-success">Aktif</span>
				<?php } else { ?>
					<span class="badge badge-secondary">Tidak Aktif</span>
				<?php } ?>
			</td>
			<td><?php echo $p->nama ?></td>
			<td>
				<a href="<?php echo base_url('admin/popup/edit/'.$p->id_popup) ?>" class="btn btn-secondary btn-xs mb-1"><i class="fa fa-edit"></i></a>
				<a href="<?php echo base_url('admin/popup/delete/'.$p->id_popup) ?>" class="btn btn-secondary btn-xs mb-1 delete-link"><i class="fa fa-trash"></i></a>
			</td>
		</tr>
		<?php $no++; } ?>
	</tbody>
</table>
</div>
</div>
