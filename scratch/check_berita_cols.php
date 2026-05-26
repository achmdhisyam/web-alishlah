<?php
$c = mysqli_connect('localhost','root','','web_sekolah',3306);
if (!$c) { die("DB connection failed: " . mysqli_connect_error()); }
$r = mysqli_query($c, "SELECT * FROM kategori");
while ($row = mysqli_fetch_assoc($r)) {
    echo $row['id_kategori'] . " - " . $row['nama_kategori'] . "\n";
}
mysqli_close($c);
