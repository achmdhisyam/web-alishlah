<?php if (!empty($video_list) && is_array($video_list)) : ?>
<section class="wrapper bg-soft-primary">
  <div class="container py-10 py-md-12">
    <div class="row text-center">
      <div class="col-lg-10 col-xl-9 col-xxl-8 mx-auto">
        <h2 class="fs-15 text-uppercase text-muted mb-3">Galeri Video</h2>
        <h3 class="display-4 mb-8 px-lg-12">Video Terbaru</h3>
      </div>
    </div>
    <div class="swiper-container dots-closer blog grid-view mb-6" data-margin="30" data-dots="true" data-items-xl="3" data-items-md="2" data-items-xs="1">
      <div class="swiper">
        <div class="swiper-wrapper">
          <?php foreach ($video_list as $v) : ?>
            <div class="swiper-slide">
              <article>
                <figure class="overlay overlay-1 hover-scale rounded mb-5">
                  <a href="https://www.youtube.com/watch?v=<?php echo $this->website->youtube_id($v->video) ?>" data-glightbox data-gallery="home-video">
                    <img src="<?php echo $this->website->youtube_thumbnail($v->video, $v->gambar) ?>" alt="<?= $v->judul ?>" />
                    <span class="bg"></span>
                  </a>
                  <figcaption>
                    <h5 class="from-top mb-0"><i class="fa fa-play mr-2"></i> Putar Video</h5>
                  </figcaption>
                </figure>
                <div class="post-header text-center">
                  <h2 class="post-title h3 mt-1 mb-3"><?= $v->judul ?></h2>
                </div>
              </article>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>
