<?php
$c = mysqli_connect('localhost','root','','javawebmedia_sekolah',3307);
$sql1 = "ALTER TABLE konfigurasi ADD google_client_id VARCHAR(255) NULL;";
$sql2 = "ALTER TABLE konfigurasi ADD google_client_secret VARCHAR(255) NULL;";
mysqli_query($c, $sql1);
mysqli_query($c, $sql2);
echo "Added Google OAuth columns";
?>
