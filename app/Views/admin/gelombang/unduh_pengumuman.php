<?php  
use App\Libraries\Website;
$this->website          = new Website(); 
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
          <h1>INFORMASI PENERIMAAN PESERTA DIDIK BARU
            <br><?php echo $this->website->namaweb() ?>
          </h1>
        </td>
      </tr>
    </tbody>
  </table>
  <hr><br>

  <p class="text-center"><strong>PENGUMUMAN PENERIMAAN PESERTA DIDIK BARU<br><?php echo strtoupper($gelombang->judul) ?></strong></p>

  <table class="printer">
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

    
    <table class="printer">
        <thead>
          <tr>
            <th width="5%" class="text-center align-middle">NO</th>
            <th width="20%" class="align-middle">SISWA</th>
            <th width="6%" class="align-middle">L/P</th>
            <th width="20%" class="align-middle text-center">TTL</th>
            <th width="20%" class="align-middle">PROGRAM/JENJANG</th>
            <th width="6%" class="align-middle">Status</th>
        </tr>
  </thead>
  <tbody>
    <?php 
    $i=1; foreach($siswa as $siswa) { 
      $wajib          = $m_jenis_dokumen->group_status_jenis_dokumen_detail('Wajib');
      $tidak_wajib      = $m_jenis_dokumen->group_status_jenis_dokumen_detail('Tidak Wajib');
      $dokumen_wajib      = $m_dokumen->total_check($siswa->id_siswa,$wajib->status_jenis_dokumen); 
      $dokumen_tidak_wajib  = $m_dokumen->total_check($siswa->id_siswa,$tidak_wajib->status_jenis_dokumen);
    ?>
    <tr>
      <td class="text-center"><?php echo $i ?></td>
      <td><?php echo $siswa->nama_siswa ?></td>
      <td><?php echo $siswa->jenis_kelamin ?></td>
      <td><?php echo $siswa->tempat_lahir ?>, <?php echo $this->website->tanggal_id($siswa->tanggal_lahir) ?></td>
      <td><?php echo $siswa->judul_program_pendidikan ?></td>
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
      
    </tr>
    <?php $i++; } ?>
  </tbody>
</table>
</div>
</page>
</body>
</html>