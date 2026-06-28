<?php if (!empty($galeri_foto) && is_array($galeri_foto)) : ?>
<section class="wrapper bg-light">
  <div class="container py-10 py-md-12">
    <div class="row text-center">
      <div class="col-lg-10 col-xl-9 col-xxl-8 mx-auto">
        <h2 class="fs-15 text-uppercase text-muted mb-3">Galeri Foto</h2>
        <h3 class="display-4 mb-8 px-lg-12">Foto Terbaru</h3>
      </div>
    </div>
    <div class="swiper-container dots-closer blog grid-view mb-6" data-margin="30" data-dots="true" data-items-xl="3" data-items-md="2" data-items-xs="1">
      <div class="swiper">
        <div class="swiper-wrapper">
          <?php foreach ($galeri_foto as $g) : ?>
            <div class="swiper-slide">
              <article>
                <figure class="overlay overlay-1 hover-scale rounded mb-5">
                  <a href="<?= base_url('assets/upload/image/'.$g->gambar) ?>" data-glightbox data-gallery="home-gallery">
                    <img src="<?= base_url('assets/upload/image/'.$g->gambar) ?>" alt="<?= $g->judul_galeri ?>" />
                    <span class="bg"></span>
                  </a>
                  <figcaption>
                    <h5 class="from-top mb-0">Lihat Foto</h5>
                  </figcaption>
                </figure>
                <div class="post-header text-center">
                  <h2 class="post-title h3 mt-1 mb-3"><?= $g->judul_galeri ?></h2>
                </div>
              </article>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="text-center mt-6">
      <a href="<?php echo base_url('galeri') ?>" class="btn btn-outline-primary rounded-pill px-6">Lihat Semua Galeri &nbsp;<i class="fa fa-arrow-right"></i></a>
    </div>
  </div>
</section>
<?php endif; ?>
