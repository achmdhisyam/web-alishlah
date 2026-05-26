<?php
$c = mysqli_connect('localhost','root','','javawebmedia_sekolah',3307);
$r = mysqli_query($c,'SELECT DISTINCT jenis_program_pendidikan FROM program_pendidikan');
while($row = mysqli_fetch_assoc($r)) {
    echo $row['jenis_program_pendidikan'].', ';
}
?>
