<?php if($program_pendidikan) { ?>
<section class="wrapper bg-light">
  <div class="container pt-3 pt-md-6">
    <div class="row text-center">
      <div class="col-lg-10 mx-auto">
        <h2 class="fs-16 text-uppercase mb-3 subjudul">Program Pendidikan</h2>
        <h3 class="display-6 mb-10">Jenjang & Program Unggulan Kami</h3>
      </div>
    </div>
    <div class="row gx-md-8 gy-8 text-center justify-content-center">
      <?php foreach($program_pendidikan as $prog) { ?>
        <div class="col-md-6 col-lg-4">
          <div class="card shadow-lg">
            <div class="card-body p-5">
              <?php if($prog->gambar) { ?>
                <img src="<?php echo base_url('assets/upload/image/thumbs/'.$prog->gambar) ?>" class="img-fluid rounded mb-4" alt="<?php echo $prog->judul_program_pendidikan ?>" style="max-height: 150px; object-fit: cover;" />
              <?php } else if($prog->icon) { ?>
                <div class="icon btn btn-circle btn-lg btn-soft-primary disabled mb-4">
                  <i class="<?php echo $prog->icon ?>"></i>
                </div>
              <?php } ?>
              <h4 class="mb-2"><?php echo $prog->judul_program_pendidikan ?></h4>
              <p class="mb-4 text-secondary"><?php echo word_limiter(strip_tags($prog->ringkasan), 15) ?></p>
              <a href="<?php echo base_url('program_pendidikan/read/'.$prog->slug_program_pendidikan) ?>" class="btn btn-primary btn-sm rounded-pill">Selengkapnya</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>
<?php } ?>
