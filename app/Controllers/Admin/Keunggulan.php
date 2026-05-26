<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Keunggulan_model;
use App\Models\User_model;

class Keunggulan extends BaseController
{
	// index
	public function index()
	{
		$m_keunggulan 	= new Keunggulan_model();
		$pager 			= service('pager'); 
		
		if(isset($_GET['keywords'])) 
		{
			$keywords 		= $this->request->getVar('keywords');
			$total 			= $m_keunggulan->total_cari($keywords);
			$title 			= 'Hasil pencarian: '.$_GET['keywords'].' - '.$total.' ditemukan';
	        $page    		= (int) ($this->request->getGet('page') ?? 1);
	        $perPage 		= $this->website->paginasi();
	        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
	        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
	        $keunggulan 	= $m_keunggulan->paginasi_admin_cari($keywords,$perPage, $page);
		}else{
			$total 			= $m_keunggulan->total();
			$title 			= 'Keunggulan ('.$total.')';
	        $page    		= (int) ($this->request->getGet('page') ?? 1);
	        $perPage 		= $this->website->paginasi();
	        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
	        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
	        $keunggulan 	= $m_keunggulan->paginasi_admin($perPage, $page);
		}
		
		$data = [	'title'			=> $title,
					'keunggulan'	=> $keunggulan,
					'pagination'	=> $pager_links,
					'content'		=> 'admin/keunggulan/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// status_keunggulan
	public function status_keunggulan($status_keunggulan)
	{
		$m_keunggulan 	= new Keunggulan_model();
		$total 			= $m_keunggulan->total_status_keunggulan($status_keunggulan);
		$pager 			= service('pager');
        $page    		= (int) ($this->request->getGet('page') ?? 1);
        $perPage 		= $this->website->paginasi();
        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
        $keunggulan 	= $m_keunggulan->status_keunggulan_all($status_keunggulan,$perPage, $page);

		$data = [	'title'			=> $status_keunggulan.' ('.$total.')',
					'keunggulan'	=> $keunggulan,
					'pagination'	=> $pager_links,
					'content'		=> 'admin/keunggulan/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// Tambah
	public function tambah()
	{
		$m_keunggulan 	= new Keunggulan_model();

		// Start validasi
		if(strtolower($this->request->getMethod()) === 'post' && $this->validate(
			[
				'judul_keunggulan' 	=> 'required',
        	])) {
        	$data = array(
        		'id_user'			=> $this->session->get('id_user'),
				'slug_keunggulan'	=> strtolower(url_title($this->request->getVar('judul_keunggulan'))),
				'judul_keunggulan'	=> $this->request->getVar('judul_keunggulan'),
				'ringkasan'			=> $this->request->getVar('ringkasan') ?? '',
				'isi'				=> $this->request->getVar('isi') ?? '',
				'status_keunggulan'	=> $this->request->getVar('status_keunggulan'),
				'keywords'			=> $this->request->getVar('keywords') ?? '',
				'gambar' 			=> '',
				'tanggal_post'		=> date('Y-m-d H:i:s'),
				'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
        	);
        	$m_keunggulan->tambah($data);
        	return redirect()->to(base_url('admin/keunggulan'))->with('sukses', 'Data Berhasil di Simpan');
	    }

		$data = [	'title'			=> 'Tambah Keunggulan',
					'content'		=> 'admin/keunggulan/tambah'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// edit
	public function edit($id_keunggulan)
	{
		$m_keunggulan 	= new Keunggulan_model();
		$keunggulan 	= $m_keunggulan->detail($id_keunggulan);
		// Start validasi
		if(strtolower($this->request->getMethod()) === 'post' && $this->validate(
			[
				'judul_keunggulan' 	=> 'required',
        	])) {
        	$data = array(
        		'id_keunggulan'		=> $id_keunggulan,
        		'id_user'			=> $this->session->get('id_user'),
				'slug_keunggulan'	=> strtolower(url_title($this->request->getVar('judul_keunggulan'))),
				'judul_keunggulan'	=> $this->request->getVar('judul_keunggulan'),
				'ringkasan'			=> $this->request->getVar('ringkasan') ?? '',
				'isi'				=> $this->request->getVar('isi') ?? '',
				'status_keunggulan'	=> $this->request->getVar('status_keunggulan'),
				'keywords'			=> $this->request->getVar('keywords') ?? '',
				'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
        	);
        	$m_keunggulan->edit($data);
       		 	return redirect()->to(base_url('admin/keunggulan'))->with('sukses', 'Data Berhasil di Simpan');
	    }

		$data = [	'title'			=> 'Edit Keunggulan: '.$keunggulan->judul_keunggulan,
					'keunggulan'	=> $keunggulan,
					'content'		=> 'admin/keunggulan/edit'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// proses
	public function proses()
	{
		$m_keunggulan 	= new Keunggulan_model();
		$pengalihan = $this->request->getVar('pengalihan');
		$submit 	= $this->request->getVar('submit');
		$id_keunggulan 	= $this->request->getVar('id_keunggulan');
		
		if(empty($this->request->getVar('id_keunggulan')))
		{
			return redirect()->to($pengalihan)->with('warning', 'Anda belum memilih data Keunggulan.');
		}
		
		if($submit=='Publish') {
			for($i=0; $i < sizeof($id_keunggulan);$i++) {
				$data = array(	'id_keunggulan'		=> $id_keunggulan[$i],
								'id_user'		=> $this->session->get('id_user'),
								'status_keunggulan'	=> 'Publish'
							);
   				$m_keunggulan->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Keunggulan berhasil dipublikasikan');
		}elseif($submit=='Draft') {
			for($i=0; $i < sizeof($id_keunggulan);$i++) {
				$data = array(	'id_keunggulan'		=> $id_keunggulan[$i],
								'id_user'		=> $this->session->get('id_user'),
								'status_keunggulan'	=> 'Draft'
							);
   				$m_keunggulan->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Keunggulan berhasil di-draft');
		}elseif($submit=='Delete') {
			for($i=0; $i < sizeof($id_keunggulan);$i++) {
				$data = array(	'id_keunggulan'	=> $id_keunggulan[$i]);
   				$m_keunggulan->hapus($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Data berhasil dihapus');
		}
	}
	
	// Delete
	public function delete($id_keunggulan)
	{
		$m_keunggulan = new Keunggulan_model();
		$data = ['id_keunggulan'	=> $id_keunggulan];
		$m_keunggulan->hapus($data);
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('admin/keunggulan'));
	}
}
