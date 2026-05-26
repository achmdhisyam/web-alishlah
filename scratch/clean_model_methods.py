import re

file_path = r"c:\xampp2\htdocs\websitesekolah-main\app\Models\Program_pendidikan_model.php"
with open(file_path, "r", encoding="utf-8") as f:
    lines = f.readlines()

# Filter out the jenjang-related methods
new_lines = []
skip = False
for line in lines:
    if "public function jenjang_status_jenis_all" in line or \
       "public function total_jenjang_status_jenis" in line or \
       "public function jenjang_all" in line or \
       "public function total_jenjang" in line or \
       "// jenjang" in line:
        skip = True
    
    if not skip:
        new_lines.append(line)
    
    if skip and "}" in line:
        # Check if it's the end of the method
        # This is a bit naive but should work for these specific methods
        if line.strip() == "}":
            skip = False

with open(file_path, "w", encoding="utf-8") as f:
    f.writelines(new_lines)

print("Program_pendidikan_model.php methods cleaned.")
