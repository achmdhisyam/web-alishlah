<?php
if (php_sapi_name() !== 'cli') {
    die("This script can only be run via Command Line Interface (CLI).");
}

$envFile = __DIR__ . '/../.env';
if (!file_exists($envFile)) {
    die(".env file not found at: {$envFile}\n");
}

$env = parse_ini_file($envFile);
$hostname = $env['database.default.hostname'] ?? 'localhost';
$database = $env['database.default.database'] ?? 'web_sekolah';
$username = $env['database.default.username'] ?? 'root';
$password = $env['database.default.password'] ?? '';

try {
    $pdo = new PDO("mysql:host={$hostname};dbname={$database};charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage() . "\n");
}

// Alter table 'siswa' to add email tracking flags
try {
    $stmt = $pdo->query("SHOW COLUMNS FROM siswa");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (!in_array('email_pendaftaran_sent', $columns)) {
        echo "Adding 'email_pendaftaran_sent' column to 'siswa' table...\n";
        $pdo->exec("ALTER TABLE siswa ADD COLUMN email_pendaftaran_sent TINYINT(1) DEFAULT 0");
    } else {
        echo "'email_pendaftaran_sent' already exists in 'siswa' table.\n";
    }

    if (!in_array('email_pengumuman_sent', $columns)) {
        echo "Adding 'email_pengumuman_sent' column to 'siswa' table...\n";
        $pdo->exec("ALTER TABLE siswa ADD COLUMN email_pengumuman_sent TINYINT(1) DEFAULT 0");
    } else {
        echo "'email_pengumuman_sent' already exists in 'siswa' table.\n";
    }
} catch (Exception $e) {
    echo "Error updating 'siswa' table: " . $e->getMessage() . "\n";
}

echo "Database Migration Completed!\n";
