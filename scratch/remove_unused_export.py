import re

file_path = r"c:\xampp2\htdocs\websitesekolah-main\app\Views\admin\gelombang\export.php"
with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# Remove '<th>Berkebutuhan Khusus</th>' and '<th>Status Masuk</th>'
content = content.replace("<th>Berkebutuhan Khusus</th>\n", "")
content = content.replace("<th>Status Masuk</th>\n", "")
content = content.replace("<th>Berkebutuhan Khusus</th>\r\n", "")
content = content.replace("<th>Status Masuk</th>\r\n", "")
# Remove '<td><?php echo $siswa->berkebutuhan_khusus ?></td>' and '<td><?php echo $siswa->jenis_siswa ?></td>'
content = content.replace("<td><?php echo $siswa->berkebutuhan_khusus ?></td>\n", "")
content = content.replace("<td><?php echo $siswa->jenis_siswa ?></td>\n", "")
content = content.replace("<td><?php echo $siswa->berkebutuhan_khusus ?></td>\r\n", "")
content = content.replace("<td><?php echo $siswa->jenis_siswa ?></td>\r\n", "")

# Same for the old spaces/tabs formatting:
content = re.sub(r"\s*<th>Berkebutuhan Khusus</th>", "", content)
content = re.sub(r"\s*<th>Status Masuk</th>", "", content)
content = re.sub(r"\s*<td><\?php echo \$siswa->berkebutuhan_khusus \?></td>", "", content)
content = re.sub(r"\s*<td><\?php echo \$siswa->jenis_siswa \?></td>", "", content)


with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("export.php removed unused fields.")
