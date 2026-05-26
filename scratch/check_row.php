<?php
$c = mysqli_connect('localhost','root','','javawebmedia_sekolah',3307);
$r = mysqli_query($c,'SELECT * FROM program_pendidikan LIMIT 1');
$row = mysqli_fetch_assoc($r);
print_r($row);
?>
