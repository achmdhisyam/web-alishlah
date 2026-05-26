<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Popup_model;

class Popup extends BaseController
{
	// index
	public function index()
	{
		$m_popup 			= new Popup_model();
		$pager 				= service('pager'); 
		
		if(isset($_GET['keywords'])) 
		{
			$keywords 		= $this->request->getVar('keywords');
			$total 			= $m_popup->total_cari($keywords);
			$title 			= 'Hasil pencarian pop up: '.$_GET['keywords'].' - '.$total.' ditemukan';
	        $page    		= (int) ($this->request->getGet('page') ?? 1);
	        $perPage 		= $this->website->paginasi();
	        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
	        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
	        $popup 			= $m_popup->paginasi_admin_cari($keywords,$perPage, $page);
		}else{
			$total 			= $m_popup->total();
			$title 			= 'Pop Up Homepage ('.$total.')';
	        $page    		= (int) ($this->request->getGet('page') ?? 1);
	        $perPage 		= $this->website->paginasi();
	        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
	        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
	        $popup 			= $m_popup->paginasi_admin($perPage, $page);
		}

		$data = [	'title'				=> $title,
					'popup'				=> $popup,
					'pagination'		=> $pager_links,
					'content'			=> 'admin/popup/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// Tambah
	public function tambah()
	{
		$m_popup 			= new Popup_model();

		// Start validasi
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'judul_popup' 	=> 'required',
				'gambar'	 	=> [
					                'uploaded[gambar]',
					                'ext_in[gambar,jpg,jpeg,gif,png,svg]',
					                'max_size[gambar,4096]',
            					],
        	])) {
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  	= $this->request->getFile('gambar');
				$namabaru 	= $avatar->getRandomName();
	            $avatar->move(WRITEPATH . '../assets/upload/image/',$namabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/image/'.$namabaru)
			    ->fit(300, 300, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$namabaru);
	        	// masuk database
	        	$data = array(
	        		'id_user'			=> $this->session->get('id_user'),
					'judul_popup'		=> $this->request->getVar('judul_popup'),
					'isi'				=> $this->request->getVar('isi'),
					'gambar' 			=> $namabaru,
					'website'			=> $this->request->getVar('website'),
					'status_text'		=> $this->request->getVar('status_text'),
					'tanggal_post'		=> date('Y-m-d H:i:s')
	        	);
	        	$m_popup->tambah($data);
        		return redirect()->to(base_url('admin/popup'))->with('sukses', 'Data Pop Up Berhasil disimpan');
        	}
        }

		$data = [	'title'				=> 'Tambah Pop Up',
					'content'			=> 'admin/popup/tambah'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// edit
	public function edit($id_popup)
	{
		$m_popup 			= new Popup_model();
		$popup 				= $m_popup->detail($id_popup);

		// Start validasi
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'judul_popup' 	=> 'required',
				'gambar'	 	=> [
					                'ext_in[gambar,jpg,jpeg,gif,png,svg]',
					                'max_size[gambar,4096]',
            					],
        	])) {
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  	= $this->request->getFile('gambar');
				$namabaru 	= $avatar->getRandomName();
	            $avatar->move(WRITEPATH . '../assets/upload/image/',$namabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/image/'.$namabaru)
			    ->fit(300, 300, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$namabaru);
	        	// masuk database
			    $data = array(
	        		'id_popup'			=> $id_popup,
	        		'id_user'			=> $this->session->get('id_user'),
					'judul_popup'		=> $this->request->getVar('judul_popup'),
					'isi'				=> $this->request->getVar('isi'),
					'gambar' 			=> $namabaru,
					'website'			=> $this->request->getVar('website'),
					'status_text'		=> $this->request->getVar('status_text'),
	        	);
	        	$m_popup->edit($data);
        		return redirect()->to(base_url('admin/popup'))->with('sukses', 'Data Pop Up Berhasil diubah');
			}else{
				$data = array(
	        		'id_popup'			=> $id_popup,
	        		'id_user'			=> $this->session->get('id_user'),
					'judul_popup'		=> $this->request->getVar('judul_popup'),
					'isi'				=> $this->request->getVar('isi'),
					'website'			=> $this->request->getVar('website'),
					'status_text'		=> $this->request->getVar('status_text'),
	        	);
	        	$m_popup->edit($data);
        		return redirect()->to(base_url('admin/popup'))->with('sukses', 'Data Pop Up Berhasil diubah');
			}
		}

		$data = [	'title'				=> 'Edit Pop Up: '.$popup->judul_popup,
					'popup'				=> $popup,
					'content'			=> 'admin/popup/edit'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// Delete
	public function delete($id_popup)
	{
		$m_popup = new Popup_model();
		$m_popup->delete($id_popup);
		$this->session->setFlashdata('sukses','Data pop up telah dihapus');
		return redirect()->to(base_url('admin/popup'));
	}
}
