import re

# Clean Nav_model.php
nav_path = r"c:\xampp2\htdocs\websitesekolah-main\app\Models\Nav_model.php"
with open(nav_path, "r", encoding="utf-8") as f:
    content = f.read()

content = content.replace(", jenjang.nama_jenjang, jenjang.id_jenjang", "")
content = re.sub(r"\s*\$builder->join\('jenjang',\s*'jenjang\.id_jenjang = program_pendidikan\.id_jenjang'\);", "", content)

with open(nav_path, "w", encoding="utf-8") as f:
    f.write(content)


# Clean Program_pendidikan_model.php
pp_path = r"c:\xampp2\htdocs\websitesekolah-main\app\Models\Program_pendidikan_model.php"
with open(pp_path, "r", encoding="utf-8") as f:
    content = f.read()

# Hapus where jenjang
content = re.sub(r"'program_pendidikan\.id_jenjang'\s*=>\s*\$id_jenjang,", "", content)
content = re.sub(r"'program_pendidikan\.id_jenjang'\s*=>\s*\$id_jenjang", "", content)

# Clean up empty arrays like [ ] or [ , ] 
content = re.sub(r"\[\s*,", "[", content)
content = re.sub(r"\[\s*\]", "", content)

with open(pp_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Models cleaned.")
