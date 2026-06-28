<div class="row">
	<div class="col-md-5 mb-4 mb-md-0">
		<div class="card">
			<div class="card-header bg-light">
				<strong>DETAIL AKUN</strong>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-sm table-bordered">
					<thead>
						<tr>
							<th>Nama</th>
							<th><?php echo $akun->nama ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Email</td>
							<td><?php echo $akun->email ?></td>
						</tr>
						<tr>
							<td>Username</td>
							<td><?php echo $akun->username ?></td>
						</tr>
						<tr>
							<td>Status</td>
							<td><?php echo $akun->status_akun ?></td>
						</tr>
						<tr>
							<td>Jenis</td>
							<td><?php echo $akun->jenis_akun ?></td>
						</tr>
						<tr>
							<td>Telepon</td>
							<td><?php echo $akun->telepon ?></td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td><?php echo $akun->alamat ?></td>
						</tr>
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-7">
		<div class="card">
			<div class="card-header bg-light">
				<strong>UPDATE AKUN</strong>
			</div>
			<div class="card-body">
				<?php echo form_open(base_url('siswa/akun')) ?>
                <div class="form-group mb-4">
                  <input type="text" class="form-control" name="nama" value="<?php echo $akun->nama ?>"  placeholder="Name" id="loginName">
                  <label for="loginName" class="text-primary">Nama</label>
                </div>

                <div class="form-group mb-4">
                  <input type="email" class="form-control" name="email" value="<?php echo $akun->email ?>"  placeholder="Email" id="loginEmail">
                  <label for="loginEmail" class="text-primary">Email (Username)</label>
                </div>

                
                  <div class="form-group password-field mb-4">
                    <input type="password" class="form-control" name="password" placeholder="Password" id="loginPassword" minlength="6" maxlength="32">
                    <span class="password-toggle"><i class="uil uil-eye"></i></span>
                    <label for="loginPassword" class="text-primary">Password minimal 6 dan maksimal 32 karakter</label>
                  </div>

                  <div class="form-group password-field mb-4">
                    <input type="password" class="form-control" name="konfirmasi_password" placeholder="Konfirmasi Password" id="loginPasswordConfirm" minlength="6" maxlength="32">
                    <span class="password-toggle"><i class="uil uil-eye"></i></span>
                    <label for="loginPasswordConfirm" class="text-primary">Konfirmasi Password</label>
                  </div>

                
                <div class="form-group mb-4">
                  <input type="text" class="form-control" name="telepon"  value="<?php echo $akun->telepon ?>" placeholder="Telepon/HP" id="Telepon">
                  <label for="loginEmail" class="text-primary">Telepon/HP</label>
                </div>

                <div class="form-group mb-4">
                  <textarea name="alamat" class="form-control" placeholder="Alamat" required="required"><?php echo $akun->alamat ?></textarea>
                  <label for="loginEmail" class="text-primary">Alamat lengkap</label>
                </div>

                <div class="form-row row">
                  <div class="col-sm-4 mb-2">
                    <button type="reset" name="reset" value="reset" class="btn btn-warning rounded-pill btn-login w-100">Reset &nbsp; <i class="fa fa-times-circle"></i></button>
                  </div>
                  <div class="col-sm-8 mb-2">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary rounded-pill btn-login w-100">Update Akun &nbsp; <i class="fa fa-save"></i></button>
                  </div>
                </div>
              </form>
			</div>
		</div>
	</div>
</div>