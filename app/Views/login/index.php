
								<?php 
								$validation = \Config\Services::validation();
								$errors = $validation->getErrors();
								if(!empty($errors))
								{
									echo '<span class="text-danger">'.$validation->listErrors().'</span>';
								}
								?>

								<?php if (session('msg')) : ?>
									<div class="alert alert-info alert-dismissible">
										<?= session('msg') ?>
										<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
									</div>
								<?php endif ?>

								<?php echo form_open(base_url('login'), 'class="signin-form"'); ?>

								<input type="hidden" name="pengalihan" value="<?php echo Session()->get('pengalihan'); ?>">

								<div class="form-group mb-3">
									<label class="label" for="name">Username</label>
									<input type="text" name="username" class="form-control" placeholder="Username" required>
								</div>
								<div class="form-group mb-3">
									<label class="label" for="password">Password</label>
									<input type="password" name="password" class="form-control" placeholder="Password" required>
								</div>
								<div class="form-group mb-3 d-flex align-items-center">
									<label class="d-flex align-items-center" style="cursor: pointer; font-size: 14.5px; color: #495057; user-select: none; font-weight: 500; margin-bottom: 0;">
										<input type="checkbox" name="remember" value="1" style="width: 18px; height: 18px; accent-color: #f35588; cursor: pointer; margin-right: 8px;">
										Ingat Saya (Remember Me)
									</label>
								</div>
								<div class="form-group">
									<button type="submit" class="form-control btn btn-primary submit px-3">Login</button>
								</div>
								
								<?php if(!empty($site->google_client_id)) { ?>
								<div class="form-group mt-3">
									<a href="<?php echo base_url('googleauth/login/admin') ?>" class="btn-google">
										<img src="https://www.gstatic.com/images/branding/product/1x/googleg_48dp.png" alt="Google"> Login with Google
									</a>
								</div>
								<?php } ?>

								<p class="text-center mt-4">
									Kembali ke <a href="<?php echo base_url() ?>">Beranda</a> | Lupa Password? <a href="<?php echo base_url('login/lupa') ?>">Reset</a>
								</p>
							
							<?php echo form_close(); ?>


