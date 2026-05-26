<!-- /section -->
<section class="wrapper bg-light">
  <div class="container pb-14 pb-md-16">
    <div class="row">
      <div class="col mt-n20">
        <div class="card shadow-lg">
          <div class="row gx-0 text-center">

            <!-- Gambar di sebelah kiri -->
            <?php if($this->website->login()!='') { ?>
              <div class="col-lg-6 image-wrapper bg-image bg-cover rounded-top rounded-lg-start d-none d-md-block" data-image-src="<?php echo $this->website->login() ?>">
            <?php }else{ ?>
              <div class="col-lg-6 image-wrapper bg-image bg-cover rounded-top rounded-lg-start d-none d-md-block" data-image-src="<?php echo base_url() ?>assets/template/assets/img/photos/tm3.jpg">
            <?php } ?>
            </div>

            <!-- Form ganti password di sebelah kanan -->
            <div class="col-lg-6">
              <div class="p-3 p-md-7 p-lg-8 text-center">

                <h3 class="mb-4">Ganti Password</h3>

                <!-- Tempat alert muncul -->
                <div id="alert-placeholder">
                  <?php if (session()->getFlashdata('warning')) { ?>
                    <div class="alert alert-warning">
                        <?= session()->getFlashdata('warning'); ?>
                    </div>
                  <?php } ?>

                  <?php if (session()->getFlashdata('sukses')) { ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('sukses'); ?>
                    </div>
                  <?php } ?>
                </div>

                <form id="formPassword" action="<?= base_url('signin/password/' . $token); ?>" method="post">
                  <?= csrf_field(); ?>

                  <div class="form-floating mb-4">
                  <input type="password" class="form-control" name="password" placeholder="Password baru" id="Password" minlength="6" maxlength="32" required>
                  <span class="password-toggle"><i class="uil uil-eye"></i></span>
                  <label for="loginPassword">Password baru</label>
                </div>

                  <div class="form-floating mb-4">
                    <input type="password" name="password2" id="password2" class="form-control" placeholder="Konfirmasi Password" minlength="6" maxlength="32" required>
                    <span class="password-toggle"><i class="uil uil-eye"></i></span>
                    <label for="password2">Konfirmasi Password</label>
                  </div>

                  <button type="submit" class="btn btn-primary rounded-pill w-100 mb-2">
                    Ubah Password&nbsp;<i class="fa fa-arrow-right"></i>
                  </button>
                </form>

                <p class="mb-1">Kembali ke <a href="<?php echo base_url() ?>">Beranda</a> | <a href="<?php echo base_url('signin') ?>" class="hover">Login?</a></p>
                <p class="mb-0">Belum punya akun? <a href="<?php echo base_url('pendaftaran/akun') ?>">Buat akun sekarang!</a></p>

              </div>
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

<script>
document.getElementById('formPassword').addEventListener('submit', function(e) {
    var pwd = document.getElementById('password').value;
    var pwd2 = document.getElementById('password2').value;

    if(pwd !== pwd2) {
        e.preventDefault(); // cegah form submit

        // Buat alert warning seperti bootstrap
        var alertPlaceholder = document.getElementById('alert-placeholder');
        alertPlaceholder.innerHTML = '<div class="alert alert-warning">Password dan Konfirmasi Password tidak sama!</div>';
        
       
    }
});

document.querySelectorAll('.password-toggle').forEach(toggle => {
  toggle.addEventListener('click', function() {
    const input = this.previousElementSibling; // input sebelum span
    if (input.type === 'password') {
      input.type = 'text';
      this.innerHTML = '<i class="uil uil-eye-slash"></i>'; // ganti icon
    } else {
      input.type = 'password';
      this.innerHTML = '<i class="uil uil-eye"></i>'; // kembalikan icon
    }
  });
});

</script>
