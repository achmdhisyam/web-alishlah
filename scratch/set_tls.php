<?php
$c = mysqli_connect('localhost','root','','javawebmedia_sekolah',3307);
$sql = "UPDATE konfigurasi SET smtp_crypto = 'tls'";
mysqli_query($c, $sql);
echo "Updated crypto to tls";
?>
