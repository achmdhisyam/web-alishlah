import re

file_path = r"c:\xampp2\htdocs\websitesekolah-main\app\Views\admin\gelombang\export.php"
with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# Remove headers
content = re.sub(r"\s*<th>Golongan Darah</th>", "", content)
content = re.sub(r"\s*<th>Tinggi Badan \(cm\)</th>", "", content)
content = re.sub(r"\s*<th>Berat Badan \(kg\)</th>", "", content)

# Remove data columns
content = re.sub(r"\s*<td><\?php echo \$siswa->goldar_siswa \?></td>", "", content)
content = re.sub(r"\s*<td><\?php echo \$siswa->tinggi \?></td>", "", content)
content = re.sub(r"\s*<td><\?php echo \$siswa->berat \?></td>", "", content)

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("export.php removed goldar, tinggi, berat.")
