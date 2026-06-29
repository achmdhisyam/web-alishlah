<style>
.google-btn {
    border: 1px solid #dadce0 !important;
    color: #3c4043 !important;
    background-color: #fff !important;
    transition: all 0.25s cubic-bezier(.4, 0, .2, 1) !important;
    font-size: 15px !important;
    padding: 10px 20px !important;
    border-radius: 50px !important;
}
.google-btn:hover {
    background-color: #f8f9fa !important;
    border-color: #c4c6ca !important;
    color: #1a73e8 !important;
    text-decoration: none !important;
    box-shadow: 0 4px 12px rgba(60,64,67, 0.15) !important;
    transform: translateY(-1px);
}
.google-btn:active {
    background-color: #f1f3f4 !important;
    transform: translateY(0);
}
</style>

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
              <p class="lead mb-5 text-start font-weight-bold">Portal Pendaftaran Siswa</p>

              <?php 
              $sessionWarning = session()->getFlashdata('warning');
              if ($sessionWarning) : 
              ?>
                <div class="alert alert-danger alert-dismissible fade show p-3 mb-3" role="alert" style="border-radius: 8px; font-size: 13.5px; text-align: left;">
                  <i class="fas fa-exclamation-circle mr-1"></i> <?= $sessionWarning ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="float: right; border: none; background: transparent; font-size: 16px; line-height: 1;">&times;</button>
                </div>
              <?php endif; ?>

              <?php 
              $sessionSukses = session()->getFlashdata('sukses');
              if ($sessionSukses) : 
              ?>
                <div class="alert alert-success alert-dismissible fade show p-3 mb-3" role="alert" style="border-radius: 8px; font-size: 13.5px; text-align: left;">
                  <i class="fas fa-check-circle mr-1"></i> <?= $sessionSukses ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="float: right; border: none; background: transparent; font-size: 16px; line-height: 1;">&times;</button>
                </div>
              <?php endif; ?>

              <?php if(!empty($konfigurasi->google_client_id)) { ?>
              <div class="mb-4">
                  <a href="<?php echo base_url('googleauth/login/siswa') ?>" class="btn btn-light w-100 d-flex align-items-center justify-content-center google-btn shadow-sm">
                      <img src="https://www.gstatic.com/images/branding/product/1x/googleg_48dp.png" alt="Google" style="width: 20px; height: 20px; margin-right: 10px;"> Masuk dengan Google
                  </a>
              </div>
              <?php } ?>

              <div class="text-center my-4">
                <a href="#manualLoginCollapse" data-bs-toggle="collapse" class="text-secondary hover" style="font-size: 13.5px; font-weight: 500; text-decoration: none;">
                  Atau masuk dengan email & password <i class="fa fa-chevron-down ms-1" style="font-size: 10px;"></i>
                </a>
              </div>

              <!-- Collapsible Manual Login Form -->
              <div class="collapse <?php if(!empty($errors)) echo 'show'; ?>" id="manualLoginCollapse">
                <div class="card card-body p-4 text-start mb-4" style="border: 1px solid #dee2e6; border-radius: 12px; background-color: #f8f9fa;">
                  
                  <?php echo form_open(base_url('signin'),' class="text-start mb-0"'); ?>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="username" placeholder="Email/Username" id="loginEmail" required>
                      <label for="loginEmail">Email/Username</label>
                    </div>
                    <div class="form-floating password-field mb-3">
                      <input type="password" class="form-control" name="password" placeholder="Password" id="loginPassword" required>
                      <span class="password-toggle"><i class="uil uil-eye"></i></span>
                      <label for="loginPassword">Password</label>
                    </div>
                    <button type="submit" name="submit" value="submit" class="btn btn-primary rounded-pill btn-login w-100">
                      Masuk&nbsp;<i class="fa fa-arrow-right"></i>
                    </button>
                  </form>
                </div>
              </div>

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