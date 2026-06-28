<?php  
use App\Libraries\Website;
$this->website          = new Website(); 

if (!function_exists('filterSyaratPendaftaran')) {
    function filterSyaratPendaftaran($html) {
        $header = '<p style="font-weight: bold; margin-top: 15px; margin-bottom: 5px;">Syarat Berkas Daftar Ulang:</p>';
        if (empty($html)) {
            return $header . '<ul class="mb-0 pl-3"><li style="margin-bottom: 6px !important;">Cetak Bukti Pendaftaran ini</li></ul>';
        }
        
        // 1. Try to extract nested list if it exists
        if (preg_match('/<li[^>]*>.*?<(ul|ol)\b[^>]*>(.*?)<\/\1>.*?<\/li>/is', $html, $matches)) {
            $sublist_content = $matches[2];
            return $header . '<ul class="mb-0 pl-3" style="list-style-type: disc !important;">
                      <li style="margin-bottom: 8px !important; font-weight: bold;">Cetak Bukti Pendaftaran ini</li>' 
                      . $sublist_content . 
                   '</ul>';
        }
        
        // 2. If no nested list is found, process flat list items
        if (strpos($html, '<li') !== false) {
            $pattern = '/<li\b[^>]*>(.*?)<\/li>/is';
            if (preg_match_all($pattern, $html, $matches)) {
                $filtered_items = [];
                $filtered_items[] = '<li style="margin-bottom: 8px !important; font-weight: bold;">Cetak Bukti Pendaftaran ini</li>';
                
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
                return $header . '<ul class="mb-0 pl-3" style="list-style-type: disc !important;">' . implode("\n", $filtered_items) . '</ul>';
            }
        }
        
        // Fallback
        return $header . '<ul class="mb-0 pl-3" style="list-style-type: disc !important;">
                  <li style="margin-bottom: 8px !important; font-weight: bold;">Cetak Bukti Pendaftaran ini</li>
                </ul>' . $html;
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title ?></title>
<link href="<?php echo base_url('assets/css/css-print.css') ?>" rel="stylesheet" media="print">
<link href="<?php echo base_url('assets/css/css-print.css') ?>" rel="stylesheet" media="screen">
</head>

<body>
<page size="A4" layout="portrait">
<div class="cetak">
<table>
    <tbody>
      <tr>
        <td style="width: 1.8cm;">
          <img src="<?php echo $this->website->icon() ?>" style="width: 1.5cm; height: auto;">
        </td>
        <td>
          <h1>INFORMASI PENDAFTARAN PESERTA DIDIK BARU
            <br><?php echo $konfigurasi->namaweb ?>
          </h1>
        </td>
      </tr>
    </tbody>
  </table>
  <hr><br>
<table class="table table-bordered table-sm printer">
    <thead>
      <tr>
        <th colspan="2" class="bg-secondary text-white text-center">DATA DASAR SISWA</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="font-bold" width="35%">Nama lengkap</td>
        <td><?php echo strtoupper($siswa->nama_siswa) ?></td>
      </tr>
      <tr>
        <td class="font-bold">Nama panggilan</td>
        <td><?php echo $siswa->nama_panggilan ?></td>
      </tr>
      <tr>
        <td class="font-bold">NIS / NISN</td>
        <td><?php echo $siswa->nis ?> / <?php echo $siswa->nisn ?></td>
      </tr>
      <tr>
        <td class="font-bold">Agama & Kewarganegaraan</td>
        <td><?php echo $siswa->nama_agama ?> - <?php echo $siswa->status_wn ?> <?php echo ($siswa->status_wn == 'WNA') ? '('.$siswa->negara_asal.')' : ''; ?></td>
      </tr>
      <tr>
        <td class="font-bold">Jenis Kelamin</td>
        <td><?php if($siswa->jenis_kelamin=='L') { echo 'Laki-laki'; }else{ echo 'Perempuan'; } ?></td>
      </tr>
      <tr>
        <td class="font-bold">Tempat, tanggal lahir</td>
        <td><?php echo $siswa->tempat_lahir ?>, <?php echo $this->website->tanggal_id($siswa->tanggal_lahir) ?></td>
      </tr>
      <tr>
        <td class="font-bold">Kode Pendaftaran</td>
        <td><?php echo $siswa->kode_siswa ?></td>
      </tr>
      <tr>
        <td class="font-bold">Periode Pendaftaran</td>
        <td><?php echo $siswa->judul ?></td>
      </tr>
      <tr>
        <td class="font-bold">Tahun Ajaran</td>
        <td><?php echo $siswa->tahun_ajaran ?></td>
      </tr>
      <tr>
        <td class="font-bold">Program</td>
        <td><?php echo $siswa->judul_program_pendidikan ?></td>
      </tr>
      <tr>
        <td class="font-bold">Status Anak</td>
        <td><?php echo $siswa->nama_hubungan ?></td>
      </tr>
      <tr>
        <td class="font-bold">Anak ke</td>
        <td><?php echo $siswa->anak_ke ?> dari <?php echo $siswa->jumlah_saudara ?> Saudara</td>
      </tr>
      <tr>
        <td class="font-bold">Alamat</td>
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
          <?php if(!empty($siswa->kode_pos)) { echo " (Kode Pos: ".$siswa->kode_pos.")"; } ?>
        </td>
      </tr>
      
      <tr>
        <td class="font-bold">Telepon</td>
        <td><?php echo $siswa->telepon ?></td>
      </tr>
       <tr>
        <td class="font-bold">Email</td>
        <td><?php echo $siswa->email ?></td>
      </tr>
      <tr>
        <td class="font-bold">Ukuran Seragam</td>
        <td><?php echo $siswa->ukuran_seragam ?></td>
      </tr>
      
    </tbody>
  </table>
  
   <table class="table table-bordered table-sm printer mt-2">
    <thead>
      <tr>
        <th colspan="2" class="bg-secondary text-white text-center">PENDIDIKAN SEBELUMNYA</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="font-bold" width="35%">Tamatan Dari</td>
        <td><?php echo $siswa->asal_sekolah ?></td>
      </tr>
    </tbody>
  </table>

  <table class="table table-bordered table-sm printer mt-2">
    <thead>
      <tr>
        <th colspan="2" class="bg-secondary text-white text-center">DATA ORANG TUA SISWA - AYAH</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="font-bold" width="35%">Nama Ayah</td>
        <td><?php echo $siswa->nama_ayah ?></td>
      </tr>
      <tr>
        <td class="font-bold">Agama Ayah</td>
        <td><?php echo $siswa->agama_ayah ?></td>
      </tr>
      <tr>
        <td class="font-bold">Tempat & Tanggal Lahir Ayah</td>
        <td><?php echo $siswa->tempat_lahir_ayah ?>, <?php echo $this->website->tanggal_id($siswa->tanggal_lahir_ayah) ?></td>
      </tr>
      <tr>
        <td class="font-bold">Kewarganegaraan Ayah</td>
        <td><?php echo $siswa->status_wn_ayah ?></td>
      </tr>
      <tr>
        <td class="font-bold">Pekerjaan Ayah</td>
        <td><?php echo $siswa->nama_pekerjaan ?></td>
      </tr>
      <tr>
        <td class="font-bold">Penghasilan per Bulan Ayah</td>
        <td><?php echo $siswa->penghasilan_ayah ?></td>
      </tr>
      <tr>
        <td class="font-bold">Pendidikan Ayah</td>
        <td><?php echo $siswa->jenjang_ayah ?></td>
      </tr>
      <tr>
        <td class="font-bold">Status Ayah</td>
        <td><?php echo $siswa->status_hidup_ayah ?></td>
      </tr>
      <tr>
        <td class="font-bold">Alamat Ayah</td>
        <td>
          <?php 
          if(!empty($siswa->rt_ayah) || !empty($siswa->rw_ayah) || !empty($siswa->kecamatan_ayah)) {
              $full = $siswa->alamat_ayah;
              if(!empty($siswa->rt_ayah) || !empty($siswa->rw_ayah)) { $full .= ', RT '.$siswa->rt_ayah.' / RW '.$siswa->rw_ayah; }
              if(!empty($siswa->kelurahan_ayah)) { $full .= ', Kel. '.$siswa->kelurahan_ayah; }
              if(!empty($siswa->kecamatan_ayah)) { $full .= ', Kec. '.$siswa->kecamatan_ayah; }
              if(!empty($siswa->kabupaten_ayah)) { $full .= ', '.$siswa->kabupaten_ayah; }
              if(!empty($siswa->provinsi_ayah)) { $full .= ', '.$siswa->provinsi_ayah; }
              echo nl2br($full);
          } else {
              echo nl2br($siswa->alamat_ayah);
          }
          ?>
          <?php if(!empty($siswa->kode_pos_ayah)) { echo " (Kode Pos: ".$siswa->kode_pos_ayah.")"; } ?>
        </td>
      </tr>
      <tr>
        <td class="font-bold">Telepon/HP Ayah</td>
        <td><?php echo $siswa->telepon_ayah ?></td>
      </tr>
    </tbody>
  </table>

  <table class="table table-bordered table-sm printer mt-2">
    <thead>
      <tr>
        <th colspan="2" class="bg-secondary text-white text-center">DATA ORANG TUA SISWA - IBU</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="font-bold" width="35%">Nama Ibu</td>
        <td><?php echo $siswa->nama_ibu ?></td>
      </tr>
      <tr>
        <td class="font-bold">Agama Ibu</td>
        <td><?php echo $siswa->agama_ibu ?></td>
      </tr>
      <tr>
        <td class="font-bold">Tempat & Tanggal Lahir Ibu</td>
        <td><?php echo $siswa->tempat_lahir_ibu ?>, <?php echo $this->website->tanggal_id($siswa->tanggal_lahir_ibu) ?></td>
      </tr>
      <tr>
        <td class="font-bold">Kewarganegaraan Ibu</td>
        <td><?php echo $siswa->status_wn_ibu ?></td>
      </tr>
      <tr>
        <td class="font-bold">Pekerjaan Ibu</td>
        <td><?php echo $siswa->pekerjaan_ibu ?></td>
      </tr>
      <tr>
        <td class="font-bold">Penghasilan per Bulan Ibu</td>
        <td><?php echo $siswa->penghasilan_ibu ?></td>
      </tr>
      <tr>
        <td class="font-bold">Pendidikan Ibu</td>
        <td><?php echo $siswa->jenjang_ibu ?></td>
      </tr>
      <tr>
        <td class="font-bold">Status Ibu</td>
        <td><?php echo $siswa->status_hidup_ibu ?></td>
      </tr>
      <tr>
        <td class="font-bold">Alamat Ibu</td>
        <td>
          <?php 
          if(!empty($siswa->rt_ibu) || !empty($siswa->rw_ibu) || !empty($siswa->kecamatan_ibu)) {
              $full = $siswa->alamat_ibu;
              if(!empty($siswa->rt_ibu) || !empty($siswa->rw_ibu)) { $full .= ', RT '.$siswa->rt_ibu.' / RW '.$siswa->rw_ibu; }
              if(!empty($siswa->kelurahan_ibu)) { $full .= ', Kel. '.$siswa->kelurahan_ibu; }
              if(!empty($siswa->kecamatan_ibu)) { $full .= ', Kec. '.$siswa->kecamatan_ibu; }
              if(!empty($siswa->kabupaten_ibu)) { $full .= ', '.$siswa->kabupaten_ibu; }
              if(!empty($siswa->provinsi_ibu)) { $full .= ', '.$siswa->provinsi_ibu; }
              echo nl2br($full);
          } else {
              echo nl2br($siswa->alamat_ibu);
          }
          ?>
          <?php if(!empty($siswa->kode_pos_ibu)) { echo " (Kode Pos: ".$siswa->kode_pos_ibu.")"; } ?>
        </td>
      </tr>
      <tr>
        <td class="font-bold">Telepon/HP Ibu</td>
        <td><?php echo $siswa->telepon_ibu ?></td>
      </tr>
    </tbody>
  </table>

  <table class="table table-bordered table-sm printer mt-2">
    <thead>
      <tr>
        <th colspan="2" class="bg-secondary text-white text-center">DATA ORANG TUA SISWA - WALI</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="font-bold" width="35%">Nama Wali</td>
        <td><?php echo $siswa->nama_wali ?></td>
      </tr>
      <tr>
        <td class="font-bold">Agama Wali</td>
        <td><?php echo $siswa->agama_wali ?></td>
      </tr>
      <tr>
        <td class="font-bold">Tempat & Tanggal Lahir Wali</td>
        <td><?php echo $siswa->tempat_lahir_wali ?>, <?php echo $this->website->tanggal_id($siswa->tanggal_lahir_wali) ?></td>
      </tr>
      <tr>
        <td class="font-bold">Pekerjaan Wali</td>
        <td><?php echo $siswa->pekerjaan_wali ?></td>
      </tr>
      <tr>
        <td class="font-bold">Penghasilan per Bulan Wali</td>
        <td><?php echo $siswa->penghasilan_wali ?></td>
      </tr>
      <tr>
        <td class="font-bold">Pendidikan Wali</td>
        <td><?php echo $siswa->jenjang_wali ?></td>
      </tr>
      <tr>
        <td class="font-bold">Alamat Wali</td>
        <td>
          <?php 
          if(!empty($siswa->rt_wali) || !empty($siswa->rw_wali) || !empty($siswa->kecamatan_wali)) {
              $full = $siswa->alamat_wali;
              if(!empty($siswa->rt_wali) || !empty($siswa->rw_wali)) { $full .= ', RT '.$siswa->rt_wali.' / RW '.$siswa->rw_wali; }
              if(!empty($siswa->kelurahan_wali)) { $full .= ', Kel. '.$siswa->kelurahan_wali; }
              if(!empty($siswa->kecamatan_wali)) { $full .= ', Kec. '.$siswa->kecamatan_wali; }
              if(!empty($siswa->kabupaten_wali)) { $full .= ', '.$siswa->kabupaten_wali; }
              if(!empty($siswa->provinsi_wali)) { $full .= ', '.$siswa->provinsi_wali; }
              echo nl2br($full);
          } else {
              echo nl2br($siswa->alamat_wali);
          }
          ?>
          <?php if(!empty($siswa->kode_pos_wali)) { echo " (Kode Pos: ".$siswa->kode_pos_wali.")"; } ?>
        </td>
      </tr>
      <tr>
        <td class="font-bold">Telepon/HP Wali</td>
        <td><?php echo $siswa->telepon_wali ?></td>
      </tr>
    </tbody>
  </table>

  






<div class="konten-print">
  <?php echo filterSyaratPendaftaran($konfigurasi->syarat_pendaftaran ?? ''); ?>
  <?php echo $konfigurasi->rincian_administrasi; ?>
</div>

</div>
</page>
</body>
</html>