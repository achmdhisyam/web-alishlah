import re

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

    # Find the start of PENDIDIKAN SEBELUMNYA
    start_idx = content.find("<!-- data dasar siswa -->\n        <div class=\"card mb-2\">\n          <div class=\"card-header bg-dark text-white mb-2\">\n            PENDIDIKAN SEBELUMNYA")
    if start_idx == -1:
        # maybe different whitespace?
        match = re.search(r"<!-- data dasar siswa -->\s*<div class=\"card mb-2\">\s*<div class=\"card-header bg-dark text-white mb-2\">\s*PENDIDIKAN SEBELUMNYA", content)
        if match:
            start_idx = match.start()
            
    # Find the start of DATA ORANG TUA SISWA - AYAH
    end_idx = content.find("<!-- data ayah -->")
    
    if start_idx != -1 and end_idx != -1:
        replacement = f"""<!-- data dasar siswa -->
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
        content = content[:start_idx] + replacement + content[end_idx:]
        
        with open(file_path, "w", encoding="utf-8") as f:
            f.write(content)
        print(f"Fixed {file_path}")
    else:
        print(f"Could not find indices in {file_path}")
