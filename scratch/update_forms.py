import re
import os

files = [
    r"c:\xampp2\htdocs\websitesekolah-main\app\Views\siswa\pendaftaran\biodata.php",
    r"c:\xampp2\htdocs\websitesekolah-main\app\Views\siswa\pendaftaran\edit.php"
]

for file_path in files:
    with open(file_path, "r", encoding="utf-8") as f:
        content = f.read()

    is_edit = "edit.php" in file_path
    
    def val(field):
        if is_edit:
            return f"<?php if(isset($_POST['submit'])) {{ echo set_value('{field}'); }}else{{ echo $siswa->{field}; }} ?>"
        else:
            return f"<?php echo set_value('{field}') ?>"
            
    def sel(field, value):
        if is_edit:
            return f"<?php if(set_value('{field}')=='{value}' || $siswa->{field} == '{value}') {{ echo 'selected'; }} ?>"
        else:
            return f"<?php if(set_value('{field}')=='{value}') {{ echo 'selected'; }} ?>"
            
    def checked(field, value):
        if is_edit:
            return f"<?php if(set_value('{field}')=='{value}' || $siswa->{field} == '{value}') {{ echo 'checked'; }} ?>"
        else:
            return f"<?php if(set_value('{field}')=='{value}') {{ echo 'checked'; }} ?>"

    # 1. Remove DATA KESEHATAN DAN INFORMASI SISWA LAINNYA block entirely.
    pattern_kesehatan = r"<!-- data dasar siswa -->\s*<div class=\"card mb-2\">\s*<div class=\"card-header bg-dark text-white mb-2\">\s*DATA KESEHATAN AND INFORMASI SISWA LAINNYA.*?</div>\s*</div>"
    # Actually the header is "DATA KESEHATAN DAN INFORMASI SISWA LAINNYA"
    pattern_kesehatan = re.compile(r"<!-- data dasar siswa -->\s*<div class=\"card mb-2\">\s*<div class=\"card-header bg-dark text-white mb-2\">\s*DATA KESEHATAN DAN INFORMASI SISWA LAINNYA.*?</div>\s*</div>", re.DOTALL)
    content = pattern_kesehatan.sub("", content)

    # 2. Modify "DATA PENERIMAAN DI SEKOLAH" to just "PENDIDIKAN SEBELUMNYA"
    # Replace Jenis Masuk Siswa, Alamat Sekolah Asal, Tanggal Pindah
    pattern_penerimaan = re.compile(r"<!-- data dasar siswa -->\s*<div class=\"card mb-2\">\s*<div class=\"card-header bg-dark text-white mb-2\">\s*DATA PENERIMAAN DI SEKOLAH\s*</div>\s*<div class=\"card-body\">.*?</div>\s*</div>", re.DOTALL)
    
    penerimaan_replacement = f"""
        <!-- data dasar siswa -->
        <div class="card mb-2">
          <div class="card-header bg-dark text-white mb-2">
            PENDIDIKAN SEBELUMNYA
          </div>
          <div class="card-body">
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tamatan Dari</label>
              <div class="col-md-9">
                <input type="text" name="asal_sekolah" class="form-control" placeholder="Nama Sekolah Asal (Tamatan Dari)" value="{val('asal_sekolah')}">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Ukuran Seragam</label>
              <div class="col-md-9">
                <select name="ukuran_seragam" class="form-control form-select">
                    <option value="">Pilih Ukuran Seragam</option>
                    <option value="M" {sel('ukuran_seragam', 'M')}>M</option>
                    <option value="L" {sel('ukuran_seragam', 'L')}>L</option>
                    <option value="XL" {sel('ukuran_seragam', 'XL')}>XL</option>
                    <option value="Lainnya" {sel('ukuran_seragam', 'Lainnya')}>Lainnya</option>
                </select>
              </div>
            </div>
          </div>
        </div>
    """
    content = pattern_penerimaan.sub(penerimaan_replacement, content)

    # 3. Add fields for Ayah
    pattern_ayah = re.compile(r"(DATA ORANG TUA SISWA - AYAH\s*</div>\s*<div class=\"card-body\">)", re.DOTALL)
    ayah_fields = f"""\\1
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tempat & Tanggal Lahir Ayah</label>
              <div class="col-md-5">
                <input type="text" name="tempat_lahir_ayah" class="form-control" placeholder="Tempat lahir ayah" value="{val('tempat_lahir_ayah')}">
              </div>
              <div class="col-md-4">
                <input type="text" name="tanggal_lahir_ayah" class="form-control tanggal" placeholder="dd-mm-yyyy" value="{val('tanggal_lahir_ayah')}">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kewarganegaraan Ayah</label>
              <div class="col-md-9">
                <select name="status_wn_ayah" class="form-control form-select">
                  <option value="WNI" {sel('status_wn_ayah', 'WNI')}>WNI</option>
                  <option value="WNA" {sel('status_wn_ayah', 'WNA')}>WNA</option>
                </select>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Penghasilan per Bulan Ayah</label>
              <div class="col-md-9">
                <input type="text" name="penghasilan_ayah" class="form-control" placeholder="Rp." value="{val('penghasilan_ayah')}">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Status Ayah</label>
              <div class="col-md-9">
                <select name="status_hidup_ayah" class="form-control form-select">
                  <option value="Hidup" {sel('status_hidup_ayah', 'Hidup')}>Masih Hidup</option>
                  <option value="Meninggal" {sel('status_hidup_ayah', 'Meninggal')}>Sudah Meninggal</option>
                </select>
              </div>
            </div>
    """
    content = pattern_ayah.sub(ayah_fields, content)

    # 4. Add fields for Ibu
    pattern_ibu = re.compile(r"(DATA ORANG TUA SISWA - IBU\s*</div>\s*<div class=\"card-body\">)", re.DOTALL)
    ibu_fields = f"""\\1
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tempat & Tanggal Lahir Ibu</label>
              <div class="col-md-5">
                <input type="text" name="tempat_lahir_ibu" class="form-control" placeholder="Tempat lahir ibu" value="{val('tempat_lahir_ibu')}">
              </div>
              <div class="col-md-4">
                <input type="text" name="tanggal_lahir_ibu" class="form-control tanggal" placeholder="dd-mm-yyyy" value="{val('tanggal_lahir_ibu')}">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kewarganegaraan Ibu</label>
              <div class="col-md-9">
                <select name="status_wn_ibu" class="form-control form-select">
                  <option value="WNI" {sel('status_wn_ibu', 'WNI')}>WNI</option>
                  <option value="WNA" {sel('status_wn_ibu', 'WNA')}>WNA</option>
                </select>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Penghasilan per Bulan Ibu</label>
              <div class="col-md-9">
                <input type="text" name="penghasilan_ibu" class="form-control" placeholder="Rp." value="{val('penghasilan_ibu')}">
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Status Ibu</label>
              <div class="col-md-9">
                <select name="status_hidup_ibu" class="form-control form-select">
                  <option value="Hidup" {sel('status_hidup_ibu', 'Hidup')}>Masih Hidup</option>
                  <option value="Meninggal" {sel('status_hidup_ibu', 'Meninggal')}>Sudah Meninggal</option>
                </select>
              </div>
            </div>
    """
    content = pattern_ibu.sub(ibu_fields, content)

    # 5. Add fields for Wali
    pattern_wali = re.compile(r"(<div id=\"myDIV\">\s*<div class=\"form-group row mb-3\">\s*<label class=\"col-md-3 text-dark\">Nama Wali<span class=\"text-danger\">\*</span></label>.*?</div>\s*</div>)", re.DOTALL)
    wali_fields = f"""\\1
              <div class="form-group row mb-3">
                <label class="col-md-3 text-dark">Tempat & Tanggal Lahir Wali</label>
                <div class="col-md-5">
                  <input type="text" name="tempat_lahir_wali" class="form-control" placeholder="Tempat lahir wali" value="{val('tempat_lahir_wali')}">
                </div>
                <div class="col-md-4">
                  <input type="text" name="tanggal_lahir_wali" class="form-control tanggal" placeholder="dd-mm-yyyy" value="{val('tanggal_lahir_wali')}">
                </div>
              </div>
              <div class="form-group row mb-3">
                <label class="col-md-3 text-dark">Penghasilan per Bulan Wali</label>
                <div class="col-md-9">
                  <input type="text" name="penghasilan_wali" class="form-control" placeholder="Rp." value="{val('penghasilan_wali')}">
                </div>
              </div>
    """
    content = pattern_wali.sub(wali_fields, content)

    # Write back
    with open(file_path, "w", encoding="utf-8") as f:
        f.write(content)
        
    print(f"Updated {file_path}")
