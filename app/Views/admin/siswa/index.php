<?php 
$uri = service('uri');
?>
<form action="<?php echo base_url('admin/siswa') ?>" method="get" accept-charset="utf-8" enctype="multipart/form-data">
<div class="row">

  <div class="col-md-7">
    <div class="input-group">                  
      <input type="text" name="keywords" class="form-control" placeholder="Ketik kata kunci pencarian siswa...." value="<?php if(isset($_GET['keywords'])) { echo $_GET['keywords']; } ?>" required>
      <span class="input-group-btn ">
        <button type="submit" class="btn btn-secondary btn-flat"><i class="fa fa-search"></i></button>

        <a href="<?php echo base_url('admin/siswa/import') ?>" class="btn btn-secondary">
        <i class="fa fa-file-excel"></i> Import Siswa</a>
        <a href="<?php echo base_url('admin/siswa/tambah') ?>" class="btn btn-info">
        <i class="fa fa-plus"></i> Tambah Baru</a>
      </span>
    </div>
  </div>
  <div class="col-md-5 text-left">
    <?php if(isset($pagination)) { echo str_replace('index.php/','',$pagination); } ?>
  </div>
</div>
</form>
<div class="clearfix"><hr></div>
<!-- Form untuk hapus data -->
<?php echo form_open(base_url('admin/siswa/proses'), array('id' => 'form-hapus-data')); ?>

<input type="hidden" name="pengalihan" value="<?php echo str_replace('index.php/','',CURRENT_URL()) ?>">

<div class="row">
  <div class="col-md-6">
    <div class="input-group input-group-sm">
      <select name="aksi_massal" class="form-control" id="aksi-massal-select" required>
        <option value="">-- Pilih Aksi Massal --</option>
        <option value="delete">Hapus Pendaftar Terpilih</option>
        <option value="update-Aktif">Ubah Status: Aktif</option>
        <option value="update-Lulus">Ubah Status: Lulus</option>
        <option value="update-Meninggal">Ubah Status: Meninggal</option>
        <option value="update-Pindah">Ubah Status: Pindah</option>
      </select>
      <span class="input-group-btn" >
        <button type="submit" class="btn btn-secondary btn-sm" name="proses_aksi" id="proses-aksi-massal-btn"><i class="fa fa-play"></i> Proses Aksi</button>
      </span>
    </div>
  </div>

  <div class="col-md-6">
      


        
        <?php 
       
        if(isset($_GET['page']) || isset($_GET['keywords'])) { 
          ?>
          <a href="<?php echo base_url('admin/siswa') ?>" class="btn btn-light btn-sm">
            <i class="fa fa-arrow-circle-left"></i> Kembali</a>
          <?php } ?>
        </div>
    </div>
    <div class="clearfix"><hr></div>
    <div class="table-responsive mailbox-messages">
      <table id="example11" class="display table table-bordered table-sm" cellspacing="0" width="100%">
        <thead>
          <tr class="bg-light text-center">
            <th width="5%">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
              </div>
            </th>
			<th width="10%" class="align-middle">NIS/NISN</th>
			<th width="20%" class="align-middle">NAMA</th>
      <th width="15%" class="align-middle">ALAMAT</th>
      <th width="10%" class="align-middle">TGL MASUK</th>
			<th width="8%" class="align-middle">L/P</th>
			<th width="10%" class="align-middle">WALI</th>
      <th width="10%" class="align-middle">STATUS</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$i=1; foreach($siswa as $siswa) { 
		?>
		<tr>
			<td class="text-center">
            <div class="icheck-primary">
              <input type="checkbox" name="id_siswa[]" value="<?php echo $siswa->id_siswa ?>" id="check<?php echo $i ?>">
              <label for="check<?php echo $i ?>"></label>
            </div>
          </td>
			<td class="text-center"><span class="badge bg-info mr-1"><?php echo $siswa->nis ?></span><span class="badge bg-success"><?php echo $siswa->nisn ?></span></td>
			<td><?php echo $siswa->nama_siswa ?>
				<small>
          <br><i class="fa fa-bullhorn"></i> <?php echo $siswa->nama_panggilan ?>
					<br><i class="fa fa-calendar"></i> <?php echo $siswa->tempat_lahir ?>, <?php echo $this->website->tanggal_id($siswa->tanggal_lahir) ?>
          <br><i class="fa fa-birthday-cake"></i> 
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
      <td><?php echo $siswa->alamat ?></td>
      <td class="text-center"><?php echo $this->website->tanggal_id($siswa->tanggal_masuk) ?></td>
			<td class="text-center"><?php echo $siswa->jenis_kelamin ?></td>
			<td class="text-center"><?php echo $siswa->nama_wali ?></td>
      <td class="text-center">
        <?php if($siswa->status_siswa=='Aktif') { ?>
          <span class="badge bg-success"><i class="fa fa-check-circle"></i> <?php echo $siswa->status_siswa ?></span>
        <?php }elseif($siswa->status_siswa=='Lulus') { ?>
          <span class="badge bg-info"><i class="fa fa-certificate"></i> <?php echo $siswa->status_siswa ?></span>
        <?php }elseif($siswa->status_siswa=='Meninggal') { ?>
          <span class="badge bg-dark"><i class="fa fa-times-circle"></i> <?php echo $siswa->status_siswa ?></span>
        <?php }elseif($siswa->status_siswa=='Pindah') { ?>
          <span class="badge bg-warning"><i class="fa fa-plane"></i> <?php echo $siswa->status_siswa ?></span>
        <?php } ?>
      </td>
			<td>
				<a href="<?php echo base_url('admin/siswa/detail/'.$siswa->id_siswa) ?>" class="btn btn-info btn-sm mb-1" title="Detail"><i class="fa fa-eye"></i></a>
        <a href="<?php echo base_url('admin/siswa/cetak/'.$siswa->id_siswa) ?>" class="btn btn-dark btn-sm mb-1" title="Cetak" target="_blank"><i class="fa fa-print"></i></a>
        <a href="<?php echo base_url('admin/siswa/unduh/'.$siswa->id_siswa) ?>" class="btn btn-danger btn-sm mb-1" title="Unduh" target="_blank"><i class="fa fa-file-pdf"></i></a>
        <a href="<?php echo base_url('admin/siswa/edit/'.$siswa->id_siswa) ?>" class="btn btn-warning btn-sm mb-1" title="Edit"><i class="fa fa-edit"></i></a>
				<a href="<?php echo base_url('admin/siswa/delete/'.$siswa->id_siswa) ?>" class="btn btn-danger btn-sm delete-link mb-1" title="Hapus"><i class="fa fa-trash"></i></a>
			</td>
		</tr>
		<?php $i++; } ?>
	</tbody>
</table>

<?php echo form_close(); ?>

<script>
$(document).ready(function() {
  $('#form-hapus-data').on('submit', function(e) {
    var form = this;
    var action = $('#aksi-massal-select').val();
    
    // Cek apakah ada checkbox yang dicentang
    var checked = $('.mailbox-messages input[type="checkbox"]:checked').length;
    if (checked === 0) {
      e.preventDefault();
      Swal.fire({
        icon: 'warning',
        title: 'Perhatian',
        text: 'Anda belum memilih pendaftar. Silakan centang minimal satu pendaftar.',
        confirmButtonColor: '#3085d6'
      });
      return false;
    }
    
    if (!action) {
      e.preventDefault();
      Swal.fire({
        icon: 'warning',
        title: 'Perhatian',
        text: 'Silakan pilih salah satu aksi massal.',
        confirmButtonColor: '#3085d6'
      });
      return false;
    }
    
    if (action === 'delete') {
      e.preventDefault();
      Swal.fire({
        title: 'Anda yakin?',
        text: "Seluruh data pendaftar terpilih akan dihapus permanen dari sistem!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus Semua!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          HTMLFormElement.prototype.submit.call(form);
        }
      });
    } else if (action.startsWith('update-')) {
      e.preventDefault();
      var status = action.replace('update-', '');
      Swal.fire({
        title: 'Ubah Status?',
        text: "Status pendaftar terpilih akan diubah menjadi: " + status,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          HTMLFormElement.prototype.submit.call(form);
        }
      });
    }
  });
});
</script>

<div class="clearfix"><hr></div>
<div class="pull-right"><?php if(isset($pagin)) { echo $pagin; } ?></div>
</div>


