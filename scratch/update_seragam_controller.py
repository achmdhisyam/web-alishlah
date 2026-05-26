import os

file_path = r"c:\xampp2\htdocs\websitesekolah-main\app\Controllers\Siswa\Pendaftaran.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# Replace all occurrences of ukuran_seragam assignment
old_assignment = "'ukuran_seragam'\t\t=> $this->request->getPost('ukuran_seragam'),"
new_assignment = "'ukuran_seragam'\t\t=> ($this->request->getPost('ukuran_seragam') == 'Lainnya') ? $this->request->getPost('ukuran_seragam_lainnya') : $this->request->getPost('ukuran_seragam'),"

content = content.replace(old_assignment, new_assignment)

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)
    
print("Updated Pendaftaran.php")
