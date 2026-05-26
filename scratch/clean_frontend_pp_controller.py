import re

file_path = r"c:\xampp2\htdocs\websitesekolah-main\app\Controllers\Program_pendidikan.php"
with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# Hapus public function jenjang($id_jenjang) { ... }
pattern = r"\s*// jenjang\s*public function jenjang\(\$id_jenjang\).*?\n\s*return view\('layout/wrapper',\$data\);\s*\n\s*\}"
content = re.sub(pattern, "", content, flags=re.DOTALL)

# Hapus use App\Models\Jenjang_model;
content = content.replace("use App\\Models\\Jenjang_model;\n", "")

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Frontend Program_pendidikan controller cleaned.")
