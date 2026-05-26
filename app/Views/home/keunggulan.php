<section class="wrapper bg-light">
  <div class="container pt-10 pt-md-10 pb-10 pb-md-10">
    <div class="row text-center">
      <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
        <h2 class="fs-16 text-uppercase subjudul mb-3">Kenapa memilih</h2>
        <h3 class="display-4 mb-9 px-xl-11"><?php echo $this->website->namaweb() ?></h3>
      </div>
      <!-- /column -->
    </div>
    <!-- /.row -->
    <div class="row gy-8 mb-5 justify-content-center">
      <?php foreach($keunggulan as $item) { ?>
      <div class="col-md-6 col-lg-4">
        <div class="d-flex flex-row">
          <div>
            <?php if($item->gambar != "") { ?>
              <img src="<?php echo base_url('assets/upload/image/thumbs/'.$item->gambar) ?>" class="svg-inject icon-svg icon-svg-sm solid-duo text-grape-fuchsia me-4" alt="<?php echo $item->judul_keunggulan ?>" />
            <?php } else { ?>
              <i class="fa fa-check-circle text-primary fa-2x me-4"></i>
            <?php } ?>
          </div>
          <div>
            <h3 class="fs-22 mb-1"><?php echo $item->judul_keunggulan ?></h3>
            <p class="mb-0"><?php echo $item->ringkasan ?></p>
          </div>
        </div>
      </div>
      <!--/column -->
      <?php } ?>
    </div>
    <!--/.row -->
    
  </div>
  <!-- /.container -->
</section>