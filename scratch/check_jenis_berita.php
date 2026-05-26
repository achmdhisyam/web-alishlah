<?php
$c = mysqli_connect('localhost','root','','web_sekolah',3306);
$r = mysqli_query($c,'SELECT DISTINCT jenis_berita FROM berita');
while($row = mysqli_fetch_assoc($r)) {
    echo $row['jenis_berita']."\n";
}
?>
