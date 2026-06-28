<?php 
namespace App\Libraries;
use App\Models\User_model;
use App\Models\Client_model;
use App\Models\Siswa_model;
use App\Models\Akun_model;

class Simple_login
{
	// check login
	public function login($username,$password,$pengalihan,$remember = false)
	{
		$this->session  = \Config\Services::session();
		$uri            = service('uri');
		$m_user 		= new User_model();
		$user 			= $m_user->login($username,$password);
		if($user) 
		{
			// Jika username password benar
			$this->session->set('username',$username);
			$this->session->set('id_user',$user->id_user);
			$this->session->set('id_staff',$user->id_staff);
			$this->session->set('nama',$user->nama);
			$this->session->set('akses_level',$user->akses_level);

			if ($remember) {
				// Buat token remember me
				$token = bin2hex(random_bytes(32));
				// Simpan token di cookie selama 30 hari
				helper('cookie');
				set_cookie([
					'name'   => 'remember_admin',
					'value'  => $token,
					'expire' => 30 * 24 * 3600,
					'httponly' => true,
					'secure' => false // Set to false to support local HTTP/Laragon
				]);
				// Simpan token ke database
				$m_user->edit([
					'id_user'        => $user->id_user,
					'remember_token' => $token
				]);
			}

			// $this->session->setFlashdata('sukses', 'Hai '.$user->nama.', Anda berhasil login');
			// return redirect()->to(base_url('admin/dasbor'));
			if($pengalihan!=='') {
				header("Location: ".$pengalihan);
			}else{
				$this->session->setFlashdata('sukses', 'Hai '.$user->nama.', Anda berhasil login');
				header("Location: admin/dasbor");
			}
			
            exit;
		}else{
			// jika username password salah
			$this->session->setFlashdata('warning','Username atau password salah');
			return redirect()->to(base_url('login'));
		}
	}

	// check login
	public function login_siswa_akun($username,$password)
	{
		$this->session  = \Config\Services::session();
		$uri            = service('uri');
		$m_siswa 		= new Siswa_model();
		$m_akun 		= new Akun_model();
		$user 			= $m_akun->login($username,($password));

		if($user) 
		{
			// Jika username password benar
			$this->session->set('username_siswa',$username);
			$this->session->set('id_akun',$user->id_akun);
			$this->session->set('nama',$user->nama);
			$this->session->set('jenis_akun',$user->jenis_akun);
			$this->session->set('nis',$user->nis);
			$this->session->set('nisn',$user->nisn);

			helper('cookie');
			set_cookie([
				'name'     => 'sudah_daftar',
				'value'    => '1',
				'expire'   => 365 * 24 * 3600,
				'httponly' => false,
				'secure'   => false
			]);
		}
	}

	// check login pendaftaran
	public function login_siswa($username,$password)
	{
		$this->session  = \Config\Services::session();
		$uri            = service('uri');
		$m_siswa 		= new Siswa_model();
		$m_akun 		= new Akun_model();

		$user = $m_akun->login($username, $password);
		$user2 = $m_akun->login_nis($username, $password);


		if($user) 
		{
			// Jika username password benar
			$this->session->set('username_siswa',$username);
			$this->session->set('id_akun',$user->id_akun);
			$this->session->set('nama_siswa',$user->nama);
			$this->session->set('jenis_akun',$user->jenis_akun);
			$this->session->set('nis',$user->nis);
			$this->session->set('nisn',$user->nisn);

			helper('cookie');
			set_cookie([
				'name'     => 'sudah_daftar',
				'value'    => '1',
				'expire'   => 365 * 24 * 3600,
				'httponly' => false,
				'secure'   => false
			]);

			session_write_close();
			header("Location: " . base_url('siswa/dasbor'));			
            exit;
        }elseif($user2) {
        	// Jika username password benar
			$this->session->set('username_siswa',$username);
			$this->session->set('id_akun',$user2->id_akun);
			$this->session->set('nama_siswa',$user2->nama_siswa);
			$this->session->set('jenis_akun',$user2->jenis_akun);
			$this->session->set('nis',$user2->nis);
			$this->session->set('nisn',$user2->nisn);

			helper('cookie');
			set_cookie([
				'name'     => 'sudah_daftar',
				'value'    => '1',
				'expire'   => 365 * 24 * 3600,
				'httponly' => false,
				'secure'   => false
			]);

			session_write_close();
			header("Location: " . base_url('siswa/dasbor'));
			exit;
		}else{
			// jika username password salah
			$this->session->setFlashdata('warning','Username atau password salah');
			session_write_close();
			header("Location: " . base_url('signin'));
			exit;
		}
	}

	// check login
	public function checklogin_siswa()
	{
		$this->session  = \Config\Services::session();
		if($this->session->get('username_siswa')=='') 
		{
			$pengalihan = str_replace('index.php/','',current_url());
			$this->session->set('pengalihan_siswa',$pengalihan);
			$this->session->setFlashdata('warning','Anda belum login');
			header("Location: ".base_url('signin')).'?redirect='.$pengalihan;
	        exit;
		}
	}

	// check login
	public function login_client($username,$password)
	{
		$this->session  = \Config\Services::session();
		$uri            = service('uri');
		$m_client 		= new Client_model();
		$user 			= $m_client->login($username,$password);
		if($user) 
		{
			// Jika username password benar
			$this->session->set('username_client',$username);
			$this->session->set('id_client',$user->id_client);
			$this->session->set('nama_client',$user->nama);
			$this->session->set('akses_level','Client');
			header("Location: client/dasbor");			
            exit;
		}else{
			// jika username password salah
			$this->session->setFlashdata('warning','Username atau password salah');
			return redirect()->to(base_url('signin'));
		}
	}

	// check login
	public function checklogin()
	{
		$this->session  = \Config\Services::session();
		if($this->session->get('username')=='') 
		{
			// Coba login otomatis menggunakan remember me cookie
			helper('cookie');
			$token = get_cookie('remember_admin');
			if ($token) {
				$m_user = new User_model();
				$user = $m_user->check_remember_token($token);
				if ($user) {
					// Restore session
					$this->session->set('username',$user->username);
					$this->session->set('id_user',$user->id_user);
					$this->session->set('id_staff',$user->id_staff);
					$this->session->set('nama',$user->nama_staff ?? $user->username);
					$this->session->set('akses_level',$user->akses_level);
					return; // auto-login sukses
				}
			}

			$pengalihan = str_replace('index.php/','',current_url());
			$this->session->set('pengalihan',$pengalihan);
			$this->session->setFlashdata('warning','Anda belum login');
			header("Location: ".base_url('login')).'?redirect='.$pengalihan;
	        exit;
		}
	}

	// check login
	public function checklogin_client()
	{
		$this->session  = \Config\Services::session();
		if($this->session->get('username_client')=='') 
		{
			$pengalihan = str_replace('index.php/','',current_url());
			$this->session->set('pengalihan_siswa',$pengalihan);
			$this->session->setFlashdata('warning','Anda belum login');
			header("Location: ".base_url('signin')).'?redirect='.$pengalihan;
	        exit;
		}
	}

	// check logout
	public function logout()
	{
		$this->session  = \Config\Services::session();
		
		// Clear remember token di database
		$id_user = $this->session->get('id_user');
		if ($id_user) {
			$m_user = new User_model();
			$m_user->edit([
				'id_user'        => $id_user,
				'remember_token' => null
			]);
		}
		
		// Hapus cookie remember me
		helper('cookie');
		delete_cookie('remember_admin');

		$this->session->remove('username');
		$this->session->remove('id_user');
		$this->session->remove('akses_level');
		$this->session->remove('nama');
		$this->session->remove('pengalihan');
		$this->session->setFlashdata('sukses','Anda berhasil logout');
		header("Location: ".base_url('login?logout=sukses'));
        exit;
	}

	// logout_siswa
	public function logout_siswa()
	{
		$this->session  = \Config\Services::session();
		$this->session->remove('username_siswa');
		$this->session->remove('id_akun');
		$this->session->remove('jenis_akun');
		$this->session->remove('nama_siswa');
		$this->session->remove('nis');
		$this->session->remove('nisn');
		$this->session->remove('pengalihan_siswa');
		$this->session->setFlashdata('sukses','Anda berhasil logout');
		header("Location: ".base_url('signin?logout=sukses'));
        exit;
	}
}