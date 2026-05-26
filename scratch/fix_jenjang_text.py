import os
import re

files = [
    r"c:\xampp2\htdocs\websitesekolah-main\app\Views\siswa\pendaftaran\biodata.php",
    r"c:\xampp2\htdocs\websitesekolah-main\app\Views\siswa\pendaftaran\edit.php"
]

for file_path in files:
    with open(file_path, "r", encoding="utf-8") as f:
        content = f.read()

    # Find the select for jenjang ayah, ibu, wali and replace "Pilih Program Pendidikan" with "Pilih Jenjang Pendidikan"
    # To be safe, we can just replace "Pilih Program Pendidikan" that appears after "id_jenjang_" 
    # Or simply:
    content = re.sub(r'(<select name="id_jenjang_(?:ayah|ibu|wali)".*?>\s*)<option value="">Pilih Program Pendidikan</option>', 
                     r'\1<option value="">Pilih Jenjang Pendidikan</option>', 
                     content, flags=re.DOTALL)

    with open(file_path, "w", encoding="utf-8") as f:
        f.write(content)
        
print("Updated options in biodata.php and edit.php")
