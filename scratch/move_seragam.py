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

    # 1. Remove from PENDIDIKAN SEBELUMNYA
    pattern_remove_seragam = re.compile(r"<div class=\"form-group row mb-3\">\s*<label class=\"col-md-3 text-dark\">Ukuran Seragam</label>.*?</div>\s*</div>", re.DOTALL)
    content = pattern_remove_seragam.sub("", content)

    # 2. Add to DATA DASAR SISWA (put it before "Gambar/Foto")
    pattern_add_seragam = re.compile(r"(<div class=\"form-group row mb-3\">\s*<label class=\"col-md-3 text-dark\">Gambar/Foto</label>)", re.DOTALL)
    
    js_toggle = """<script>
                  function checkSeragam(val) {
                      if(val == 'Lainnya') {
                          document.getElementById('ukuran_seragam_lainnya').style.display = 'block';
                      } else {
                          document.getElementById('ukuran_seragam_lainnya').style.display = 'none';
                      }
                  }
                  </script>"""
    
    # We will just write the JS once at the bottom, or inline.
    
    if is_edit:
        select_logic = """
                    <option value="">Pilih Ukuran Seragam</option>
                    <option value="M" <?php if(set_value('ukuran_seragam')=='M' || $siswa->ukuran_seragam == 'M') { echo 'selected'; } ?>>M</option>
                    <option value="L" <?php if(set_value('ukuran_seragam')=='L' || $siswa->ukuran_seragam == 'L') { echo 'selected'; } ?>>L</option>
                    <option value="XL" <?php if(set_value('ukuran_seragam')=='XL' || $siswa->ukuran_seragam == 'XL') { echo 'selected'; } ?>>XL</option>
                    <option value="Lainnya" <?php if(set_value('ukuran_seragam')=='Lainnya' || (!in_array($siswa->ukuran_seragam, ['M','L','XL','']) && $siswa->ukuran_seragam != null)) { echo 'selected'; } ?>>Lainnya</option>
        """
        input_logic = f"""
                <input type="text" name="ukuran_seragam_lainnya" id="ukuran_seragam_lainnya" class="form-control mt-2" placeholder="Ketik ukuran manual..." value="<?php echo (!in_array($siswa->ukuran_seragam, ['M','L','XL',''])) ? $siswa->ukuran_seragam : ''; ?>" style="display: <?php echo (!in_array($siswa->ukuran_seragam, ['M','L','XL','']) && $siswa->ukuran_seragam != null) ? 'block' : 'none'; ?>;">
        """
    else:
        select_logic = """
                    <option value="">Pilih Ukuran Seragam</option>
                    <option value="M" <?php if(set_value('ukuran_seragam')=='M') { echo 'selected'; } ?>>M</option>
                    <option value="L" <?php if(set_value('ukuran_seragam')=='L') { echo 'selected'; } ?>>L</option>
                    <option value="XL" <?php if(set_value('ukuran_seragam')=='XL') { echo 'selected'; } ?>>XL</option>
                    <option value="Lainnya" <?php if(set_value('ukuran_seragam')=='Lainnya') { echo 'selected'; } ?>>Lainnya</option>
        """
        input_logic = """
                <input type="text" name="ukuran_seragam_lainnya" id="ukuran_seragam_lainnya" class="form-control mt-2" placeholder="Ketik ukuran manual..." style="display: none;">
        """

    seragam_block = f"""<div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Ukuran Seragam</label>
              <div class="col-md-9">
                <select name="ukuran_seragam" class="form-control form-select" onchange="checkSeragam(this.value)">
                    {select_logic}
                </select>
                {input_logic}
              </div>
            </div>

            \\1"""
            
    content = pattern_add_seragam.sub(seragam_block, content, count=1)
    
    if "function checkSeragam" not in content:
        content += "\n<script>\nfunction checkSeragam(val) {\n  if(val == 'Lainnya') {\n    document.getElementById('ukuran_seragam_lainnya').style.display = 'block';\n  } else {\n    document.getElementById('ukuran_seragam_lainnya').style.display = 'none';\n  }\n}\n</script>\n"

    with open(file_path, "w", encoding="utf-8") as f:
        f.write(content)
        
    print(f"Updated {file_path}")
