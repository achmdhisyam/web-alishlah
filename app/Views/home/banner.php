<?php if (!empty($slider) && is_array($slider)) : ?>

<section class="wrapper bg-light">
  <div class="container-card">
    <div class="card image-wrapper bg-full bg-image mt-2 mb-0" data-image-src="<?= $this->website->banner() ?>">
      <div class="card-body py-10 px-0">
        <div class="container">
          <div class="row gx-md-8 gx-xl-12 gy-10 align-items-center text-center text-lg-start">

            <!-- TEKS SLIDER -->
            <div class="col-lg-6">
              <div id="text-slider" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                  <?php $isFirst = true; foreach ($slider as $s) : ?>
                    <div class="carousel-item <?= $isFirst ? 'active' : '' ?>">
                      <h1 class="display-4 mb-4 me-xl-5 me-xxl-0 text-haqi"><?= $s->judul_galeri ?></h1>
                      <p class="lead fs-23 lh-sm mb-7 pe-xxl-15 text-white"><?= strip_tags($s->isi) ?></p>
                      <?php if (!empty($s->website)) : ?>
                        <a href="<?= $s->website ?>" class="btn btn-lg btn-primary rounded">
                          <?= !empty($s->text_website) ? $s->text_website : 'Selengkapnya' ?> &nbsp;<i class="fa fa-arrow-right ml-2"></i>
                        </a>
                      <?php endif; ?>
                    </div>
                  <?php $isFirst = false; endforeach; ?>
                </div>
              </div>
            </div>

            <!-- GAMBAR SLIDER -->
            <div class="col-lg-6 position-relative">
              <div id="small-slider" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                  <?php $isFirst = true; foreach ($slider as $s) : ?>
                    <div class="carousel-item <?= $isFirst ? 'active' : '' ?>">
                      <img class="img-fluid rounded shadow-black w-100" src="<?= base_url('assets/upload/image/'.$s->gambar) ?>" alt="">
                    </div>
                  <?php $isFirst = false; endforeach; ?>
                </div>

                <!-- NEXT / PREV BUTTONS -->
                <button class="carousel-control-prev" type="button" data-bs-target="#small-slider" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#small-slider" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  // Sinkronkan teks dan gambar slider
  var imgSlider = document.getElementById('small-slider');
  var txtSlider = document.getElementById('text-slider');

  imgSlider.addEventListener('slide.bs.carousel', function (e) {
    var index = e.to;
    var tCarousel = bootstrap.Carousel.getInstance(txtSlider);
    tCarousel.to(index);
  });
</script>



<!-- Modal -->
<div class="modal fade" id="VideoModal" tabindex="-1" aria-labelledby="VideoModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
         <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="ratio ratio-16x9 rounded shadow-lg border border-secondary p-2">
          <iframe src="https://www.youtube.com/embed/<?php echo $site->link_video ?>" title="<?php echo $this->website->namaweb() ?>" allowfullscreen></iframe>
      </div>
      </div>
    </div>
  </div>
</div>

<?php endif; ?>
