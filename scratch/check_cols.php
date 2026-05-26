<?php
$c = mysqli_connect('localhost','root','','web_sekolah',3306);
$r = mysqli_query($c,'SHOW COLUMNS FROM program_pendidikan');
while($row = mysqli_fetch_assoc($r)) {
    echo $row['Field'].', ';
}
?>
