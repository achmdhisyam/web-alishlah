<section class="wrapper bg-soft-primary  bg-image" data-image-src="<?php echo $this->website->banner() ?>">
  <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
    <div class="row">
      <div class="col-md-10 col-lg-10 col-xl-5 mx-auto">
        <h1 class="display-1 mb-1 text-haqi"><?php echo $title ?></h1>
    </div>
    <!-- /column -->
</div>
<!-- /.row -->
</div>
<!-- /.container -->
</section>
<!-- /section -->
<section class="wrapper bg-light">
  <div class="container pb-14 pb-md-16">
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="blog classic-view mt-n17 row justify-content-center">
        <?php foreach($program_pendidikan as $program_pendidikan) { ?>
            <div class="col-md-3">
            <article class="post">
                <div class="card">
                  <figure class="card-img-top overlay overlay-1 hover-scale">
                    <a class="link-dark" href="<?php echo base_url('program_pendidikan/read/'.$program_pendidikan->id_program_pendidikan) ?>">
                      <?php if($program_pendidikan->gambar !='') { ?>
                            <img src="<?php echo base_url('assets/upload/image/'.$program_pendidikan->gambar) ?>" alt="<?php echo $title ?>" class="img-thumbnail">
                        <?php } ?>
                    </a>
                    <figcaption>
                      <h5 class="from-top mb-0">Baca detail...</h5>
                    </figcaption>
                  </figure>
                  <div class="card-body">
                    <div class="post-header">
                      
                      <!-- /.post-category -->
                      <h2 class="post-title mt-1 mb-0">
                        <a class="link-dark" href="<?php echo base_url('program_pendidikan/read/'.$program_pendidikan->slug_program_pendidikan) ?>">
                            <?php echo $program_pendidikan->judul_program_pendidikan ?>
                        </a>
                    </h2>
                    </div>
                    <!-- /.post-header -->
                    <div class="post-content">
                      <p><?php echo $program_pendidikan->ringkasan ?></p>
                    </div>
                    <!-- /.post-content -->
                  </div>
                  <!--/.card-body -->
                  <div class="card-footer">
                    <ul class="post-meta d-flex mb-0">
                      
                      <li class="post-comments"><a href="#"><i class="fa fa-eye"></i><span> Dibaca <?php echo $program_pendidikan->hits ?> kali</span></a></li>
                    </ul>
                    <!-- /.post-meta -->
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </article>
              <!-- /.post -->
            </div>
            
    <?php } ?>
    <div class="col-xxl-10 col-lg-10 offset-1">
        <div class="as-blog blog-single has-post-thumbnail row justify-content-end">
            <?php if(isset($pagination)) { echo str_replace('index.php/','',$pagination); } ?>
        </div>
    </div>
</div>
</div>
</div>
</div>
</section>