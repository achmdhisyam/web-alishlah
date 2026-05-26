<?php 
require 'public/index.php'; 
$m = new App\Models\Siswa_model(); 
$m->edit(['id_siswa' => 8, 'nama_siswa' => 'TEST UPDATE']); 
echo 'Done';
