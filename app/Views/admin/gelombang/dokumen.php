<?php
use App\Libraries\Website;
$this->website = new Website();

$is_dokumen_lengkap = true;
$is_dokumen_disetujui = true;
foreach($jenis_dokumen as $jd) {
  if($jd->status_jenis_dokumen=='Wajib') {
    $check_dok = $m_dokumen->check($siswa->id_siswa, $jd->id_jenis_dokumen);
    if(!$check_dok) {
      $is_dokumen_lengkap = false;
      $is_dokumen_disetujui = false;
    } elseif ($check_dok->status_verifikasi !== 'Disetujui') {
      $is_dokumen_disetujui = false;
    }
  }
}

// Function to format phone number
if (!function_exists('format_phone_wa')) {
    function format_phone_wa($phone) {
        if (empty($phone)) return '';
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strpos($phone, '0') === 0) {
            $phone = '62' . substr($phone, 1);
        } elseif (strpos($phone, '8') === 0) {
            $phone = '62' . $phone;
        }
        return $phone;
    }
}

// Function to generate WA link
if (!function_exists('get_wa_link')) {
    function get_wa_link($phone, $tipe, $siswa, $website) {
        $formatted = format_phone_wa($phone);
        if (empty($formatted)) return '#';
        
        $status_pendaftaran_raw = $siswa->status_pendaftaran ?? 'Menunggu';
        $status_pendaftaran_txt = 'Menunggu Verifikasi';
        $langkah_selanjutnya = '';

        if ($status_pendaftaran_raw == 'Diterima') {
            $status_pendaftaran_txt = 'DITERIMA (LULUS)';
            $langkah_selanjutnya = "Selamat! Berkas pendaftaran telah diverifikasi dan dinyatakan Diterima. Silakan masuk ke dasbor pendaftaran siswa untuk mencetak Bukti Kelulusan dan mengikuti alur daftar ulang selanjutnya.";
        } elseif ($status_pendaftaran_raw == 'Tidak-Diterima') {
            $status_pendaftaran_txt = 'TIDAK DITERIMA (TIDAK LULUS)';
            $langkah_selanjutnya = "Mohon maaf, pendaftaran Anda saat ini dinyatakan Belum Diterima. Terima kasih banyak atas minat dan partisipasi Bapak/Ibu.";
        } elseif ($status_pendaftaran_raw == 'Diperiksa') {
            $status_pendaftaran_txt = 'SEDANG DIPERIKSA';
            $langkah_selanjutnya = "Berkas pendaftaran Anda saat ini sedang diperiksa secara detail oleh tim verifikator kami. Mohon untuk memantau dasbor pendaftaran siswa secara berkala.";
        } else {
            $status_pendaftaran_txt = 'MENUNGGU VERIFIKASI';
            $langkah_selanjutnya = "Berkas pendaftaran Anda telah tersimpan dan berada dalam antrean Menunggu Verifikasi. Kami akan segera memeriksa berkas Anda. Mohon pastikan data dan berkas yang diunggah sudah lengkap dan benar.";
        }

        $pesan = "Assalamu'alaikum Wr. Wb.\n\n"
               . "Yth. Bapak/Ibu Orang Tua/Wali (" . $tipe . ") dari calon siswa *" . $siswa->nama_siswa . "* (No. Pendaftaran: *" . $siswa->kode_siswa . "*).\n\n"
               . "Kami dari Panitia SPMB " . $website->namaweb() . " menginformasikan bahwa berkas pendaftaran online saat ini berstatus: *" . $status_pendaftaran_txt . "*.\n\n"
               . "*Langkah Selanjutnya*:\n"
               . $langkah_selanjutnya . "\n\n"
               . "Silakan pantau perkembangan pendaftaran secara berkala melalui akun dasbor siswa Anda.\n"
               . "Terima kasih atas perhatiannya.\n\n"
               . "Salam hangat,\n"
               . "Panitia SPMB " . $website->namaweb();
               
        return "https://api.whatsapp.com/send?phone=" . $formatted . "&text=" . urlencode($pesan);
    }
}

// Function to generate WA link for document rejection
if (!function_exists('get_wa_link_tolak')) {
    function get_wa_link_tolak($phone, $tipe, $siswa, $doc_name, $catatan, $website) {
        $formatted = format_phone_wa($phone);
        if (empty($formatted)) return '#';
        
        $pesan = "Assalamu'alaikum Wr. Wb.\n\n"
               . "Yth. Bapak/Ibu Orang Tua/Wali (" . $tipe . ") dari calon siswa *" . $siswa->nama_siswa . "* (No. Pendaftaran: *" . $siswa->kode_siswa . "*).\n\n"
               . "Kami dari Panitia SPMB " . $website->namaweb() . " menginformasikan bahwa berkas dokumen *" . $doc_name . "* pendaftaran online calon pendaftar memerlukan perbaikan / diunggah ulang.\n\n"
               . "*Catatan Revisi dari Panitia*:\n"
               . ($catatan ? "_" . $catatan . "_" : "_Berkas kurang jelas / belum sesuai ketentuan_") . "\n\n"
               . "Mohon untuk masuk kembali ke akun dasbor pendaftaran online siswa untuk melakukan unggah ulang berkas yang dimaksud agar kami dapat melanjutkan verifikasi.\n"
               . "Terima kasih banyak atas kerja samanya.\n\n"
               . "Salam hangat,\n"
               . "Panitia SPMB " . $website->namaweb();
               
        return "https://api.whatsapp.com/send?phone=" . $formatted . "&text=" . urlencode($pesan);
    }
}

// Function to generate a combined WA link for all document rejections
if (!function_exists('get_wa_link_tolak_all')) {
    function get_wa_link_tolak_all($phone, $tipe, $siswa, $rejected_docs, $website) {
        $formatted = format_phone_wa($phone);
        if (empty($formatted)) return '#';
        
        $daftar_revisi = "";
        $no = 1;
        foreach ($rejected_docs as $doc) {
            $catatan = !empty($doc['catatan']) ? $doc['catatan'] : 'Berkas kurang jelas / belum sesuai ketentuan';
            $daftar_revisi .= $no . ". *" . $doc['nama'] . "*\n   Catatan revisi: _" . $catatan . "_\n\n";
            $no++;
        }
        
        $pesan = "Assalamu'alaikum Wr. Wb.\n\n"
               . "Yth. Bapak/Ibu Orang Tua/Wali (" . $tipe . ") dari calon siswa *" . $siswa->nama_siswa . "* (No. Pendaftaran: *" . $siswa->kode_siswa . "*).\n\n"
               . "Kami dari Panitia SPMB " . $website->namaweb() . " menginformasikan bahwa berkas dokumen pendaftaran online berikut memerlukan perbaikan / diunggah ulang:\n\n"
               . $daftar_revisi
               . "Mohon untuk masuk kembali ke akun dasbor pendaftaran online siswa untuk melakukan unggah ulang berkas-berkas yang dimaksud agar kami dapat melanjutkan verifikasi.\n"
               . "Terima kasih banyak atas kerja samanya.\n\n"
               . "Salam hangat,\n"
               . "Panitia SPMB " . $website->namaweb();
               
        return "https://api.whatsapp.com/send?phone=" . $formatted . "&text=" . urlencode($pesan);
    }
}
?>
<style>
.verif-inline-form { display: none; }
.verif-inline-form.show { display: block; }
.doc-row-disetujui { background-color: #f0fff4 !important; }
.doc-row-ditolak   { background-color: #fff5f5 !important; }
.doc-row-menunggu  { background-color: #fffdf0 !important; }
.status-selector {
  display: flex;
  flex-direction: column;
  gap: 6px;
  margin-bottom: 12px;
}
.status-option {
  display: block;
  margin: 0;
  cursor: pointer;
}
.status-option input[type="radio"] {
  display: none;
}
.status-pill {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px 12px;
  border: 1px solid #dee2e6;
  border-radius: 4px;
  background: #f8f9fa;
  font-weight: 600;
  font-size: 13px;
  color: #495057;
  transition: all 0.15s ease-in-out;
}
.status-pill i {
  width: 16px;
  text-align: center;
}
.status-option input[type="radio"]:checked + .status-pill.status-menunggu {
  background-color: #fffbeb;
  border-color: #ffc107;
  color: #854d0e;
}
.status-option input[type="radio"]:checked + .status-pill.status-diperiksa {
  background-color: #f0f9ff;
  border-color: #17a2b8;
  color: #0c5460;
}
.status-option input[type="radio"]:checked + .status-pill.status-diterima {
  background-color: #f0fdf4;
  border-color: #28a745;
  color: #155724;
}
.status-option input[type="radio"]:checked + .status-pill.status-tidak {
  background-color: #fef2f2;
  border-color: #dc3545;
  color: #721c24;
}
.status-option.disabled-option {
  cursor: not-allowed;
}
.status-option.disabled-option .status-pill {
  opacity: 0.5;
  background-color: #e9ecef;
  border-color: #dee2e6;
  color: #6c757d !important;
}
.status-option.disabled-option .status-pill i {
  color: #6c757d !important;
}

/* Stepper CSS */
.stepper-row {
  display: flex;
  margin-bottom: 24px;
  gap: 15px;
}
@media (max-width: 768px) {
  .stepper-row {
    flex-direction: column;
  }
}
.step-item {
  flex: 1;
  background: #ffffff;
  border: 2px solid #e2e8f0;
  border-radius: 8px;
  padding: 15px;
  transition: all 0.3s ease;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.step-item.disabled {
  opacity: 0.45;
  background-color: #f8fafc;
  cursor: not-allowed !important;
}
.step-item.active {
  border-color: #007bff;
  background-color: #f8fafc;
}
.step-item.active-success {
  border-color: #28a745;
  background-color: #f8fafc;
}
.step-item.completed {
  border-color: #28a745;
  background-color: #f6fff9;
}
.step-badge {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background: #cbd5e1;
  color: #475569;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 14px;
  margin-bottom: 8px;
  transition: all 0.3s ease;
}
.step-item.active .step-badge {
  background: #007bff;
  color: #fff;
}
.step-item.active-success .step-badge,
.step-item.completed .step-badge {
  background: #28a745;
  color: #fff;
}
.step-title {
  font-size: 14px;
  font-weight: bold;
  color: #1e293b;
  margin-bottom: 4px;
  text-align: center;
}
.step-desc {
  font-size: 11.5px;
  color: #64748b;
  text-align: center;
  margin-bottom: 8px;
  line-height: 1.3;
}
.step-content-section {
  display: none;
}
.step-content-section.active {
  display: block;
  animation: fadeInStep 0.4s ease-in-out;
}
@keyframes fadeInStep {
  from { opacity: 0; transform: translateY(12px); }
  to { opacity: 1; transform: translateY(0); }
}
.btn-wa-prominent {
  background-color: #28a745 !important;
  border-color: #28a745 !important;
  color: #ffffff !important;
  font-size: 14px !important;
  font-weight: bold !important;
  padding: 10px 20px !important;
  border-radius: 4px !important;
  transition: background-color 0.15s ease-in-out !important;
  display: inline-block !important;
  text-decoration: none !important;
}
.btn-wa-prominent:hover {
  background-color: #218838 !important;
  border-color: #1e7e34 !important;
}
</style>

<?php
// Resolve current active step based on session flashdata and database state
$active_step = 1;
$step1_class = 'active';
$step2_class = 'disabled';
$step3_class = 'disabled';
$flashSuksesStatus = Session()->getFlashdata('sukses_status');
$flashSukses = Session()->getFlashdata('sukses');

if ($flashSuksesStatus) {
    $active_step = 3;
    $step1_class = 'completed';
    $step2_class = 'completed';
    $step3_class = 'active-success';
} elseif ($flashSukses) {
    // Jika baru saja memverifikasi dokumen (Langkah 1), tetap di Langkah 1!
    $active_step = 1;
    $step1_class = 'active';
    $step2_class = ($siswa->status_pendaftaran !== 'Menunggu') ? '' : 'disabled';
    $step3_class = 'disabled';
} elseif (in_array($siswa->status_pendaftaran ?? '', ['Diterima', 'Tidak-Diterima'])) {
    $active_step = 3;
    $step1_class = 'completed';
    $step2_class = 'completed';
    $step3_class = 'active-success';
} elseif ($siswa->status_pendaftaran === 'Diperiksa') {
    $active_step = 2;
    $step1_class = 'completed';
    $step2_class = 'active';
    $step3_class = 'disabled';
} else {
    $active_step = 1;
    $step1_class = 'active';
    $step2_class = 'disabled';
    $step3_class = 'disabled';
}

$sukses_msg = $flashSukses ?? $flashSuksesStatus;
?>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
  <h4 class="text-dark font-weight-bold mb-2"><i class="fa fa-user-check text-primary mr-1"></i> Alur Verifikasi Pendaftaran</h4>
  <div class="mb-2">
    <a href="<?php echo base_url('admin/gelombang/detail/'.$siswa->id_gelombang.'/Semua/Semua') ?>" class="btn btn-outline-secondary btn-sm font-weight-bold">
      <i class="fa fa-arrow-left mr-1"></i> Kembali ke Daftar
    </a>
  </div>
</div>

<?php if (!empty($sukses_msg)) : ?>
  <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 p-3 bg-white" role="alert" style="border-left: 5px solid #28a745 !important;">
    <div class="d-flex align-items-center flex-wrap" style="gap: 12px;">
      <div class="text-success" style="font-size: 24px;">
        <i class="fas fa-check-circle"></i>
      </div>
      <div class="flex-grow-1">
        <h6 class="alert-heading font-weight-bold mb-1 text-success" style="font-size: 14px;">Pembaruan Berhasil!</h6>
        <span class="text-secondary" style="font-size: 13px;"><?= esc($sukses_msg) ?>. Status siswa saat ini: <strong><?= esc($siswa->status_pendaftaran) ?></strong>.</span>
      </div>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="top: 8px;">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<!-- STEPPER VISUAL ALUR VERIFIKASI -->
<div class="stepper-row">
  <!-- Langkah 1 -->
  <div class="step-item <?php echo $step1_class; ?>" id="step-card-1" onclick="showStep(1)" style="cursor: pointer;">
    <div class="step-badge">
      <?php if ($step1_class === 'completed'): ?><i class="fa fa-check"></i><?php else: ?>1<?php endif; ?>
    </div>
    <div class="step-title">Langkah 1: Periksa Berkas & Data</div>
    <div class="step-desc">Periksa biodata dasar dan verifikasi dokumen pendukung</div>
    <?php if ($step1_class === 'active'): ?>
      <span class="badge badge-primary font-weight-bold px-2 py-1 mt-1">Sedang Aktif</span>
    <?php else: ?>
      <span class="text-success font-weight-bold" style="font-size: 12px;"><i class="fa fa-check-circle"></i> Selesai Diperiksa</span>
    <?php endif; ?>
  </div>

  <!-- Langkah 2 -->
  <div class="step-item <?php echo $step2_class; ?>" id="step-card-2" onclick="showStep(2)" style="cursor: pointer;">
    <div class="step-badge">
      <?php if ($step2_class === 'completed'): ?><i class="fa fa-check"></i><?php else: ?>2<?php endif; ?>
    </div>
    <div class="step-title">Langkah 2: Tentukan Hasil Seleksi</div>
    <div class="step-desc">Ubah status keputusan pendaftaran siswa</div>
    <?php if ($step2_class === 'active'): ?>
      <span class="badge badge-primary font-weight-bold px-2 py-1 mt-1">Sedang Aktif</span>
    <?php elseif ($step2_class === 'completed'): ?>
      <span class="text-success font-weight-bold" style="font-size: 12px;"><i class="fa fa-check-circle"></i> Keputusan Disimpan</span>
    <?php else: ?>
      <span class="text-muted" style="font-size: 11px;">Belum Aktif</span>
    <?php endif; ?>
  </div>

  <!-- Langkah 3 -->
  <div class="step-item <?php echo $step3_class; ?>" id="step-card-3" onclick="showStep(3)" style="cursor: pointer;">
    <div class="step-badge">3</div>
    <div class="step-title">Langkah 3: Hubungi Orang Tua / Wali</div>
    <div class="step-desc">Kirim notifikasi otomatis langsung ke WhatsApp</div>
    <?php if ($step3_class === 'active-success'): ?>
      <span class="badge badge-success font-weight-bold px-2 py-1 mt-1">Siap Dikirim</span>
    <?php else: ?>
      <span class="text-muted" style="font-size: 11px;">Menunggu Langkah 2</span>
    <?php endif; ?>
  </div>
</div>

<hr>

<!-- TATA LETAK BERALUR (SEQUENTIAL WORKFLOW SECTIONS) -->

<!-- STEP CONTENT 1: PEMERIKSAAN BERKAS & DATA -->
<div id="step-content-1" class="step-content-section">
  <!-- SECTION 1: PEMERIKSAAN DATA & BIODATA -->
  <div class="card card-outline card-primary shadow-sm mb-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
      <h5 class="font-weight-bold text-dark mb-0" style="font-size: 15px;"><i class="fa fa-id-card text-primary mr-1"></i> [LANGKAH 1] Periksa Biodata Calon Siswa</h5>
      <span class="badge badge-primary font-weight-bold px-2 py-1">Langkah 1 dari 3</span>
    </div>
    <div class="card-body">
      <?php include('selesai.php') ?>
    </div>
  </div>

  <!-- SECTION 2: VERIFIKASI DOKUMEN PENDUKUNG -->
  <div class="card card-outline card-primary shadow-sm mb-4" id="section-dokumen">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
      <h5 class="font-weight-bold text-dark mb-0" style="font-size: 15px;"><i class="fa fa-folder-open text-primary mr-1"></i> [LANGKAH 1] Verifikasi Dokumen Pendukung</h5>
      <span class="badge badge-primary font-weight-bold px-2 py-1">Langkah 1 dari 3</span>
    </div>
    <div class="card-body p-0">
      <?php
      $rejected_docs_array = [];
      $id_siswa   = $siswa->id_siswa;
      $no         = 1;
      foreach($jenis_dokumen as $jd) {
        $id_jenis_dokumen = $jd->id_jenis_dokumen;
        $check_dokumen    = $m_dokumen->check($id_siswa, $id_jenis_dokumen);
        
        if ($check_dokumen && $check_dokumen->status_verifikasi == 'Ditolak') {
            $rejected_docs_array[] = [
                'nama' => $jd->nama_jenis_dokumen,
                'catatan' => $check_dokumen->catatan_verifikasi
            ];
        }
        
        $row_class = '';
        if ($check_dokumen) {
          if ($check_dokumen->status_verifikasi == 'Disetujui') $row_class = 'doc-row-disetujui';
          elseif ($check_dokumen->status_verifikasi == 'Ditolak') $row_class = 'doc-row-ditolak';
          else $row_class = 'doc-row-menunggu';
        }
      ?>
      <div class="border-bottom p-3 <?php echo $row_class ?>">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
          <div class="flex-grow-1 mr-3">
            <div class="d-flex align-items-center mb-1">
              <span class="font-weight-bold mr-2"><?php echo $no ?>. <?php echo $jd->nama_jenis_dokumen ?></span>
              <?php if($jd->status_jenis_dokumen=='Wajib'): ?>
                <span class="badge badge-danger" style="font-size:10px;">Wajib</span>
              <?php else: ?>
                <span class="badge badge-secondary" style="font-size:10px;">Opsional</span>
              <?php endif; ?>
            </div>
            <?php if(!empty($jd->keterangan)): ?>
              <small class="text-muted d-block mb-1"><?php echo $jd->keterangan ?></small>
            <?php endif; ?>

            <?php if($check_dokumen): ?>
              <div class="mt-1">
                <?php if($check_dokumen->status_verifikasi == 'Disetujui'): ?>
                  <span class="badge badge-success px-2 py-1"><i class="fa fa-check-circle"></i> Dokumen Disetujui</span>
                <?php elseif($check_dokumen->status_verifikasi == 'Ditolak'): ?>
                  <span class="badge badge-danger px-2 py-1"><i class="fa fa-times-circle"></i> Dokumen Ditolak</span>
                  <?php if(!empty($check_dokumen->catatan_verifikasi)): ?>
                    <div class="alert alert-danger p-1 mt-1 mb-1" style="font-size:11px;">
                      <strong>Catatan:</strong> <?php echo esc($check_dokumen->catatan_verifikasi) ?>
                    </div>
                  <?php endif; ?>
                <?php else: ?>
                  <span class="badge badge-warning px-2 py-1"><i class="fa fa-clock"></i> Menunggu Verifikasi</span>
                <?php endif; ?>
              </div>
            <?php else: ?>
              <span class="badge badge-secondary mt-1"><i class="fa fa-times"></i> Belum Diunggah</span>
            <?php endif; ?>
          </div>

          <div class="mt-2 mt-md-0 text-right" style="min-width: 200px;">
            <?php if($check_dokumen): ?>
              <div class="btn-group mb-2">
                <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#modal-<?php echo $jd->id_jenis_dokumen ?>">
                  <i class="fa fa-eye"></i> Pratinjau
                </button>
                <a class="btn btn-outline-secondary btn-sm" href="<?php echo base_url('admin/gelombang/unduh/'.$check_dokumen->kode_dokumen.'/'.$siswa->slug_siswa) ?>" target="_blank">
                  <i class="fa fa-download"></i>
                </a>
                <a class="btn btn-outline-danger btn-sm delete-link" href="<?php echo base_url('admin/gelombang/hapus/'.$check_dokumen->kode_dokumen.'/'.$siswa->slug_siswa) ?>">
                  <i class="fa fa-trash"></i>
                </a>
              </div>

              <div class="d-flex" style="gap: 4px;">
                <?php echo form_open(base_url('admin/gelombang/dokumen/'.$siswa->slug_siswa)) ?>
                <?php echo csrf_field() ?>
                <input type="hidden" name="id_dokumen" value="<?php echo $check_dokumen->id_dokumen ?>">
                <input type="hidden" name="status_verifikasi" value="Disetujui">
                <input type="hidden" name="catatan_verifikasi" value="">
                <button type="submit" name="verifikasi_dokumen" value="simpan" class="btn btn-sm <?php echo $check_dokumen->status_verifikasi == 'Disetujui' ? 'btn-success' : 'btn-outline-success' ?> flex-fill">
                  <i class="fa fa-check"></i> Setuju
                </button>
                <?php echo form_close() ?>

                <button type="button" class="btn btn-sm <?php echo $check_dokumen->status_verifikasi == 'Ditolak' ? 'btn-danger' : 'btn-outline-danger' ?> flex-fill" onclick="toggleTolakForm(<?php echo $id_jenis_dokumen ?>)">
                  <i class="fa fa-times"></i> Tolak
                </button>
              </div>

              <div id="tolak-form-<?php echo $id_jenis_dokumen ?>" class="verif-inline-form mt-2">
                <?php echo form_open(base_url('admin/gelombang/dokumen/'.$siswa->slug_siswa)) ?>
                <?php echo csrf_field() ?>
                <input type="hidden" name="id_dokumen" value="<?php echo $check_dokumen->id_dokumen ?>">
                <input type="hidden" name="status_verifikasi" value="Ditolak">
                <div class="form-group mb-1">
                  <label class="form-label text-danger font-weight-bold" style="font-size:11px;">Alasan Penolakan / Catatan Revisi (Wajib Diisi)</label>
                  <textarea name="catatan_verifikasi" class="form-control form-control-sm mb-1" rows="2" placeholder="Alasan penolakan berkas..." required><?php echo esc($check_dokumen->catatan_verifikasi) ?></textarea>
                </div>
                <button type="submit" name="verifikasi_dokumen" value="simpan" class="btn btn-danger btn-sm btn-block">
                  <i class="fa fa-save"></i> Simpan Penolakan
                </button>
                <?php echo form_close() ?>
              </div>
            <?php else: ?>
              <?php echo form_open_multipart(base_url('admin/gelombang/dokumen/'.$siswa->slug_siswa)); ?>
              <?php echo csrf_field(); ?>
              <input type="hidden" name="id_jenis_dokumen" value="<?php echo $id_jenis_dokumen ?>">
              <div class="input-group input-group-sm">
                <input type="file" name="gambar" class="form-control form-control-sm" required>
                <div class="input-group-append">
                  <button type="submit" name="submit" value="Unggah" class="btn btn-success btn-sm"><i class="fa fa-upload"></i></button>
                </div>
              </div>
              <?php echo form_close(); ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php if($check_dokumen) include('lihat.php'); ?>
      <?php $no++; } ?>
    </div>
  </div>

  <?php if (!empty($rejected_docs_array)): ?>
    <div class="card shadow-sm mb-4 border-0" style="border-radius: 8px; background: #fff5f5; border: 1px solid #feb2b2 !important;">
      <div class="card-body p-4 text-center">
        <div class="text-left w-100 mb-3">
          <h6 class="font-weight-bold mb-2" style="color: #c53030; font-size: 14.5px;">
            <i class="fa fa-exclamation-circle mr-1"></i> Tindakan Diperlukan: Notifikasi Revisi Berkas
          </h6>
          <p class="mb-0" style="color: #742a2a; font-size: 13px; line-height: 1.5;">
            Terdapat berkas pendaftaran calon siswa yang ditolak. Harap klik tombol WhatsApp di bawah untuk mengonfirmasi seluruh daftar perbaikan berkas kepada orang tua/wali dalam <strong>satu pesan chat terpadu</strong>.
          </p>
        </div>
        
        <?php 
        $t_phone = $siswa->telepon_ayah ?: ($siswa->telepon_ibu ?: $siswa->telepon_wali);
        $t_role = $siswa->telepon_ayah ? 'Ayah' : ($siswa->telepon_ibu ? 'Ibu' : 'Wali');
        if (!empty($t_phone)): 
        ?>
          <div class="my-2">
            <a href="<?php echo get_wa_link_tolak_all($t_phone, $t_role, $siswa, $rejected_docs_array, $this->website) ?>" class="btn-wa-prominent shadow" target="_blank">
              <i class="fab fa-whatsapp mr-2"></i> KIRIM NOTIFIKASI REVISI BERKAS (<?= $t_role ?>: <?= esc($t_phone) ?>)
            </a>
          </div>
        <?php else: ?>
          <div class="alert alert-danger d-inline-block px-4 py-2 font-weight-bold">
            <i class="fa fa-exclamation-triangle"></i> Nomor kontak orang tua/wali tidak tersedia. Silakan perbarui data pendaftar terlebih dahulu.
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="d-flex justify-content-end mb-4">
    <button type="button" class="btn btn-primary font-weight-bold px-4 py-2" onclick="goToStep2()">
      Lanjut ke Langkah 2: Hasil Seleksi <i class="fa fa-arrow-right ml-1"></i>
    </button>
  </div>
</div>

<!-- STEP CONTENT 2: TENTUKAN HASIL SELEKSI -->
<div id="step-content-2" class="step-content-section">
  <div class="card card-outline card-primary shadow-sm mb-4" id="section-keputusan">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
      <h5 class="font-weight-bold text-dark mb-0" style="font-size: 15px;"><i class="fa fa-clipboard-check text-primary mr-1"></i> [LANGKAH 2] Tentukan Status Keputusan Pendaftaran</h5>
      <span class="badge badge-primary font-weight-bold px-2 py-1">Langkah 2 dari 3</span>
    </div>
    <div class="card-body py-4">
      <div class="row justify-content-center">
        <div class="col-md-8 text-center">
          <p class="text-muted mb-4" style="font-size: 13.5px;">Tentukan apakah calon siswa dinyatakan diterima, ditolak, atau memerlukan pemeriksaan lanjut setelah berkas terverifikasi.</p>
          
          <?php echo form_open(base_url('admin/gelombang/dokumen/'.$siswa->slug_siswa)) ?>
          <div class="d-flex justify-content-center align-items-center flex-wrap mb-4" style="gap: 15px;">
            <label class="status-option">
              <input type="radio" name="status_pendaftaran" value="Menunggu" <?php if($siswa->status_pendaftaran=='Menunggu') echo 'checked'; ?>>
              <span class="status-pill status-menunggu" style="font-size: 14px; padding: 10px 20px;"><i class="fa fa-clock text-warning"></i> Menunggu</span>
            </label>
            <label class="status-option">
              <input type="radio" name="status_pendaftaran" value="Diperiksa" <?php if($siswa->status_pendaftaran=='Diperiksa') echo 'checked'; ?>>
              <span class="status-pill status-diperiksa" style="font-size: 14px; padding: 10px 20px;"><i class="fa fa-search text-info"></i> Diperiksa</span>
            </label>
            <label class="status-option <?php echo !$is_dokumen_disetujui ? 'disabled-option' : '' ?>">
              <input type="radio" name="status_pendaftaran" value="Diterima" <?php if($siswa->status_pendaftaran=='Diterima') echo 'checked'; ?> <?php if(!$is_dokumen_disetujui) echo 'disabled'; ?>>
              <span class="status-pill status-diterima" style="font-size: 14px; padding: 10px 20px;"><i class="fa fa-check-circle text-success"></i> Diterima</span>
            </label>
            <label class="status-option <?php echo !$is_dokumen_disetujui ? 'disabled-option' : '' ?>">
              <input type="radio" name="status_pendaftaran" value="Tidak-Diterima" <?php if($siswa->status_pendaftaran=='Tidak-Diterima') echo 'checked'; ?> <?php if(!$is_dokumen_disetujui) echo 'disabled'; ?>>
              <span class="status-pill status-tidak" style="font-size: 14px; padding: 10px 20px;"><i class="fa fa-times-circle text-danger"></i> Tidak Diterima</span>
            </label>
          </div>

          <?php if(!$is_dokumen_disetujui): ?>
            <div class="alert alert-warning d-inline-block p-2 px-3 mb-4 mx-auto text-left" style="font-size:12.5px; max-width: 500px;">
              <i class="fa fa-exclamation-triangle text-dark mr-1"></i> Pilihan status <strong>Diterima</strong> & <strong>Tidak Diterima</strong> dikunci karena dokumen wajib calon siswa belum sepenuhnya disetujui pada Langkah 1.
            </div>
          <?php endif; ?>

          <div>
            <button type="submit" class="btn btn-success font-weight-bold px-5 py-2 shadow-sm" name="status" value="update" id="btn-save-status">
              <i class="fa fa-save mr-1"></i> Simpan Status Keputusan
            </button>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-between mb-4">
    <button type="button" class="btn btn-outline-secondary font-weight-bold px-4 py-2" onclick="showStep(1)">
      <i class="fa fa-arrow-left mr-1"></i> Kembali ke Langkah 1
    </button>
  </div>
</div>

<!-- STEP CONTENT 3: KIRIM NOTIFIKASI WA -->
<div id="step-content-3" class="step-content-section">
  <div class="card card-outline card-success shadow-sm mb-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
      <h5 class="font-weight-bold text-dark mb-0" style="font-size: 15px;"><i class="fab fa-whatsapp text-success mr-1"></i> [LANGKAH 3] Kirim Notifikasi Kelulusan ke Orang Tua</h5>
      <span class="badge badge-success font-weight-bold px-2 py-1">Langkah 3 dari 3</span>
    </div>
    <div class="card-body py-5 text-center">
      <div class="mx-auto mb-3 text-success" style="font-size: 54px;">
        <i class="fab fa-whatsapp"></i>
      </div>
      <h5 class="font-weight-bold mb-3" style="font-size: 18px;">Kirim Notifikasi Hasil Seleksi ke Orang Tua</h5>
      
      <div class="alert shadow-sm d-inline-block px-4 py-3 mb-4 mx-auto text-left w-100 border-0" style="font-size: 13.5px; max-width: 650px; background-color: #f0fdf4; border-left: 5px solid #22c55e !important;">
        <h6 class="font-weight-bold mb-2" style="color: #166534; font-size: 14.5px;">
          <i class="fab fa-whatsapp mr-1"></i> Langkah Akhir: Kirim Hasil Seleksi ke Orang Tua
        </h6>
        <p class="mb-0" style="color: #14532d; font-size: 13px; line-height: 1.5;">
          Status keputusan pendaftaran telah berhasil disimpan. Silakan klik tombol di bawah untuk mengirimkan pesan konfirmasi resmi hasil seleksi langsung ke nomor WhatsApp Orang Tua/Wali siswa.
        </p>
      </div>

      <div class="my-4">
        <?php 
        $target_phone = '';
        $target_role = '';
        if (!empty($siswa->telepon_ayah)) {
            $target_phone = $siswa->telepon_ayah;
            $target_role = 'Ayah';
        } elseif (!empty($siswa->telepon_ibu)) {
            $target_phone = $siswa->telepon_ibu;
            $target_role = 'Ibu';
        } elseif (!empty($siswa->telepon_wali)) {
            $target_phone = $siswa->telepon_wali;
            $target_role = 'Wali';
        }
        
        if (!empty($target_phone)) { ?>
          <a href="<?php echo get_wa_link($target_phone, $target_role, $siswa, $this->website) ?>" class="btn-wa-prominent shadow" target="_blank" onclick="markStep3Done()">
            <i class="fab fa-whatsapp mr-2"></i> KIRIM NOTIFIKASI KEPUTUSAN (<?= $target_role ?>: <?= esc($target_phone) ?>)
          </a>
        <?php } else { ?>
          <div class="alert alert-danger d-inline-block px-4 py-2 font-weight-bold">
            <i class="fa fa-exclamation-triangle"></i> Nomor kontak orang tua/wali tidak tersedia. Silakan perbarui data pendaftar terlebih dahulu.
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-between mb-4">
    <button type="button" class="btn btn-outline-secondary font-weight-bold px-4 py-2" onclick="showStep(2)">
      <i class="fa fa-arrow-left mr-1"></i> Kembali ke Langkah 2
    </button>
    <a href="<?php echo base_url('admin/gelombang/detail/'.$siswa->id_gelombang.'/Semua/Semua') ?>" class="btn btn-primary font-weight-bold px-4 py-2 shadow-sm">
      Selesai & Kembali ke Daftar <i class="fa fa-check-double ml-1"></i>
    </a>
  </div>
</div>

<script>
function toggleTolakForm(id) {
    var el = document.getElementById('tolak-form-' + id);
    el.classList.toggle('show');
}

function showStep(stepNum) {
  var targetCard = document.getElementById('step-card-' + stepNum);
  if (targetCard.classList.contains('disabled')) {
    alert('Langkah ini belum aktif. Selesaikan langkah sebelumnya terlebih dahulu.');
    return;
  }

  // Hide all contents
  document.querySelectorAll('.step-content-section').forEach(function(el) {
    el.classList.remove('active');
  });

  // Show target content
  var targetContent = document.getElementById('step-content-' + stepNum);
  if (targetContent) {
    targetContent.classList.add('active');
  }

  // Update active state in stepper headers
  document.querySelectorAll('.step-item').forEach(function(card, idx) {
    var cNum = idx + 1;
    if (cNum === stepNum) {
      if (!card.classList.contains('completed') && !card.classList.contains('active-success')) {
        card.classList.add('active');
      }
    } else {
      card.classList.remove('active');
    }
  });

  // Scroll to top of the content area
  window.scrollTo({ top: document.querySelector('.stepper-row').offsetTop - 20, behavior: 'smooth' });
}

function goToStep2() {
  var step1 = document.getElementById('step-card-1');
  step1.classList.remove('active');
  step1.classList.add('completed');
  step1.querySelector('.step-badge').innerHTML = '<i class="fa fa-check"></i>';
  
  var step2 = document.getElementById('step-card-2');
  step2.classList.remove('disabled');
  step2.classList.add('active');
  
  showStep(2);
}

function markStep3Done() {
  var step3 = document.getElementById('step-card-3');
  step3.classList.remove('active-success');
  step3.classList.add('completed');
  step3.querySelector('.step-badge').innerHTML = '<i class="fa fa-check"></i>';
}

function validateModalForm(form) {
  var status = form.querySelector('select[name="status_verifikasi"]').value;
  var catatan = form.querySelector('textarea[name="catatan_verifikasi"]').value.trim();
  if (status === 'Ditolak' && catatan === '') {
    alert('Alasan penolakan / catatan revisi wajib diisi jika status dokumen Ditolak!');
    form.querySelector('textarea[name="catatan_verifikasi"]').focus();
    return false;
  }
  return true;
}

document.addEventListener("DOMContentLoaded", function() {
  var initialStep = <?php echo $active_step; ?>;
  // Make sure intermediate steps have correct states unlocked
  if (initialStep >= 2) {
    var step1 = document.getElementById('step-card-1');
    step1.classList.remove('disabled', 'active');
    step1.classList.add('completed');
    step1.querySelector('.step-badge').innerHTML = '<i class="fa fa-check"></i>';

    var step2 = document.getElementById('step-card-2');
    step2.classList.remove('disabled');
    step2.classList.add('active');
  }
  if (initialStep >= 3) {
    var step2 = document.getElementById('step-card-2');
    step2.classList.remove('disabled', 'active');
    step2.classList.add('completed');
    step2.querySelector('.step-badge').innerHTML = '<i class="fa fa-check"></i>';

    var step3 = document.getElementById('step-card-3');
    step3.classList.remove('disabled');
    step3.classList.add('active-success');
  }

  showStep(initialStep);
});
</script>
