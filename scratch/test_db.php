<?php
$c = mysqli_connect('localhost','root','','web_sekolah',3306);
$r = mysqli_query($c,'SELECT COUNT(*) as c FROM program_pendidikan');
$row = mysqli_fetch_assoc($r);
echo "program_pendidikan count: " . $row['c'] . "\n";
