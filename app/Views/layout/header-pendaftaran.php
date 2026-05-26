 <?php 
use App\Models\Nav_model;
use App\Models\Konfigurasi_model;
use App\Libraries\Website;
$this->website          = new Website(); 
$m_nav                 = new Nav_model();
$m_site                 = new Konfigurasi_model();
?>
<section class="wrapper bg-soft-primary bg-image" data-image-src="<?php echo $this->website->banner() ?>" style="background-size: cover; background-position: center; background-repeat: no-repeat;">
  <div class="container  pt-10 pt-md-12 pb-21 pb-md-21 text-center">
    <div class="row">
      <div class="col-md-10 col-lg-10 col-xl-10 mx-auto">
        <p class="text-center">
          <a href="<?php echo base_url() ?>">
            <img src="<?php echo $this->website->icon() ?>" style="max-width: 150px; height: auto;">
          </a>
        </p>
        <h1 class="display-1 mb-1 text-white"><?php echo $title ?></h1>
        
      </div>
      <!-- /column -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
</section>
