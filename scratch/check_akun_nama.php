<?php
$c = mysqli_connect('localhost','root','','javawebmedia_sekolah',3307);
$r = mysqli_query($c,'SELECT nama FROM akun LIMIT 1');
if (!$r) echo mysqli_error($c);
$row = mysqli_fetch_assoc($r);
print_r($row);
?>
