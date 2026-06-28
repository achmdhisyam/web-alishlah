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

class Pendaftaran extends BaseController
{
	public function index()
	{
		$m_siswa 	= new Siswa_model();
		$id_akun 	= $this->session->get('id_akun');
		$siswa 		= $m_siswa->akun($id_akun);

		$data = [   'title'     		=> 'Data Pendaftaran Peserta Didik Baru (SPMB)',
					'description'   	=> 'Data Pendaftaran',
                    'keywords'      	=> 'Data Pendaftaran',
                    'siswa'				=> $siswa,
                    'm_jenis_dokumen'	=> new Jenis_dokumen_model(),
                    'm_dokumen'			=> new Dokumen_model(),
					'content'			=> 'siswa/pendaftaran/index'
                ];
        return view('siswa/layout/wrapper',$data);
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

		if(empty(Session()->get('username_siswa'))) {
			$this->session->setFlashdata('warning','Anda belum login');
			return redirect()->to(base_url('signin'));
		}

		// Cek jika sudah mendaftar
		$siswa_exist = $m_siswa->akun($id_akun);
		if($siswa_exist) {
			$this->session->setFlashdata('warning','Anda sudah pernah melakukan pendaftaran pada akun ini. Jika ingin mendaftar lagi, silakan buat akun baru.');
			return redirect()->to(base_url('siswa/pendaftaran'));
		}
		
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
					                'max_size[gambar,4096]',
            					],
        	])) {

			if($this->request->getPost('identitas_wali')=='Ayah') {
				$id_agama_wali 		= $this->request->getPost('id_agama_ayah');
				$id_pekerjaan_wali 	= $this->request->getPost('id_pekerjaan_ayah');
				$id_jenjang_wali	= $this->request->getPost('id_jenjang_ayah');
				$nama_wali			= $this->request->getPost('nama_ayah');
				$alamat_wali 		= $this->request->getPost('alamat_ayah');
				$telepon_wali		= $this->request->getPost('telepon_ayah');
				$rt_wali			= $this->request->getPost('rt_ayah');
				$rw_wali			= $this->request->getPost('rw_ayah');
				$kelurahan_wali		= $this->request->getPost('kelurahan_ayah');
				$kecamatan_wali		= $this->request->getPost('kecamatan_ayah');
				$kabupaten_wali		= $this->request->getPost('kabupaten_ayah');
				$provinsi_wali		= $this->request->getPost('provinsi_ayah');
				$kode_pos_wali		= $this->request->getPost('kode_pos_ayah');
				$tempat_lahir_wali	= $this->request->getPost('tempat_lahir_ayah');
				$tanggal_lahir_wali	= $this->request->getPost('tanggal_lahir_ayah');
				$status_wn_wali		= $this->request->getPost('status_wn_ayah');
				$penghasilan_wali	= $this->request->getPost('penghasilan_ayah');
			}elseif($this->request->getPost('identitas_wali')=='Ibu') {
				$id_agama_wali 		= $this->request->getPost('id_agama_ibu');
				$id_pekerjaan_wali 	= $this->request->getPost('id_pekerjaan_ibu');
				$id_jenjang_wali	= $this->request->getPost('id_jenjang_ibu');
				$nama_wali			= $this->request->getPost('nama_ibu');
				$alamat_wali 		= $this->request->getPost('alamat_ibu');
				$telepon_wali		= $this->request->getPost('telepon_ibu');
				$rt_wali			= $this->request->getPost('rt_ibu');
				$rw_wali			= $this->request->getPost('rw_ibu');
				$kelurahan_wali		= $this->request->getPost('kelurahan_ibu');
				$kecamatan_wali		= $this->request->getPost('kecamatan_ibu');
				$kabupaten_wali		= $this->request->getPost('kabupaten_ibu');
				$provinsi_wali		= $this->request->getPost('provinsi_ibu');
				$kode_pos_wali		= $this->request->getPost('kode_pos_ibu');
				$tempat_lahir_wali	= $this->request->getPost('tempat_lahir_ibu');
				$tanggal_lahir_wali	= $this->request->getPost('tanggal_lahir_ibu');
				$status_wn_wali		= $this->request->getPost('status_wn_ibu');
				$penghasilan_wali	= $this->request->getPost('penghasilan_ibu');
			}else{
				$id_agama_wali 		= $this->request->getPost('id_agama_wali');
				$id_pekerjaan_wali 	= $this->request->getPost('id_pekerjaan_wali');
				$id_jenjang_wali	= $this->request->getPost('id_jenjang_wali');
				$nama_wali			= $this->request->getPost('nama_wali');
				$alamat_wali 		= $this->request->getPost('alamat_wali');
				$telepon_wali		= $this->request->getPost('telepon_wali');
				$rt_wali			= $this->request->getPost('rt_wali');
				$rw_wali			= $this->request->getPost('rw_wali');
				$kelurahan_wali		= $this->request->getPost('kelurahan_wali');
				$kecamatan_wali		= $this->request->getPost('kecamatan_wali');
				$kabupaten_wali		= $this->request->getPost('kabupaten_wali');
				$provinsi_wali		= $this->request->getPost('provinsi_wali');
				$kode_pos_wali		= $this->request->getPost('kode_pos_wali');
				$tempat_lahir_wali	= $this->request->getPost('tempat_lahir_wali');
				$tanggal_lahir_wali	= $this->request->getPost('tanggal_lahir_wali');
				$status_wn_wali		= $this->request->getPost('status_wn_wali');
				$penghasilan_wali	= $this->request->getPost('penghasilan_wali');
			}

			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  					= $this->request->getFile('gambar');
				$nama_siswabaru 	= $avatar->getRandomName();
	            $avatar->move(WRITEPATH . '../assets/upload/image/',$nama_siswabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/image/'.$nama_siswabaru)
			    ->fit(100, 100, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$nama_siswabaru);
	        	// masuk database
	        	$slug_siswa 	= strtolower(url_title($this->request->getVar('nama_siswa'))).'-'.strtoupper(random_string('alnum', 8));
				$data = [							'id_user'				=> $this->session->get('id_user'),
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
							'email'					=> $this->request->getPost('email'),
							'nisn'					=> $this->request->getPost('nisn'),
							'status_wn'				=> $this->request->getPost('status_wn'),
							'nama_siswa'			=> $this->request->getPost('nama_siswa'),
							'nama_panggilan'		=> $this->request->getPost('nama_panggilan'),
							'tempat_lahir'			=> $this->request->getPost('tempat_lahir'),
							'tanggal_lahir'			=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir')),
							'alamat'				=> $this->request->getPost('alamat'),
							'rt'					=> $this->request->getPost('rt'),
							'rw'					=> $this->request->getPost('rw'),
							'kelurahan'				=> $this->request->getPost('kelurahan'),
							'kecamatan'				=> $this->request->getPost('kecamatan'),
							'kabupaten'				=> $this->request->getPost('kabupaten'),
							'provinsi'				=> $this->request->getPost('provinsi'),
							'kode_pos'				=> $this->request->getPost('kode_pos'),
							'telepon'				=> $this->request->getPost('telepon'),
							'jenis_kelamin'			=> $this->request->getPost('jenis_kelamin'),
							'nama_ayah'				=> $this->request->getPost('nama_ayah'),
							'tempat_lahir_ayah'		=> $this->request->getPost('tempat_lahir_ayah'),
							'tanggal_lahir_ayah'	=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir_ayah')),
							'status_wn_ayah'		=> $this->request->getPost('status_wn_ayah'),
							'penghasilan_ayah'		=> $this->request->getPost('penghasilan_ayah'),
							'status_hidup_ayah'		=> $this->request->getPost('status_hidup_ayah'),
							'nama_ibu'				=> $this->request->getPost('nama_ibu'),
							'tempat_lahir_ibu'		=> $this->request->getPost('tempat_lahir_ibu'),
							'tanggal_lahir_ibu'		=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir_ibu')),
							'status_wn_ibu'			=> $this->request->getPost('status_wn_ibu'),
							'penghasilan_ibu'		=> $this->request->getPost('penghasilan_ibu'),
							'status_hidup_ibu'		=> $this->request->getPost('status_hidup_ibu'),
							'nama_wali'				=> $nama_wali,
							'tempat_lahir_wali'		=> $tempat_lahir_wali,
							'tanggal_lahir_wali'	=> $this->website->tanggal_input($tanggal_lahir_wali),
							'status_wn_wali'		=> $status_wn_wali,
							'penghasilan_wali'		=> $penghasilan_wali,
							'alamat_ayah'			=> $this->request->getPost('alamat_ayah'),
							'rt_ayah'				=> $this->request->getPost('rt_ayah'),
							'rw_ayah'				=> $this->request->getPost('rw_ayah'),
							'kelurahan_ayah'		=> $this->request->getPost('kelurahan_ayah'),
							'kecamatan_ayah'		=> $this->request->getPost('kecamatan_ayah'),
							'kabupaten_ayah'		=> $this->request->getPost('kabupaten_ayah'),
							'provinsi_ayah'			=> $this->request->getPost('provinsi_ayah'),
							'kode_pos_ayah'			=> $this->request->getPost('kode_pos_ayah'),
							'alamat_ibu'			=> $this->request->getPost('alamat_ibu'),
							'rt_ibu'				=> $this->request->getPost('rt_ibu'),
							'rw_ibu'				=> $this->request->getPost('rw_ibu'),
							'kelurahan_ibu'			=> $this->request->getPost('kelurahan_ibu'),
							'kecamatan_ibu'			=> $this->request->getPost('kecamatan_ibu'),
							'kabupaten_ibu'			=> $this->request->getPost('kabupaten_ibu'),
							'provinsi_ibu'			=> $this->request->getPost('provinsi_ibu'),
							'kode_pos_ibu'			=> $this->request->getPost('kode_pos_ibu'),
							'alamat_wali'			=> $alamat_wali,
							'rt_wali'				=> $rt_wali,
							'rw_wali'				=> $rw_wali,
							'kelurahan_wali'		=> $kelurahan_wali,
							'kecamatan_wali'		=> $kecamatan_wali,
							'kabupaten_wali'		=> $kabupaten_wali,
							'provinsi_wali'			=> $provinsi_wali,
							'kode_pos_wali'			=> $kode_pos_wali,
							'telepon_ayah'			=> $this->request->getPost('telepon_ayah'),
							'telepon_ibu'			=> $this->request->getPost('telepon_ibu'),
							'telepon_wali'			=> $telepon_wali,
							'ukuran_seragam'		=> ($this->request->getPost('ukuran_seragam') == 'Lainnya') ? $this->request->getPost('ukuran_seragam_lainnya') : $this->request->getPost('ukuran_seragam'),
							'asal_sekolah'			=> $this->request->getPost('asal_sekolah'),
							'anak_ke'				=> $this->request->getPost('anak_ke'),
							'jumlah_saudara'		=> $this->request->getPost('jumlah_saudara'),
							'gambar'				=> $nama_siswabaru,
							'status_siswa'			=> 'Menunggu',
							'status_pendaftaran'	=> 'Menunggu',
							'identitas_wali'		=> $this->request->getPost('identitas_wali'),
							'tanggal_baca'			=> date('Y-m-d H:i:s'),
							'tanggal_post'			=> date('Y-m-d H:i:s')
						];
				$m_siswa->tambah($data);
				$siswa_baru_id = $this->db->insertID();

				// Kirim Push Notification OneSignal ke Admin
				$admins = $this->db->table('users')->select('id_user')->get()->getResult();
				$adminPushIds = [];
				foreach ($admins as $ad) {
					$adminPushIds[] = 'admin_' . $ad->id_user;
				}
				if (!empty($adminPushIds)) {
					send_push_notification(
						$adminPushIds,
						"Siswa baru bernama " . $this->request->getPost('nama_siswa') . " telah mendaftar online.",
						"Pendaftar Baru PPDB!",
						base_url('admin/siswa/detail/' . $siswa_baru_id)
					);
				}

				// Kirim notifikasi email ke Admin SPMB jika dikonfigurasi
				$emailAdmin = !empty($konfigurasi->email_admin_spmb) ? $konfigurasi->email_admin_spmb : $konfigurasi->email;
				if (!empty($emailAdmin)) {
					$linkKelola = base_url('admin/gelombang/dokumen/' . $slug_siswa);
					$programId = $this->request->getPost('id_program_pendidikan');
					$programObj = $programId ? $m_program_pendidikan->detail($programId) : null;
					$programNama = $programObj ? $programObj->judul_program_pendidikan : '-';

					$dataEmailAdmin = [
						'nama_siswa'  => $this->request->getPost('nama_siswa'),
						'nisn'        => $this->request->getPost('nisn'),
						'program'     => $programNama,
						'telepon'     => $this->request->getPost('telepon'),
						'link_kelola' => $linkKelola,
						'namaweb'     => $konfigurasi->namaweb
					];
					$messageAdmin = view('email_templates/pendaftar_baru_admin', $dataEmailAdmin);
					$this->sendEmail($emailAdmin, '📢 Pendaftar Baru SPMB - ' . $this->request->getPost('nama_siswa'), $messageAdmin);
				}
				// masuk database
				$this->session->setFlashdata('sukses','Data telah ditambah');
				return redirect()->to(base_url('siswa/pendaftaran/dokumen/'.$slug_siswa));
			}else{
				// masuk database
				$slug_siswa 	= strtolower(url_title($this->request->getVar('nama_siswa'))).'-'.strtoupper(random_string('alnum', 8));
				$data = [							'id_user'				=> $this->session->get('id_user'),
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
							'email'					=> $this->request->getPost('email'),
							'nisn'					=> $this->request->getPost('nisn'),
							'status_wn'				=> $this->request->getPost('status_wn'),
							'nama_siswa'			=> $this->request->getPost('nama_siswa'),
							'nama_panggilan'		=> $this->request->getPost('nama_panggilan'),
							'tempat_lahir'			=> $this->request->getPost('tempat_lahir'),
							'tanggal_lahir'			=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir')),
							'alamat'				=> $this->request->getPost('alamat'),
							'rt'					=> $this->request->getPost('rt'),
							'rw'					=> $this->request->getPost('rw'),
							'kelurahan'				=> $this->request->getPost('kelurahan'),
							'kecamatan'				=> $this->request->getPost('kecamatan'),
							'kabupaten'				=> $this->request->getPost('kabupaten'),
							'provinsi'				=> $this->request->getPost('provinsi'),
							'kode_pos'				=> $this->request->getPost('kode_pos'),
							'telepon'				=> $this->request->getPost('telepon'),
							'jenis_kelamin'			=> $this->request->getPost('jenis_kelamin'),
							'nama_ayah'				=> $this->request->getPost('nama_ayah'),
							'tempat_lahir_ayah'		=> $this->request->getPost('tempat_lahir_ayah'),
							'tanggal_lahir_ayah'	=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir_ayah')),
							'status_wn_ayah'		=> $this->request->getPost('status_wn_ayah'),
							'penghasilan_ayah'		=> $this->request->getPost('penghasilan_ayah'),
							'status_hidup_ayah'		=> $this->request->getPost('status_hidup_ayah'),
							'nama_ibu'				=> $this->request->getPost('nama_ibu'),
							'tempat_lahir_ibu'		=> $this->request->getPost('tempat_lahir_ibu'),
							'tanggal_lahir_ibu'		=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir_ibu')),
							'status_wn_ibu'			=> $this->request->getPost('status_wn_ibu'),
							'penghasilan_ibu'		=> $this->request->getPost('penghasilan_ibu'),
							'status_hidup_ibu'		=> $this->request->getPost('status_hidup_ibu'),
							'nama_wali'				=> $nama_wali,
							'tempat_lahir_wali'		=> $tempat_lahir_wali,
							'tanggal_lahir_wali'	=> $this->website->tanggal_input($tanggal_lahir_wali),
							'status_wn_wali'		=> $status_wn_wali,
							'penghasilan_wali'		=> $penghasilan_wali,
							'alamat_ayah'			=> $this->request->getPost('alamat_ayah'),
							'rt_ayah'				=> $this->request->getPost('rt_ayah'),
							'rw_ayah'				=> $this->request->getPost('rw_ayah'),
							'kelurahan_ayah'		=> $this->request->getPost('kelurahan_ayah'),
							'kecamatan_ayah'		=> $this->request->getPost('kecamatan_ayah'),
							'kabupaten_ayah'		=> $this->request->getPost('kabupaten_ayah'),
							'provinsi_ayah'			=> $this->request->getPost('provinsi_ayah'),
							'kode_pos_ayah'			=> $this->request->getPost('kode_pos_ayah'),
							'alamat_ibu'			=> $this->request->getPost('alamat_ibu'),
							'rt_ibu'				=> $this->request->getPost('rt_ibu'),
							'rw_ibu'				=> $this->request->getPost('rw_ibu'),
							'kelurahan_ibu'			=> $this->request->getPost('kelurahan_ibu'),
							'kecamatan_ibu'			=> $this->request->getPost('kecamatan_ibu'),
							'kabupaten_ibu'			=> $this->request->getPost('kabupaten_ibu'),
							'provinsi_ibu'			=> $this->request->getPost('provinsi_ibu'),
							'kode_pos_ibu'			=> $this->request->getPost('kode_pos_ibu'),
							'alamat_wali'			=> $alamat_wali,
							'rt_wali'				=> $rt_wali,
							'rw_wali'				=> $rw_wali,
							'kelurahan_wali'		=> $kelurahan_wali,
							'kecamatan_wali'		=> $kecamatan_wali,
							'kabupaten_wali'		=> $kabupaten_wali,
							'provinsi_wali'			=> $provinsi_wali,
							'kode_pos_wali'			=> $kode_pos_wali,
							'telepon_ayah'			=> $this->request->getPost('telepon_ayah'),
							'telepon_ibu'			=> $this->request->getPost('telepon_ibu'),
							'telepon_wali'			=> $telepon_wali,
							'ukuran_seragam'		=> ($this->request->getPost('ukuran_seragam') == 'Lainnya') ? $this->request->getPost('ukuran_seragam_lainnya') : $this->request->getPost('ukuran_seragam'),
							'asal_sekolah'			=> $this->request->getPost('asal_sekolah'),
							'anak_ke'				=> $this->request->getPost('anak_ke'),
							'jumlah_saudara'		=> $this->request->getPost('jumlah_saudara'),
							'status_siswa'			=> 'Menunggu',
							'status_pendaftaran'	=> 'Menunggu',
							'identitas_wali'		=> $this->request->getPost('identitas_wali'),
							'tanggal_baca'			=> date('Y-m-d H:i:s'),
							'tanggal_post'			=> date('Y-m-d H:i:s')
						];
				// masuk database
				$m_siswa->tambah($data);
				// Kirim notifikasi email ke Admin SPMB jika dikonfigurasi
				$emailAdmin = !empty($konfigurasi->email_admin_spmb) ? $konfigurasi->email_admin_spmb : $konfigurasi->email;
				if (!empty($emailAdmin)) {
					$linkKelola = base_url('admin/gelombang/dokumen/' . $slug_siswa);
					$programId = $this->request->getPost('id_program_pendidikan');
					$programObj = $programId ? $m_program_pendidikan->detail($programId) : null;
					$programNama = $programObj ? $programObj->judul_program_pendidikan : '-';

					$dataEmailAdmin = [
						'nama_siswa'  => $this->request->getPost('nama_siswa'),
						'nisn'        => $this->request->getPost('nisn'),
						'program'     => $programNama,
						'telepon'     => $this->request->getPost('telepon'),
						'link_kelola' => $linkKelola,
						'namaweb'     => $konfigurasi->namaweb
					];
					$messageAdmin = view('email_templates/pendaftar_baru_admin', $dataEmailAdmin);
					$this->sendEmail($emailAdmin, '📢 Pendaftar Baru SPMB - ' . $this->request->getPost('nama_siswa'), $messageAdmin);
				}
				$this->session->setFlashdata('sukses','Data telah ditambah');
				return redirect()->to(base_url('siswa/pendaftaran/dokumen/'.$slug_siswa));
			}
	    }else{

			$data = [	'title'			=> 'Isi Biodata Calon Siswa',
						'description'	=> 'Isi Data Siswa Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->tentang,
						'keywords'		=> 'Isi Data Siswa Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->keywords,
						'konfigurasi'	=> $konfigurasi,
						'akun'			=> $akun,
						'program_pendidikan'	=> $program_pendidikan,
						'gelombang'		=> $gelombang,
						'content'		=> 'siswa/pendaftaran/biodata'
					];
			echo view('siswa/layout/wrapper',$data);
		}
	}

	// edit
	public function edit($slug_siswa)
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
		$id_akun 				= $this->session->get('id_akun');
		$akun 					= $m_akun->detail($id_akun);
		$program_pendidikan 	= $m_nav->program_pendidikan();
		$gelombang 				= $m_gelombang->detail($id_gelombang);

		if(empty(Session()->get('username_siswa'))) {
			$this->session->setFlashdata('warning','Anda belum login');
			return redirect()->to(base_url('signin'));
		}
		
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
					                'max_size[gambar,4096]',
            					],
        	])) {

			if($this->request->getPost('identitas_wali')=='Ayah') {
				$id_agama_wali 		= $this->request->getPost('id_agama_ayah');
				$id_pekerjaan_wali 	= $this->request->getPost('id_pekerjaan_ayah');
				$id_jenjang_wali	= $this->request->getPost('id_jenjang_ayah');
				$nama_wali			= $this->request->getPost('nama_ayah');
				$alamat_wali 		= $this->request->getPost('alamat_ayah');
				$telepon_wali		= $this->request->getPost('telepon_ayah');
				$rt_wali			= $this->request->getPost('rt_ayah');
				$rw_wali			= $this->request->getPost('rw_ayah');
				$kelurahan_wali		= $this->request->getPost('kelurahan_ayah');
				$kecamatan_wali		= $this->request->getPost('kecamatan_ayah');
				$kabupaten_wali		= $this->request->getPost('kabupaten_ayah');
				$provinsi_wali		= $this->request->getPost('provinsi_ayah');
				$kode_pos_wali		= $this->request->getPost('kode_pos_ayah');
				$tempat_lahir_wali	= $this->request->getPost('tempat_lahir_ayah');
				$tanggal_lahir_wali	= $this->request->getPost('tanggal_lahir_ayah');
				$status_wn_wali		= $this->request->getPost('status_wn_ayah');
				$penghasilan_wali	= $this->request->getPost('penghasilan_ayah');
			}elseif($this->request->getPost('identitas_wali')=='Ibu') {
				$id_agama_wali 		= $this->request->getPost('id_agama_ibu');
				$id_pekerjaan_wali 	= $this->request->getPost('id_pekerjaan_ibu');
				$id_jenjang_wali	= $this->request->getPost('id_jenjang_ibu');
				$nama_wali			= $this->request->getPost('nama_ibu');
				$alamat_wali 		= $this->request->getPost('alamat_ibu');
				$telepon_wali		= $this->request->getPost('telepon_ibu');
				$rt_wali			= $this->request->getPost('rt_ibu');
				$rw_wali			= $this->request->getPost('rw_ibu');
				$kelurahan_wali		= $this->request->getPost('kelurahan_ibu');
				$kecamatan_wali		= $this->request->getPost('kecamatan_ibu');
				$kabupaten_wali		= $this->request->getPost('kabupaten_ibu');
				$provinsi_wali		= $this->request->getPost('provinsi_ibu');
				$kode_pos_wali		= $this->request->getPost('kode_pos_ibu');
				$tempat_lahir_wali	= $this->request->getPost('tempat_lahir_ibu');
				$tanggal_lahir_wali	= $this->request->getPost('tanggal_lahir_ibu');
				$status_wn_wali		= $this->request->getPost('status_wn_ibu');
				$penghasilan_wali	= $this->request->getPost('penghasilan_ibu');
			}else{
				$id_agama_wali 		= $this->request->getPost('id_agama_wali');
				$id_pekerjaan_wali 	= $this->request->getPost('id_pekerjaan_wali');
				$id_jenjang_wali	= $this->request->getPost('id_jenjang_wali');
				$nama_wali			= $this->request->getPost('nama_wali');
				$alamat_wali 		= $this->request->getPost('alamat_wali');
				$telepon_wali		= $this->request->getPost('telepon_wali');
				$rt_wali			= $this->request->getPost('rt_wali');
				$rw_wali			= $this->request->getPost('rw_wali');
				$kelurahan_wali		= $this->request->getPost('kelurahan_wali');
				$kecamatan_wali		= $this->request->getPost('kecamatan_wali');
				$kabupaten_wali		= $this->request->getPost('kabupaten_wali');
				$provinsi_wali		= $this->request->getPost('provinsi_wali');
				$kode_pos_wali		= $this->request->getPost('kode_pos_wali');
				$tempat_lahir_wali	= $this->request->getPost('tempat_lahir_wali');
				$tanggal_lahir_wali	= $this->request->getPost('tanggal_lahir_wali');
				$status_wn_wali		= $this->request->getPost('status_wn_wali');
				$penghasilan_wali	= $this->request->getPost('penghasilan_wali');
			}
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  					= $this->request->getFile('gambar');
				$nama_siswabaru 	= $avatar->getRandomName();
	            $avatar->move(WRITEPATH . '../assets/upload/image/',$nama_siswabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/image/'.$nama_siswabaru)
			    ->fit(100, 100, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$nama_siswabaru);
	        	// masuk database
	        	$slug_siswa 	= $siswa->slug_siswa ?: strtolower(url_title($this->request->getVar('nama_siswa'))).'-'.strtoupper(random_string('alnum', 8));
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
							'id_tahun'				=> $this->request->getPost('id_tahun') ?: $siswa->id_tahun,
							'id_kelas'				=> $this->request->getPost('id_kelas') ?: $siswa->id_kelas,
							'id_jenjang'			=> $this->request->getPost('id_jenjang') ?: $siswa->id_jenjang,
							'id_hubungan'			=> $this->request->getPost('id_hubungan'),
							'id_akun'				=> $akun->id_akun,
							'id_program_pendidikan'	=> $this->request->getPost('id_program_pendidikan'),
							'email'					=> $this->request->getPost('email'),
							'nisn'					=> $this->request->getPost('nisn'),
							'status_wn'				=> $this->request->getPost('status_wn'),
							'nama_siswa'			=> $this->request->getPost('nama_siswa'),
							'nama_panggilan'		=> $this->request->getPost('nama_panggilan'),
							'tempat_lahir'			=> $this->request->getPost('tempat_lahir'),
							'tanggal_lahir'			=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir')),
							'alamat'				=> $this->request->getPost('alamat'),
							'rt'					=> $this->request->getPost('rt'),
							'rw'					=> $this->request->getPost('rw'),
							'kelurahan'				=> $this->request->getPost('kelurahan'),
							'kecamatan'				=> $this->request->getPost('kecamatan'),
							'kabupaten'				=> $this->request->getPost('kabupaten'),
							'provinsi'				=> $this->request->getPost('provinsi'),
							'kode_pos'				=> $this->request->getPost('kode_pos'),
							'telepon'				=> $this->request->getPost('telepon'),
							'jenis_kelamin'			=> $this->request->getPost('jenis_kelamin'),
							'nama_ayah'				=> $this->request->getPost('nama_ayah'),
							'tempat_lahir_ayah'		=> $this->request->getPost('tempat_lahir_ayah'),
							'tanggal_lahir_ayah'	=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir_ayah')),
							'status_wn_ayah'		=> $this->request->getPost('status_wn_ayah'),
							'penghasilan_ayah'		=> $this->request->getPost('penghasilan_ayah'),
							'status_hidup_ayah'		=> $this->request->getPost('status_hidup_ayah'),
							'nama_ibu'				=> $this->request->getPost('nama_ibu'),
							'tempat_lahir_ibu'		=> $this->request->getPost('tempat_lahir_ibu'),
							'tanggal_lahir_ibu'		=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir_ibu')),
							'status_wn_ibu'			=> $this->request->getPost('status_wn_ibu'),
							'penghasilan_ibu'		=> $this->request->getPost('penghasilan_ibu'),
							'status_hidup_ibu'		=> $this->request->getPost('status_hidup_ibu'),
							'nama_wali'				=> $nama_wali,
							'tempat_lahir_wali'		=> $tempat_lahir_wali,
							'tanggal_lahir_wali'	=> $this->website->tanggal_input($tanggal_lahir_wali),
							'status_wn_wali'		=> $status_wn_wali,
							'penghasilan_wali'		=> $penghasilan_wali,
							'alamat_ayah'			=> $this->request->getPost('alamat_ayah'),
							'rt_ayah'				=> $this->request->getPost('rt_ayah'),
							'rw_ayah'				=> $this->request->getPost('rw_ayah'),
							'kelurahan_ayah'		=> $this->request->getPost('kelurahan_ayah'),
							'kecamatan_ayah'		=> $this->request->getPost('kecamatan_ayah'),
							'kabupaten_ayah'		=> $this->request->getPost('kabupaten_ayah'),
							'provinsi_ayah'			=> $this->request->getPost('provinsi_ayah'),
							'kode_pos_ayah'			=> $this->request->getPost('kode_pos_ayah'),
							'alamat_ibu'			=> $this->request->getPost('alamat_ibu'),
							'rt_ibu'				=> $this->request->getPost('rt_ibu'),
							'rw_ibu'				=> $this->request->getPost('rw_ibu'),
							'kelurahan_ibu'			=> $this->request->getPost('kelurahan_ibu'),
							'kecamatan_ibu'			=> $this->request->getPost('kecamatan_ibu'),
							'kabupaten_ibu'			=> $this->request->getPost('kabupaten_ibu'),
							'provinsi_ibu'			=> $this->request->getPost('provinsi_ibu'),
							'kode_pos_ibu'			=> $this->request->getPost('kode_pos_ibu'),
							'alamat_wali'			=> $alamat_wali,
							'rt_wali'				=> $rt_wali,
							'rw_wali'				=> $rw_wali,
							'kelurahan_wali'		=> $kelurahan_wali,
							'kecamatan_wali'		=> $kecamatan_wali,
							'kabupaten_wali'		=> $kabupaten_wali,
							'provinsi_wali'			=> $provinsi_wali,
							'kode_pos_wali'			=> $kode_pos_wali,
							'telepon_ayah'			=> $this->request->getPost('telepon_ayah'),
							'telepon_ibu'			=> $this->request->getPost('telepon_ibu'),
							'telepon_wali'			=> $telepon_wali,
							'ukuran_seragam'		=> ($this->request->getPost('ukuran_seragam') == 'Lainnya') ? $this->request->getPost('ukuran_seragam_lainnya') : $this->request->getPost('ukuran_seragam'),
							'asal_sekolah'			=> $this->request->getPost('asal_sekolah'),
							'anak_ke'				=> $this->request->getPost('anak_ke'),
							'jumlah_saudara'		=> $this->request->getPost('jumlah_saudara'),
							'gambar'				=> $nama_siswabaru,
							'identitas_wali'		=> $this->request->getPost('identitas_wali'),
							'slug_siswa'			=> $slug_siswa,
						];
				$m_siswa->edit($data);
				$this->session->setFlashdata('sukses','Data telah diupdate');
				return redirect()->to(base_url('siswa/pendaftaran/dokumen/'.$slug_siswa));
			}else{
				// masuk database
				$slug_siswa 	= $siswa->slug_siswa ?: strtolower(url_title($this->request->getVar('nama_siswa'))).'-'.strtoupper(random_string('alnum', 8));
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
							'id_tahun'				=> $this->request->getPost('id_tahun') ?: $siswa->id_tahun,
							'id_kelas'				=> $this->request->getPost('id_kelas') ?: $siswa->id_kelas,
							'id_jenjang'			=> $this->request->getPost('id_jenjang') ?: $siswa->id_jenjang,
							'id_hubungan'			=> $this->request->getPost('id_hubungan'),
							'id_akun'				=> $akun->id_akun,
							'id_program_pendidikan'	=> $this->request->getPost('id_program_pendidikan'),
							'email'					=> $this->request->getPost('email'),
							'nisn'					=> $this->request->getPost('nisn'),
							'status_wn'				=> $this->request->getPost('status_wn'),
							'nama_siswa'			=> $this->request->getPost('nama_siswa'),
							'nama_panggilan'		=> $this->request->getPost('nama_panggilan'),
							'tempat_lahir'			=> $this->request->getPost('tempat_lahir'),
							'tanggal_lahir'			=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir')),
							'alamat'				=> $this->request->getPost('alamat'),
							'rt'					=> $this->request->getPost('rt'),
							'rw'					=> $this->request->getPost('rw'),
							'kelurahan'				=> $this->request->getPost('kelurahan'),
							'kecamatan'				=> $this->request->getPost('kecamatan'),
							'kabupaten'				=> $this->request->getPost('kabupaten'),
							'provinsi'				=> $this->request->getPost('provinsi'),
							'kode_pos'				=> $this->request->getPost('kode_pos'),
							'telepon'				=> $this->request->getPost('telepon'),
							'jenis_kelamin'			=> $this->request->getPost('jenis_kelamin'),
							'nama_ayah'				=> $this->request->getPost('nama_ayah'),
							'tempat_lahir_ayah'		=> $this->request->getPost('tempat_lahir_ayah'),
							'tanggal_lahir_ayah'	=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir_ayah')),
							'status_wn_ayah'		=> $this->request->getPost('status_wn_ayah'),
							'penghasilan_ayah'		=> $this->request->getPost('penghasilan_ayah'),
							'status_hidup_ayah'		=> $this->request->getPost('status_hidup_ayah'),
							'nama_ibu'				=> $this->request->getPost('nama_ibu'),
							'tempat_lahir_ibu'		=> $this->request->getPost('tempat_lahir_ibu'),
							'tanggal_lahir_ibu'		=> $this->website->tanggal_input($this->request->getPost('tanggal_lahir_ibu')),
							'status_wn_ibu'			=> $this->request->getPost('status_wn_ibu'),
							'penghasilan_ibu'		=> $this->request->getPost('penghasilan_ibu'),
							'status_hidup_ibu'		=> $this->request->getPost('status_hidup_ibu'),
							'nama_wali'				=> $nama_wali,
							'tempat_lahir_wali'		=> $tempat_lahir_wali,
							'tanggal_lahir_wali'	=> $this->website->tanggal_input($tanggal_lahir_wali),
							'status_wn_wali'		=> $status_wn_wali,
							'penghasilan_wali'		=> $penghasilan_wali,
							'alamat_ayah'			=> $this->request->getPost('alamat_ayah'),
							'rt_ayah'				=> $this->request->getPost('rt_ayah'),
							'rw_ayah'				=> $this->request->getPost('rw_ayah'),
							'kelurahan_ayah'		=> $this->request->getPost('kelurahan_ayah'),
							'kecamatan_ayah'		=> $this->request->getPost('kecamatan_ayah'),
							'kabupaten_ayah'		=> $this->request->getPost('kabupaten_ayah'),
							'provinsi_ayah'			=> $this->request->getPost('provinsi_ayah'),
							'kode_pos_ayah'			=> $this->request->getPost('kode_pos_ayah'),
							'alamat_ibu'			=> $this->request->getPost('alamat_ibu'),
							'rt_ibu'				=> $this->request->getPost('rt_ibu'),
							'rw_ibu'				=> $this->request->getPost('rw_ibu'),
							'kelurahan_ibu'			=> $this->request->getPost('kelurahan_ibu'),
							'kecamatan_ibu'			=> $this->request->getPost('kecamatan_ibu'),
							'kabupaten_ibu'			=> $this->request->getPost('kabupaten_ibu'),
							'provinsi_ibu'			=> $this->request->getPost('provinsi_ibu'),
							'kode_pos_ibu'			=> $this->request->getPost('kode_pos_ibu'),
							'alamat_wali'			=> $alamat_wali,
							'rt_wali'				=> $rt_wali,
							'rw_wali'				=> $rw_wali,
							'kelurahan_wali'		=> $kelurahan_wali,
							'kecamatan_wali'		=> $kecamatan_wali,
							'kabupaten_wali'		=> $kabupaten_wali,
							'provinsi_wali'			=> $provinsi_wali,
							'kode_pos_wali'			=> $kode_pos_wali,
							'telepon_ayah'			=> $this->request->getPost('telepon_ayah'),
							'telepon_ibu'			=> $this->request->getPost('telepon_ibu'),
							'telepon_wali'			=> $telepon_wali,
							'ukuran_seragam'		=> ($this->request->getPost('ukuran_seragam') == 'Lainnya') ? $this->request->getPost('ukuran_seragam_lainnya') : $this->request->getPost('ukuran_seragam'),
							'asal_sekolah'			=> $this->request->getPost('asal_sekolah'),
							'anak_ke'				=> $this->request->getPost('anak_ke'),
							'jumlah_saudara'		=> $this->request->getPost('jumlah_saudara'),
							'identitas_wali'		=> $this->request->getPost('identitas_wali'),
							'slug_siswa'			=> $slug_siswa,
						];
				$m_siswa->edit($data);
				// masuk database
				$this->session->setFlashdata('sukses','Data telah diupdate');
				return redirect()->to(base_url('siswa/pendaftaran/dokumen/'.$slug_siswa));
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
						'content'		=> 'siswa/pendaftaran/edit'
					];
			echo view('siswa/layout/wrapper',$data);
		}
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
		if(empty(Session()->get('username_siswa'))) {
			$this->session->setFlashdata('warning','Anda belum login');
			return redirect()->to(base_url('signin'));
		}

		$siswa 				= $m_siswa->read($slug_siswa);
		if (empty($siswa)) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		// Keamanan: Siswa hanya boleh mengakses dokumennya sendiri
		if ($siswa->id_akun != $this->session->get('id_akun')) {
			$this->session->setFlashdata('warning','Anda tidak memiliki akses ke halaman tersebut');
			return redirect()->to(base_url('siswa/pendaftaran'));
		}

		$jenis_dokumen 		= $m_jenis_dokumen->listing();
		$akun 				= $m_akun->detail($siswa->id_akun);

		// Start tambah
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'id_jenis_dokumen' => 'required',
				'gambar'	 	=> [
									'uploaded[gambar]',
					                'ext_in[gambar,jpg,jpeg,png,gif,zip,rar,doc,docx,xls,xlsx,ppt,pptx,pdf]',
					                'max_size[gambar,24096]',
            					],
        	])) {
			// Image upload
			$avatar  	= $this->request->getFile('gambar');
			$namabaru 	= $avatar->getRandomName();
			$file_ext 	= $avatar->guessExtension();
			$file_size 	= $avatar->getSizeByUnit('mb');
            $avatar->move(WRITEPATH . '../assets/upload/pendaftaran/',$namabaru);
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
    		return redirect()->to(base_url('siswa/pendaftaran/dokumen/'.$slug_siswa))->with('sukses', 'Data Berhasil di Simpan');
		}else{

			$data = [	'title'				=> 'Unggah Dokumen',
						'description'		=> 'Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->tentang,
						'keywords'			=> 'Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->keywords,
						'konfigurasi'		=> $konfigurasi,
						'akun'				=> $akun,
						'jenis_dokumen'		=> $jenis_dokumen,
						'siswa'				=> $siswa,
						'm_dokumen'			=> $m_dokumen,
						'content'			=> 'siswa/pendaftaran/dokumen'
					];
			echo view('siswa/layout/wrapper',$data);
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

		// Send registration email if not sent yet
		if ($siswa && $siswa->email_pendaftaran_sent == 0) {
			$emailData = [
				'nama_siswa'      => $siswa->nama_siswa,
				'kode_siswa'      => $siswa->kode_siswa,
				'program'         => $siswa->judul_program_pendidikan,
				'gelombang'       => $siswa->judul,
				'tgl_pengumuman'  => $this->website->tanggal_id($siswa->tanggal_pengumuman),
				'namaweb'         => $konfigurasi->namaweb,
				'link_pengumuman' => base_url('check')
			];
			$htmlMessage = view('email_templates/pendaftaran_selesai', $emailData);
			
			$recipientEmail = !empty($siswa->email_akun) ? $siswa->email_akun : $siswa->email;
			if ($this->sendEmail($recipientEmail, 'Pendaftaran PPDB Berhasil - ' . $konfigurasi->namaweb, $htmlMessage)) {
				$m_siswa->edit([
					'id_siswa'               => $siswa->id_siswa,
					'email_pendaftaran_sent' => 1
				]);
				// Reload fresh data to reflect changes in view
				$siswa = $m_siswa->read($slug_siswa);
				$this->session->setFlashdata('sukses', 'Pendaftaran Berhasil! Bukti pendaftaran telah dikirim ke email: ' . $recipientEmail);
			} else {
				// Log the error to writeable/logs for debugging if email sending fails
				$email_service = \Config\Services::email();
				log_message('error', 'Gagal mengirim email pendaftaran ke ' . $recipientEmail . '. Detail: ' . $email_service->printDebugger(['headers', 'subject', 'body']));
				$this->session->setFlashdata('warning', 'Pendaftaran Berhasil disimpan, namun sistem gagal mengirim email bukti pendaftaran ke ' . $recipientEmail . '. Anda tetap dapat mengunduh bukti secara langsung.');
			}
		}

		$data = [	'title'				=> 'Pendaftaran Berhasil',
					'description'		=> 'Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->tentang,
					'keywords'			=> 'Pendaftaran Peserta Didik Baru '.$konfigurasi->namaweb.', '.$konfigurasi->keywords,
					'konfigurasi'		=> $konfigurasi,
					'akun'				=> $akun,
					'jenis_dokumen'		=> $jenis_dokumen,
					'siswa'				=> $siswa,
					'm_dokumen'			=> $m_dokumen,
					'content'			=> 'siswa/pendaftaran/selesai'
				];
		echo view('siswa/layout/wrapper',$data);
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
					'content'			=> 'siswa/pendaftaran/selesai'
				];
		// echo view('layout/wrapper',$data);
		$mpdf = new \Mpdf\Mpdf([
						'default_font_size' => 11,
						'default_font' => 'nunito-regular'
					]);
		$html = view('siswa/pendaftaran/cetak',$data);
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		// download langsung
		// $mpdf->Output('Informasi-Pendaftaran-'.$siswa->nama_siswa.'.pdf','I'); // buka di browser
		$mpdf->Output('Informasi-Pendaftaran-'.$siswa->nama_siswa.'.pdf','D'); 
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
		$dokumen = $m_dokumen->kode_dokumen($kode_dokumen);
		if ($dokumen && !empty($dokumen->gambar)) {
			$filepath = WRITEPATH . '../assets/upload/pendaftaran/' . $dokumen->gambar;
			if (file_exists($filepath)) {
				@unlink($filepath);
			}
		}
		$data = ['kode_dokumen'	=> $kode_dokumen];
		$m_dokumen->hapus($data);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('siswa/pendaftaran/dokumen/'.$kode_siswa));
	}

	// hapus
	public function delete($slug_siswa)
	{
		$m_siswa = new Siswa_model();
		$id_akun = $this->session->get('id_akun');
		$siswa = $m_siswa->getSiswaBySlugAndAkun($slug_siswa, $id_akun);
		if ($siswa) {
			$m_siswa->deleteSiswaCascading($siswa->id_siswa, false);
		}
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('siswa/pendaftaran'));
	}
}