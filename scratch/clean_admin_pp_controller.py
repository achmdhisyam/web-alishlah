import re

file_path = r"c:\xampp2\htdocs\websitesekolah-main\app\Controllers\Admin\Program_pendidikan.php"
with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# Hapus public function jenjang($id_jenjang) { ... }
pattern = r"\s*// jenjang\s*public function jenjang\(\$id_jenjang\).*?\n\s*echo view\('admin/layout/wrapper',\$data\);\s*\n\s*\}"
content = re.sub(pattern, "", content, flags=re.DOTALL)

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Admin Program_pendidikan controller cleaned.")
