<?php if($yayasan) { ?>
<section class="wrapper bg-light">
  <div class="container pt-3 pt-md-6">
        <div class="px-lg-5 mb-4 mb-md-6">
            <div class="row gx-0 gx-md-8 gx-xl-12 gy-8 justify-content-center">

               <div class="col-lg-10 mx-auto text-center">
              <h2 class="fs-16 text-uppercase mb-3 subjudul">Terkait</h2>
            </div>

               <?php foreach($yayasan as $jp) { ?>
                <div class="col-md-3">
                  <div class="card">
                    <div class="card-body p-2">
                      <div class="px-md-0 px-lg-0 px-xl-1 text-center">
                        <p class="text-center">
                          <?php if($jp->gambar) { ?>
                            <img src="<?php echo base_url('assets/upload/image/'.$jp->gambar) ?>" class="img-fluid rounded rounded-circle w-50" alt="" />
                          <?php } ?>
                        </p>
                        <h4 class="text-uppercase"><?php echo $jp->judul_yayasan ?></h4>
                        <a href="<?php echo base_url('yayasan/read/'.$jp->slug_yayasan) ?>" class="btn btn-selengkapnya btn-sm">Selengkapnya...</a>
                      </div>
                    </div>
                  </div>
                </div>
               <?php } ?>
              
            </div>
          </div>
  </div>
</section>
<?php } ?>
