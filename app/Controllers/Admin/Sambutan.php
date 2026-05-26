<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Sambutan_model;
use App\Models\User_model;

class Sambutan extends BaseController
{
	// index
	public function index()
	{
		$m_sambutan 	= new Sambutan_model();
		
		if ($m_sambutan->total() == 0) {
			$data_default = [
				'id_user'			=> $this->session->get('id_user'),
				'slug_sambutan'		=> 'sambutan-kepala-sekolah',
				'judul_sambutan'	=> 'Sambutan Kepala Sekolah',
				'ringkasan'			=> 'Masukkan ringkasan sambutan...',
				'isi'				=> 'Masukkan isi sambutan...',
				'status_sambutan'	=> 'Publish',
				'gambar'			=> '',
				'tanggal_post'		=> date('Y-m-d H:i:s'),
				'tanggal_publish'	=> date('Y-m-d H:i:s')
			];
			$m_sambutan->tambah($data_default);
		}

		$list = $m_sambutan->listing();
		$sambutan = $list[0];
		
		return redirect()->to(base_url('admin/sambutan/edit/'.$sambutan->id_sambutan));
	}

	// status_sambutan
	public function status_sambutan($status_sambutan)
	{
		$m_sambutan 	= new Sambutan_model();
		$total 			= $m_sambutan->total_status_sambutan($status_sambutan);
		$pager 			= service('pager');
        $page    		= (int) ($this->request->getGet('page') ?? 1);
        $perPage 		= $this->website->paginasi();
        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
        $sambutan 		= $m_sambutan->status_sambutan_all($status_sambutan,$perPage, $page);

		$data = [	'title'			=> $status_sambutan.' ('.$total.')',
					'sambutan'		=> $sambutan,
					'pagination'	=> $pager_links,
					'content'		=> 'admin/sambutan/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// Tambah
	public function tambah()
	{
		$m_sambutan 	= new Sambutan_model();

		// Start validasi
		$rules = [
			'judul_sambutan' 	=> 'required',
		];
		
		$gambar = $this->request->getFile('gambar');
		if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
			$rules['gambar'] = 'ext_in[gambar,jpg,jpeg,gif,png,svg]|max_size[gambar,4096]';
		}

		if(strtolower($this->request->getMethod()) === 'post' && $this->validate($rules)) {
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  	= $this->request->getFile('gambar');
				$namabaru 	= $avatar->getRandomName();
	            $avatar->move(WRITEPATH . '../assets/upload/image/',$namabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/image/'.$namabaru)
			    ->fit(100, 100, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$namabaru);
	        	// masuk database
	        	$data = array(
	        		'id_user'			=> $this->session->get('id_user'),
					'slug_sambutan'		=> strtolower(url_title($this->request->getVar('judul_sambutan'))),
					'judul_sambutan'	=> $this->request->getVar('judul_sambutan'),
					'ringkasan'			=> $this->request->getVar('ringkasan'),
					'isi'				=> $this->request->getVar('isi'),
					'status_sambutan'	=> $this->request->getVar('status_sambutan'),
					'keywords'			=> $this->request->getVar('keywords'),
					'gambar' 			=> $namabaru,
					'tanggal_post'		=> date('Y-m-d H:i:s'),
					'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
	        	);
	        	$m_sambutan->tambah($data);
	        	return redirect()->to(base_url('admin/sambutan'))->with('sukses', 'Data Berhasil di Simpan');
	        }else{
	        	$data = array(
	        		'id_user'			=> $this->session->get('id_user'),
					'slug_sambutan'		=> strtolower(url_title($this->request->getVar('judul_sambutan'))),
					'judul_sambutan'	=> $this->request->getVar('judul_sambutan'),
					'ringkasan'			=> $this->request->getVar('ringkasan'),
					'isi'				=> $this->request->getVar('isi'),
					'status_sambutan'	=> $this->request->getVar('status_sambutan'),
					'keywords'			=> $this->request->getVar('keywords'),
					'tanggal_post'		=> date('Y-m-d H:i:s'),
					'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
	        	);
	        	$m_sambutan->tambah($data);
	        	return redirect()->to(base_url('admin/sambutan'))->with('sukses', 'Data Berhasil di Simpan');
	        }
	    }

		$data = [	'title'			=> 'Tambah Sambutan',
					'content'		=> 'admin/sambutan/tambah'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// edit
	public function edit($id_sambutan)
	{
		$m_sambutan 	= new Sambutan_model();
		$sambutan 		= $m_sambutan->detail($id_sambutan);
		// Start validasi
		$rules = [
			'judul_sambutan' 	=> 'required',
		];
		
		$gambar = $this->request->getFile('gambar');
		if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
			$rules['gambar'] = 'ext_in[gambar,jpg,jpeg,gif,png,svg]|max_size[gambar,4096]';
		}

		if(strtolower($this->request->getMethod()) === 'post' && $this->validate($rules)) {
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  	= $this->request->getFile('gambar');
				$namabaru 	= $avatar->getRandomName();
	            $avatar->move(WRITEPATH . '../assets/upload/image/',$namabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/image/'.$namabaru)
			    ->fit(100, 100, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$namabaru);
	        	// masuk database
	        	$data = array(
	        		'id_sambutan'		=> $id_sambutan,
	        		'id_user'			=> $this->session->get('id_user'),
					'slug_sambutan'		=> strtolower(url_title($this->request->getVar('judul_sambutan'))),
					'judul_sambutan'	=> $this->request->getVar('judul_sambutan'),
					'ringkasan'			=> $this->request->getVar('ringkasan'),
					'isi'				=> $this->request->getVar('isi'),
					'status_sambutan'	=> $this->request->getVar('status_sambutan'),
					'keywords'			=> $this->request->getVar('keywords') ?? '',
					'gambar' 			=> $namabaru,
					'tanggal_publish'	=> date('Y-m-d H:i:s')
	        	);
	        	$m_sambutan->edit($data);
       		 	return redirect()->to(base_url('admin/sambutan/edit/'.$id_sambutan))->with('sukses', 'Data Berhasil di Simpan');
	        }else{
	        	$data = array(
	        		'id_sambutan'		=> $id_sambutan,
	        		'id_user'			=> $this->session->get('id_user'),
					'slug_sambutan'		=> strtolower(url_title($this->request->getVar('judul_sambutan'))),
					'judul_sambutan'	=> $this->request->getVar('judul_sambutan'),
					'ringkasan'			=> $this->request->getVar('ringkasan'),
					'isi'				=> $this->request->getVar('isi'),
					'status_sambutan'	=> $this->request->getVar('status_sambutan'),
					'keywords'			=> $this->request->getVar('keywords') ?? '',
					'tanggal_publish'	=> date('Y-m-d H:i:s')
	        	);
	        	$m_sambutan->edit($data);
       		 	return redirect()->to(base_url('admin/sambutan/edit/'.$id_sambutan))->with('sukses', 'Data Berhasil di Simpan');
	        }
	    }

		$data = [	'title'			=> 'Edit Sambutan: '.$sambutan->judul_sambutan,
					'sambutan'		=> $sambutan,
					'content'		=> 'admin/sambutan/edit'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// proses
	public function proses()
	{
		$m_sambutan 	= new Sambutan_model();
		$pengalihan = $this->request->getVar('pengalihan');
		$submit 	= $this->request->getVar('submit');
		$id_sambutan 	= $this->request->getVar('id_sambutan');
		
		if(empty($this->request->getVar('id_sambutan')))
		{
			return redirect()->to($pengalihan)->with('warning', 'Anda belum memilih data Sambutan.');
		}
		
		if($submit=='Publish') {
			for($i=0; $i < sizeof($id_sambutan);$i++) {
				$data = array(	'id_sambutan'		=> $id_sambutan[$i],
								'id_user'		=> $this->session->get('id_user'),
								'status_sambutan'	=> 'Publish'
							);
   				$m_sambutan->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Sambutan berhasil dipublikasikan');
		}elseif($submit=='Draft') {
			for($i=0; $i < sizeof($id_sambutan);$i++) {
				$data = array(	'id_sambutan'		=> $id_sambutan[$i],
								'id_user'		=> $this->session->get('id_user'),
								'status_sambutan'	=> 'Draft'
							);
   				$m_sambutan->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Sambutan berhasil di-draft');
		}elseif($submit=='Delete') {
			for($i=0; $i < sizeof($id_sambutan);$i++) {
				$data = array(	'id_sambutan'	=> $id_sambutan[$i]);
   				$m_sambutan->hapus($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Data berhasil dihapus');
		}
	}
	
	// Delete
	public function delete($id_sambutan)
	{
		$m_sambutan = new Sambutan_model();
		$data = ['id_sambutan'	=> $id_sambutan];
		$m_sambutan->hapus($data);
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('admin/sambutan'));
	}
}
