<section class="wrapper bg-soft-primary bg-image" data-image-src="<?php echo $this->website->banner() ?>">
  <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
    <div class="row">
      <div class="col-md-10 col-lg-10 col-xl-10 mx-auto">
        <h1 class="display-1 mb-1 text-haqi"><?php echo $title ?></h1>
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
                
                <div class="mb-8">
                  <h2 class="display-6 text-primary mb-3"><i class="fas fa-check-circle"></i> Visi</h2>
                  <blockquote class="fs-lg border-start border-primary border-4 ps-4 italic">
                    <?php echo nl2br(htmlspecialchars($visi_misi->ringkasan)) ?>
                  </blockquote>
                </div>

                <hr class="my-8" />

                <div>
                  <h2 class="display-6 text-primary mb-3"><i class="fas fa-check-circle"></i> Misi</h2>
                  <div class="post-content">
                    <?php echo $visi_misi->isi ?>
                  </div>
                </div>

              </div>
              <div class="card-footer">
                <ul class="post-meta d-flex mb-0">
                  <li class="post-date"><i class="uil uil-calendar-alt"></i><span><?php echo $this->website->tanggal_bulan_menit($visi_misi->tanggal_publish) ?></span></li>
                  <li class="post-comments"><a href="#"><i class="fa fa-eye"></i><span> Dibaca <?php echo $visi_misi->hits ?> kali</span></a></li>
                </ul>
              </div>
            </div>
          </article>
        </div>
      </div>
    </div>
  </div>
</section>
