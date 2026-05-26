<?php
$c = mysqli_connect('localhost','root','','web_sekolah',3306);
if (!$c) { die("DB connection failed: " . mysqli_connect_error()); }
$tables = ['profil', 'visi_misi', 'sambutan', 'keunggulan'];
foreach ($tables as $t) {
    echo "--- Table: $t ---\n";
    $r = mysqli_query($c, "SHOW COLUMNS FROM $t");
    while ($row = mysqli_fetch_assoc($r)) {
        echo "  " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
}
mysqli_close($c);
