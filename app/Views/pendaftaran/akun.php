<style>
.google-btn {
    border: 1px solid #dadce0 !important;
    color: #3c4043 !important;
    background-color: #fff !important;
    transition: all 0.2s ease !important;
}
.google-btn:hover {
    background-color: #f8f9fa !important;
    border-color: #c4c6ca !important;
    color: #1a0dab !important;
    text-decoration: none !important;
    box-shadow: 0 1px 3px rgba(60,64,67, 0.2) !important;
}
</style>

<!-- Section Header -->
<section class="wrapper bg-light">
  <div class="container pb-14 pb-md-16">
    <div class="row">
      <div class="col-lg-8 col-xl-8 col-xxl-8 mx-auto mt-n20">
        <div class="card shadow-lg border-0 rounded-lg">
          <div class="card-body p-6 p-md-8">
            
            <!-- Step Progress Bar (Roadmap) -->
            <div class="row mb-6 mt-2 text-center">
              <div class="col-12">
                <div class="d-flex justify-content-between align-items-center position-relative mx-auto" style="max-width: 600px;">
                  <!-- Progress line background -->
                  <div class="position-absolute start-0 end-0 top-50 translate-middle-y" style="height: 4px; background-color: #e9ecef; z-index: 1;">
                    <div style="height: 100%; width: 25%; background-color: #3f78e0;"></div>
                  </div>
                  <!-- Step 1 -->
                  <div class="text-center position-relative" style="z-index: 2;">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 40px; height: 40px; font-weight: bold; border: 3px solid #fff;">1</div>
                    <span class="text-primary font-weight-bold" style="font-size: 13px;">Buat Akun</span>
                  </div>
                  <!-- Step 2 -->
                  <div class="text-center position-relative" style="z-index: 2;">
                    <div class="rounded-circle bg-white text-secondary border d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; font-weight: bold; border-color: #dee2e6 !important;">2</div>
                    <span class="text-muted" style="font-size: 13px;">Pilih Gelombang</span>
                  </div>
                  <!-- Step 3 -->
                  <div class="text-center position-relative" style="z-index: 2;">
                    <div class="rounded-circle bg-white text-secondary border d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; font-weight: bold; border-color: #dee2e6 !important;">3</div>
                    <span class="text-muted" style="font-size: 13px;">Isi Biodata</span>
                  </div>
                  <!-- Step 4 -->
                  <div class="text-center position-relative" style="z-index: 2;">
                    <div class="rounded-circle bg-white text-secondary border d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px; font-weight: bold; border-color: #dee2e6 !important;">4</div>
                    <span class="text-muted" style="font-size: 13px;">Unggah Berkas</span>
                  </div>
                </div>
              </div>
            </div>

            <hr class="mb-5">

            <h2 class="mb-2 text-start fw-bold">Membuat akun pendaftaran di <?php echo $this->website->namaweb() ?></h2>
            <p class="lead mb-5 text-start text-secondary">Masukkan data Anda dengan benar dan lengkap untuk memulai proses pendaftaran.</p>

            <?php 
            $validation = \Config\Services::validation();
            $errors = $validation->getErrors();
            if(!empty($errors)) {
                echo '<div class="alert alert-danger">'.$validation->listErrors().'</div>';
            }
            if (session('msg')) : 
            ?>
                 <div class="alert alert-info alert-dismissible">
                     <?= session('msg') ?>
                     <button type="button" class="close btn-close" data-dismiss="alert" aria-label="Close"></button>
                 </div>
            <?php endif ?>

            <!-- Google SSO Button (Prioritized at the top) -->
            <?php if(!empty($konfigurasi->google_client_id)) { ?>
            <div class="mb-4 text-center">
                <a href="<?php echo base_url('googleauth/login/siswa') ?>" class="btn btn-light w-100 rounded-pill py-2 font-weight-bold shadow-sm d-flex align-items-center justify-content-center google-btn" style="border: 1px solid #dadce0; color: #3c4043; background-color: #fff; transition: all 0.2s ease;">
                    <img src="https://www.gstatic.com/images/branding/product/1x/googleg_48dp.png" alt="Google" style="width: 20px; height: 20px; margin-right: 10px;"> Daftar Instan dengan Akun Google
                </a>
                <div class="d-flex align-items-center my-4">
                  <div class="flex-grow-1 bg-secondary-subtle" style="height: 1px;"></div>
                  <span class="mx-3 text-secondary" style="font-size: 13px; font-weight: 500;">atau gunakan email manual</span>
                  <div class="flex-grow-1 bg-secondary-subtle" style="height: 1px;"></div>
                </div>
            </div>
            <?php } ?>

            <?php echo form_open(base_url('pendaftaran/akun'), ['id' => 'formRegister']) ?>
              
              <div class="form-floating mb-4">
                <input type="text" class="form-control" name="nama" value="<?php echo set_value('nama') ?>" placeholder="Name" id="loginName" required>
                <label for="loginName" class="text-primary">Nama Lengkap <span class="text-danger">*</span></label>
              </div>

              <div class="form-floating mb-4 position-relative">
                <input type="email" class="form-control" name="email" value="<?php echo set_value('email') ?>" placeholder="Email" id="loginEmail" required>
                <label for="loginEmail" class="text-primary">Email (Username) <span class="text-danger">*</span></label>
                <div id="emailFeedback" class="mt-1" style="font-size: 12px; display: none;"></div>
              </div>

              <div class="form-floating password-field mb-4">
                <input type="password" class="form-control" name="password" placeholder="Password" id="loginPassword" minlength="6" maxlength="32" required>
                <span class="password-toggle"><i class="uil uil-eye"></i></span>
                <label for="loginPassword" class="text-primary">Password <span class="text-danger">*</span> (min 6 & max 32 kar.)</label>
              </div>

              <div class="form-floating password-field mb-4">
                <input type="password" class="form-control" name="konfirmasi_password" placeholder="Konfirmasi Password" id="loginPasswordConfirm" minlength="6" maxlength="32" required>
                <span class="password-toggle"><i class="uil uil-eye"></i></span>
                <label for="loginPasswordConfirm" class="text-primary">Konfirmasi Password <span class="text-danger">*</span></label>
              </div>

              <div class="form-floating mb-4">
                <input type="text" class="form-control" name="telepon" value="<?php echo set_value('telepon') ?>" placeholder="Telepon/HP" id="Telepon" required>
                <label for="Telepon" class="text-primary">Telepon/HP <span class="text-danger">*</span></label>
              </div>

              <p class="mt-4">
                <button type="reset" name="reset" value="reset" class="btn btn-warning rounded-pill btn-login w-40 mb-2">Reset &nbsp; <i class="fa fa-times-circle"></i></button>
                <button type="submit" id="btnSubmit" name="submit" value="submit" class="btn btn-primary rounded-pill btn-login w-60 mb-2">Buat Akun dan Lanjutkan &nbsp; <i class="fa fa-arrow-circle-right"></i></button>
              </p>
            </form>
            <!-- /form -->

            <p class="mb-0 mt-3">Sudah punya Akun? <a href="<?php echo base_url('signin') ?>" class="hover">Login di sini</a>. <br>Atau <a href="<?php echo base_url() ?>">Kembali ke Beranda</a></p>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Real-time Email Duplication Check Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    var emailInput = document.getElementById('loginEmail');
    var feedbackDiv = document.getElementById('emailFeedback');
    var btnSubmit = document.getElementById('btnSubmit');

    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            var emailValue = emailInput.value.trim();
            if (emailValue === '') {
                feedbackDiv.style.display = 'none';
                return;
            }

            // Simple client-side regex check
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailValue)) {
                feedbackDiv.className = 'text-danger mt-1';
                feedbackDiv.innerHTML = '<i class="fa fa-exclamation-circle"></i> Format email tidak valid';
                feedbackDiv.style.display = 'block';
                return;
            }

            feedbackDiv.className = 'text-secondary mt-1';
            feedbackDiv.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Memeriksa ketersediaan email...';
            feedbackDiv.style.display = 'block';

            // AJAX call to check email
            var formData = new FormData();
            formData.append('email', emailValue);

            fetch('<?php echo base_url("pendaftaran/cek_email") ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'taken') {
                    feedbackDiv.className = 'text-danger mt-1';
                    feedbackDiv.innerHTML = '<i class="fa fa-times-circle"></i> Email sudah terdaftar. Silakan gunakan email lain atau login.';
                    btnSubmit.disabled = true;
                } else {
                    feedbackDiv.className = 'text-success mt-1';
                    feedbackDiv.innerHTML = '<i class="fa fa-check-circle"></i> Email tersedia';
                    btnSubmit.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error checking email:', error);
                feedbackDiv.style.display = 'none';
            });
        });
    }
});
</script>
