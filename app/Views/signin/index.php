
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
              <p class="lead mb-6 text-start">Masukkan NIS/Email/Username dan Password Anda.</p>
              <?php 
              $validation = \Config\Services::validation();
                  $errors = $validation->getErrors();
                  if(!empty($errors))
                  {
                      echo '<span class="text-danger">'.$validation->listErrors().'</span>';
                  }
              ?>
  
             
              <?php echo form_open(base_url('signin'),' class=="text-start mb-3"'); ?>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="username" placeholder="NIS/Email" id="loginEmail">
                  <label for="loginEmail">NIS/Email/Username</label>
                </div>
                <div class="form-floating password-field mb-3">
                  <input type="password" class="form-control" name="password" placeholder="Password" id="loginPassword">
                  <span class="password-toggle"><i class="uil uil-eye"></i></span>
                  <label for="loginPassword">Password</label>
                </div>
                <button type="submit" name="submit" value="submit" class="btn btn-primary rounded-pill btn-login w-100 mb-2">
                  Masuk&nbsp;<i class="fa fa-arrow-right"></i>
                </button>
              </form>
              <!-- /form -->

              <?php if(!empty($konfigurasi->google_client_id)) { ?>
              <p class="text-center mt-3">
                  <a href="<?php echo base_url('googleauth/login/siswa') ?>" class="btn-google">
                      <img src="https://www.gstatic.com/images/branding/product/1x/googleg_48dp.png" alt="Google"> Masuk dengan Google
                  </a>
              </p>
              <?php } ?>

              <p class="mb-1 mt-4">Kembali ke <a href="<?php echo base_url() ?>">Beranda</a> | <a href="<?php echo base_url('signin/reset') ?>" class="hover">Lupa Password?</a></p>
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