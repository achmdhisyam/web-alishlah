<?php
$c = mysqli_connect('localhost', 'root', '', 'web_sekolah', 3306);
if (!$c) {
    die("Connection failed: " . mysqli_connect_error());
}

// 1. Create table `yayasan`
$createTableQuery = "CREATE TABLE IF NOT EXISTS `yayasan` (
  `id_yayasan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `slug_yayasan` varchar(255) NOT NULL,
  `judul_yayasan` varchar(255) NOT NULL,
  `ringkasan` text DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `status_yayasan` varchar(50) DEFAULT 'Draft',
  `keywords` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `hits` int(11) DEFAULT 0,
  `urutan` int(11) DEFAULT 0,
  `tanggal_post` datetime DEFAULT NULL,
  `tanggal_publish` datetime DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_yayasan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($c, $createTableQuery)) {
    echo "Table 'yayasan' created or already exists.\n";
} else {
    die("Error creating table: " . mysqli_error($c) . "\n");
}

// 2. Fetch all rows from `program_pendidikan` where `jenis_program_pendidikan = 'Yayasan'`
$selectQuery = "SELECT * FROM `program_pendidikan` WHERE `jenis_program_pendidikan` = 'Yayasan'";
$result = mysqli_query($c, $selectQuery);

if ($result) {
    $migratedCount = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $id_user = $row['id_user'];
        $slug_yayasan = mysqli_real_escape_string($c, $row['slug_program_pendidikan']);
        $judul_yayasan = mysqli_real_escape_string($c, $row['judul_program_pendidikan']);
        $ringkasan = mysqli_real_escape_string($c, $row['ringkasan']);
        $isi = mysqli_real_escape_string($c, $row['isi']);
        $status_yayasan = mysqli_real_escape_string($c, $row['status_program_pendidikan']);
        $keywords = mysqli_real_escape_string($c, $row['keywords']);
        $gambar = mysqli_real_escape_string($c, $row['gambar']);
        $icon = mysqli_real_escape_string($c, $row['icon']);
        $hits = $row['hits'];
        $urutan = $row['urutan'];
        $tanggal_post = $row['tanggal_post'];
        $tanggal_publish = $row['tanggal_publish'];

        // Check if already migrated by checking slug
        $checkQuery = "SELECT * FROM `yayasan` WHERE `slug_yayasan` = '$slug_yayasan'";
        $checkResult = mysqli_query($c, $checkQuery);
        if (mysqli_num_rows($checkResult) == 0) {
            $insertQuery = "INSERT INTO `yayasan` (
                `id_user`, `slug_yayasan`, `judul_yayasan`, `ringkasan`, `isi`, `status_yayasan`, 
                `keywords`, `gambar`, `icon`, `hits`, `urutan`, `tanggal_post`, `tanggal_publish`
            ) VALUES (
                '$id_user', '$slug_yayasan', '$judul_yayasan', '$ringkasan', '$isi', '$status_yayasan', 
                '$keywords', '$gambar', '$icon', '$hits', '$urutan', '$tanggal_post', '$tanggal_publish'
            )";
            if (mysqli_query($c, $insertQuery)) {
                $migratedCount++;
            } else {
                echo "Error inserting row: " . mysqli_error($c) . "\n";
            }
        }
    }
    echo "Migrated $migratedCount rows from program_pendidikan to yayasan table.\n";

    // 3. Delete migrated rows from `program_pendidikan`
    $deleteQuery = "DELETE FROM `program_pendidikan` WHERE `jenis_program_pendidikan` = 'Yayasan'";
    if (mysqli_query($c, $deleteQuery)) {
        echo "Deleted Yayasan entries from program_pendidikan table.\n";
    } else {
        echo "Error deleting rows: " . mysqli_error($c) . "\n";
    }
} else {
    echo "Error selecting data: " . mysqli_error($c) . "\n";
}

mysqli_close($c);
?>
