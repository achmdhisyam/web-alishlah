<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Profil_model;
use App\Models\User_model;

class Profil extends BaseController
{
	// index
	public function index()
	{
		$m_profil 		= new Profil_model();
		$pager 			= service('pager'); 
		
		if(isset($_GET['keywords'])) 
		{
			$keywords 		= $this->request->getVar('keywords');
			$total 			= $m_profil->total_cari($keywords);
			$title 			= 'Hasil pencarian: '.$_GET['keywords'].' - '.$total.' ditemukan';
	        $page    		= (int) ($this->request->getGet('page') ?? 1);
	        $perPage 		= $this->website->paginasi();
	        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
	        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
	        $profil 		= $m_profil->paginasi_admin_cari($keywords,$perPage, $page);
		}else{
			$total 			= $m_profil->total();
			$title 			= 'Profil & Sejarah Sekolah ('.$total.')';
	        $page    		= (int) ($this->request->getGet('page') ?? 1);
	        $perPage 		= $this->website->paginasi();
	        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
	        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
	        $profil 		= $m_profil->paginasi_admin($perPage, $page);
		}
		
		$data = [	'title'			=> $title,
					'profil'		=> $profil,
					'pagination'	=> $pager_links,
					'content'		=> 'admin/profil/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// status_profil
	public function status_profil($status_profil)
	{
		$m_profil 		= new Profil_model();
		$total 			= $m_profil->total_status_profil($status_profil);
		$pager 			= service('pager');
        $page    		= (int) ($this->request->getGet('page') ?? 1);
        $perPage 		= $this->website->paginasi();
        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
        $profil 		= $m_profil->status_profil_all($status_profil,$perPage, $page);

		$data = [	'title'			=> $status_profil.' ('.$total.')',
					'profil'		=> $profil,
					'pagination'	=> $pager_links,
					'content'		=> 'admin/profil/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// Tambah
	public function tambah()
	{
		$m_profil 		= new Profil_model();

		// Start validasi
		if(strtolower($this->request->getMethod()) === 'post' && $this->validate(
			[
				'judul_profil' 	=> 'required',
        	])) {
        	$data = array(
        		'id_user'			=> $this->session->get('id_user'),
				'slug_profil'		=> strtolower(url_title($this->request->getVar('judul_profil'))),
				'judul_profil'		=> $this->request->getVar('judul_profil'),
				'ringkasan'			=> $this->request->getVar('ringkasan') ?? '',
				'isi'				=> $this->request->getVar('isi'),
				'status_profil'		=> $this->request->getVar('status_profil'),
				'keywords'			=> $this->request->getVar('keywords') ?? '',
				'gambar' 			=> '',
				'tanggal_post'		=> date('Y-m-d H:i:s'),
				'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
        	);
        	$m_profil->tambah($data);
        	return redirect()->to(base_url('admin/profil'))->with('sukses', 'Data Berhasil di Simpan');
	    }

		$data = [	'title'			=> 'Tambah Profil',
					'content'		=> 'admin/profil/tambah'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// edit
	public function edit($id_profil)
	{
		$m_profil 		= new Profil_model();
		$profil 		= $m_profil->detail($id_profil);
		// Start validasi
		if(strtolower($this->request->getMethod()) === 'post' && $this->validate(
			[
				'judul_profil' 	=> 'required',
        	])) {
        	$data = array(
        		'id_profil'			=> $id_profil,
        		'id_user'			=> $this->session->get('id_user'),
				'slug_profil'		=> strtolower(url_title($this->request->getVar('judul_profil'))),
				'judul_profil'		=> $this->request->getVar('judul_profil'),
				'ringkasan'			=> $this->request->getVar('ringkasan') ?? '',
				'isi'				=> $this->request->getVar('isi'),
				'status_profil'		=> $this->request->getVar('status_profil'),
				'keywords'			=> $this->request->getVar('keywords') ?? '',
				'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
        	);
        	$m_profil->edit($data);
   		 	return redirect()->to(base_url('admin/profil'))->with('sukses', 'Data Berhasil di Simpan');
	    }

		$data = [	'title'			=> 'Edit Profil: '.$profil->judul_profil,
					'profil'		=> $profil,
					'content'		=> 'admin/profil/edit'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// proses
	public function proses()
	{
		$m_profil 		= new Profil_model();
		$pengalihan = $this->request->getVar('pengalihan');
		$submit 	= $this->request->getVar('submit');
		$id_profil 	= $this->request->getVar('id_profil');
		
		if(empty($this->request->getVar('id_profil')))
		{
			return redirect()->to($pengalihan)->with('warning', 'Anda belum memilih data Profil.');
		}
		
		if($submit=='Publish') {
			for($i=0; $i < sizeof($id_profil);$i++) {
				$data = array(	'id_profil'		=> $id_profil[$i],
								'id_user'		=> $this->session->get('id_user'),
								'status_profil'	=> 'Publish'
							);
   				$m_profil->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Profil berhasil dipublikasikan');
		}elseif($submit=='Draft') {
			for($i=0; $i < sizeof($id_profil);$i++) {
				$data = array(	'id_profil'		=> $id_profil[$i],
								'id_user'		=> $this->session->get('id_user'),
								'status_profil'	=> 'Draft'
							);
   				$m_profil->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Profil berhasil di-draft');
		}elseif($submit=='Delete') {
			for($i=0; $i < sizeof($id_profil);$i++) {
				$data = array(	'id_profil'	=> $id_profil[$i]);
   				$m_profil->hapus($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Data berhasil dihapus');
		}
	}
	
	// Delete
	public function delete($id_profil)
	{
		$m_profil = new Profil_model();
		$data = ['id_profil'	=> $id_profil];
		$m_profil->hapus($data);
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('admin/profil'));
	}
}
