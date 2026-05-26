
<!-- /section -->
<section class="wrapper bg-light">
<div class="container pb-14 pb-md-16">
  <div class="row">
    <div class="col mt-n20">
      <div class="card shadow-lg">
        <div class="row gx-0 text-center">
          <?php if($this->website->login()!='') { ?>
            <div class="col-lg-6 image-wrapper bg-image bg-cover rounded-top rounded-lg-start d-none d-md-block" data-image-src="<?php echo $this->website->login() ?>">
          <?php }else{ ?>
            <div class="col-lg-6 image-wrapper bg-image bg-cover rounded-top rounded-lg-start d-none d-md-block" data-image-src="<?php echo base_url() ?>assets/template/assets/img/photos/tm3.jpg">
          <?php } ?>
          </div>
          <!--/column -->
          <div class="col-lg-6">
            <div class="p-3 p-md-7 p-lg-8">
              <p class="lead mb-6 text-start">Masukkan Email Anda.</p>
              <?php 
              $validation = \Config\Services::validation();
                  $errors = $validation->getErrors();
                  if(!empty($errors))
                  {
                      echo '<span class="text-danger">'.$validation->listErrors().'</span>';
                  }
              ?>
  
             
              <?php echo form_open(base_url('signin/reset'),' class=="text-start mb-3"'); ?>
                <div class="form-floating mb-3">
                  <input type="email" class="form-control" name="email" placeholder="Email Anda" id="loginEmail">
                  <label for="loginEmail">Email Anda</label>
                </div>
               
                <button type="submit" name="submit" value="submit" class="btn btn-primary rounded-pill btn-login w-100 mb-2">
                  Reset Password&nbsp;<i class="fa fa-arrow-right"></i>
                </button>
              </form>
              <!-- /form -->
              <p class="mb-1">Kembali ke <a href="<?php echo base_url() ?>">Beranda</a> | <a href="<?php echo base_url('signin') ?>" class="hover">Login?</a></p>
              <p class="mb-0">Belum punya akun? <a href="<?php echo base_url('pendaftaran/akun') ?>">Buat akun sekarang!</a></p>
          
            
              <!--/.social -->
            </div>
            <!--/div -->
          </div>
          <!--/column -->
        </div>
        <!--/.row -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /column -->
  </div>
  <!-- /.row -->
</div>
<!-- /.container -->
</section>
<!-- /section -->