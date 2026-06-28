<?php
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Siswa_model;
use App\Models\Program_pendidikan_model;
use App\Models\Gelombang_model;

class Analisis extends BaseController
{
    public function index()
    {
        $m_siswa = new Siswa_model();
        $m_program = new Program_pendidikan_model();
        $m_gelombang = new Gelombang_model();

        $db = \Config\Database::connect();

        // 1. Total pendaftar berdasarkan status pendaftaran
        $queryStatus = $db->query("SELECT status_pendaftaran, COUNT(id_siswa) as total FROM siswa GROUP BY status_pendaftaran");
        $statusStats = $queryStatus->getResult();
        
        $stats = [
            'Menunggu' => 0,
            'Diperiksa' => 0,
            'Diterima' => 0,
            'Tidak-Diterima' => 0,
            'Total' => 0
        ];
        foreach ($statusStats as $row) {
            $stats[$row->status_pendaftaran] = (int)$row->total;
            $stats['Total'] += (int)$row->total;
        }

        // 2. Sebaran Program Pendidikan
        $queryProgram = $db->query("SELECT jp.judul_program_pendidikan as program, COUNT(s.id_siswa) as total 
                                    FROM siswa s
                                    JOIN program_pendidikan jp ON s.id_program_pendidikan = jp.id_program_pendidikan 
                                    GROUP BY s.id_program_pendidikan, jp.judul_program_pendidikan");
        $programStats = $queryProgram->getResult();

        // 3. Sebaran Jenis Kelamin
        $queryGender = $db->query("SELECT 
                                    CASE 
                                        WHEN jenis_kelamin IN ('L', 'Laki-laki') THEN 'L'
                                        WHEN jenis_kelamin IN ('P', 'Perempuan') THEN 'P'
                                        ELSE 'L'
                                    END as jenis_kelamin,
                                    COUNT(id_siswa) as total 
                                   FROM siswa 
                                   GROUP BY 
                                    CASE 
                                        WHEN jenis_kelamin IN ('L', 'Laki-laki') THEN 'L'
                                        WHEN jenis_kelamin IN ('P', 'Perempuan') THEN 'P'
                                        ELSE 'L'
                                    END");
        $genderStats = $queryGender->getResult();

        // 4. Tren Pendaftaran Harian (30 hari terakhir)
        $queryTrend = $db->query("SELECT DATE(tanggal_post) as tanggal, COUNT(id_siswa) as total 
                                  FROM siswa 
                                  WHERE tanggal_post >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                                  GROUP BY DATE(tanggal_post)
                                  ORDER BY DATE(tanggal_post) ASC");
        $trendStats = $queryTrend->getResult();

        $data = [
            'title'        => 'Analisis Statistik SPMB',
            'stats'        => $stats,
            'programStats' => $programStats,
            'genderStats'  => $genderStats,
            'trendStats'   => $trendStats,
            'content'      => 'admin/analisis/index'
        ];

        return view('admin/layout/wrapper', $data);
    }
}
