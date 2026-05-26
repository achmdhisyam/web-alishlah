<?php
$c = mysqli_connect('localhost','root','','javawebmedia_sekolah',3307);
$r = mysqli_query($c,'SELECT protocol, smtp_host, smtp_user, smtp_port, smtp_crypto FROM konfigurasi');
$row = mysqli_fetch_assoc($r);
print_r($row);
?>
