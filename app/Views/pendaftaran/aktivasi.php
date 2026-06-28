<section class="wrapper bg-light">
  <div class="container py-14">
    <div class="row justify-content-center">
      <div class="col-lg-6 text-center">

        <?php 
        $sessionSukses = session()->getFlashdata('sukses');
        $sessionWarning = session()->getFlashdata('warning');
        if($sessionSukses): 
        ?>
          <div class="alert alert-success">
            <?= $sessionSukses; ?>
          </div>
        <?php elseif($sessionWarning): ?>
          <div class="alert alert-warning">
            <?= $sessionWarning; ?>
          </div>
        <?php endif; ?>

        <h3 class="mb-4">Aktivasi Akun</h3>
        <p>
          <a href="<?= base_url('signin') ?>" class="btn btn-primary">Login Sekarang</a>
        </p>
      </div>
    </div>
  </div>
</section>
