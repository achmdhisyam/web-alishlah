<?php 
namespace App\Controllers\Siswa;

use CodeIgniter\Controller;
use App\Models\Konfigurasi_model;
use App\Models\Galeri_model;
use App\Models\Berita_model;
use App\Models\Siswa_model;
use App\Models\Rombel_model;
use App\Models\Kelas_model;
use App\Models\Tahun_model;
use App\Models\Jenjang_model;
use App\Models\Pekerjaan_model;
use App\Models\Hubungan_model;
use App\Models\Siswa_rombel_model;
use App\Models\Agama_model;
use App\Models\Akun_model;
use App\Models\Jenis_dokumen_model;
use App\Models\Dokumen_model;
use App\Models\Gelombang_model;
use App\Models\Program_pendidikan_model;
use App\Models\Nav_model;

class Gelombang extends BaseController
{
	public function index()
	{
		$m_gelombang 	= new Gelombang_model();
		$m_siswa 		= new Siswa_model();
		$gelombang 		= $m_gelombang->aktif();

		// Cek apakah user sudah mendaftar
		$id_akun = $this->session->get('id_akun');
		$siswa_exist = $m_siswa->akun($id_akun);
		if($siswa_exist) {
			$this->session->setFlashdata('warning','Anda sudah pernah melakukan pendaftaran pada akun ini. Jika ingin mendaftar lagi, silakan buat akun baru.');
			return redirect()->to(base_url('siswa/pendaftaran'));
		}

		$data = [   'title'     	=> 'Periode Pendaftaran Peserta Didik Baru (SPMB)',
					'description'   => 'Dasbor Pendaftar',
                    'keywords'      => 'Dasbor Pendaftar',
                    'gelombang'		=> $gelombang,
					'gelombang2'	=> $gelombang,
					'content'		=> 'siswa/gelombang/index'
                ];
        return view('siswa/layout/wrapper',$data);
	}
}