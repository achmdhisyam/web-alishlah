<form action="<?php echo base_url('admin/konfigurasi/chatbot') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<?php 
echo csrf_field(); 
?>

<input type="hidden" name="id_konfigurasi" value="<?php echo $konfigurasi->id_konfigurasi ?>">
<div class="form-group row">
    <label class="col-3">Ganti Ikon Chatbot Baru</label>
    <div class="col-6">
        <input type="file" name="icon_chatbot" class="form-control">
        <small class="text-secondary">Format: JPG, PNG, GIF</small>
    </div>
    <div class="col-3">
        <?php if(!empty($konfigurasi->icon_chatbot)) { ?>
            <img src="<?php echo base_url('assets/upload/image/'.$konfigurasi->icon_chatbot) ?>" class="img img-thumbnail" style="max-height: 100px;">
        <?php } else { ?>
            <i class="fas fa-robot fa-3x text-info"></i>
        <?php } ?>
    </div>
</div>

<div class="form-group row">
    <label class="col-3"></label>
    <div class="col-9">
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Ikon Chatbot</button>
    </div>
</div>

</form>