


<?php echo form_open(base_url('admin/konfigurasi/email')) ?>
<input type="hidden" name="id_konfigurasi" value="<?php echo $site->id_konfigurasi ?>">
<div class="form-group row">
    <label class="col-md-3">Protocol</label>
    <div class="col-md-9">
        <input type="text" name="protocol" placeholder="Protocol" value="<?php echo $site->protocol ?>" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3">Host</label>
    <div class="col-md-9">
        <input type="text" name="smtp_host" placeholder="Host" value="<?php echo $site->smtp_host ?>" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3">Port</label>
    <div class="col-md-9">
        <input type="text" name="smtp_port" placeholder="Port" value="<?php echo $site->smtp_port ?>" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3">TimeOut</label>
    <div class="col-md-9">
        <input type="text" name="smtp_timeout" placeholder="TimeOut" value="<?php echo $site->smtp_timeout ?>" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3">User</label>
    <div class="col-md-9">
        <input type="text" name="smtp_user" placeholder="User" value="<?php echo $site->smtp_user ?>" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3">Password</label>
    <div class="col-md-9">
        <input type="password" name="smtp_pass" placeholder="Password" value="<?php echo $site->smtp_pass ?>" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3">SMTP Crypto</label>
    <div class="col-md-9">
        <select name="smtp_crypto" class="form-control">
            <option value="">None</option>
            <option value="ssl" <?php if($site->smtp_crypto=='ssl') { echo 'selected'; } ?>>SSL (Port 465)</option>
            <option value="tls" <?php if($site->smtp_crypto=='tls') { echo 'selected'; } ?>>TLS (Port 587)</option>
        </select>
        <small class="text-secondary">Gunakan <strong>SSL</strong> untuk port 465 dan <strong>TLS</strong> untuk port 587.</small>
    </div>
</div>

<hr>
<div class="form-group row">
    <label class="col-md-3"></label>
    <div class="col-md-9">
        <button type="submit" class="btn btn-success" name="submit" value="Save Configuration">
			<i class="fa fa-save"></i> Simpan Konfigurasi Email
		</button>
        <button type="submit" class="btn btn-primary" name="submit" value="Reset">
			<i class="fa fa-sync-alt"></i> Reset
		</button>
    </div>
</div>



</form>

