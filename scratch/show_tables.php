<?php
$c = mysqli_connect('localhost','root','','web_sekolah',3306);
if (!$c) { die("DB connection failed: " . mysqli_connect_error()); }
$r = mysqli_query($c,'SHOW TABLES');
while ($row = mysqli_fetch_array($r)) {
    echo $row[0] . "\n";
}
mysqli_close($c);
