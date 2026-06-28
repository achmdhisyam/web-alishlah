<?php
// Pre-calculate active states for filters
$is_all_program = ($id_program_pendidikan == 'Semua');
$active_status = $status_pendaftaran;
?>

<!-- Custom CSS for Premium UI/UX -->
<style>
  .filter-btn-group .btn {
    margin-right: 5px;
    margin-bottom: 8px;
    border-radius: 20px;
    padding: 6px 16px;
    font-weight: 500;
    font-size: 13px;
    transition: all 0.2s;
  }
  .filter-btn-group .btn i {
    margin-right: 4px;
  }
  .stat-card {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-top: 3px solid #dee2e6;
    border-radius: 4px;
    padding: 12px 15px;
    margin-bottom: 15px;
    transition: all 0.15s ease-in-out;
  }
  .stat-card:hover {
    background: #e9ecef;
    border-color: #ced4da;
  }
  .stat-card.sc-total { border-top-color: #007bff; }
  .stat-card.sc-menunggu { border-top-color: #ffc107; }
  .stat-card.sc-diterima { border-top-color: #28a745; }
  .stat-card.sc-tidak { border-top-color: #dc3545; }
  .stat-card.sc-diperiksa { border-top-color: #17a2b8; }
  
  .stat-card .sc-title {
    font-size: 11px;
    color: #495057;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 3px;
    font-weight: 600;
  }
  .stat-card .sc-value {
    font-size: 20px;
    font-weight: 700;
    color: #212529;
  }
  .badge-status {
    padding: 8px 14px;
    border-radius: 4px;
    font-weight: 600;
    font-size: 13px;
    letter-spacing: 0.3px;
    display: inline-block;
  }
  .dropdown-menu .dropdown-item {
    padding: 8px 16px;
    font-size: 13px;
  }
  .table-student th {
    background-color: #f8f9fa;
    border-top: none !important;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 0.5px;
    color: #495057;
    font-weight: 700;
    padding: 12px 10px !important;
  }
  .table-student td {
    vertical-align: middle !important;
    padding: 12px 10px !important;
  }
  .doc-pill {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    margin: 2px 0;
  }
  .doc-pill.complete {
    background-color: #e2fbe8;
    color: #1e7e34;
  }
  .doc-pill.incomplete {
    background-color: #fce8e6;
    color: #c82333;
  }
  .doc-pill.optional {
    background-color: #f1f3f5;
    color: #495057;
  }
</style>

<!-- Top Action Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
  <div>
    <a href="<?php echo base_url('admin/gelombang') ?>" class="btn btn-outline-secondary btn-sm rounded-pill">
      <i class="fa fa-arrow-left"></i> Kembali
    </a>
  </div>
  <div class="d-flex flex-wrap style-gap" style="gap: 5px;">
    <a href="<?php echo base_url('admin/gelombang/export/'.$gelombang->id_gelombang.'/'.$status_pendaftaran.'/'.$id_program_pendidikan) ?>" class="btn btn-success btn-sm rounded-pill" target="_blank">
      <i class="fa fa-file-excel"></i> Ekspor Excel
    </a>
    <a href="<?php echo base_url('admin/gelombang/unduh_data/'.$gelombang->id_gelombang.'/'.$status_pendaftaran.'/'.$id_program_pendidikan) ?>" class="btn btn-danger btn-sm rounded-pill" target="_blank">
      <i class="fa fa-file-pdf"></i> Cetak PDF
    </a>
    <a href="<?php echo base_url('admin/gelombang/unduh_pengumuman/'.$gelombang->id_gelombang.'/'.$status_pendaftaran.'/'.$id_program_pendidikan) ?>" class="btn btn-danger btn-sm rounded-pill" target="_blank">
      <i class="fa fa-bullhorn"></i> Cetak Pengumuman
    </a>
  </div>
</div>

<!-- Row 1: Informasi Gelombang & Statistik Ringkas -->
<div class="row">
  <!-- Detail Gelombang -->
  <div class="col-lg-4 col-md-5 col-sm-12">
    <div class="card card-outline card-primary mb-3">
      <div class="card-header bg-light">
        <h3 class="card-title font-weight-bold mb-0" style="font-size: 16px;">
          <i class="fa fa-info-circle text-primary mr-1"></i> Informasi Gelombang
        </h3>
      </div>
      <div class="card-body p-0">
        <table class="table table-sm mb-0">
          <tbody>
            <tr>
              <td class="pl-3 py-2 font-weight-bold text-muted" style="width: 40%;">Nama Periode</td>
              <td class="pr-3 py-2 font-weight-bold"><?php echo $gelombang->judul ?></td>
            </tr>
            <tr>
              <td class="pl-3 py-2 font-weight-bold text-muted">Pelaksanaan</td>
              <td class="pr-3 py-2" style="font-size: 13px;">
                Buka: <?php echo date('d-m-Y', strtotime($gelombang->tanggal_buka)) ?><br>
                Tutup: <?php echo date('d-m-Y', strtotime($gelombang->tanggal_tutup)) ?><br>
                Pengumuman: <?php echo date('d-m-Y', strtotime($gelombang->tanggal_pengumuman)) ?>
              </td>
            </tr>
            <tr>
              <td class="pl-3 py-2 font-weight-bold text-muted">Tahun Ajaran</td>
              <td class="pr-3 py-2"><?php echo $gelombang->tahun_ajaran ?> (<?php echo $gelombang->tahun ?>)</td>
            </tr>
            <tr>
              <td class="pl-3 py-2 font-weight-bold text-muted">Status Gelombang</td>
              <td class="pr-3 py-2">
                <?php if($gelombang->status_gelombang=='Buka') { ?>
                  <span class="badge badge-success"><i class="fa fa-eye"></i> Buka</span>
                <?php } else { ?>
                  <span class="badge badge-secondary"><i class="fa fa-eye-slash"></i> Tutup</span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td class="pl-3 py-2 font-weight-bold text-muted">Program & Status</td>
              <td class="pr-3 py-2">
                <span class="badge badge-info mb-1"><?php echo $judul_program_pendidikan ?></span><br>
                <span class="badge badge-warning"><?php echo $status_pendaftaran ?></span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Statistik Angka Calon Siswa -->
  <div class="col-lg-8 col-md-7 col-sm-12">
    <div class="row">
      <div class="col-sm-4 col-6">
        <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Semua/'.$id_program_pendidikan) ?>" style="text-decoration: none;">
          <div class="stat-card sc-total">
            <div class="sc-title">Total Pendaftar</div>
            <div class="sc-value"><?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Semua',$id_program_pendidikan)->total); ?></div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-6">
        <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Menunggu/'.$id_program_pendidikan) ?>" style="text-decoration: none;">
          <div class="stat-card sc-menunggu">
            <div class="sc-title">Menunggu</div>
            <div class="sc-value"><?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Menunggu',$id_program_pendidikan)->total); ?></div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-6">
        <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Diterima/'.$id_program_pendidikan) ?>" style="text-decoration: none;">
          <div class="stat-card sc-diterima">
            <div class="sc-title">Diterima</div>
            <div class="sc-value"><?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Diterima',$id_program_pendidikan)->total); ?></div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-6">
        <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Tidak-Diterima/'.$id_program_pendidikan) ?>" style="text-decoration: none;">
          <div class="stat-card sc-tidak">
            <div class="sc-title">Tidak Diterima</div>
            <div class="sc-value"><?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Tidak-Diterima',$id_program_pendidikan)->total); ?></div>
          </div>
        </a>
      </div>
      <div class="col-sm-4 col-6">
        <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Diperiksa/'.$id_program_pendidikan) ?>" style="text-decoration: none;">
          <div class="stat-card sc-diperiksa">
            <div class="sc-title">Diperiksa</div>
            <div class="sc-value"><?php echo $this->website->angka($m_siswa->total_gelombang_status_siswa($id_gelombang,'Diperiksa',$id_program_pendidikan)->total); ?></div>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Row 2: Tabel Akumulasi Jenjang/Program -->
<div class="card mb-3">
  <div class="card-header bg-light">
    <h3 class="card-title font-weight-bold mb-0" style="font-size: 15px;">
      <i class="fa fa-chart-pie text-secondary mr-1"></i> Akumulasi per Program Pendidikan
    </h3>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover table-striped mb-0" style="font-size: 13px;">
        <thead>
          <tr>
            <th width="30%">Program Pendidikan</th>
            <th width="15%" class="text-center">Status</th>
            <th width="15%" class="text-center">Jumlah</th>
            <th class="text-right pr-4">Aksi Kelola</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($akumulasi as $ak) { ?>
            <tr>
              <td class="font-weight-bold pl-3"><?php echo $ak->judul_program_pendidikan ?></td>
              <td class="text-center">
                <?php if($ak->status_pendaftaran=='Menunggu') { ?>
                  <span class="badge badge-warning"><i class="fa fa-clock mr-1"></i>Menunggu</span>
                <?php }elseif($ak->status_pendaftaran=='Diterima') { ?>
                  <span class="badge badge-success"><i class="fa fa-check-circle mr-1"></i>Diterima</span>
                <?php }elseif($ak->status_pendaftaran=='Tidak-Diterima') { ?>
                  <span class="badge badge-danger"><i class="fa fa-times-circle mr-1"></i>Tidak Diterima</span>
                <?php }else{ ?>
                  <span class="badge badge-info"><i class="fa fa-tasks mr-1"></i>Diperiksa</span>
                <?php } ?>
              </td>
              <td class="text-center font-weight-bold"><?php echo $this->website->angka($ak->jumlah_siswa) ?></td>
              <td class="text-right pr-4">
                <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/'.$ak->status_pendaftaran.'/'.$ak->id_program_pendidikan) ?>" class="btn btn-outline-primary btn-xs mr-1">
                  <i class="fa fa-user-check"></i> Filter
                </a>
                <a href="<?php echo base_url('admin/gelombang/export/'.$gelombang->id_gelombang.'/'.$ak->status_pendaftaran.'/'.$ak->id_program_pendidikan) ?>" class="btn btn-outline-success btn-xs mr-1" target="_blank">
                  <i class="fa fa-file-excel"></i> Excel
                </a>
                <a href="<?php echo base_url('admin/gelombang/unduh_data/'.$gelombang->id_gelombang.'/'.$ak->status_pendaftaran.'/'.$ak->id_program_pendidikan) ?>" class="btn btn-outline-danger btn-xs mr-1" target="_blank">
                  <i class="fa fa-file-pdf"></i> PDF
                </a>
                <a href="<?php echo base_url('admin/gelombang/unduh_pengumuman/'.$gelombang->id_gelombang.'/'.$ak->status_pendaftaran.'/'.$ak->id_program_pendidikan) ?>" class="btn btn-danger btn-xs" target="_blank">
                  <i class="fa fa-bullhorn"></i> Pengumuman
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Row 3: List Pendaftar Utama -->
<div class="card card-outline card-primary">
  <div class="card-header bg-white">
    <h3 class="card-title font-weight-bold mb-0 text-dark" style="font-size: 16px;">
      <i class="fa fa-users text-primary mr-1"></i> Daftar Calon Siswa Terdaftar
    </h3>
  </div>

  <!-- Status Filter Button Group -->
  <div class="card-body bg-white border-bottom p-3">
    <div class="d-flex flex-wrap align-items-center" style="gap: 5px;">
      <span class="text-muted font-weight-bold mr-2" style="font-size: 13px;"><i class="fa fa-filter"></i> Filter Status:</span>
      <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Semua/'.$id_program_pendidikan) ?>" class="btn <?php echo $status_pendaftaran == 'Semua' ? 'btn-primary' : 'btn-outline-primary' ?> btn-sm rounded-pill">
        Semua Pendaftar
      </a>
      <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Menunggu/'.$id_program_pendidikan) ?>" class="btn <?php echo $status_pendaftaran == 'Menunggu' ? 'btn-warning text-white' : 'btn-outline-warning' ?> btn-sm rounded-pill">
        Menunggu
      </a>
      <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Diperiksa/'.$id_program_pendidikan) ?>" class="btn <?php echo $status_pendaftaran == 'Diperiksa' ? 'btn-info' : 'btn-outline-info' ?> btn-sm rounded-pill">
        Diperiksa
      </a>
      <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Diterima/'.$id_program_pendidikan) ?>" class="btn <?php echo $status_pendaftaran == 'Diterima' ? 'btn-success' : 'btn-outline-success' ?> btn-sm rounded-pill">
        Diterima
      </a>
      <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/Tidak-Diterima/'.$id_program_pendidikan) ?>" class="btn <?php echo $status_pendaftaran == 'Tidak-Diterima' ? 'btn-danger' : 'btn-outline-danger' ?> btn-sm rounded-pill">
        Tidak Diterima
      </a>
    </div>
  </div>
  
  <?php echo form_open(base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/'.$status_pendaftaran.'/'.$id_program_pendidikan), ['id' => 'form-pendaftaran']) ?>
  <input type="hidden" name="pengalihan" value="<?php echo str_replace('index.php','',CURRENT_URL()) ?>">
  <input type="hidden" name="pengalihan" value="<?php echo str_replace('index.php/','',CURRENT_URL()) ?>">

  <!-- Bulk Actions / Quick Filters Toolbar -->
  <div class="card-body bg-light border-bottom p-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center" style="gap: 15px;">
      <!-- Bulk Action Section -->
      <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
        <span class="text-muted font-weight-bold mr-1" style="font-size: 13px;"><i class="fa fa-tasks"></i> Aksi Massal:</span>
        <select name="status_pendaftaran" class="form-control form-control-sm" style="width: auto; display: inline-block;" required>
          <option value="">-- Pilih Status --</option>
          <option value="Menunggu">Menunggu</option>
          <option value="Diperiksa">Diperiksa</option>
          <option value="Diterima">Diterima</option>
          <option value="Tidak-Diterima">Tidak Diterima</option>
        </select>
        <button type="submit" class="btn btn-info btn-sm font-weight-bold" name="submit" value="update">
          <i class="fa fa-save"></i> Terapkan Status
        </button>
      </div>

      <!-- Quick Reset Program Filter -->
      <div>
        <?php if($id_program_pendidikan != 'Semua'): ?>
          <a href="<?php echo base_url('admin/gelombang/detail/'.$gelombang->id_gelombang.'/'.$status_pendaftaran.'/Semua') ?>" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="fa fa-users"></i> Lihat Semua Program
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table id="example2" class="table table-hover table-striped table-student mb-0" style="width:100%">
        <thead>
          <tr>
            <th width="4%" class="text-center align-middle">
              <button type="button" class="btn btn-default btn-xs checkbox-toggle"><i class="far fa-square"></i></button>
            </th>
            <th width="30%" class="align-middle">Calon Siswa & Informasi</th>
            <th width="26%" class="align-middle">Alamat & Kontak</th>
            <th width="20%" class="align-middle text-center">Kelengkapan Dokumen</th>
            <th width="10%" class="align-middle text-center">Status</th>
            <th width="10%" class="align-middle text-right pr-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i=1; 
          foreach($siswa as $s) { 
            $wajib          = $m_jenis_dokumen->group_status_jenis_dokumen_detail('Wajib');
            $tidak_wajib    = $m_jenis_dokumen->group_status_jenis_dokumen_detail('Tidak Wajib');
            $dokumen_wajib  = $m_dokumen->total_check($s->id_siswa, $wajib->status_jenis_dokumen); 
            $dokumen_opt    = $m_dokumen->total_check($s->id_siswa, $tidak_wajib->status_jenis_dokumen);
            
            // Age calculation
            $date1 = $s->tanggal_lahir;
            $date2 = date('Y-m-d');
            $diff  = abs(strtotime($date2) - strtotime($date1));
            $years = floor($diff / (365*60*60*24));
            $months= floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
          ?>
          <tr>
            <td class="text-center">
              <div class="icheck-primary">
                <input type="checkbox" name="id_siswa[]" value="<?php echo $s->id_siswa ?>" id="check<?php echo $i ?>">
                <label for="check<?php echo $i ?>"></label>
              </div>
            </td>
            <td>
              <span class="d-block font-weight-bold text-dark" style="font-size:14px;"><?php echo strtoupper($s->nama_siswa) ?></span>
              <small class="text-muted" style="line-height:1.4;">
                <span class="text-secondary">Program:</span> <strong class="text-info"><?php echo $s->judul_program_pendidikan ?></strong><br>
                <span class="text-secondary">Kode:</span> <strong class="text-dark"><?php echo $s->kode_siswa ?></strong><br>
                <span class="text-secondary">Panggilan / Wali:</span> <?php echo $s->nama_panggilan ?> / <?php echo $s->nama_wali ?><br>
                <span class="text-secondary">TTL:</span> <?php echo $s->tempat_lahir ?>, <?php echo $this->website->tanggal_id($s->tanggal_lahir) ?><br>
                <span class="text-secondary">Usia:</span> <?php echo $years; ?> Thn <?php echo $months; ?> Bln <?php echo $days; ?> Hari
              </small>
            </td>
            <td>
              <span class="d-block text-truncate" style="max-width: 250px; font-size:13px;" title="<?php echo $s->alamat ?>"><?php echo $s->alamat ?></span>
              <small class="text-muted">
                <span class="text-secondary">Telepon:</span> <strong><?php echo $s->telepon ?></strong><br>
                <span class="text-secondary">Email:</span> <?php echo $s->email ?>
              </small>
            </td>
            <td class="text-center">
              <!-- Combine document status into neat indicators -->
              <div class="d-flex flex-column align-items-center">
                <?php if($dokumen_wajib >= $wajib->total): ?>
                  <span class="doc-pill complete w-75 text-center" title="Semua dokumen wajib terunggah">
                    Wajib: <?php echo $dokumen_wajib ?> / <?php echo $wajib->total ?> <i class="fa fa-check-circle ml-1"></i>
                  </span>
                <?php else: ?>
                  <span class="doc-pill incomplete w-75 text-center" title="Ada dokumen wajib belum diunggah">
                    Wajib: <?php echo $dokumen_wajib ?> / <?php echo $wajib->total ?> <i class="fa fa-exclamation-circle ml-1"></i>
                  </span>
                <?php endif; ?>
                
                <span class="doc-pill optional w-75 text-center mt-1" title="Dokumen opsional terunggah">
                  Opsional: <?php echo $dokumen_opt ?> / <?php echo $tidak_wajib->total ?>
                </span>
              </div>
            </td>
            <td class="text-center">
              <?php if($s->status_pendaftaran=='Menunggu'): ?>
                <span class="badge badge-warning badge-status"><i class="fa fa-clock mr-1"></i>Menunggu</span>
              <?php elseif($s->status_pendaftaran=='Diterima'): ?>
                <span class="badge badge-success badge-status"><i class="fa fa-check-circle mr-1"></i>Diterima</span>
              <?php elseif($s->status_pendaftaran=='Tidak-Diterima'): ?>
                <span class="badge badge-danger badge-status"><i class="fa fa-times-circle mr-1"></i>Tidak Diterima</span>
              <?php else: ?>
                <span class="badge badge-info badge-status"><i class="fa fa-search mr-1"></i>Diperiksa</span>
              <?php endif; ?>
            </td>
            <td class="text-right pr-3">
              <div class="btn-group-vertical btn-group-sm">
                <a href="<?php echo base_url('admin/gelombang/dokumen/'.$s->slug_siswa) ?>" class="btn btn-info btn-xs text-white" title="Review Dokumen & Status">
                  <i class="fa fa-tasks"></i> Review
                </a>
                <a href="<?php echo base_url('admin/gelombang/edit_siswa/'.$s->slug_siswa) ?>" class="btn btn-warning btn-xs text-dark" title="Edit Biodata">
                  <i class="fa fa-edit"></i> Edit
                </a>
                <a href="<?php echo base_url('admin/gelombang/cetak/'.$s->slug_siswa) ?>" class="btn btn-outline-secondary btn-xs" title="Cetak Bukti Pendaftaran" target="_blank">
                  <i class="fa fa-file-pdf"></i> Bukti
                </a>
                <?php if($s->status_pendaftaran=='Menunggu'): ?>
                  <a href="<?php echo base_url('admin/gelombang/delete_siswa/'.$s->slug_siswa.'/'.$s->id_gelombang) ?>" class="btn btn-danger btn-xs delete-link" title="Hapus Calon Siswa">
                    <i class="fa fa-trash"></i> Hapus
                  </a>
                <?php endif; ?>
              </div>
            </td>
          </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
    </div>
  </div>
  
  <?php echo form_close(); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // validasi sebelum submit aksi massal
  let pendaftaranForm = document.getElementById("form-pendaftaran");
  if (pendaftaranForm) {
    pendaftaranForm.addEventListener("submit", function(e) {
      let submitBtn = e.submitter;
      if (submitBtn && submitBtn.name === "submit" && submitBtn.value === "update") {
        let cek = document.querySelectorAll('input[name="id_siswa[]"]:checked').length;
        if (cek === 0) {
          e.preventDefault(); // hentikan submit form
          Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Pilih minimal satu calon siswa terlebih dahulu sebelum melakukan update status massal!',
            confirmButtonColor: '#17a2b8'
          });
        }
      }
    });
  }
</script>
