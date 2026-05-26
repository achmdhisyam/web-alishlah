<section class="wrapper bg-soft-primary  bg-image" data-image-src="<?php echo $this->website->banner() ?>">
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
                    <div class="post-content row">
                      <div class="col-md-5">
                        <figure class="card-img-top overlay overlay-1 hover-scale">
                            <?php if($yayasan->gambar !='') { ?>
                                  <img src="<?php echo base_url('assets/upload/image/'.$yayasan->gambar) ?>" alt="<?php echo $title ?>" class="img-thumbnail">
                              <?php } ?>
                        </figure>
                      </div>
                      <div class="col-md-7">
                        <?php echo $yayasan->isi ?>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <ul class="post-meta d-flex mb-0">
                      <li class="post-date"><i class="uil uil-calendar-alt"></i><span><?php echo $this->website->tanggal_bulan_menit($yayasan->tanggal_publish) ?></span></li>
                      <li class="post-author"><a href="#"><i class="uil uil-user"></i><span><?php echo $yayasan->nama ?></span></a></li>
                      <li class="post-comments"><a href="#"><i class="fa fa-eye"></i><span> Dibaca <?php echo $yayasan->hits ?> kali</span></a></li>
                    </ul>
                  </div>
                </div>
              </article>
            </div>
        </div>
    </div>
  </div>
</section>
