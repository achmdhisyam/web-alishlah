import re

file_path = r"c:\xampp2\htdocs\websitesekolah-main\app\Models\Program_pendidikan_model.php"
with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# Hapus select jenjang.nama_jenjang
content = content.replace(", jenjang.nama_jenjang", "")

# Hapus join jenjang
content = re.sub(r"\$this->join\('jenjang','jenjang\.id_jenjang = program_pendidikan\.id_jenjang','LEFT'\);\n\s*", "", content)

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Program_pendidikan_model.php updated.")
