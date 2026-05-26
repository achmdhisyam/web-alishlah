<?php
$c = mysqli_connect('localhost','root','','javawebmedia_sekolah',3307);
$r = mysqli_query($c,'SELECT email FROM konfigurasi');
$row = mysqli_fetch_assoc($r);
echo $row['email'];
?>
