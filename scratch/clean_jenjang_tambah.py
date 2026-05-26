import re

file_path = r"c:\xampp2\htdocs\websitesekolah-main\app\Views\admin\program_pendidikan\tambah.php"
with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# Hapus div col-md-3 berisi select id_jenjang
pattern = r'<div class="col-md-3">\s*<select name="id_jenjang".*?</select>\s*<small class="text-secondary">jenjang Pendidikan</small>\s*</div>'
content = re.sub(pattern, "", content, flags=re.DOTALL)

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("tambah.php updated.")
