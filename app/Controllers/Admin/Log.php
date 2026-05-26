<?php
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Log_model;

class Log extends BaseController
{
    public function index()
    {
        if (Session()->get('akses_level') !== 'Admin') {
            $this->session->setFlashdata('warning', 'Anda tidak memiliki hak akses ke halaman ini.');
            return redirect()->to(base_url('admin/dasbor'));
        }

        $m_log = new Log_model();
        $logs = $m_log->listing();

        $data = [
            'title'   => 'Log Aktivitas Sistem',
            'logs'    => $logs,
            'content' => 'admin/log/index'
        ];

        return view('admin/layout/wrapper', $data);
    }
}
