import re

file_path = r"c:\xampp2\htdocs\websitesekolah-main\app\Controllers\Admin\Program_pendidikan.php"
with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# Hapus assignment id_jenjang
content = re.sub(r"\s*'id_jenjang'\s*=>\s*\$this->request->getVar\('id_jenjang'\),", "", content)

# Hapus use App\Models\Jenjang_model;
content = content.replace("use App\\Models\\Jenjang_model;\n", "")

# Hapus inisiasi jenjang model dan variabelnya
content = re.sub(r"\s*\$m_jenjang\s*=\s*new Jenjang_model\(\);\n", "\n", content)
content = re.sub(r"\s*\$jenjang\s*=\s*\$m_jenjang->listing\(\);\n", "\n", content)
content = re.sub(r"\s*\$jenjang\s*=\s*\$m_jenjang->detail\(\$id_jenjang\);\n", "\n", content)

# Hapus array key 'jenjang' => $jenjang,
content = re.sub(r"\s*'jenjang'\s*=>\s*\$jenjang,", "", content)

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Program_pendidikan controller updated.")
