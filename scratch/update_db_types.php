<?php
$c = mysqli_connect('localhost','root','','javawebmedia_sekolah',3307);
$sql = "UPDATE program_pendidikan SET jenis_program_pendidikan = 'Program Pendidikan' WHERE jenis_program_pendidikan = 'Jenjang'";
mysqli_query($c, $sql);
echo "Updated " . mysqli_affected_rows($c) . " rows.";
?>
