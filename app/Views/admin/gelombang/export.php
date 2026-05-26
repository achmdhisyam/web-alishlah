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

<p>Klik tombol <strong>Excel</strong> pada tabel di bawah ini untuk melakukan Ekspor data ke Excel</p>
<div class="table-responsive">
	<table class="tabelku table-sm" id="example1">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Lengkap</th>
						<th>Nama Panggilan</th>
						<th>L/P</th>
						<th>Tempat Lahir</th>
						<th>Tanggal Lahir</th>
						<th>NIS</th>
						<th>NISN</th>
						<th>Alamat Siswa</th>
						<th>Telepon Siswa</th>
						<th>Email Siswa</th>
						<th>Kewarganegaraan Siswa</th>
						<th>Status Anak</th>
						<th>Anak Ke</th>
						<th>Jumlah Saudara</th>
						<th>Agama Siswa</th>
						<th>Ukuran Seragam</th>
						<th>Asal Sekolah</th>
												
						<th>Nama Ayah</th>
						<th>Agama Ayah</th>
						<th>Tempat Lahir Ayah</th>
						<th>Tanggal Lahir Ayah</th>
						<th>Kewarganegaraan Ayah</th>
						<th>Pendidikan Ayah</th>
						<th>Pekerjaan Ayah</th>
						<th>Penghasilan Ayah</th>
						<th>Status Hidup Ayah</th>
						<th>Alamat Ayah</th>
						<th>Telepon Ayah</th>
						
						<th>Nama Ibu</th>
						<th>Agama Ibu</th>
						<th>Tempat Lahir Ibu</th>
						<th>Tanggal Lahir Ibu</th>
						<th>Kewarganegaraan Ibu</th>
						<th>Pendidikan Ibu</th>
						<th>Pekerjaan Ibu</th>
						<th>Penghasilan Ibu</th>
						<th>Status Hidup Ibu</th>
						<th>Alamat Ibu</th>
						<th>Telepon Ibu</th>

						<th>Identitas Wali</th>
						<th>Nama Wali</th>
						<th>Agama Wali</th>
						<th>Tempat Lahir Wali</th>
						<th>Tanggal Lahir Wali</th>
						<th>Kewarganegaraan Wali</th>
						<th>Pendidikan Wali</th>
						<th>Pekerjaan Wali</th>
						<th>Penghasilan Wali</th>
						<th>Alamat Wali</th>
						<th>Telepon Wali</th>
						
						<th>Status Pendaftaran</th>
						<th>Program Pendidikan</th>
											</tr>
				</thead>
						<tbody>
					<?php $no=1; foreach($siswa as $siswa) { ?>
					<tr>
						<td><?php echo $no ?></td>
						<td><?php echo $siswa->nama_siswa ?></td>
						<td><?php echo $siswa->nama_panggilan ?></td>
						<td><?php echo $siswa->jenis_kelamin ?></td>
						<td><?php echo $siswa->tempat_lahir ?></td>
						<td><?php echo $siswa->tanggal_lahir ?></td>
						<td><?php echo $siswa->nis ?></td>
						<td><?php echo $siswa->nisn ?></td>
						<td><?php echo $siswa->alamat ?></td>
						<td><?php echo $siswa->telepon ?></td>
						<td><?php echo $siswa->email ?></td>
						<td><?php echo $siswa->status_wn ?></td>
						<td><?php echo $siswa->nama_hubungan ?></td>
						<td><?php echo $siswa->anak_ke ?></td>
						<td><?php echo $siswa->jumlah_saudara ?></td>
						<td><?php echo $siswa->nama_agama ?></td>
						<td><?php echo $siswa->ukuran_seragam ?></td>
						<td><?php echo $siswa->asal_sekolah ?></td>
						
						<td><?php echo $siswa->nama_ayah ?></td>
						<td><?php echo $siswa->agama_ayah ?></td>
						<td><?php echo $siswa->tempat_lahir_ayah ?></td>
						<td><?php echo $siswa->tanggal_lahir_ayah ?></td>
						<td><?php echo $siswa->status_wn_ayah ?></td>
						<td><?php echo $siswa->jenjang_ayah ?></td>
						<td><?php echo $siswa->pekerjaan_ayah ?></td>
						<td><?php echo $siswa->penghasilan_ayah ?></td>
						<td><?php echo $siswa->status_hidup_ayah ?></td>
						<td><?php echo $siswa->alamat_ayah ?></td>
						<td><?php echo $siswa->telepon_ayah ?></td>

						<td><?php echo $siswa->nama_ibu ?></td>
						<td><?php echo $siswa->agama_ibu ?></td>
						<td><?php echo $siswa->tempat_lahir_ibu ?></td>
						<td><?php echo $siswa->tanggal_lahir_ibu ?></td>
						<td><?php echo $siswa->status_wn_ibu ?></td>
						<td><?php echo $siswa->jenjang_ibu ?></td>
						<td><?php echo $siswa->pekerjaan_ibu ?></td>
						<td><?php echo $siswa->penghasilan_ibu ?></td>
						<td><?php echo $siswa->status_hidup_ibu ?></td>
						<td><?php echo $siswa->alamat_ibu ?></td>
						<td><?php echo $siswa->telepon_ibu ?></td>

						<td><?php echo $siswa->identitas_wali ?></td>
						<td><?php echo $siswa->nama_wali ?></td>
						<td><?php echo $siswa->agama_wali ?></td>
						<td><?php echo $siswa->tempat_lahir_wali ?></td>
						<td><?php echo $siswa->tanggal_lahir_wali ?></td>
						<td><?php echo $siswa->status_wn_wali ?></td>
						<td><?php echo $siswa->jenjang_wali ?></td>
						<td><?php echo $siswa->pekerjaan_wali ?></td>
						<td><?php echo $siswa->penghasilan_wali ?></td>
						<td><?php echo $siswa->alamat_wali ?></td>
						<td><?php echo $siswa->telepon_wali ?></td>

						<td><?php echo $siswa->status_pendaftaran ?></td>
						<td><?php echo $siswa->judul_program_pendidikan ?></td>
											</tr>
					<?php $no++; } ?>
				</tbody>
	</table>
</div>