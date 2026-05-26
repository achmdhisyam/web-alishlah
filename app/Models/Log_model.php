<?php
namespace App\Models;

use CodeIgniter\Model;

class Log_model extends Model
{
    protected $table            = 'log_aktivitas';
    protected $primaryKey       = 'id_log';
    protected $allowedFields    = ['id_user', 'username', 'aktivitas', 'kategori', 'ip_address', 'tanggal_log'];

    public function listing()
    {
        return $this->select('log_aktivitas.*, users.nama as nama_user')
                    ->join('users', 'users.id_user = log_aktivitas.id_user', 'LEFT')
                    ->orderBy('id_log', 'DESC')
                    ->get()
                    ->getResult();
    }

    public function tambah($data)
    {
        return $this->insert($data);
    }
}
