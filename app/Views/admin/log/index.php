<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-history mr-1"></i> Audit Trail / Log Aktivitas Admin</h3>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-sm" id="example1">
        <thead>
          <tr class="bg-light text-center">
            <th width="5%">No</th>
            <th width="15%">Tanggal &amp; Waktu</th>
            <th width="20%">Nama Admin</th>
            <th width="12%">Kategori</th>
            <th>Aktivitas / Tindakan</th>
            <th width="12%">IP Address</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($logs as $log) : ?>
            <tr>
              <td class="text-center"><?= $no++ ?></td>
              <td class="text-center"><?= date('d-m-Y H:i:s', strtotime($log->tanggal_log)) ?></td>
              <td>
                <strong><?= esc($log->nama_user ?? 'Sistem') ?></strong>
                <?php if ($log->username) : ?>
                  <br><small class="text-muted"><i class="fa fa-user"></i> <?= esc($log->username) ?></small>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <?php 
                  $badge = 'bg-secondary';
                  if ($log->kategori == 'SPMB') $badge = 'bg-success';
                  elseif ($log->kategori == 'Autentikasi') $badge = 'bg-info';
                  elseif ($log->kategori == 'Berita') $badge = 'bg-primary';
                ?>
                <span class="badge <?= $badge ?>"><?= esc($log->kategori) ?></span>
              </td>
              <td><?= esc($log->aktivitas) ?></td>
              <td class="text-center font-italic"><?= esc($log->ip_address) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
