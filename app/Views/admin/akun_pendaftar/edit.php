<h3>Edit Akun Pendaftar</h3>
<form action="<?= base_url('admin/akun_pendaftar/update/'.$akun->id_akun) ?>" method="post">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= $akun->nama ?>" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= $akun->email ?>" required>
    </div>
    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" class="form-control" value="<?= $akun->username ?>" required>
    </div>
    <div class="form-group">
        <label>Password (kosongkan jika tidak diganti)</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="form-group">
        <label>Jenis Akun</label>
        <select name="jenis_akun" class="form-control">
            <option <?= $akun->jenis_akun=='Pendaftar'?'selected':'' ?> value="Pendaftar">Pendaftar</option>
            <option <?= $akun->jenis_akun=='Admin'?'selected':'' ?> value="Admin">Admin</option>
        </select>
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status_akun" class="form-control">
            <option <?= $akun->status_akun=='Aktif'?'selected':'' ?> value="Aktif">Aktif</option>
            <option <?= $akun->status_akun=='Menunggu'?'selected':'' ?> value="Menunggu">Menunggu</option>
            <option <?= $akun->status_akun=='Non-Aktif'?'selected':'' ?> value="Non-Aktif">Non-Aktif</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
</form>
