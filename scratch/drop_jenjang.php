<?php
$conn = mysqli_connect("localhost", "root", "", "javawebmedia_sekolah", 3307);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Hapus foreign key index jika ada (opsional, tapi biasanya aman untuk drop column jika tidak ada constraint ketat)
// Coba drop column langsung
$sql = "ALTER TABLE program_pendidikan DROP COLUMN id_jenjang";
if (mysqli_query($conn, $sql)) {
    echo "Column id_jenjang dropped successfully.\n";
} else {
    echo "Error dropping column: " . mysqli_error($conn) . "\n";
}
mysqli_close($conn);
?>
