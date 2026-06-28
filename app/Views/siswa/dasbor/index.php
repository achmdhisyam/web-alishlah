<?php
$db = \Config\Database::connect();
$id_akun = Session()->get('id_akun');
$siswa = $db->table('siswa')->where('id_akun', $id_akun)->get()->getRow();
$ditolak_docs = [];
$pct = 0;
$progress_dok = null;

if ($siswa) {
    $ditolak_docs = $db->table('dokumen')
        ->select('dokumen.*, jenis_dokumen.nama_jenis_dokumen')
        ->join('jenis_dokumen', 'jenis_dokumen.id_jenis_dokumen = dokumen.id_jenis_dokumen')
        ->where('dokumen.id_siswa', $siswa->id_siswa)
        ->where('dokumen.status_verifikasi', 'Ditolak')
        ->get()->getResult();

    $total_wajib = $db->table('jenis_dokumen')->where('status_jenis_dokumen', 'Wajib')->countAllResults();
    $sudah_upload = $db->table('dokumen')->where('id_siswa', $siswa->id_siswa)->countAllResults();
    $progress_dok = ['sudah' => $sudah_upload, 'total' => $total_wajib];
    $pct = $total_wajib > 0 ? min(100, round(($sudah_upload / $total_wajib) * 100)) : 0;
}

// Load configurations for WhatsApp SPMB
$m_konfigurasi = new \App\Models\Konfigurasi_model();
$konfigurasi = $m_konfigurasi->listing();
$no_wa_admin = !empty($konfigurasi->whatsapp_spmb) ? $konfigurasi->whatsapp_spmb : (!empty($konfigurasi->whatsapp) ? $konfigurasi->whatsapp : $konfigurasi->hp);
$no_wa_admin = preg_replace('/[^0-9]/', '', $no_wa_admin);
if (strpos($no_wa_admin, '0') === 0) {
    $no_wa_admin = '62' . substr($no_wa_admin, 1);
} elseif (strpos($no_wa_admin, '8') === 0) {
    $no_wa_admin = '62' . $no_wa_admin;
}

if (!function_exists('filterSyaratPendaftaran')) {
    function filterSyaratPendaftaran($html) {
        if (empty($html)) {
            return '<ul class="mb-0 pl-3"><li style="margin-bottom: 6px !important;">Cetak Bukti Pendaftaran (diunduh dari dasbor ini)</li></ul>';
        }
        
        // 1. Try to extract nested list if it exists
        if (preg_match('/<li[^>]*>.*?<(ul|ol)\b[^>]*>(.*?)<\/\1>.*?<\/li>/is', $html, $matches)) {
            $sublist_content = $matches[2];
            return '<ul class="mb-0 pl-3" style="list-style-type: disc !important;">
                      <li style="margin-bottom: 8px !important; font-weight: bold; color: #166534;"><i class="fa fa-print mr-1"></i> Cetak Bukti Pendaftaran (diunduh dari dasbor ini)</li>' 
                      . $sublist_content . 
                   '</ul>';
        }
        
        // 2. If no nested list is found, process flat list items
        if (strpos($html, '<li') !== false) {
            $pattern = '/<li\b[^>]*>(.*?)<\/li>/is';
            if (preg_match_all($pattern, $html, $matches)) {
                $filtered_items = [];
                $filtered_items[] = '<li style="margin-bottom: 8px !important; font-weight: bold; color: #166534;"><i class="fa fa-print mr-1"></i> Cetak Bukti Pendaftaran (diunduh dari dasbor ini)</li>';
                
                foreach ($matches[0] as $idx => $full_li) {
                    $content = $matches[1][$idx];
                    $text = strtolower(strip_tags($content));
                    
                    // Whitelist: Document related keywords
                    $keep_keywords = ['fotocopy', 'fotokopi', 'fc', 'lembar', 'berkas', 'ijazah', 'kk', 'ktp', 'pas foto', 'pasfoto', 'kartu', 'pkh', 'kip', 'kks', 'akte', 'akta', 'lahir', 'dokumen'];
                    $is_document = false;
                    foreach ($keep_keywords as $k) {
                        if (strpos($text, $k) !== false) {
                            $is_document = true;
                            break;
                        }
                    }
                    
                    if ($is_document) {
                        $full_li = preg_replace('/<li/is', '<li style="margin-bottom: 6px !important;"', $full_li);
                        $filtered_items[] = $full_li;
                        continue;
                    }
                    
                    // Blacklist: Registration online action keywords
                    $filter_keywords = ['mengisi', 'isi', 'formulir', 'online', 'buat akun', 'membuat akun', 'mendaftar', 'transfer', 'membayar', 'pendaftaran'];
                    $should_filter = false;
                    foreach ($filter_keywords as $f) {
                        if (strpos($text, $f) !== false) {
                            $should_filter = true;
                            break;
                        }
                    }
                    
                    if (!$should_filter) {
                        $full_li = preg_replace('/<li/is', '<li style="margin-bottom: 6px !important;"', $full_li);
                        $filtered_items[] = $full_li;
                    }
                }
                return '<ul class="mb-0 pl-3" style="list-style-type: disc !important;">' . implode("\n", $filtered_items) . '</ul>';
            }
        }
        
        // Fallback
        return '<ul class="mb-0 pl-3" style="list-style-type: disc !important;">
                  <li style="margin-bottom: 8px !important; font-weight: bold; color: #166534;"><i class="fa fa-print mr-1"></i> Cetak Bukti Pendaftaran (diunduh dari dasbor ini)</li>
                </ul>' . $html;
    }
}
?>


<?php if ($siswa && $pct >= 100 && !in_array($siswa->status_pendaftaran ?? '', ['Diterima', 'Tidak-Diterima'])) : 
    $program_nama = '';
    if (!empty($siswa->id_program_pendidikan)) {
        $prog = $db->table('program_pendidikan')->where('id_program_pendidikan', $siswa->id_program_pendidikan)->get()->getRow();
        if ($prog) { $program_nama = $prog->judul_program_pendidikan; }
    }
    $pesan_konfirm = "Halo Panitia SPMB " . $this->website->namaweb() . ", saya ingin mengonfirmasi pendaftaran anak kami:\n\n- Nama Calon Siswa: " . $siswa->nama_siswa . "\n- Kode Pendaftaran: " . $siswa->kode_siswa . "\n- Program Pendidikan: " . $program_nama . "\n\ntelah selesai mengisi seluruh biodata dan mengunggah berkas pendaftaran online. Mohon informasi langkah verifikasi selanjutnya. Terima kasih.";
    $link_konfirm = "https://api.whatsapp.com/send?phone=" . $no_wa_admin . "&text=" . urlencode($pesan_konfirm);
?>
  <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-left: 5px solid #ffc107 !important; background-color: #fff3cd; color: #856404;">
    <div class="d-flex align-items-center justify-content-between flex-wrap w-100">
      <div class="d-flex align-items-start">
        <div class="mr-3 mt-1" style="font-size: 24px; color: #856404;">
          <i class="fab fa-whatsapp"></i>
        </div>
        <div>
          <h5 class="alert-heading font-weight-bold mb-1" style="color: #856404;">Wajib Konfirmasi Pendaftaran</h5>
          <p class="mb-0 text-dark" style="font-size: 13px;">Anda telah menyelesaikan pendaftaran online. <strong>Silakan hubungi Panitia SPMB via WhatsApp untuk konfirmasi sekarang</strong> agar berkas Anda segera diverifikasi.</p>
        </div>
      </div>
      <a href="<?php echo $link_konfirm ?>" target="_blank" class="btn btn-warning btn-md font-weight-bold text-dark ml-lg-3 mt-2 mt-lg-0 shadow-sm border-0" style="background-color: #ffc107; border-radius: 4px; text-decoration: none !important;">
        <i class="fab fa-whatsapp mr-1"></i> Kirim Konfirmasi Sekarang
      </a>
    </div>
  </div>
<?php endif; ?>

<?php if (!empty($ditolak_docs)) : ?>
  <div class="alert shadow-sm mb-4 border-0" role="alert" style="border-radius: 8px; background-color: #fff5f5; border-left: 5px solid #e53e3e !important; border-top: 1px solid #feb2b2 !important; border-right: 1px solid #feb2b2 !important; border-bottom: 1px solid #feb2b2 !important; padding: 20px;">
    <div class="d-flex align-items-start">
      <div class="mr-3 text-danger" style="font-size: 24px; margin-top: 2px;">
        <i class="fas fa-exclamation-triangle"></i>
      </div>
      <div class="w-100">
        <h5 class="alert-heading font-weight-bold mb-2" style="color: #c53030; font-size: 16px;">Perhatian: Ada Dokumen yang Ditolak</h5>
        <p class="mb-3 text-dark font-weight-normal" style="font-size: 14px; line-height: 1.5; color: #2d3748 !important;">Beberapa dokumen pendaftaran Anda memerlukan revisi. Silakan unggah kembali dokumen berikut:</p>
        
        <div class="p-3 bg-white rounded border mb-3" style="border-color: #fed7d7 !important;">
          <ul class="mb-0 pl-3" style="font-size: 13.5px; line-height: 1.8; color: #2d3748;">
            <?php foreach ($ditolak_docs as $doc) : ?>
              <li class="mb-2" style="list-style-type: square;">
                <strong class="text-dark" style="font-size: 14px;"><?= esc($doc->nama_jenis_dokumen) ?></strong>
                <?php if (!empty($doc->catatan_verifikasi)) : ?>
                  <div class="mt-1 p-2 rounded" style="background-color: #fff5f5; border: 1px dashed #feb2b2; display: block; width: 100%; max-width: 600px;">
                    <span class="text-danger font-weight-bold" style="font-size: 12.5px;">
                      <i class="fa fa-info-circle mr-1"></i> Catatan Revisi: <span class="text-dark font-weight-normal"><?= esc($doc->catatan_verifikasi) ?></span>
                    </span>
                  </div>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        
        <a href="<?= base_url('siswa/pendaftaran/dokumen/' . $siswa->slug_siswa) ?>" class="btn btn-danger btn-sm font-weight-bold px-4 py-2 shadow-sm" style="border-radius: 4px; text-decoration: none !important; background-color: #e53e3e; border: none;">
          <i class="fas fa-upload mr-1"></i> Unggah Ulang Berkas Sekarang
        </a>
      </div>
    </div>
  </div>
<?php endif; ?>

<div class="callout callout-success">
	Hai <strong><?php echo Session()->get('nama_siswa') ?></strong>, 
	Selamat datang di <strong><?php echo $this->website->namaweb() ?></strong>
</div>

<?php
// Ambil data status pendaftaran & progress dokumen
$status_pend = $siswa ? ($siswa->status_pendaftaran ?? null) : null;

// Hitung persentase alur pendaftaran keseluruhan (overall progress)
$overall_pct = 0; 
if (!$siswa) {
    $overall_pct = 25; // Baru buat akun, belum isi biodata
} else {
    $overall_pct = 50; // Sudah isi biodata
    if ($pct >= 100) {
        $overall_pct = 83; // Sudah unggah semua dokumen wajib
        if (in_array($status_pend, ['Diterima', 'Tidak-Diterima'])) {
            $overall_pct = 100; // Sudah ada keputusan kelulusan
        }
    } else {
        $overall_pct = 50 + round($pct * 0.33); // Progress dokumen
    }
}
?>

<!-- STEPPER ROADMAP PENDAFTARAN -->
<div class="card shadow-sm mb-4 border-0" style="border-radius: 4px;">
  <div class="card-body p-4">
    <h5 class="font-weight-bold mb-4 text-dark" style="font-size: 15px;">
      <i class="fa fa-route text-primary mr-1"></i> Alur Proses Pendaftaran Anda
    </h5>
    
    <div class="d-flex justify-content-between align-items-center position-relative mx-auto" style="max-width: 750px; padding: 10px 0;">
      <!-- Progress Bar Background Line -->
      <div class="position-absolute" style="height: 4px; background-color: #e9ecef; left: 40px; right: 40px; top: 32px; z-index: 1;">
        <div style="height: 100%; width: <?php echo $overall_pct ?>%; background-color: #28a745; transition: width 0.4s ease;"></div>
      </div>
      
      <!-- Step 1: Registrasi Akun -->
      <div class="text-center position-relative" style="z-index: 2; width: 90px;">
        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm border border-white" style="width: 44px; height: 44px; font-size: 14px; font-weight: bold;">
          <i class="fa fa-user-plus"></i>
        </div>
        <span class="font-weight-bold text-success" style="font-size: 11px; display: block; line-height: 1.2;">1. Buat Akun</span>
      </div>
      
      <!-- Step 2: Isi Biodata -->
      <?php 
        $step2_active = !empty($siswa); 
        $step2_class = $step2_active ? 'bg-success text-white border-white' : 'bg-white text-secondary border';
        $step2_text_class = $step2_active ? 'text-success font-weight-bold' : 'text-muted';
      ?>
      <div class="text-center position-relative" style="z-index: 2; width: 90px;">
        <div class="rounded-circle <?php echo $step2_class ?> d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 44px; height: 44px; font-size: 14px; font-weight: bold; border-color: #dee2e6 !important;">
          <i class="fa fa-file-alt"></i>
        </div>
        <span class="<?php echo $step2_text_class ?>" style="font-size: 11px; display: block; line-height: 1.2;">2. Isi Biodata</span>
      </div>
      
      <!-- Step 3: Unggah Dokumen -->
      <?php 
        $step3_active = ($siswa && $pct >= 100);
        $step3_in_progress = ($siswa && $pct > 0 && $pct < 100);
        $step3_class = $step3_active ? 'bg-success text-white border-white' : ($step3_in_progress ? 'bg-info text-white border-white' : 'bg-white text-secondary border');
        $step3_text_class = $step3_active ? 'text-success font-weight-bold' : ($step3_in_progress ? 'text-info font-weight-bold' : 'text-muted');
      ?>
      <div class="text-center position-relative" style="z-index: 2; width: 90px;">
        <div class="rounded-circle <?php echo $step3_class ?> d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 44px; height: 44px; font-size: 14px; font-weight: bold; border-color: #dee2e6 !important;">
          <i class="fa fa-upload"></i>
        </div>
        <span class="<?php echo $step3_text_class ?>" style="font-size: 11px; display: block; line-height: 1.2;">3. Unggah Berkas</span>
      </div>
      
      <!-- Step 4: Kelulusan / Seleksi -->
      <?php 
        $step4_done = ($siswa && in_array($status_pend, ['Diterima', 'Tidak-Diterima']));
        $step4_in_progress = ($siswa && $pct >= 100 && in_array($status_pend, ['Menunggu', 'Diperiksa']));
        $step4_class = $step4_done ? ($status_pend == 'Diterima' ? 'bg-success text-white border-white' : 'bg-danger text-white border-white') : ($step4_in_progress ? 'bg-info text-white border-white' : 'bg-white text-secondary border');
        $step4_text_class = $step4_done ? ($status_pend == 'Diterima' ? 'text-success font-weight-bold' : 'text-danger font-weight-bold') : ($step4_in_progress ? 'text-info font-weight-bold' : 'text-muted');
      ?>
      <div class="text-center position-relative" style="z-index: 2; width: 90px;">
        <div class="rounded-circle <?php echo $step4_class ?> d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 44px; height: 44px; font-size: 14px; font-weight: bold; border-color: #dee2e6 !important;">
          <i class="fa fa-award"></i>
        </div>
        <span class="<?php echo $step4_text_class ?>" style="font-size: 11px; display: block; line-height: 1.2;">4. Pengumuman</span>
      </div>
      
    </div>
  </div>
</div>

<?php if ($siswa): ?>
<?php
  $status_color = 'secondary'; $status_icon = 'fa-clock'; $status_text = 'Belum Mendaftar'; $status_bg = '#6c757d';
  if ($status_pend == 'Menunggu')           { $status_color = 'warning';  $status_icon = 'fa-clock';        $status_text = 'Menunggu Verifikasi'; $status_bg = '#ffc107'; }
  elseif ($status_pend == 'Diperiksa')      { $status_color = 'info';     $status_icon = 'fa-search';       $status_text = 'Sedang Diperiksa';    $status_bg = '#17a2b8'; }
  elseif ($status_pend == 'Diterima')       { $status_color = 'success';  $status_icon = 'fa-check-circle'; $status_text = 'Selamat! Diterima'; $status_bg = '#28a745'; }
  elseif ($status_pend == 'Tidak-Diterima') { $status_color = 'danger';   $status_icon = 'fa-times-circle'; $status_text = 'Tidak Diterima';      $status_bg = '#dc3545'; }
  $bar_color = $pct >= 100 ? 'bg-success' : ($pct > 0 ? 'bg-info' : 'bg-secondary');
?>

<div class="card card-outline card-<?php echo $status_color ?> mb-4 shadow-sm" style="border-radius: 4px;">
  <div class="card-body p-4">
    <div class="row">

      <!-- Kiri: Status + Kode Pendaftaran + Panduan Checklist -->
      <div class="col-md-7">
        <p class="text-muted mb-1" style="font-size:12px; text-transform:uppercase; letter-spacing:1px;">Status Pendaftaran Kamu</p>
        <div class="d-flex align-items-center mb-3">
          <i class="fa <?php echo $status_icon ?> text-<?php echo $status_color ?> mr-2" style="font-size:1.6rem;"></i>
          <span class="font-weight-bold text-<?php echo $status_color ?>" style="font-size:1.4rem;"><?php echo $status_text ?></span>
        </div>

        <?php if (!empty($siswa->kode_siswa)): ?>
        <div class="mt-2 mb-3 p-3 rounded" style="background: #f8f9fa; border: 1px dashed #ced4da;">
          <small class="text-muted d-block mb-1"><i class="fa fa-id-card mr-1"></i> Kode Pendaftaran — gunakan untuk cek pengumuman</small>
          <span style="font-size: 1.8rem; font-weight: 900; letter-spacing: 4px; color: #343a40; font-family: monospace;"><?php echo $siswa->kode_siswa ?></span>
        </div>
        <?php endif; ?>

        <!-- Progress Dokumen -->
        <small class="text-muted">
          Dokumen Wajib: <strong><?php echo $progress_dok['sudah'] ?> dari <?php echo $progress_dok['total'] ?> diunggah</strong>
        </small>
        <div class="progress mt-1 mb-1" style="height: 8px; border-radius: 4px;">
          <div class="progress-bar <?php echo $bar_color ?>" style="width: <?php echo $pct ?>%" title="<?php echo $pct ?>%"></div>
        </div>
        <small class="text-muted mb-4 d-block"><?php echo $pct ?>% berkas terunggah</small>

        <?php if ($status_pend == 'Diterima') : ?>
          <div class="mt-2 mb-3 p-4 rounded shadow-sm" style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; border-left: 5px solid #22c55e !important;">
            <h5 class="font-weight-bold mb-3" style="font-size: 13.5px; color: #166534;"><i class="fa fa-graduation-cap mr-1"></i> Prosedur Daftar Ulang & Persiapan Masuk Sekolah:</h5>
            <div class="text-dark" style="font-size: 12.5px; line-height: 1.6;">
              <p class="mb-3">Selamat atas kelulusan Anda! Untuk melakukan pendaftaran ulang dan mempersiapkan masuk sekolah, silakan ikuti langkah-langkah berikut:</p>
              
              <style>
                /* === Rincian Content Styles === */
                .rincian-content {
                  font-size: 13px;
                  color: #374151;
                  line-height: 1.65;
                  word-break: break-word;
                  overflow-wrap: break-word;
                }
                .rincian-content p {
                  font-size: 13px;
                  line-height: 1.65;
                  margin-bottom: 8px;
                  word-break: break-word;
                }
                .rincian-content span, .rincian-content div, .rincian-content strong {
                  font-size: 13px;
                  word-break: break-word;
                  overflow-wrap: break-word;
                }
                .rincian-content h1, .rincian-content h2, .rincian-content h3,
                .rincian-content h4, .rincian-content h5, .rincian-content h6 {
                  font-size: 13.5px;
                  font-weight: 700;
                  line-height: 1.4;
                  margin-top: 10px;
                  margin-bottom: 6px;
                  color: #1e293b;
                  word-break: break-word;
                }
                .rincian-content ul, .rincian-content ol {
                  margin-top: 6px;
                  margin-bottom: 10px;
                  padding-left: 20px;
                }
                .rincian-content li {
                  font-size: 13px;
                  line-height: 1.65;
                  margin-bottom: 6px;
                  word-break: break-word;
                }
                /* Scrollable table wrapper on mobile */
                .rincian-table-scroll {
                  overflow-x: auto;
                  -webkit-overflow-scrolling: touch;
                  margin: 8px 0 10px 0;
                  border-radius: 4px;
                }
                .rincian-content table {
                  width: 100%;
                  min-width: 500px;
                  border-collapse: collapse;
                  font-size: 12px;
                  line-height: 1.5;
                }
                .rincian-content td, .rincian-content th {
                  padding: 7px 8px;
                  border: 1px solid #cbd5e1;
                  word-break: normal;
                  font-size: 12px;
                  white-space: normal;
                  vertical-align: top;
                }
                .rincian-content th {
                  background-color: #f1f5f9;
                  font-weight: 700;
                  color: #1e293b;
                }
                @media (max-width: 576px) {
                  .rincian-content {
                    font-size: 12.5px;
                  }
                  .rincian-content p, .rincian-content li, .rincian-content span,
                  .rincian-content div, .rincian-content strong {
                    font-size: 12.5px;
                    line-height: 1.6;
                  }
                  .rincian-content h1, .rincian-content h2, .rincian-content h3,
                  .rincian-content h4, .rincian-content h5, .rincian-content h6 {
                    font-size: 13px;
                  }
                  .rincian-content table {
                    font-size: 11.5px;
                  }
                  .rincian-content td, .rincian-content th {
                    padding: 5px 6px;
                    font-size: 11.5px;
                  }
                }
              </style>

              <ul class="pl-3 mb-3" style="list-style-type: decimal; font-size: 12.5px;">
                <li class="mb-3">
                  <strong>Konfirmasi Kedatangan & Kelulusan:</strong>
                  <div class="text-secondary mt-1" style="font-size: 12px; line-height: 1.5;">
                    Klik tombol di bawah untuk mengonfirmasi kelulusan Anda langsung ke WhatsApp Panitia SPMB agar kursi pendaftaran Anda aman.
                  </div>
                </li>
                <li class="mb-3">
                  <strong>Rincian Biaya & Administrasi:</strong>
                  <div class="text-secondary mt-1 mb-2" style="font-size: 12px; line-height: 1.5;">
                    Lakukan pembayaran daftar ulang dengan mengacu pada rincian biaya berikut:
                  </div>
                  <div class="rincian-table-scroll"><div class="rincian-content p-2 bg-light rounded border-0">
                    <?php if (!empty($konfigurasi->rincian_administrasi)): ?>
                      <?php echo $konfigurasi->rincian_administrasi; ?>
                    <?php else: ?>
                      <span class="text-muted"><i class="fa fa-info-circle mr-1"></i> Rincian administrasi belum diatur oleh admin.</span>
                    <?php endif; ?>
                  </div></div>
                </li>
                <li class="mb-3">
                  <strong>Syarat Berkas Daftar Ulang:</strong>
                  <div class="text-secondary mt-1 mb-2" style="font-size: 12px; line-height: 1.6;">
                    Siapkan dan bawa dokumen fisik berikut saat daftar ulang ke sekolah:
                  </div>
                  <div class="rincian-content p-2 bg-light rounded border-0">
                    <?php echo filterSyaratPendaftaran($konfigurasi->syarat_pendaftaran ?? ''); ?>
                  </div>
                </li>
                <li class="mb-3">
                  <strong>Verifikasi Berkas Fisik & Pengukuran Seragam:</strong>
                  <div class="text-secondary mt-1" style="font-size: 12px; line-height: 1.5;">
                    Datang ke kantor panitia pada hari kerja dengan membawa berkas asli pendukung serta cetak bukti pendaftaran untuk pengukuran seragam sekolah.
                  </div>
                </li>
              </ul>
            </div>
            <div class="mt-3">
              <a href="https://api.whatsapp.com/send?phone=<?php echo $no_wa_admin ?>&text=<?php echo urlencode("Halo Panitia SPMB " . $this->website->namaweb() . ", saya orang tua dari calon siswa " . $siswa->nama_siswa . " (Kode: " . $siswa->kode_siswa . ") ingin mengonfirmasi kelulusan dan menanyakan prosedur daftar ulang serta persiapan masuk sekolah.") ?>" 
                 class="btn btn-success btn-sm font-weight-bold text-white shadow-sm" target="_blank" style="border-radius: 4px; text-decoration: none !important; background-color: #28a745; border: none; padding: 6px 16px;">
                <i class="fab fa-whatsapp mr-1"></i> Hubungi Panitia & Konfirmasi Daftar Ulang
              </a>
            </div>
          </div>
        <?php elseif ($status_pend == 'Tidak-Diterima') : ?>
          <div class="mt-2 mb-3 p-4 rounded shadow-sm" style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; border-left: 5px solid #ef4444 !important;">
            <h5 class="font-weight-bold mb-2" style="font-size: 14px; color: #991b1b;"><i class="fa fa-info-circle mr-1"></i> Informasi Pengumuman:</h5>
            <p class="text-dark mb-0" style="font-size: 13.5px; line-height: 1.6;">Terima kasih telah berpartisipasi dan mendaftar di sekolah kami. Kami mengapresiasi minat serta perjuangan Anda. Tetap semangat, jangan berkecil hati, dan teruslah belajar dengan giat untuk mencapai cita-cita Anda di masa depan.</p>
          </div>
        <?php endif; ?>

        <!-- Checklist Alur Panduan Kerja Siswa -->
        <div class="p-3 bg-light rounded border mt-3">
          <h6 class="font-weight-bold text-dark mb-3" style="font-size: 13px;"><i class="fa fa-tasks text-primary mr-1"></i> Panduan Langkah Pendaftaran Anda:</h6>
          <ul class="list-unstyled mb-0" style="font-size: 12.5px; line-height: 1.8;">
            <li class="d-flex align-items-start mb-2">
              <i class="fa fa-check-circle text-success mr-2 mt-1" style="font-size: 14px;"></i>
              <div>
                <strong>Langkah 1: Isi Biodata</strong>
                <span class="text-success font-weight-bold d-block">Selesai mengisi data diri & orang tua.</span>
              </div>
            </li>
            <li class="d-flex align-items-start mb-2">
              <i class="fa <?php echo $pct >= 100 ? 'fa-check-circle text-success' : 'fa-dot-circle' ?> mr-2 mt-1" style="font-size: 14px; <?php echo $pct < 100 ? 'color: #0056b3;' : '' ?>"></i>
              <div>
                <strong>Langkah 2: Unggah Berkas Wajib</strong>
                <?php if ($pct >= 100): ?>
                  <span class="text-success font-weight-bold d-block">Selesai mengunggah seluruh berkas wajib.</span>
                <?php else: ?>
                  <span class="text-muted d-block">Lengkapi berkas wajib (Baru <?php echo $progress_dok['sudah'] ?> dari <?php echo $progress_dok['total'] ?>).</span>
                  <a href="<?php echo base_url('siswa/pendaftaran/dokumen/'.$siswa->slug_siswa) ?>" class="btn btn-xs btn-primary mt-1 font-weight-bold text-white"><i class="fa fa-upload"></i> Unggah Berkas Sekarang</a>
                <?php endif; ?>
              </div>
            </li>
            <li class="d-flex align-items-start mb-2">
              <i class="fa <?php echo $pct >= 100 ? 'fa-dot-circle' : 'fa-circle text-muted' ?> mr-2 mt-1" style="font-size: 14px; opacity: <?php echo $pct >= 100 ? '1' : '0.5' ?>; <?php echo $pct >= 100 ? 'color: #0056b3;' : '' ?>"></i>
              <div>
                <strong>Langkah 3: Cetak Bukti Pendaftaran</strong>
                <?php if ($pct >= 100): ?>
                  <span class="font-weight-bold d-block mb-1" style="color: #0056b3;">Seluruh data & berkas lengkap! Silakan cetak bukti pendaftaran Anda.</span>
                  <a href="<?php echo base_url('siswa/pendaftaran/cetak/'.$siswa->slug_siswa) ?>" target="_blank" class="btn btn-xs btn-danger font-weight-bold"><i class="fa fa-file-pdf"></i> Cetak Bukti Pendaftaran</a>
                <?php else: ?>
                  <span class="text-muted d-block">Dapat diunduh setelah mengunggah seluruh berkas wajib di Langkah 2.</span>
                <?php endif; ?>
              </div>
            </li>
            <?php 
              $step4_done = in_array($status_pend, ['Diterima', 'Tidak-Diterima']);
              $step4_active = ($pct >= 100 && !$step4_done);
              $step4_icon = $step4_done ? 'fa-check-circle text-success' : ($step4_active ? 'fa-dot-circle' : 'fa-circle text-muted');
              $step4_opacity = ($step4_done || $step4_active) ? '1' : '0.5';
              $step4_color_style = $step4_active ? 'color: #0056b3;' : '';
            ?>
            <li class="d-flex align-items-start">
              <i class="fa <?php echo $step4_icon ?> mr-2 mt-1" style="font-size: 14px; opacity: <?php echo $step4_opacity ?>; <?php echo $step4_color_style ?>"></i>
              <div>
                <strong>Langkah 4: Pantau Hasil Pengumuman</strong>
                <?php if ($step4_done): ?>
                  <?php if ($status_pend == 'Diterima'): ?>
                    <span class="text-success font-weight-bold d-block">Selamat! Anda dinyatakan DITERIMA. Silakan cek detail langkah selanjutnya.</span>
                  <?php else: ?>
                    <span class="text-danger font-weight-bold d-block">Anda dinyatakan TIDAK DITERIMA. Terima kasih telah mendaftar.</span>
                  <?php endif; ?>
                <?php elseif ($step4_active): ?>
                  <span class="font-weight-bold d-block mb-1" style="color: #0056b3;">Sedang dalam proses verifikasi berkas oleh Panitia.</span>
                  <span class="text-muted d-block">Pantau status pendaftaran secara berkala pada dasbor ini atau klik tombol cek pengumuman.</span>
                <?php else: ?>
                  <span class="text-muted d-block">Pengumuman kelulusan akan aktif setelah berkas pendaftaran Anda diverifikasi lengkap oleh Panitia.</span>
                <?php endif; ?>
              </div>
            </li>
          </ul>
        </div>

      </div>

      <!-- Kanan: Tombol aksi utama -->
      <div class="col-md-5 mt-3 mt-md-0 d-flex flex-column justify-content-start border-left-md pl-md-4">
        <h6 class="font-weight-bold text-dark mb-3"><i class="fa fa-directions text-primary mr-1"></i> Aksi Cepat</h6>
        
        <?php if (!empty($siswa->slug_siswa)): ?>
        <a href="<?php echo base_url('siswa/pendaftaran/cetak/'.$siswa->slug_siswa) ?>" target="_blank"
           class="btn btn-danger btn-block mb-2 font-weight-bold p-2 <?php echo $pct < 100 ? 'disabled' : '' ?>"
           style="text-decoration: none !important;"
           title="<?php echo $pct < 100 ? 'Lengkapi semua berkas wajib terlebih dahulu' : 'Cetak kartu bukti pendaftaran' ?>">
          <i class="fa fa-file-pdf mr-1"></i> Cetak Bukti Pendaftaran
          <?php if ($pct < 100): ?>
            <small class="d-block font-weight-normal text-white-50" style="font-size:10px;">(Kunci: Berkas Belum Lengkap)</small>
          <?php endif; ?>
        </a>
        <?php endif; ?>

        <?php if (!empty($siswa->kode_siswa)): ?>
        <a href="<?php echo base_url('check') ?>" target="_blank"
           class="btn btn-<?php echo $status_color ?> btn-block mb-2 font-weight-bold p-2"
           style="white-space: normal; text-decoration: none !important;">
          <i class="fa fa-search mr-1"></i> Cek Pengumuman Kelulusan
        </a>
        <?php endif; ?>
        <a href="https://api.whatsapp.com/send?phone=<?php echo $no_wa_admin ?>&text=<?php echo urlencode("Halo Panitia SPMB " . $this->website->namaweb() . ", saya ingin bertanya terkait pendaftaran PPDB online...") ?>" 
           class="btn btn-outline-success btn-block mb-2 font-weight-bold p-2 text-left" 
           target="_blank" style="text-decoration: none !important;">
          <i class="fab fa-whatsapp mr-1 text-success"></i> Hubungi Panitia (Tanya Jawab)
        </a>

        <div class="dropdown-divider mb-3"></div>

        <a href="<?php echo base_url('siswa/pendaftaran/selesai/'.$siswa->slug_siswa) ?>" class="btn btn-outline-secondary btn-block btn-sm mb-2 text-left" style="text-decoration: none !important;">
          <i class="fa fa-user mr-2 text-secondary"></i> Lihat Detail Biodata
        </a>
        
        <a href="<?php echo base_url('siswa/pendaftaran/edit/'.$siswa->slug_siswa) ?>" class="btn btn-outline-warning btn-block btn-sm mb-2 text-left text-dark" style="text-decoration: none !important;">
          <i class="fa fa-edit mr-2 text-warning"></i> Ubah Biodata Pendaftaran
        </a>
        <a href="<?php echo base_url('siswa/pendaftaran/dokumen/'.$siswa->slug_siswa) ?>" class="btn btn-outline-info btn-block btn-sm mb-2 text-left" style="text-decoration: none !important;">
          <i class="fa fa-upload mr-2 text-info"></i> Unggah / Kelola Berkas
        </a>
      </div>

    </div>
  </div>
</div>
<?php else: ?>
<div class="card card-outline card-primary mb-4 shadow-sm" style="border-radius: 4px;">
  <div class="card-body p-4 text-center">
    <div class="mb-3">
      <div style="width: 70px; height: 70px; border-radius: 50%; background: #e0f2fe; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
        <i class="fa fa-info-circle text-primary" style="font-size: 36px;"></i>
      </div>
    </div>
    <h4 class="font-weight-bold text-dark mb-2">Langkah Selanjutnya: Pilih Periode Pendaftaran</h4>
    <p class="text-muted mx-auto mb-4" style="max-width: 550px; font-size: 14px; line-height: 1.6;">
      Halo! Akun Anda telah berhasil dibuat. Untuk melanjutkan proses pendaftaran, silakan pilih periode atau gelombang pendaftaran yang tersedia, kemudian isi data biodata Anda dengan lengkap.
    </p>
    <a href="<?php echo base_url('siswa/gelombang') ?>" class="btn btn-primary btn-lg px-5 shadow-sm font-weight-bold" style="border-radius: 30px; text-decoration: none !important;">
      <i class="fa fa-calendar-check mr-2"></i> Pilih Periode / Gelombang Sekarang
    </a>
  </div>
</div>
<?php endif; ?>




