<?php 
require 'public/index.php'; 
$db = \Config\Database::connect();
$builder = $db->table('siswa');
$data = ['id_siswa' => 8, 'nama_siswa' => 'TEST DUMP'];
$builder->where('id_siswa', $data['id_siswa']);
$sql = $builder->getCompiledUpdate($data);
echo "SQL QUERY: " . $sql;
