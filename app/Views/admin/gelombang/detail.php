<p class="text-right">
	<a href="<?php echo base_url('admin/gelombang') ?>" class="btn btn-outline-info btn-xs mb-1" >
		<i class="fa fa-arrow-left"></i> Kembali
	</a>
	<a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Semua/Semua') ?>" class="btn btn-warning btn-xs mb-1">
      	<i class="fa fa-users"></i> Semua Program Pendidikan (<?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Semua','Semua')->total); ?>)
      </a>
      <?php if($id_program_pendidikan != 'Semua') { ?>
      <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Semua/'.$id_program_pendidikan) ?>" class="btn btn-info btn-xs mb-1">
            <i class="fa fa-user-check"></i> <?php echo $judul_program_pendidikan ?> (<?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Semua',$id_program_pendidikan)->total); ?>)
      </a>
    <?php } ?>

      <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Menunggu/'.$id_program_pendidikan) ?>" class="btn btn-dark btn-xs mb-1">
      	<i class="fa fa-tasks"></i> Menunggu (<?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Menunggu',$id_program_pendidikan)->total); ?>)
      </a>
      <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Diterima/'.$id_program_pendidikan) ?>" class="btn btn-success btn-xs mb-1">
      	<i class="fa fa-check-circle"></i> Diterima (<?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Diterima',$id_program_pendidikan)->total); ?>)
      </a>
      <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Tidak-Diterima/'.$id_program_pendidikan) ?>" class="btn btn-warning btn-xs mb-1">
      	<i class="fa fa-times-circle"></i> Tidak Diterima (<?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Tidak-Diterima',$id_program_pendidikan)->total); ?>)
      </a>
      <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Diperiksa/'.$id_program_pendidikan) ?>" class="btn btn-secondary btn-xs mb-1">
      	<i class="fa fa-edit"></i> Diperiksa (<?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Diperiksa',$id_program_pendidikan)->total); ?>)
      </a>
	<a href="<?php echo base_url('admin/gelombang/export/'.$gelombang->id_gelombang.'/'.$status_pendaftaran.'/'.$id_program_pendidikan) ?>" class="btn btn-success btn-xs mb-1" target="_blank"><i class="fa fa-file-excel"></i> Ekspor Siswa</a>
	<a href="<?php echo base_url('admin/gelombang/unduh_data/'.$gelombang->id_gelombang.'/'.$status_pendaftaran.'/'.$id_program_pendidikan) ?>" class="btn btn-danger btn-xs mb-1" target="_blank"><i class="fa fa-file-pdf"></i> Cetak</a>
	<a href="<?php echo base_url('admin/gelombang/unduh_pengumuman/'.$gelombang->id_gelombang.'/'.$status_pendaftaran.'/'.$id_program_pendidikan) ?>" class="btn btn-danger btn-xs mb-1" target="_blank"><i class="fa fa-file-pdf"></i> Cetak Pengumuman</a>
	<a href="<?php echo base_url('pendaftaran') ?>" class="btn btn-primary btn-xs mb-1" target="_blank"><i class="fa fa-eye"></i> Baca</a>
</p>

<div class="row">
	<div class="col-md-12">
		<table class="tabelku table-sm mb-3">
			<thead>
				<tr>
					<th width="30%">Nama Periode</th>
					<th><?php echo $gelombang->judul ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Tanggal pelaksanaan</td>
					<td>
						<span class="text-secondary">Pembukaan:</span> <?php echo $this->website->hari($gelombang->tanggal_buka) ?>
						<br><span class="text-secondary">Penutupan:</span> <?php echo $this->website->hari($gelombang->tanggal_tutup) ?>
						<br><span class="text-secondary">Pengumuman:</span> <?php echo $this->website->hari($gelombang->tanggal_pengumuman) ?>
					</td>
				</tr>
				<tr>
					<td>Periode</td>
					<td><?php echo $gelombang->tahun ?></td>
				</tr>
				<tr>
					<td>Tahun Ajaran</td>
					<td><?php echo $gelombang->tahun_ajaran ?></td>
				</tr>
				<tr>
					<td>Status</td>
					<td>
						<?php if($gelombang->status_gelombang=='Buka') { ?>
							<span class="badge bg-info">
								<i class="fa fa-eye"></i> <?php echo $gelombang->status_gelombang ?>
							</span>
						<?php }else{ ?>
							<span class="badge bg-secondary">
								<i class="fa fa-eye-slash"></i> Not Published
							</span>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td>Program Pendidikan</td>
					<td><?php echo $judul_program_pendidikan ?></td>
				</tr>
				<tr>
					<td>Status Pendaftaran</td>
					<td><?php echo $status_pendaftaran ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-4">
		<table class="tabelku table-sm mb-3">
			<thead>
				<tr>
					<th width="70%" colspan="2"><?php echo $judul_program_pendidikan ?></th>
					<th>Jumlah</th>
				</tr>
			</thead>
			<tbody>

		<tr>
			<td class="text-center" width="5%"><i class="fa fa-user-check"></i></td>
			<td>Jumlah Pendaftar</td>
			<td>
				<?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Semua',$id_program_pendidikan)->total); ?>
			</td>
		</tr>
		<tr>
			<td class="text-center"><i class="fa fa-tasks"></i></td>
			<td>Jumlah Menunggu</td>
			<td>
				<?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Menunggu',$id_program_pendidikan)->total); ?>
			</td>
		</tr>
		<tr>
			<td class="text-center"><i class="fa fa-check-circle"></i></td>
			<td>Jumlah Diterima</td>
			<td>
				<?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Diterima',$id_program_pendidikan)->total); ?>
			</td>
		</tr>
		<tr>
			<td class="text-center"><i class="fa fa-times-circle"></i></td>
			<td>Jumlah Tidak Diterima</td>
			<td>
				<?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Tidak-Diterima',$id_program_pendidikan)->total); ?>
			</td>
		</tr>
		<tr>
			<td class="text-center"><i class="fa fa-edit"></i></td>
			<td>Jumlah Diperiksa</td>
			<td>
				<?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Diperiksa',$id_program_pendidikan)->total); ?>
			</td>
		</tr>
	</tbody>
</table>
	</div>
	<div class="col-md-8">
		<table class="tabelku table-sm mb-3">
			<thead>
				<tr>
					<th width="30%">Jenjang/program</th>
					<th width="15%">Status</th>
					<th width="15%">Jumlah</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($akumulasi as $akumulasi) { ?>
					<tr>
						<td><?php echo $akumulasi->judul_program_pendidikan ?></td>
						<td>
							<?php if($akumulasi->status_pendaftaran=='Menunggu') { ?>
                    <span class="badge badge-warning"><i class="fa fa-clock"></i>&nbsp;<?php echo $akumulasi->status_pendaftaran ?></span>
                  <?php }elseif($akumulasi->status_pendaftaran=='Diterima') { ?>
                    <span class="badge badge-success"><i class="fa fa-check-circle"></i>&nbsp;<?php echo $akumulasi->status_pendaftaran ?></span>
                  <?php }elseif($akumulasi->status_pendaftaran=='Tidak-Diterima') { ?>
                    <span class="badge badge-danger"><i class="fa fa-times-circle"></i>&nbsp;<?php echo $akumulasi->status_pendaftaran ?></span>
                  <?php }else{ ?>
                    <span class="badge badge-info"><i class="fa fa-tasks"></i>&nbsp;<?php echo $akumulasi->status_pendaftaran ?></span>
                  <?php } ?>
						</td>
						<td><?php echo $this->website->angka($akumulasi->jumlah_siswa) ?></td>
						<td>
							<a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/'.$akumulasi->status_pendaftaran.'/'.$akumulasi->id_program_pendidikan) ?>" class="btn btn-secondary btn-xs mb-1">
				      	<i class="fa fa-user-check"></i> Lihat
				      </a>
				      <a href="<?php echo base_url('admin/gelombang/export/'.$gelombang->id_gelombang.'/'.$akumulasi->status_pendaftaran.'/'.$akumulasi->id_program_pendidikan) ?>" class="btn btn-secondary btn-xs mb-1" target="_blank">
				      	<i class="fa fa-file-excel"></i> Ekspor Program
				      </a>
				      <a href="<?php echo base_url('admin/gelombang/unduh_data/'.$gelombang->id_gelombang.'/'.$akumulasi->status_pendaftaran.'/'.$akumulasi->id_program_pendidikan) ?>" class="btn btn-secondary btn-xs mb-1" target="_blank">
				      	<i class="fa fa-file-pdf"></i> Unduh
				      </a>
				      <a href="<?php echo base_url('admin/gelombang/unduh_pengumuman/'.$gelombang->id_gelombang.'/'.$akumulasi->status_pendaftaran.'/'.$akumulasi->id_program_pendidikan) ?>" class="btn btn-danger btn-xs mb-1" target="_blank">
				      	<i class="fa fa-file-pdf"></i> Pengumuman
				      </a>
						</td>
					</tr>
				<?php } ?>
	</tbody>
</table>
</div>
</div>

		

<?php echo form_open(base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/'.$status_pendaftaran.'/'.$id_program_pendidikan)) ?>
<input type="hidden" name="pengalihan" value="<?php echo str_replace('index.php','',CURRENT_URL()) ?>">
<div class="mailbox-controls">


<input type="hidden" name="pengalihan" value="<?php echo str_replace('index.php/','',CURRENT_URL()) ?>">

<div class="row">
  <div class="col-md-12">
    <div class="input-group">

      <select name="status_pendaftaran" class="form-control" required>
      	<option value="">Pilih Status Siswa</option>
        <option value="Menunggu">Menunggu</option>
        <option value="Diterima">Diterima</option>
        <option value="Tidak-Diterima">Tidak Diterima</option>
        <option value="Diperiksa">Diperiksa</option>
      </select>
      <span class="input-group-btn" >
        <button type="submit" class="btn btn-info" name="submit" value="update"><i class="fa fa-save"></i> Update Status SPMB</button>
      </span>
      <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Semua/Semua') ?>" class="btn btn-warning">
      	<i class="fa fa-users"></i> Lihat Semua Program Pendidikan (<?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Semua','Semua')->total); ?>)
      </a>
    </div>
  </div>

  <div class="col-md-6">
      
      
 	</div>
    </div>
    <div class="clearfix"><hr></div>
    <div class="table-responsive mailbox-messages">
      <table id="example2" class="tabelku table-sm" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th width="5%" rowspan="2" class="text-center align-middle">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
              </div>
            </th>
			<th width="20%" class="align-middle" rowspan="2">Nama dan Informasi</th>
      		<th width="20%" class="align-middle" rowspan="2">Alamat</th>
      		<th width="32%" class="align-middle text-center" colspan="4">Dokumen Pendukung</th>
      		<th width="6%" class="align-middle" rowspan="2">Status</th>
			<th rowspan="2"></th>
		</tr>
		<tr>
			<th class="text-center align-middle" width="8%">Wajib</th>
			<th class="text-center align-middle" width="8%">Sudah Diunggah</th>
			<th class="text-center align-middle" width="8%">Tidak Wajib</th>
			<th class="text-center align-middle" width="8%">Sudah Diunggah</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$i=1; foreach($siswa as $siswa) { 
			$wajib 					= $m_jenis_dokumen->group_status_jenis_dokumen_detail('Wajib');
			$tidak_wajib 			= $m_jenis_dokumen->group_status_jenis_dokumen_detail('Tidak Wajib');
			$dokumen_wajib 			= $m_dokumen->total_check($siswa->id_siswa,$wajib->status_jenis_dokumen); 
			$dokumen_tidak_wajib 	= $m_dokumen->total_check($siswa->id_siswa,$tidak_wajib->status_jenis_dokumen);
		?>
		<tr>
			<td class="text-center">
            <div class="icheck-primary">
              <input type="checkbox" name="id_siswa[]" value="<?php echo $siswa->id_siswa ?>" id="check<?php echo $i ?>">
              <label for="check<?php echo $i ?>"></label>
            </div>
          </td>
			<td><strong><?php echo $siswa->nama_siswa ?></strong>
				<small>
					<br><span class="text-secondary">Program:</span> <strong><?php echo $siswa->judul_program_pendidikan ?></strong>
					<br><span class="text-secondary">Kode:</span> <strong><?php echo $siswa->kode_siswa ?></strong>
					<br><span class="text-secondary">NIS/NISN:</span> <?php echo $siswa->nis ?>/<?php echo $siswa->nisn ?>
		          	<br><span class="text-secondary">Panggilan:</span> <?php echo $siswa->nama_panggilan ?>
					<br><span class="text-secondary">TTL:</span> <?php echo $siswa->tempat_lahir ?>, <?php echo $this->website->tanggal_id($siswa->tanggal_lahir) ?>
					<br><span class="text-secondary">Kelamin:</span> <?php if($siswa->jenis_kelamin=='L') { echo 'Laki-laki'; }else{ echo 'Perempuan'; } ?>
					<br><span class="text-secondary">Wali:</span><?php echo $siswa->nama_wali ?>
		          	<br><span class="text-secondary">Usia:</span> 
			          <?php 
			          // jeda
			          $date1 = $siswa->tanggal_lahir;
			          $date2 = date('Y-m-d');

			          $diff   = abs(strtotime($date2) - strtotime($date1));

			          $years  = floor($diff / (365*60*60*24));
			          $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			          $days   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			          ?>
			          <?php echo $years; ?> Tahun <?php echo $months; ?> Bulan <?php echo $days; ?> Hari
		          
				</small>
			</td>
      		<td><?php echo $siswa->alamat ?>
      			<small>
      				<br><span class="text-secondary">Telepon:</span> <?php echo $siswa->telepon ?>
      				<br><span class="text-secondary">Email:</span> <?php echo $siswa->email ?>
      			</small>
      		</td>
      		<td class="text-center"><?php echo $wajib->total ?></td>
      		<td class="text-center <?php if($dokumen_wajib >= $wajib->total) { echo 'text-success'; }else{ echo 'text-danger'; } ?>"><?php  echo $dokumen_wajib; ?></td>
      		<td class="text-center"><?php echo $tidak_wajib->total ?></td>
      		<td class="text-center <?php if($dokumen_tidak_wajib >= $tidak_wajib->total) { echo 'text-success'; }else{ echo 'text-danger'; } ?>"><?php  echo $dokumen_tidak_wajib; ?></td>
      		
		    <td>
		        <?php if($siswa->status_pendaftaran=='Menunggu') { ?>
                    <span class="badge badge-warning"><i class="fa fa-clock"></i>&nbsp;<?php echo $siswa->status_pendaftaran ?></span>
                  <?php }elseif($siswa->status_pendaftaran=='Diterima') { ?>
                    <span class="badge badge-success"><i class="fa fa-check-circle"></i>&nbsp;<?php echo $siswa->status_pendaftaran ?></span>
                  <?php }elseif($siswa->status_pendaftaran=='Tidak-Diterima') { ?>
                    <span class="badge badge-danger"><i class="fa fa-times-circle"></i>&nbsp;<?php echo $siswa->status_pendaftaran ?></span>
                  <?php }else{ ?>
                    <span class="badge badge-info"><i class="fa fa-tasks"></i>&nbsp;<?php echo $siswa->status_pendaftaran ?></span>
                  <?php } ?>
		    </td>
			<td>
				<!-- <a href="<?php echo base_url('admin/gelombang/review/'.$siswa->slug_siswa) ?>" class="btn btn-success btn-xs mb-1" title="Edit"><i class="fa fa-tasks"></i> Review</a> -->

					<a href="<?php echo base_url('admin/gelombang/dokumen/'.$siswa->slug_siswa) ?>" class="btn btn-info btn-xs mb-1" title="Edit"><i class="fa fa-tasks"></i> Review</a>

			        <a href="<?php echo base_url('admin/gelombang/cetak/'.$siswa->slug_siswa) ?>" class="btn btn-danger btn-xs mb-1" title="Unduh" target="_blank"><i class="fa fa-file-pdf"></i></a>
			        <a href="<?php echo base_url('admin/gelombang/edit_siswa/'.$siswa->slug_siswa) ?>" class="btn btn-warning btn-xs mb-1" title="Edit"><i class="fa fa-edit"></i></a>
        			<?php if($siswa->status_pendaftaran=='Menunggu') { ?>
						<a href="<?php echo base_url('admin/gelombang/delete_siswa/'.$siswa->slug_siswa.'/'.$siswa->id_gelombang) ?>" class="btn btn-secondary btn-xs delete-link mb-1" title="Hapus"><i class="fa fa-trash"></i></a>
					<?php } ?>
			</td>
		</tr>
		<?php $i++; } ?>
	</tbody>
</table>
</div>
</div>


<?php echo form_close(); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // validasi sebelum submit
  document.querySelector("form").addEventListener("submit", function(e) {
    let cek = document.querySelectorAll('input[name="id_siswa[]"]:checked').length;
    if (cek === 0) {
      e.preventDefault(); // hentikan submit form
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Pilih minimal satu siswa dulu sebelum update status!',
      });
    }
  });
</script>
