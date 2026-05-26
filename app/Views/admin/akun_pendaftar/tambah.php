<h3>Tambah Akun Pendaftar</h3>
<form action="<?= base_url('admin/akun_pendaftar/store') ?>" method="post">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Jenis Akun</label>
        <select name="jenis_akun" class="form-control">
            <option value="Pendaftar">Pendaftar</option>
        </select>
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status_akun" class="form-control">
            <option value="Aktif">Aktif</option>
            <option value="Menunggu">Menunggu</option>
            <option value="Non-Aktif">Non-Aktif</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
</form>
