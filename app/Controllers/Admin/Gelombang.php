<?php 
namespace App\Controllers\Admin;

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

	// index
	public function index()
	{
		$m_gelombang 	= new Gelombang_model();
		$gelombang 		= $m_gelombang->listing();
		$total 			= $m_gelombang->total();	

		$data = [	'title'				=> 'Data Periode SPMB: '.$total->total,
					'gelombang'			=> $gelombang,
					'm_gelombang'		=> $m_gelombang,
					'm_siswa'			=> new Siswa_model(),
					'content'			=> 'admin/gelombang/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// edit
	public function detail($id_gelombang,$status_pendaftaran,$id_program_pendidikan)
	{
		$m_gelombang 				= new Gelombang_model();
		$m_siswa 					= new Siswa_model();
		$m_program_pendidikan 		= new Program_pendidikan_model();
		$gelombang 					= $m_gelombang->detail($id_gelombang);
		$siswa 						= $m_siswa->gelombang_status_siswa($id_gelombang,$status_pendaftaran,$id_program_pendidikan);
		$akumulasi 					= $m_siswa->gelombang($id_gelombang);
		if($id_program_pendidikan =='Semua') {
			$judul_program_pendidikan 	= 'Semua Program Pendidikan';
		}else{
			$program_pendidikan 		= $m_program_pendidikan->detail($id_program_pendidikan);
			$judul_program_pendidikan 	= $program_pendidikan->judul_program_pendidikan;
		}
		if(isset($_POST['submit'])) {
			$pengalihan 	= $this->request->getVar('pengalihan');
			$id_siswa 		= $this->request->getVar('id_siswa');
			$status_baru 	= $this->request->getVar('status_pendaftaran');

			$m_konfigurasi  = new Konfigurasi_model();
			$konfigurasi 	= $m_konfigurasi->listing();

   			for($i=0; $i < sizeof($id_siswa);$i++) {
				$data = array(	'id_siswa'				=> $id_siswa[$i],
								'id_user'				=> $this->session->get('id_user'),
								'status_pendaftaran'	=> $status_baru
							);

				$s_detail = $m_siswa->detail($id_siswa[$i]);
				if ($s_detail && ($status_baru == 'Diterima' || $status_baru == 'Tidak-Diterima')) {
					$data['email_pengumuman_sent'] = 1;

					$emailData = [
						'nama_siswa'         => $s_detail->nama_siswa,
						'kode_siswa'         => $s_detail->kode_siswa,
						'program'            => $s_detail->judul_program_pendidikan,
						'status_pendaftaran' => $status_baru,
						'namaweb'            => $konfigurasi->namaweb,
						'link_login'         => base_url('signin')
					];
					$htmlMessage = view('email_templates/pengumuman_kelulusan', $emailData);
					$recipientEmail = !empty($s_detail->email_akun) ? $s_detail->email_akun : $s_detail->email;
					if (!$this->sendEmail($recipientEmail, 'Pengumuman Hasil Seleksi SPMB - ' . $konfigurasi->namaweb, $htmlMessage)) {
						$email_service = \Config\Services::email();
						log_message('error', 'Gagal mengirim email pengumuman kelulusan (batch) ke ' . $recipientEmail . '. Detail: ' . $email_service->printDebugger(['headers', 'subject', 'body']));
					}
				}

   				$m_siswa->edit($data);
				$this->logActivity('SPMB', 'Mengubah status pendaftaran siswa: ' . ($s_detail->nama_siswa ?? $id_siswa[$i]) . ' menjadi ' . $status_baru);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Data Siswa berhasil diupdate statusnya');
		}

		$data = [	'title'					=> $gelombang->judul,
					'judul_program_pendidikan'	=> $judul_program_pendidikan,
					'gelombang'				=> $gelombang,
					'm_gelombang'			=> $m_gelombang,
					'siswa'					=> $siswa,
					'status_pendaftaran'	=> $status_pendaftaran,
					'id_program_pendidikan'	=> $id_program_pendidikan,
					'id_gelombang'			=> $id_gelombang,
					'm_siswa'				=> $m_siswa,
					'akumulasi'				=> $akumulasi,
					'm_jenis_dokumen'		=> new Jenis_dokumen_model(),
                    'm_dokumen'				=> new Dokumen_model(),
					'content'				=> 'admin/gelombang/detail'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// export
	public function export($id_gelombang,$status_pendaftaran,$id_program_pendidikan)
	{
		$m_gelombang 				= new Gelombang_model();
		$m_siswa 					= new Siswa_model();
		$m_program_pendidikan 		= new Program_pendidikan_model();
		$gelombang 					= $m_gelombang->detail($id_gelombang);
		$siswa 						= $m_siswa->gelombang_status_siswa($id_gelombang,$status_pendaftaran,$id_program_pendidikan);
		$akumulasi 					= $m_siswa->gelombang($id_gelombang);
		if($id_program_pendidikan =='Semua') {
			$judul_program_pendidikan 	= 'Semua Program Pendidikan';
		}else{
			$program_pendidikan 		= $m_program_pendidikan->detail($id_program_pendidikan);
			$judul_program_pendidikan 	= $program_pendidikan->judul_program_pendidikan;
		}

		$data = [	'title'					=> $gelombang->judul,
					'judul_program_pendidikan'	=> $judul_program_pendidikan,
					'gelombang'				=> $gelombang,
					'm_gelombang'			=> $m_gelombang,
					'siswa'					=> $siswa,
					'status_pendaftaran'	=> $status_pendaftaran,
					'id_program_pendidikan'	=> $id_program_pendidikan,
					'id_gelombang'			=> $id_gelombang,
					'm_siswa'				=> $m_siswa,
					'm_jenis_dokumen'		=> new Jenis_dokumen_model(),
                    'm_dokumen'				=> new Dokumen_model(),
					'content'				=> 'admin/gelombang/export'
				];
		echo view('admin/layout/wrapper-export',$data);
	}

	// unduh_data
	public function unduh_data($id_gelombang,$status_pendaftaran,$id_program_pendidikan)
	{
		$m_gelombang 				= new Gelombang_model();
		$m_siswa 					= new Siswa_model();
		$m_program_pendidikan 		= new Program_pendidikan_model();
		$gelombang 					= $m_gelombang->detail($id_gelombang);
		$siswa 						= $m_siswa->gelombang_status_siswa($id_gelombang,$status_pendaftaran,$id_program_pendidikan);
		$akumulasi 					= $m_siswa->gelombang($id_gelombang);
		if($id_program_pendidikan =='Semua') {
			$judul_program_pendidikan 	= 'Semua Program Pendidikan';
		}else{
			$program_pendidikan 		= $m_program_pendidikan->detail($id_program_pendidikan);
			$judul_program_pendidikan 	= $program_pendidikan->judul_program_pendidikan;
		}

		$data = [	'title'					=> $gelombang->judul,
					'judul_program_pendidikan'	=> $judul_program_pendidikan,
					'gelombang'				=> $gelombang,
					'm_gelombang'			=> $m_gelombang,
					'siswa'					=> $siswa,
					'status_pendaftaran'	=> $status_pendaftaran,
					'id_program_pendidikan'	=> $id_program_pendidikan,
					'id_gelombang'			=> $id_gelombang,
					'm_siswa'				=> $m_siswa,
					'm_jenis_dokumen'		=> new Jenis_dokumen_model(),
                    'm_dokumen'				=> new Dokumen_model(),
				];
		// echo view('layout/wrapper',$data);
		$mpdf = new \Mpdf\Mpdf([
						'default_font_size' => 11,
						'default_font' => 'nunito-regular'
					]);
		$html = view('admin/gelombang/unduh_data',$data);
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		// buka di browser
		$mpdf->Output($gelombang->judul.'.pdf','I'); 
	}

	// unduh_pengumuman
	public function unduh_pengumuman($id_gelombang,$status_pendaftaran,$id_program_pendidikan)
	{
		$m_gelombang 				= new Gelombang_model();
		$m_siswa 					= new Siswa_model();
		$m_program_pendidikan 		= new Program_pendidikan_model();
		$gelombang 					= $m_gelombang->detail($id_gelombang);
		$siswa 						= $m_siswa->gelombang_status_siswa($id_gelombang,$status_pendaftaran,$id_program_pendidikan);
		$akumulasi 					= $m_siswa->gelombang($id_gelombang);
		if($id_program_pendidikan =='Semua') {
			$judul_program_pendidikan 	= 'Semua Program Pendidikan';
		}else{
			$program_pendidikan 		= $m_program_pendidikan->detail($id_program_pendidikan);
			$judul_program_pendidikan 	= $program_pendidikan->judul_program_pendidikan;
		}

		$data = [	'title'					=> $gelombang->judul,
					'judul_program_pendidikan'	=> $judul_program_pendidikan,
					'gelombang'				=> $gelombang,
					'm_gelombang'			=> $m_gelombang,
					'siswa'					=> $siswa,
					'status_pendaftaran'	=> $status_pendaftaran,
					'id_program_pendidikan'	=> $id_program_pendidikan,
					'id_gelombang'			=> $id_gelombang,
					'm_siswa'				=> $m_siswa,
					'm_jenis_dokumen'		=> new Jenis_dokumen_model(),
                    'm_dokumen'				=> new Dokumen_model(),
				];
		// echo view('layout/wrapper',$data);
		$mpdf = new \Mpdf\Mpdf([
						'default_font_size' => 11,
						'default_font' => 'nunito-regular'
					]);
		$html = view('admin/gelombang/unduh_pengumuman',$data);
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		// buka di browser
		$mpdf->Output($gelombang->judul.'.pdf','I'); 
	}

	// mainpage
	public function tambah()
	{
		
		$m_gelombang 	= new Gelombang_model();
		$gelombang 		= $m_gelombang->listing();
		$total 			= $m_gelombang->total();
		$tahun_ajaran 	= (date('Y')+1)."/".(date('Y')+2);
		$akhir 			= $m_gelombang->akhir($tahun_ajaran);
		if($akhir) {
			$tahap = $akhir->tahap + 1;
		}else{
			$tahap = 1;
		}
		$nama_gelombang = 'SPMB Tahap '.$tahap.' - Tahun Ajaran '.$tahun_ajaran;

		// Start validasi
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'judul' 	=> 'required',
				'gambar'	 			=> [
								                'mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png]',
								                'max_size[gambar,102400]',
			            					],
        	])) {
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  					= $this->request->getFile('gambar');
				$judulbaru 	= $avatar->getRandomName();
	            $avatar->move(WRITEPATH . '../assets/upload/image/',$judulbaru);
	            $this->compressImage(WRITEPATH . '../assets/upload/image/' . $judulbaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/image/'.$judulbaru)
			    ->fit(100, 100, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$judulbaru);
	        	// masuk database
	        	$slug 	= strtolower(url_title($this->request->getVar('judul')));
				$data = [	'id_user'					=> $this->session->get('id_user'),
							'tahun_ajaran'				=> $this->request->getPost('tahun_ajaran'),
							'tahap'						=> $tahap,
							'tahun'						=> $this->request->getPost('tahun'),
							'slug'						=> $slug,
							'judul'						=> $this->request->getPost('judul'),
							'isi'						=> $this->request->getPost('isi'),
							'tanggal_buka'				=> $this->website->tanggal_input($this->request->getPost('tanggal_buka')),
							'tanggal_tutup'				=> $this->website->tanggal_input($this->request->getPost('tanggal_tutup')),
							'tanggal_pengumuman'		=> $this->website->tanggal_input($this->request->getPost('tanggal_pengumuman')),
							'status_gelombang'			=> $this->request->getPost('status_gelombang'),
							'gambar'					=> $judulbaru
						];
				$m_gelombang->tambah($data);
				// masuk database
				$this->session->setFlashdata('sukses','Data telah ditambah');
				return redirect()->to(base_url('admin/gelombang'));
			}else{
				// masuk database
				$slug 	= strtolower(url_title($this->request->getVar('judul')));
				$data = [	'id_user'					=> $this->session->get('id_user'),
							'tahun_ajaran'				=> $this->request->getPost('tahun_ajaran'),
							'tahap'						=> $tahap,
							'tahun'						=> $this->request->getPost('tahun'),
							'slug'						=> $slug,
							'judul'						=> $this->request->getPost('judul'),
							'isi'						=> $this->request->getPost('isi'),
							'tanggal_buka'				=> $this->website->tanggal_input($this->request->getPost('tanggal_buka')),
							'tanggal_tutup'				=> $this->website->tanggal_input($this->request->getPost('tanggal_tutup')),
							'tanggal_pengumuman'		=> $this->website->tanggal_input($this->request->getPost('tanggal_pengumuman')),
							'status_gelombang'			=> $this->request->getPost('status_gelombang')
						];
				$m_gelombang->tambah($data);
				// masuk database
				$this->session->setFlashdata('sukses','Data telah ditambah');
				return redirect()->to(base_url('admin/gelombang'));
			}
	    }else{
			$data = [	'title'				=> 'Tambah Periode SPMB',
						'gelombang'			=> $gelombang,
						'm_gelombang'		=> $m_gelombang,
						'nama_gelombang'	=> $nama_gelombang,
						'content'			=> 'admin/gelombang/tambah'
					];
			echo view('admin/layout/wrapper',$data);
		}
	}

	// edit
	public function edit($id_gelombang)
	{
		
		$m_gelombang 	= new Gelombang_model();
		$gelombang 	= $m_gelombang->detail($id_gelombang);

		// Start validasi
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'judul' 	=> 'required',
				'gambar'	 			=> [
								                'mime_in[gambar,image/jpg,image/jpeg,image/gif,image/png]',
								                'max_size[gambar,102400]',
			            					],
        	])) {
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  	= $this->request->getFile('gambar');
				$judulbaru 	= $avatar->getRandomName();
	            $avatar->move(WRITEPATH . '../assets/upload/image/',$judulbaru);
	            $this->compressImage(WRITEPATH . '../assets/upload/image/' . $judulbaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/image/'.$judulbaru)
			    ->fit(100, 100, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$judulbaru);
	        	// masuk database
	        	$slug 	= strtolower(url_title($this->request->getVar('judul')));
				$data = [	'id_gelombang'				=> $id_gelombang,
							'id_user'					=> $this->session->get('id_user'),
							'tahun_ajaran'				=> $this->request->getPost('tahun_ajaran'),
							'tahun'						=> $this->request->getPost('tahun'),
							'slug'						=> $slug,
							'judul'						=> $this->request->getPost('judul'),
							'isi'						=> $this->request->getPost('isi'),
							'tanggal_buka'				=> $this->website->tanggal_input($this->request->getPost('tanggal_buka')),
							'tanggal_tutup'				=> $this->website->tanggal_input($this->request->getPost('tanggal_tutup')),
							'tanggal_pengumuman'		=> $this->website->tanggal_input($this->request->getPost('tanggal_pengumuman')),
							'status_gelombang'			=> $this->request->getPost('status_gelombang'),
							'gambar'					=> $judulbaru
						];
				$m_gelombang->edit($data);
				// masuk database
				$this->session->setFlashdata('sukses','Data telah disimpan');
				return redirect()->to(base_url('admin/gelombang'));
			}else{
				// masuk database
				$slug 	= strtolower(url_title($this->request->getVar('judul')));
				$data = [	'id_gelombang'				=> $id_gelombang,
							'id_user'					=> $this->session->get('id_user'),
							'tahun_ajaran'				=> $this->request->getPost('tahun_ajaran'),
							'tahun'						=> $this->request->getPost('tahun'),
							'slug'						=> $slug,
							'judul'						=> $this->request->getPost('judul'),
							'isi'						=> $this->request->getPost('isi'),
							'tanggal_buka'				=> $this->website->tanggal_input($this->request->getPost('tanggal_buka')),
							'tanggal_tutup'				=> $this->website->tanggal_input($this->request->getPost('tanggal_tutup')),
							'tanggal_pengumuman'		=> $this->website->tanggal_input($this->request->getPost('tanggal_pengumuman')),
							'status_gelombang'			=> $this->request->getPost('status_gelombang')
						];
				$m_gelombang->edit($data);
				// masuk database
				$this->session->setFlashdata('sukses','Data telah disimpan');
				return redirect()->to(base_url('admin/gelombang'));
			}
	    }else{
			$data = [	'title'			=> 'Edit Periode Pendaftaran SPMB: '.$gelombang->judul,
						'gelombang'=> $gelombang,
						'content'		=> 'admin/gelombang/edit'
					];
			echo view('admin/layout/wrapper',$data);
		}
	}

	// biodata
	public function biodata($id_gelombang)
	{
		$m_konfigurasi 			= new Konfigurasi_model();
		$m_akun 				= new Akun_model();
		$m_siswa 				= new Siswa_model();
		$m_program_pendidikan 	= new Program_pendidikan_model();
		$m_gelombang 			= new Gelombang_model();
		$m_nav 					= new Nav_model();

		$konfigurasi 			= $m_konfigurasi->listing();
		$id_akun 				= $this->session->get('id_akun');
		$akun 					= $m_akun->detail($id_akun);
		$program_pendidikan 	= $m_nav->program_pendidikan();
		$gelombang 				= $m_gelombang->detail($id_gelombang);
		
		$siswa 			= $m_siswa->last_id();
		if($siswa) {
			$urutan = $siswa->id_siswa+1;
		}else{
			$urutan = 1;
		}

		// Start validasi
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'nama_siswa' 	=> 'required',
				'gambar'	 	=> [
					                'ext_in[gambar,jpg,jpeg,gif,png,svg]',
					                'max_size[gambar,102400]',
            					],
        	])) {

			if($this->request->getPost('identitas_wali')=='Ayah') {
				$id_agama_wali 		= $this->request->getPost('id_agama_ayah');
				$id_pekerjaan_wali 	= $this->request->getPost('id_pekerjaan_ayah');
				$id_jenjang_wali	= $this->request->getPost('id_jenjang_ayah');
				$nama_wali			= $this->request->getPost('nama_ayah');
				$alamat_wali 		= $this->request->getPost('alamat_ayah');
				$telepon_wali		= $this->request->getPost('telepon_ayah');
			}elseif($this->request->getPost('identitas_wali')=='Ibu') {
				$id_agama_wali 		= $this->request->getPost('id_agama_ibu');
				$id_pekerjaan_wali 	= $this->request->getPost('id_pekerjaan_ibu');
				$id_jenjang_wali	= $this->request->getPost('id_jenjang_ibu');
				$nama_wali			= $this->request->getPost('nama_ibu');
				$alamat_wali 		= $this->request->getPost('alamat_ibu');
				$telepon_wali		= $this->request->getPost('telepon_ibu');
			}else{
				$id_agama_wali 		= $this->request->getPost('id_agama_wali');
				$id_pekerjaan_wali 	= $this->request->getPost('id_pekerjaan_wali');
				$id_jenjang_wali	= $this->request->getPost('id_jenjang_wali');
				$nama_wali			= $this->request->getPost('nama_wali');
				$alamat_wali 		= $this->request->getPost('alamat_wali');
				$telepon_wali		= $this->request->getPost('telepon_wali');
			}
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  					= $this->request->getFile('gambar');
				$nama_siswabaru 	= $avatar->getRandomName();
	            $avatar->move(WRITEPATH . '../assets/upload/image/',$nama_siswabaru);
	            $this->compressImage(WRITEPATH . '../assets/upload/image/' . $nama_siswabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/image/'.$nama_siswabaru)
			    ->fit(100, 100, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$nama_siswabaru);
	        	// masuk database
	        	$slug_siswa 	= strtolower(url_title($this->request->getVar('nama_siswa'))).'-'.strtoupper(random_string('alnum', 8));
				$data = [	'id_user'				=> $this->session->get('id_user'),
							'id_gelombang'			=> $id_gelombang,
							'id_agama'				=> $this->request->getPost('id_agama'),
							'id_agama_ayah'			=> $this->request->getPost('id_agama_ayah'),
							'id_agama_ibu'			=> $this->request->getPost('id_agama_ibu'),
							'id_agama_wali'			=> $id_agama_wali,
							'id_pekerjaan_ayah'		=> $this->request->getPost('id_pekerjaan_ayah'),
							'id_pekerjaan_ibu'		=> $this->request->getPost('id_pekerjaan_ibu'),
							'id_pekerjaan_wali'		=> $id_pekerjaan_wali,
							'id_jenjang_ayah'		=> $this->request->getPost('id_jenjang_ayah'),
							'id_jenjang_ibu'		=> $this->request->getPost('id_jenjang_ibu'),
							'id_jenjang_wali'		=> $id_jenjang_wali,
							'id_tahun'				=> $this->request->getPost('id_tahun'),
							'id_kelas'				=> $this->request->getPost('id_kelas'),
							'id_jenjang'			=> $this->request->getPost('id_jenjang'),
							'id_hubungan'			=> $this->request->getPost('id_hubungan'),
							'id_akun'				=> $akun->id_akun,
							'id_program_pendidikan'	=> $this->request->getPost('id_program_pendidikan'),
							'kode_siswa'			=> strtoupper(random_string('alnum', 8)),
							'slug_siswa'			=> $slug_siswa,
							'nis'					=> $this->request->getPost('nis'),
							'nisn'					=> $this->request->getPost('nisn'),
							'status_wn'				=> $this->request->getPost('status_wn'),
							'negara_asal'			=> $this->request->getPost('negara_asal'),
							'nama_siswa'			=> $this->request->getPost('nama_siswa'),
							'nama_panggilan'		=> $this->request->getPost('nama_panggilan'),
							'tempat_lahir'			=> $this->request->getPost('tempat_lahir'),
							'tanggal_lahir'			=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir')),
							'alamat'				=> $this->request->getPost('alamat'),
							'telepon'				=> $this->request->getPost('telepon'),
							'kode_pos'				=> $this->request->getPost('kode_pos'),
							'website'				=> $this->request->getPost('website'),
							'email'					=> $this->request->getPost('email'),
							'jenis_kelamin'			=> $this->request->getPost('jenis_kelamin'),
							'berkebutuhan_khusus'	=> $this->request->getPost('berkebutuhan_khusus'),
							'isi'					=> $this->request->getPost('isi'),
							'nama_ayah'				=> $this->request->getPost('nama_ayah'),
							'nama_ibu'				=> $this->request->getPost('nama_ibu'),
							'nama_wali'				=> $nama_wali,
							'alamat_ayah'			=> $this->request->getPost('alamat_ayah'),
							'alamat_ibu'			=> $this->request->getPost('alamat_ibu'),
							'alamat_wali'			=> $alamat_wali,
							'telepon_ayah'			=> $this->request->getPost('telepon_ayah'),
							'telepon_ibu'			=> $this->request->getPost('telepon_ibu'),
							'telepon_wali'			=> $telepon_wali,
							'goldar_siswa'			=> $this->request->getPost('goldar_siswa'),
							'hobi_siswa'			=> $this->request->getPost('hobi_siswa'),
							'penyakit_siswa'		=> $this->request->getPost('penyakit_siswa'),
							'tinggi'				=> $this->request->getPost('tinggi'),
							'berat'					=> $this->request->getPost('berat'),
							'kelompok'				=> $this->request->getPost('kelompok'),
							'tanggal_masuk'			=> $this->website->tanggal_input($this->request->getPost('tanggal_masuk')),
							'jenis_siswa'			=> $this->request->getPost('jenis_siswa'),
							'asal_sekolah'			=> $this->request->getPost('asal_sekolah'),
							'alamat_sekolah_asal'	=> $this->request->getPost('alamat_sekolah_asal'),
							'dari_kelompok'			=> $this->request->getPost('dari_kelompok'),
							'tanggal_pindah'		=> $this->website->tanggal_input($this->request->getPost('tanggal_pindah')),
							'anak_ke'				=> $this->request->getPost('anak_ke'),
							'jumlah_saudara'		=> $this->request->getPost('jumlah_saudara'),
							'gambar'				=> $nama_siswabaru,
							'status_siswa'			=> 'Menunggu',
							'status_pendaftaran'	=> $this->request->getPost('status_pendaftaran'),
							'identitas_wali'		=> $this->request->getPost('identitas_wali'),
							'tanggal_baca'			=> date('Y-m-d H:i:s'),
							'tanggal_post'			=> date('Y-m-d H:i:s')
						];
				$m_siswa->tambah($data);
				// masuk database
				$this->session->setFlashdata('sukses','Data telah ditambah');
				return redirect()->to(base_url('admin/gelombang/dokumen/'.$slug_siswa));
			}else{
				// masuk database
				$slug_siswa 	= strtolower(url_title($this->request->getVar('nama_siswa'))).'-'.strtoupper(random_string('alnum', 8));
				$data = [	'id_user'				=> $this->session->get('id_user'),
							'id_gelombang'			=> $id_gelombang,
							'id_agama'				=> $this->request->getPost('id_agama'),
							'id_agama_ayah'			=> $this->request->getPost('id_agama_ayah'),
							'id_agama_ibu'			=> $this->request->getPost('id_agama_ibu'),
							'id_agama_wali'			=> $id_agama_wali,
							'id_pekerjaan_ayah'		=> $this->request->getPost('id_pekerjaan_ayah'),
							'id_pekerjaan_ibu'		=> $this->request->getPost('id_pekerjaan_ibu'),
							'id_pekerjaan_wali'		=> $id_pekerjaan_wali,
							'id_jenjang_ayah'		=> $this->request->getPost('id_jenjang_ayah'),
							'id_jenjang_ibu'		=> $this->request->getPost('id_jenjang_ibu'),
							'id_jenjang_wali'		=> $id_jenjang_wali,
							'id_tahun'				=> $this->request->getPost('id_tahun'),
							'id_kelas'				=> $this->request->getPost('id_kelas'),
							'id_jenjang'			=> $this->request->getPost('id_jenjang'),
							'id_hubungan'			=> $this->request->getPost('id_hubungan'),
							'id_akun'				=> $akun->id_akun,
							'id_program_pendidikan'	=> $this->request->getPost('id_program_pendidikan'),
							'kode_siswa'			=> strtoupper(random_string('alnum', 8)),
							'slug_siswa'			=> $slug_siswa,
							'nis'					=> $this->request->getPost('nis'),
							'nisn'					=> $this->request->getPost('nisn'),
							'status_wn'				=> $this->request->getPost('status_wn'),
							'negara_asal'			=> $this->request->getPost('negara_asal'),
							'nama_siswa'			=> $this->request->getPost('nama_siswa'),
							'nama_panggilan'		=> $this->request->getPost('nama_panggilan'),
							'tempat_lahir'			=> $this->request->getPost('tempat_lahir'),
							'tanggal_lahir'			=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir')),
							'alamat'				=> $this->request->getPost('alamat'),
							'telepon'				=> $this->request->getPost('telepon'),
							'kode_pos'				=> $this->request->getPost('kode_pos'),
							'website'				=> $this->request->getPost('website'),
							'email'					=> $this->request->getPost('email'),
							'jenis_kelamin'			=> $this->request->getPost('jenis_kelamin'),
							'berkebutuhan_khusus'	=> $this->request->getPost('berkebutuhan_khusus'),
							'isi'					=> $this->request->getPost('isi'),
							'nama_ayah'				=> $this->request->getPost('nama_ayah'),
							'nama_ibu'				=> $this->request->getPost('nama_ibu'),
							'nama_wali'				=> $nama_wali,
							'alamat_ayah'			=> $this->request->getPost('alamat_ayah'),
							'alamat_ibu'			=> $this->request->getPost('alamat_ibu'),
							'alamat_wali'			=> $alamat_wali,
							'telepon_ayah'			=> $this->request->getPost('telepon_ayah'),
							'telepon_ibu'			=> $this->request->getPost('telepon_ibu'),
							'telepon_wali'			=> $telepon_wali,
							'goldar_siswa'			=> $this->request->getPost('goldar_siswa'),
							'hobi_siswa'			=> $this->request->getPost('hobi_siswa'),
							'penyakit_siswa'		=> $this->request->getPost('penyakit_siswa'),
							'tinggi'				=> $this->request->getPost('tinggi'),
							'berat'					=> $this->request->getPost('berat'),
							'kelompok'				=> $this->request->getPost('kelompok'),
							'tanggal_masuk'			=> $this->website->tanggal_input($this->request->getPost('tanggal_masuk')),
							'jenis_siswa'			=> $this->request->getPost('jenis_siswa'),
							'asal_sekolah'			=> $this->request->getPost('asal_sekolah'),
							'alamat_sekolah_asal'	=> $this->request->getPost('alamat_sekolah_asal'),
							'dari_kelompok'			=> $this->request->getPost('dari_kelompok'),
							'tanggal_pindah'		=> $this->website->tanggal_input($this->request->getPost('tanggal_pindah')),
							'anak_ke'				=> $this->request->getPost('anak_ke'),
							'jumlah_saudara'		=> $this->request->getPost('jumlah_saudara'),
							// 'gambar'				=> $nama_siswabaru,
							'status_siswa'			=> 'Menunggu',
							'status_pendaftaran'	=> $this->request->getPost('status_pendaftaran'),
							'identitas_wali'		=> $this->request->getPost('identitas_wali'),
							'tanggal_baca'			=> date('Y-m-d H:i:s'),
							'tanggal_post'			=> date('Y-m-d H:i:s')
						];
				// masuk database
				$m_siswa->tambah($data);
				$this->session->setFlashdata('sukses','Data telah ditambah');
				return redirect()->to(base_url('admin/gelombang/dokumen/'.$slug_siswa));
			}
	    }else{

			$data = [	'title'			=> 'Isi Biodata Calon Siswa',
						'description'	=> 'Isi Data Siswa Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->tentang,
						'keywords'		=> 'Isi Data Siswa Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->keywords,
						'konfigurasi'	=> $konfigurasi,
						'akun'			=> $akun,
						'program_pendidikan'	=> $program_pendidikan,
						'gelombang'		=> $gelombang,
						'content'		=> 'admin/gelombang/biodata'
					];
			echo view('admin/layout/wrapper',$data);
		}
	}

	// edit
	public function edit_siswa($slug_siswa)
	{
		$m_konfigurasi 			= new Konfigurasi_model();
		$m_akun 				= new Akun_model();
		$m_siswa 				= new Siswa_model();
		$m_program_pendidikan 	= new Program_pendidikan_model();
		$m_gelombang 			= new Gelombang_model();
		$m_nav 					= new Nav_model();

		$siswa 					= $m_siswa->read($slug_siswa);
		$id_gelombang 			= $siswa->id_gelombang;
		$konfigurasi 			= $m_konfigurasi->listing();
		$id_akun 				= $siswa->id_akun;
		$akun 					= $m_akun->detail($id_akun);
		$program_pendidikan 	= $m_nav->program_pendidikan();
		$gelombang 				= $m_gelombang->detail($id_gelombang);
		
		$last_siswa 	= $m_siswa->last_id();
		if($last_siswa) {
			$urutan = $last_siswa->id_siswa+1;
		}else{
			$urutan = 1;
		}

		// Start validasi
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'nama_siswa' 	=> 'required',
				'gambar'	 	=> [
					                'ext_in[gambar,jpg,jpeg,gif,png,svg]',
					                'max_size[gambar,102400]',
            					],
        	])) {

			if($this->request->getPost('identitas_wali')=='Ayah') {
				$id_agama_wali 		= $this->request->getPost('id_agama_ayah');
				$id_pekerjaan_wali 	= $this->request->getPost('id_pekerjaan_ayah');
				$id_jenjang_wali	= $this->request->getPost('id_jenjang_ayah');
				$nama_wali			= $this->request->getPost('nama_ayah');
				$alamat_wali 		= $this->request->getPost('alamat_ayah');
				$telepon_wali		= $this->request->getPost('telepon_ayah');
			}elseif($this->request->getPost('identitas_wali')=='Ibu') {
				$id_agama_wali 		= $this->request->getPost('id_agama_ibu');
				$id_pekerjaan_wali 	= $this->request->getPost('id_pekerjaan_ibu');
				$id_jenjang_wali	= $this->request->getPost('id_jenjang_ibu');
				$nama_wali			= $this->request->getPost('nama_ibu');
				$alamat_wali 		= $this->request->getPost('alamat_ibu');
				$telepon_wali		= $this->request->getPost('telepon_ibu');
			}else{
				$id_agama_wali 		= $this->request->getPost('id_agama_wali');
				$id_pekerjaan_wali 	= $this->request->getPost('id_pekerjaan_wali');
				$id_jenjang_wali	= $this->request->getPost('id_jenjang_wali');
				$nama_wali			= $this->request->getPost('nama_wali');
				$alamat_wali 		= $this->request->getPost('alamat_wali');
				$telepon_wali		= $this->request->getPost('telepon_wali');
			}
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  					= $this->request->getFile('gambar');
				$nama_siswabaru 	= $avatar->getRandomName();
	            $avatar->move(WRITEPATH . '../assets/upload/image/',$nama_siswabaru);
	            $this->compressImage(WRITEPATH . '../assets/upload/image/' . $nama_siswabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/image/'.$nama_siswabaru)
			    ->fit(100, 100, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$nama_siswabaru);
	        	// masuk database
	        	$slug_siswa 	= strtolower(url_title($this->request->getVar('nama_siswa'))).'-'.strtoupper(random_string('alnum', 8));
				$data = [	'id_siswa'				=> $siswa->id_siswa,
							'id_user'				=> $this->session->get('id_user'),
							'id_gelombang'			=> $id_gelombang,
							'id_agama'				=> $this->request->getPost('id_agama'),
							'id_agama_ayah'			=> $this->request->getPost('id_agama_ayah'),
							'id_agama_ibu'			=> $this->request->getPost('id_agama_ibu'),
							'id_agama_wali'			=> $id_agama_wali,
							'id_pekerjaan_ayah'		=> $this->request->getPost('id_pekerjaan_ayah'),
							'id_pekerjaan_ibu'		=> $this->request->getPost('id_pekerjaan_ibu'),
							'id_pekerjaan_wali'		=> $id_pekerjaan_wali,
							'id_jenjang_ayah'		=> $this->request->getPost('id_jenjang_ayah'),
							'id_jenjang_ibu'		=> $this->request->getPost('id_jenjang_ibu'),
							'id_jenjang_wali'		=> $id_jenjang_wali,
							'id_tahun'				=> $this->request->getPost('id_tahun'),
							'id_kelas'				=> $this->request->getPost('id_kelas'),
							'id_jenjang'			=> $this->request->getPost('id_jenjang'),
							'id_hubungan'			=> $this->request->getPost('id_hubungan'),
							'id_akun'				=> $akun->id_akun,
							'id_program_pendidikan'	=> $this->request->getPost('id_program_pendidikan'),
							// 'kode_siswa'			=> strtoupper(random_string('alnum', 8)),
							// 'slug_siswa'			=> $slug_siswa,
							'nis'					=> $this->request->getPost('nis'),
							'nisn'					=> $this->request->getPost('nisn'),
							'status_wn'				=> $this->request->getPost('status_wn'),
							'negara_asal'			=> $this->request->getPost('negara_asal'),
							'nama_siswa'			=> $this->request->getPost('nama_siswa'),
							'nama_panggilan'		=> $this->request->getPost('nama_panggilan'),
							'tempat_lahir'			=> $this->request->getPost('tempat_lahir'),
							'tanggal_lahir'			=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir')),
							'alamat'				=> $this->request->getPost('alamat'),
							'telepon'				=> $this->request->getPost('telepon'),
							'kode_pos'				=> $this->request->getPost('kode_pos'),
							'website'				=> $this->request->getPost('website'),
							'email'					=> $this->request->getPost('email'),
							'jenis_kelamin'			=> $this->request->getPost('jenis_kelamin'),
							'berkebutuhan_khusus'	=> $this->request->getPost('berkebutuhan_khusus'),
							'isi'					=> $this->request->getPost('isi'),
							'nama_ayah'				=> $this->request->getPost('nama_ayah'),
							'nama_ibu'				=> $this->request->getPost('nama_ibu'),
							'nama_wali'				=> $nama_wali,
							'alamat_ayah'			=> $this->request->getPost('alamat_ayah'),
							'alamat_ibu'			=> $this->request->getPost('alamat_ibu'),
							'alamat_wali'			=> $alamat_wali,
							'telepon_ayah'			=> $this->request->getPost('telepon_ayah'),
							'telepon_ibu'			=> $this->request->getPost('telepon_ibu'),
							'telepon_wali'			=> $telepon_wali,
							'goldar_siswa'			=> $this->request->getPost('goldar_siswa'),
							'hobi_siswa'			=> $this->request->getPost('hobi_siswa'),
							'penyakit_siswa'		=> $this->request->getPost('penyakit_siswa'),
							'tinggi'				=> $this->request->getPost('tinggi'),
							'berat'					=> $this->request->getPost('berat'),
							'kelompok'				=> $this->request->getPost('kelompok'),
							'tanggal_masuk'			=> $this->website->tanggal_input($this->request->getPost('tanggal_masuk')),
							'jenis_siswa'			=> $this->request->getPost('jenis_siswa'),
							'asal_sekolah'			=> $this->request->getPost('asal_sekolah'),
							'alamat_sekolah_asal'	=> $this->request->getPost('alamat_sekolah_asal'),
							'dari_kelompok'			=> $this->request->getPost('dari_kelompok'),
							'tanggal_pindah'		=> $this->website->tanggal_input($this->request->getPost('tanggal_pindah')),
							'anak_ke'				=> $this->request->getPost('anak_ke'),
							'jumlah_saudara'		=> $this->request->getPost('jumlah_saudara'),
							'gambar'				=> $nama_siswabaru,
							'identitas_wali'		=> $this->request->getPost('identitas_wali'),
							'status_pendaftaran'	=> $this->request->getPost('status_pendaftaran')
						];
				$m_siswa->edit($data);
				$this->session->setFlashdata('sukses','Data telah diupdate');
				return redirect()->to(base_url('admin/gelombang/detail/'.$siswa->id_gelombang.'/'.$this->request->getPost('status_pendaftaran')));
			}else{
				// masuk database
				$slug_siswa 	= strtolower(url_title($this->request->getVar('nama_siswa'))).'-'.strtoupper(random_string('alnum', 8));
				$data = [	'id_siswa'				=> $siswa->id_siswa,
							'id_user'				=> $this->session->get('id_user'),
							'id_gelombang'			=> $id_gelombang,
							'id_agama'				=> $this->request->getPost('id_agama'),
							'id_agama_ayah'			=> $this->request->getPost('id_agama_ayah'),
							'id_agama_ibu'			=> $this->request->getPost('id_agama_ibu'),
							'id_agama_wali'			=> $id_agama_wali,
							'id_pekerjaan_ayah'		=> $this->request->getPost('id_pekerjaan_ayah'),
							'id_pekerjaan_ibu'		=> $this->request->getPost('id_pekerjaan_ibu'),
							'id_pekerjaan_wali'		=> $id_pekerjaan_wali,
							'id_jenjang_ayah'		=> $this->request->getPost('id_jenjang_ayah'),
							'id_jenjang_ibu'		=> $this->request->getPost('id_jenjang_ibu'),
							'id_jenjang_wali'		=> $id_jenjang_wali,
							'id_tahun'				=> $this->request->getPost('id_tahun'),
							'id_kelas'				=> $this->request->getPost('id_kelas'),
							'id_jenjang'			=> $this->request->getPost('id_jenjang'),
							'id_hubungan'			=> $this->request->getPost('id_hubungan'),
							'id_akun'				=> $akun->id_akun,
							'id_program_pendidikan'	=> $this->request->getPost('id_program_pendidikan'),
							// 'kode_siswa'			=> strtoupper(random_string('alnum', 8)),
							// 'slug_siswa'			=> $slug_siswa,
							'nis'					=> $this->request->getPost('nis'),
							'nisn'					=> $this->request->getPost('nisn'),
							'status_wn'				=> $this->request->getPost('status_wn'),
							'negara_asal'			=> $this->request->getPost('negara_asal'),
							'nama_siswa'			=> $this->request->getPost('nama_siswa'),
							'nama_panggilan'		=> $this->request->getPost('nama_panggilan'),
							'tempat_lahir'			=> $this->request->getPost('tempat_lahir'),
							'tanggal_lahir'			=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir')),
							'alamat'				=> $this->request->getPost('alamat'),
							'telepon'				=> $this->request->getPost('telepon'),
							'kode_pos'				=> $this->request->getPost('kode_pos'),
							'website'				=> $this->request->getPost('website'),
							'email'					=> $this->request->getPost('email'),
							'jenis_kelamin'			=> $this->request->getPost('jenis_kelamin'),
							'berkebutuhan_khusus'	=> $this->request->getPost('berkebutuhan_khusus'),
							'isi'					=> $this->request->getPost('isi'),
							'nama_ayah'				=> $this->request->getPost('nama_ayah'),
							'nama_ibu'				=> $this->request->getPost('nama_ibu'),
							'nama_wali'				=> $nama_wali,
							'alamat_ayah'			=> $this->request->getPost('alamat_ayah'),
							'alamat_ibu'			=> $this->request->getPost('alamat_ibu'),
							'alamat_wali'			=> $alamat_wali,
							'telepon_ayah'			=> $this->request->getPost('telepon_ayah'),
							'telepon_ibu'			=> $this->request->getPost('telepon_ibu'),
							'telepon_wali'			=> $telepon_wali,
							'goldar_siswa'			=> $this->request->getPost('goldar_siswa'),
							'hobi_siswa'			=> $this->request->getPost('hobi_siswa'),
							'penyakit_siswa'		=> $this->request->getPost('penyakit_siswa'),
							'tinggi'				=> $this->request->getPost('tinggi'),
							'berat'					=> $this->request->getPost('berat'),
							'kelompok'				=> $this->request->getPost('kelompok'),
							'tanggal_masuk'			=> $this->website->tanggal_input($this->request->getPost('tanggal_masuk')),
							'jenis_siswa'			=> $this->request->getPost('jenis_siswa'),
							'asal_sekolah'			=> $this->request->getPost('asal_sekolah'),
							'alamat_sekolah_asal'	=> $this->request->getPost('alamat_sekolah_asal'),
							'dari_kelompok'			=> $this->request->getPost('dari_kelompok'),
							'tanggal_pindah'		=> $this->website->tanggal_input($this->request->getPost('tanggal_pindah')),
							'anak_ke'				=> $this->request->getPost('anak_ke'),
							'jumlah_saudara'		=> $this->request->getPost('jumlah_saudara'),
							'identitas_wali'		=> $this->request->getPost('identitas_wali'),
							'status_pendaftaran'	=> $this->request->getPost('status_pendaftaran')
						];
				// masuk database
				$m_siswa->edit($data);
				$this->session->setFlashdata('sukses','Data telah diupdate');
				return redirect()->to(base_url('admin/gelombang/detail/'.$siswa->id_gelombang.'/'.$this->request->getPost('status_pendaftaran')));
			}
	    }else{

			$data = [	'title'			=> 'Update Biodata Calon Siswa',
						'description'	=> 'Update Data Siswa Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->tentang,
						'keywords'		=> 'Update Data Siswa Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->keywords,
						'konfigurasi'	=> $konfigurasi,
						'akun'			=> $akun,
						'program_pendidikan'	=> $program_pendidikan,
						'gelombang'		=> $gelombang,
						'siswa'		=> $siswa,
						'content'		=> 'admin/gelombang/edit_siswa'
					];
			echo view('admin/layout/wrapper',$data);
		}
	}

	// review
	public function review($slug_siswa)
	{
		$m_konfigurasi 		= new Konfigurasi_model();
		$m_akun 			= new Akun_model();
		$m_jenis_dokumen 	= new Jenis_dokumen_model();
		$m_siswa 			= new Siswa_model();
		$m_dokumen 			= new Dokumen_model();

		$konfigurasi 		= $m_konfigurasi->listing();
		$siswa 				= $m_siswa->read($slug_siswa);
		$jenis_dokumen 		= $m_jenis_dokumen->listing();
		$akun 				= $m_akun->detail($siswa->id_akun);

		$data = [	'title'				=> 'Review Pendaftar',
					'description'		=> 'Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->tentang,
					'keywords'			=> 'Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->keywords,
					'konfigurasi'		=> $konfigurasi,
					'akun'				=> $akun,
					'jenis_dokumen'		=> $jenis_dokumen,
					'siswa'				=> $siswa,
					'm_dokumen'			=> $m_dokumen,
					'content'			=> 'admin/gelombang/review'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// dokumen
	public function dokumen($slug_siswa)
	{
		$m_konfigurasi 		= new Konfigurasi_model();
		$m_akun 			= new Akun_model();
		$m_jenis_dokumen 	= new Jenis_dokumen_model();
		$m_siswa 			= new Siswa_model();
		$m_dokumen 			= new Dokumen_model();

		$konfigurasi 		= $m_konfigurasi->listing();
		$siswa 				= $m_siswa->read($slug_siswa);
		$jenis_dokumen 		= $m_jenis_dokumen->listing();
		$akun 				= $m_akun->detail($siswa->id_akun);

		// proses update
		if(isset($_POST['status'])) {
			$status_baru = $this->request->getPost('status_pendaftaran');
			$data = [	'id_siswa'				=> $siswa->id_siswa,
						'id_user'				=> $this->session->get('id_user'),						
						'status_pendaftaran'	=> $status_baru
					];

			if ($siswa && ($status_baru == 'Diterima' || $status_baru == 'Tidak-Diterima')) {
				$data['email_pengumuman_sent'] = 1;

				$emailData = [
					'nama_siswa'         => $siswa->nama_siswa,
					'kode_siswa'         => $siswa->kode_siswa,
					'program'            => $siswa->judul_program_pendidikan,
					'status_pendaftaran' => $status_baru,
					'namaweb'            => $konfigurasi->namaweb,
					'link_login'         => base_url('signin')
				];
				$htmlMessage = view('email_templates/pengumuman_kelulusan', $emailData);
				$recipientEmail = !empty($siswa->email_akun) ? $siswa->email_akun : $siswa->email;
				if (!$this->sendEmail($recipientEmail, 'Pengumuman Hasil Seleksi SPMB - ' . $konfigurasi->namaweb, $htmlMessage)) {
					$email_service = \Config\Services::email();
					log_message('error', 'Gagal mengirim email pengumuman kelulusan ke ' . $recipientEmail . '. Detail: ' . $email_service->printDebugger(['headers', 'subject', 'body']));
				}
			}

			// masuk database
			$m_siswa->edit($data);
			$this->logActivity('SPMB', 'Mengubah status pendaftaran siswa: ' . $siswa->nama_siswa . ' menjadi ' . $status_baru);
			$this->session->setFlashdata('sukses','Data telah diupdate');
			return redirect()->to(base_url('admin/gelombang/dokumen/'.$siswa->slug_siswa));
		}
		// proses update verifikasi dokumen individu
		if(isset($_POST['verifikasi_dokumen'])) {
			$id_dokumen = $this->request->getPost('id_dokumen');
			$status_verifikasi = $this->request->getPost('status_verifikasi');
			$catatan_verifikasi = $this->request->getPost('catatan_verifikasi');

			$doc_detail = $m_dokumen->detail($id_dokumen);
			$doc_name = $doc_detail ? $doc_detail->nama_jenis_dokumen : 'Dokumen ID: ' . $id_dokumen;

			$m_dokumen->edit([
				'id_dokumen' => $id_dokumen,
				'status_verifikasi' => $status_verifikasi,
				'catatan_verifikasi' => $catatan_verifikasi
			]);

			$this->logActivity('SPMB', 'Memverifikasi dokumen (' . $doc_name . ') milik siswa: ' . $siswa->nama_siswa . ' dengan status: ' . $status_verifikasi);
			$this->session->setFlashdata('sukses','Status verifikasi dokumen berhasil diupdate');
			return redirect()->to(base_url('admin/gelombang/dokumen/'.$siswa->slug_siswa));
		}
		// end update
		// Start tambah
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'id_jenis_dokumen' => 'required',
				'gambar'	 	=> [
									'uploaded[gambar]',
					                'ext_in[gambar,jpg,jpeg,png,gif,zip,rar,doc,docx,xls,xlsx,ppt,pptx,pdf]',
					                'max_size[gambar,102400]',
            					],
        	])) {
			// Image upload
			$avatar  	= $this->request->getFile('gambar');
			$namabaru 	= $avatar->getRandomName();
			$file_ext 	= $avatar->guessExtension();
			$file_size 	= $avatar->getSizeByUnit('mb');
            $avatar->move(WRITEPATH . '../assets/upload/pendaftaran/',$namabaru);
            $this->compressImage(WRITEPATH . '../assets/upload/pendaftaran/' . $namabaru);
        	// masuk database
		    $data = array(
        		'id_akun'				=> $akun->id_akun,
				'id_siswa'				=> $siswa->id_siswa,
				'id_jenis_dokumen'		=> $this->request->getVar('id_jenis_dokumen'),
				'kode_dokumen'			=> strtoupper(random_string('alnum', 32)),
				'gambar' 				=> $namabaru,
				'file_ext' 				=> $file_ext,
				'file_size' 			=> $file_size,
				'status_dokumen'		=> 'Menunggu',
				'tanggal_post'			=> date('Y-m-d H:i:s')
        	);
        	$m_dokumen->tambah($data);
    		return redirect()->to(base_url('admin/gelombang/dokumen/'.$slug_siswa))->with('sukses', 'Data Berhasil di Simpan');
		}else{

			$data = [	'title'				=> 'Unggah Dokumen',
						'description'		=> 'Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->tentang,
						'keywords'			=> 'Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->keywords,
						'konfigurasi'		=> $konfigurasi,
						'akun'				=> $akun,
						'jenis_dokumen'		=> $jenis_dokumen,
						'siswa'				=> $siswa,
						'm_dokumen'			=> $m_dokumen,
						'content'			=> 'admin/gelombang/dokumen'
					];
			echo view('admin/layout/wrapper',$data);
		}
	}

	// selesai
	public function selesai($slug_siswa)
	{
		$m_konfigurasi 		= new Konfigurasi_model();
		$m_akun 			= new Akun_model();
		$m_jenis_dokumen 	= new Jenis_dokumen_model();
		$m_siswa 			= new Siswa_model();
		$m_dokumen 			= new Dokumen_model();

		$konfigurasi 		= $m_konfigurasi->listing();
		$siswa 				= $m_siswa->read($slug_siswa);
		$jenis_dokumen 		= $m_jenis_dokumen->listing();
		$akun 				= $m_akun->detail($siswa->id_akun);

		$data = [	'title'				=> 'Pendaftaran Berhasil',
					'description'		=> 'Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->tentang,
					'keywords'			=> 'Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->keywords,
					'konfigurasi'		=> $konfigurasi,
					'akun'				=> $akun,
					'jenis_dokumen'		=> $jenis_dokumen,
					'siswa'				=> $siswa,
					'm_dokumen'			=> $m_dokumen,
					'content'			=> 'admin/gelombang/selesai'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// cetak
	public function cetak($slug_siswa)
	{
		$m_konfigurasi 		= new Konfigurasi_model();
		$m_akun 			= new Akun_model();
		$m_jenis_dokumen 	= new Jenis_dokumen_model();
		$m_siswa 			= new Siswa_model();
		$m_dokumen 			= new Dokumen_model();

		$konfigurasi 		= $m_konfigurasi->listing();
		$siswa 				= $m_siswa->read($slug_siswa);
		$jenis_dokumen 		= $m_jenis_dokumen->listing();
		$akun 				= $m_akun->detail($siswa->id_akun);

		$data = [	'title'				=> 'Pendaftaran Peserta Didik Baru - Pendaftaran Berhasil',
					'description'		=> 'Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->tentang,
					'keywords'			=> 'Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->keywords,
					'konfigurasi'		=> $konfigurasi,
					'akun'				=> $akun,
					'jenis_dokumen'		=> $jenis_dokumen,
					'siswa'				=> $siswa,
					'm_dokumen'			=> $m_dokumen,
					'content'			=> 'admin/gelombang/selesai'
				];
		// echo view('layout/wrapper',$data);
		$mpdf = new \Mpdf\Mpdf([
						'default_font_size' => 11,
						'default_font' => 'nunito-regular'
					]);
		$html = view('admin/gelombang/cetak',$data);
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		// buka di browser
		$mpdf->Output('Informasi-Pendaftaran-'.$siswa->nama_siswa.'.pdf','I'); 
	}

	// Unduh
	public function unduh($kode_dokumen,$kode_siswa)
	{
		$m_dokumen 			= new Dokumen_model();
		$dokumen 			= $m_dokumen->kode_dokumen($kode_dokumen);
		if(!file_exists('../assets/upload/pendaftaran/'.$dokumen->gambar)) {
			$this->session->setFlashdata('warning','Mohon maaf, file tidak ditemukan.');
			return redirect()->to(base_url('pendaftaran/dokumen/'.$kode_siswa));
		}else{
			return $this->response->download('../assets/upload/pendaftaran/'.$dokumen->gambar, null);
		}
	}

	// hapus
	public function hapus($kode_dokumen,$kode_siswa)
	{
		$m_dokumen = new Dokumen_model();
		$data = ['kode_dokumen'	=> $kode_dokumen];
		$m_dokumen->hapus($data);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('admin/gelombang/dokumen/'.$kode_siswa));
	}

	// hapus
	public function delete_siswa($slug_siswa,$id_gelombang)
	{
		$m_siswa = new Siswa_model();
		$id_akun 	= $this->session->get('id_akun');
		$data = ['slug_siswa'	=> $slug_siswa,
				'id_akun'		=> $id_akun];
		$m_siswa->hapus($data);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('admin/gelombang/detail/'.$id_gelombang));
	}

	// delete
	public function delete($id_gelombang)
	{
		
		$m_gelombang = new Gelombang_model();
		$data = ['id_gelombang'	=> $id_gelombang];
		$m_gelombang->delete($data);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('admin/gelombang'));
	}
}