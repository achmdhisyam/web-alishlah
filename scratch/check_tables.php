<?php
$conn = mysqli_connect("localhost", "root", "", "javawebmedia_sekolah", 3307);
if (!$conn) { die("Connection failed"); }
$res = mysqli_query($conn, "SHOW TABLES LIKE 'jenjang'");
if (mysqli_num_rows($res) > 0) { echo "jenjang exists.\n"; } else { echo "jenjang missing.\n"; }

$res2 = mysqli_query($conn, "SHOW COLUMNS FROM program_pendidikan");
while($row = mysqli_fetch_assoc($res2)) {
    echo $row['Field'] . ", ";
}
echo "\n";
mysqli_close($conn);
?>
