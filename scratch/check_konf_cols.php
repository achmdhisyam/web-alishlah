<?php
$c = mysqli_connect('localhost','root','','javawebmedia_sekolah',3307);
$r = mysqli_query($c,'SHOW COLUMNS FROM konfigurasi');
while($row = mysqli_fetch_assoc($r)) {
    echo $row['Field'].", ";
}
?>
