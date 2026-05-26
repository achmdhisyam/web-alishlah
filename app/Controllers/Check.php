<?php 
namespace App\Controllers;

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


class Check extends BaseController
{

	// index
	public function index()
	{
		$m_konfigurasi 	= new Konfigurasi_model();
		$konfigurasi 	= $m_konfigurasi->listing();
		$m_akun 		= new Akun_model();
		$kode_akun 		= strtoupper(random_string('alnum', 64));
		
		$data = [	'title'			=> 'Cek Status Pendaftaran',
					'description'	=> 'Cek Status Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->tentang,
					'keywords'		=> 'Cek Status Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->keywords,
					'm_siswa'		=> new Siswa_model(),
					'konfigurasi'	=> $konfigurasi,
					'content'		=> 'check/index'
				];
		echo view('layout/wrapper-pendaftaran',$data);
	}



}