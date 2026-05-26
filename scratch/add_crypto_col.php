<?php
$c = mysqli_connect('localhost','root','','javawebmedia_sekolah',3307);
$sql = "ALTER TABLE konfigurasi ADD smtp_crypto VARCHAR(255) NULL AFTER smtp_pass";
mysqli_query($c, $sql);
echo mysqli_error($c);
?>
