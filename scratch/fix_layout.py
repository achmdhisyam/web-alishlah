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

    def render_parent_block(title, prefix, role):
        # role is 'ayah', 'ibu', 'wali'
        # if role is wali, we don't have 'status_hidup'
        # if role is wali, we need myDIV wrapper
        
        req = 'required' if role != 'wali' else ''
        req_star = '<span class="text-danger">*</span>' if role != 'wali' else ''
        
        html = f"""
          <div class="card-header bg-dark text-white mb-2">
            {title}
          </div>
          <div class="card-body">"""

        if role == 'wali':
            html += f"""
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Identitas Wali Murid<span class="text-danger">*</span></label>
              <div class="col-md-9">
                <div class="form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="identitas_wali" value="Ayah" onclick="Ayah()" <?php if(set_value('identitas_wali')=='Ayah' { '|| $siswa->identitas_wali=="Ayah"' if is_edit else '' }) {{ echo 'checked'; }} ?> required>
                    <label class="form-check-label">Sama dengan Ayah</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="identitas_wali" value="Ibu" onclick="Ibu()" <?php if(set_value('identitas_wali')=='Ibu' { '|| $siswa->identitas_wali=="Ibu"' if is_edit else '' }) {{ echo 'checked'; }} ?> required>
                    <label class="form-check-label">Sama dengan Ibu</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="identitas_wali" value="Berbeda" onclick="Berbeda()" <?php if(set_value('identitas_wali')=='Berbeda' { '|| $siswa->identitas_wali=="Berbeda"' if is_edit else '' }) {{ echo 'checked'; }} ?> required>
                    <label class="form-check-label">Berbeda dengan Ayah dan Ibu</label>
                  </div>
                </div>
              </div>
            </div>
            <div id="myDIV">"""
        
        html += f"""
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Nama {prefix}{req_star}</label>
              <div class="col-md-9">
                <input type="text" name="nama_{role}" class="form-control" placeholder="Nama {prefix}" value="{val('nama_'+role)}" {req}>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Agama {prefix}</label>
              <div class="col-md-9">
                <?php $agama = $m_agama->listing(); ?>
                <select name="id_agama_{role}" class="form-control form-select">
                  <option value="">Pilih Agama</option>
                  <?php foreach($agama as $ag) {{ ?>
                    <option value="<?php echo $ag->id_agama ?>" <?php if(set_value('id_agama_{role}')==$ag->id_agama { f'|| $siswa->id_agama_{role} == $ag->id_agama' if is_edit else '' }) {{ echo 'selected'; }} ?>>
                      <?php echo $ag->nama_agama ?>
                    </option>
                  <?php }} ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Tempat & Tanggal Lahir {prefix}</label>
              <div class="col-md-5">
                <input type="text" name="tempat_lahir_{role}" class="form-control" placeholder="Tempat lahir {role}" value="{val('tempat_lahir_'+role)}">
              </div>
              <div class="col-md-4">
                <input type="text" name="tanggal_lahir_{role}" class="form-control tanggal" placeholder="dd-mm-yyyy" value="{val('tanggal_lahir_'+role)}">
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Kewarganegaraan {prefix}</label>
              <div class="col-md-9">
                <select name="status_wn_{role}" class="form-control form-select">
                  <option value="WNI" {sel('status_wn_'+role, 'WNI')}>WNI</option>
                  <option value="WNA" {sel('status_wn_'+role, 'WNA')}>WNA</option>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Pendidikan {prefix}</label>
              <div class="col-md-9">
                <?php $jenjang = $m_jenjang->listing(); ?>
                <select name="id_jenjang_{role}" class="form-control form-select">
                  <option value="">Pilih Program Pendidikan</option>
                  <?php foreach($jenjang as $jg) {{ ?>
                    <option value="<?php echo $jg->id_jenjang ?>" <?php if(set_value('id_jenjang_{role}')==$jg->id_jenjang { f'|| $siswa->id_jenjang_{role} == $jg->id_jenjang' if is_edit else '' }) {{ echo 'selected'; }} ?>>
                      <?php echo $jg->nama_jenjang ?>
                    </option>
                  <?php }} ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Pekerjaan {prefix}{req_star}</label>
              <div class="col-md-9">
                <?php $pekerjaan = $m_pekerjaan->listing(); ?>
                <select name="id_pekerjaan_{role}" class="form-control form-select" {req}>
                  <option value="">Pilih Pekerjaan</option>
                  <?php foreach($pekerjaan as $pk) {{ ?>
                    <option value="<?php echo $pk->id_pekerjaan ?>" <?php if(set_value('id_pekerjaan_{role}')==$pk->id_pekerjaan { f'|| $siswa->id_pekerjaan_{role} == $pk->id_pekerjaan' if is_edit else '' }) {{ echo 'selected'; }} ?>>
                      <?php echo $pk->nama_pekerjaan ?>
                    </option>
                  <?php }} ?>
                </select>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Penghasilan per Bulan {prefix}</label>
              <div class="col-md-9">
                <input type="text" name="penghasilan_{role}" class="form-control" placeholder="Rp." value="{val('penghasilan_'+role)}">
              </div>
            </div>"""

        if role != 'wali':
            html += f"""
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Status {prefix}</label>
              <div class="col-md-9">
                <select name="status_hidup_{role}" class="form-control form-select">
                  <option value="Hidup" {sel('status_hidup_'+role, 'Hidup')}>Masih Hidup</option>
                  <option value="Meninggal" {sel('status_hidup_'+role, 'Meninggal')}>Sudah Meninggal</option>
                </select>
              </div>
            </div>"""

        html += f"""
            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Alamat {prefix}{req_star}</label>
              <div class="col-md-9">
                <textarea name="alamat_{role}" placeholder="Alamat {prefix}" class="form-control" {req}>{val('alamat_'+role)}</textarea>
              </div>
            </div>

            <div class="form-group row mb-3">
              <label class="col-md-3 text-dark">Telepon/HP {prefix}{req_star}</label>
              <div class="col-md-9">
                <input type="text" name="telepon_{role}" class="form-control" placeholder="Telepon/HP {prefix}" value="{val('telepon_'+role)}" {req}>
              </div>
            </div>
            """
        
        if role == 'wali':
            html += """
            </div>""" # close myDIV
            
        html += """
          </div>"""
        
        return html

    # Regex search for the blocks and replace them.
    # Ayah
    pattern_ayah = re.compile(r"<div class=\"card-header bg-dark text-white mb-2\">\s*DATA ORANG TUA SISWA - AYAH\s*</div>.*?</div>\s*</div>\s*<!-- data ibu -->", re.DOTALL)
    ayah_block = render_parent_block("DATA ORANG TUA SISWA - AYAH", "Ayah", "ayah")
    content = pattern_ayah.sub(ayah_block + "\n        </div>\n        <!-- data ibu -->", content)

    # Ibu
    pattern_ibu = re.compile(r"<div class=\"card-header bg-dark text-white mb-2\">\s*DATA ORANG TUA SISWA - IBU\s*</div>.*?</div>\s*</div>\s*<!-- data wali -->", re.DOTALL)
    ibu_block = render_parent_block("DATA ORANG TUA SISWA - IBU", "Ibu", "ibu")
    content = pattern_ibu.sub(ibu_block + "\n        </div>\n        <!-- data wali -->", content)

    # Wali
    pattern_wali = re.compile(r"<div class=\"card-header bg-dark text-white mb-2\">\s*DATA ORANG TUA SISWA - WALI MURID\s*</div>.*?</div>\s*</div>\s*<div class=\"card-footer", re.DOTALL)
    wali_block = render_parent_block("DATA ORANG TUA SISWA - WALI MURID", "Wali", "wali")
    content = pattern_wali.sub(wali_block + "\n        </div>\n        <div class=\"card-footer", content)

    with open(file_path, "w", encoding="utf-8") as f:
        f.write(content)
        
    print(f"Fixed ordering in {file_path}")
