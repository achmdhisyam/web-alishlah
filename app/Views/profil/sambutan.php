<section class="wrapper bg-soft-primary bg-image" data-image-src="<?php echo $this->website->banner() ?>">
  <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
    <div class="row">
      <div class="col-md-10 col-lg-10 col-xl-10 mx-auto">
        <h1 class="display-1 mb-1 text-haqi">Sambutan Kepala Sekolah</h1>
      </div>
    </div>
  </div>
</section>

<section class="wrapper bg-light">
  <div class="container pb-14 pb-md-16">
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="blog classic-view mt-n17">
          <article class="post">
            <div class="card">
              <div class="card-body">
                <div class="row gy-6 align-items-center">
                  <?php if($sambutan->gambar != '') { ?>
                    <div class="col-md-4 text-center">
                      <img src="<?php echo base_url('assets/upload/image/'.$sambutan->gambar) ?>" alt="<?php echo $sambutan->judul_sambutan ?>" class="img-thumbnail rounded-circle shadow-lg" style="max-width: 200px;">
                      <h4 class="mt-3 mb-0"><?php echo $sambutan->judul_sambutan ?></h4>
                      <small class="text-muted">Kepala Sekolah</small>
                    </div>
                    <div class="col-md-8">
                      <div class="post-content">
                        <?php echo $sambutan->isi ?>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="col-12">
                      <h4 class="mb-3 text-center"><?php echo $sambutan->judul_sambutan ?></h4>
                      <div class="post-content">
                        <?php echo $sambutan->isi ?>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <div class="card-footer">
                <ul class="post-meta d-flex mb-0">
                  <li class="post-date"><i class="uil uil-calendar-alt"></i><span><?php echo $this->website->tanggal_bulan_menit($sambutan->tanggal_publish) ?></span></li>
                  <li class="post-comments"><a href="#"><i class="fa fa-eye"></i><span> Dibaca <?php echo $sambutan->hits ?> kali</span></a></li>
                </ul>
              </div>
            </div>
          </article>
        </div>
      </div>
    </div>
  </div>
</section>
