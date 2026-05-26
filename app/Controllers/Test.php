<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\Siswa_model;

class Test extends Controller {
    public function index() {
        $m = new Siswa_model();
        $ids = [8, 10, 11, 12];
        foreach ($ids as $id) {
            $siswa = $m->detail($id);
            if ($siswa) {
                echo "ID: $id -> Returned ID: {$siswa->id_siswa} | Name: {$siswa->nama_siswa}\n";
            } else {
                echo "ID: $id -> Not found\n";
            }
        }
    }
}
