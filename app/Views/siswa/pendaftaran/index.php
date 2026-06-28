<?php if($siswa) { ?>
	<div class="callout callout-success">
		Berikut adalah data pendaftaran Anda.
	</div>

	<table class="tabelku table-sm" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th width="5%" rowspan="2">NO</th>
			<th width="20%" class="align-middle" rowspan="2">Nama dan Informasi</th>
      		<th width="20%" class="align-middle" rowspan="2">Alamat</th>
      		<th width="36%" class="align-middle text-center" colspan="4">Dokumen Pendukung</th>
      		<th width="6%" class="align-middle" rowspan="2">Status</th>
			<th rowspan="2"></th>
		</tr>
		<tr>
			<th class="text-center align-middle" width="6%">Wajib</th>
			<th class="text-center align-middle" width="6%">Sudah Diunggah</th>
			<th class="text-center align-middle" width="6%">Tidak Wajib</th>
			<th class="text-center align-middle" width="6%">Sudah Diunggah</th>
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
			<td class="text-center"><?php echo $i ?></td>
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
      		<td>
            <?php 
            if(!empty($siswa->rt) || !empty($siswa->rw) || !empty($siswa->kecamatan)) {
                $full = $siswa->alamat;
                if(!empty($siswa->rt) || !empty($siswa->rw)) { $full .= ', RT '.$siswa->rt.' / RW '.$siswa->rw; }
                if(!empty($siswa->kelurahan)) { $full .= ', Kel. '.$siswa->kelurahan; }
                if(!empty($siswa->kecamatan)) { $full .= ', Kec. '.$siswa->kecamatan; }
                if(!empty($siswa->kabupaten)) { $full .= ', '.$siswa->kabupaten; }
                if(!empty($siswa->provinsi)) { $full .= ', '.$siswa->provinsi; }
                echo nl2br($full);
            } else {
                echo nl2br($siswa->alamat);
            }
            ?>
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
                    <span class="badge badge-warning"><i class="fa fa-clock"></i>&nbsp;Menunggu</span>
                  <?php }elseif($siswa->status_pendaftaran=='Diterima') { ?>
                    <span class="badge badge-success"><i class="fa fa-check-circle"></i>&nbsp;Diterima</span>
                  <?php }elseif($siswa->status_pendaftaran=='Tidak-Diterima') { ?>
                    <span class="badge badge-danger"><i class="fa fa-times-circle"></i>&nbsp;Tidak Diterima</span>
                  <?php }else{ ?>
                    <span class="badge badge-info"><i class="fa fa-tasks"></i>&nbsp;<?php echo $siswa->status_pendaftaran ?></span>
                  <?php } ?>
		    </td>
			<td>
					<a href="<?php echo base_url('siswa/pendaftaran/dokumen/'.$siswa->slug_siswa) ?>" class="btn btn-info btn-xs mb-1" title="Edit"><i class="fa fa-upload"></i> Unggah Dokumen</a>

			        <a href="<?php echo base_url('siswa/pendaftaran/cetak/'.$siswa->slug_siswa) ?>" class="btn btn-danger btn-xs mb-1" title="Cetak"><i class="fa fa-file-pdf"></i> Cetak</a>
			        <a href="<?php echo base_url('siswa/pendaftaran/edit/'.$siswa->slug_siswa) ?>" class="btn btn-warning btn-xs mb-1" title="Edit"><i class="fa fa-edit"></i></a>
        			<?php if($siswa->status_pendaftaran=='Menunggu') { ?>
						<a href="<?php echo base_url('siswa/pendaftaran/delete/'.$siswa->slug_siswa) ?>" class="btn btn-secondary btn-xs delete-link mb-1" title="Hapus"><i class="fa fa-trash"></i></a>
					<?php } ?>
			</td>
		</tr>
		<?php $i++; } ?>
	</tbody>
</table>
<?php }else{ ?>
	<div class="alert alert-info">
		Mohon Maaf, Anda belum melakukan pendaftaran.
	</div>
<?php } ?>