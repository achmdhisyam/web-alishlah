<section class="wrapper bg-light">
  <div class="container py-14">
    <div class="row justify-content-center">
      <div class="col-lg-6 text-center">

        <?php if(session()->getFlashdata('sukses')): ?>
          <div class="alert alert-success">
            <?= session()->getFlashdata('sukses'); ?>
          </div>
        <?php elseif(session()->getFlashdata('warning')): ?>
          <div class="alert alert-warning">
            <?= session()->getFlashdata('warning'); ?>
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
