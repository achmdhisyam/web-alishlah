import re

files = [
    r"c:\xampp2\htdocs\websitesekolah-main\app\Views\siswa\pendaftaran\cetak.php",
    r"c:\xampp2\htdocs\websitesekolah-main\app\Views\pendaftaran\cetak.php",
    r"c:\xampp2\htdocs\websitesekolah-main\app\Views\admin\gelombang\cetak.php"
]

for file_path in files:
    with open(file_path, "r", encoding="utf-8") as f:
        content = f.read()

    # 1. Strip the hardcoded "SYARAT PENDAFTARAN" and "RINCIAN ADMINISTRASI" blocks if they exist
    # These typically look like <table class="table ..."><thead><tr><th>SYARAT PENDAFTARAN</th>...
    # Or "RINCIAN ADMINISTRASI KEUANGAN"
    # Actually, it's easier to just strip them by looking for the blocks.
    
    # We remove anything from "SYARAT PENDAFTARAN" to the end of its table
    content = re.sub(r'<table class="table table-bordered table-sm printer mt-2">\s*<thead>\s*<tr>\s*<th class="bg-secondary text-white text-center">SYARAT PENDAFTARAN.*?</table>', '', content, flags=re.DOTALL)
    
    # We remove anything from "RINCIAN ADMINISTRASI" to the end of its table
    content = re.sub(r'<table class="table table-bordered table-sm printer mt-2">\s*<thead>\s*<tr>\s*<th colspan="3" class="bg-secondary text-white text-center">\s*RINCIAN ADMINISTRASI KEUANGAN.*?</table>', '', content, flags=re.DOTALL)
    
    # Remove old <?php echo $konfigurasi->rincian_administrasi; ?>
    content = content.replace("<?php echo $konfigurasi->rincian_administrasi; ?>", "")
    content = content.replace("<?php echo $konfigurasi->syarat_pendaftaran; ?>", "")
    
    # Now append the dynamic fields right before "</div>\n</page>"
    dynamic_blocks = "\n<?php echo $konfigurasi->syarat_pendaftaran; ?>\n<?php echo $konfigurasi->rincian_administrasi; ?>\n"
    
    # We look for "</div>\n</page>" or similar
    content = re.sub(r'</div>\s*</page>', f'{dynamic_blocks}\n</div>\n</page>', content)
    
    with open(file_path, "w", encoding="utf-8") as f:
        f.write(content)
        
print("Updated all cetak.php files")
