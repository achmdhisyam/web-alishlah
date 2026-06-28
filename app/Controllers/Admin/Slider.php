<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Slider_model;

class Slider extends BaseController
{
	// index
	public function index()
	{
		$m_slider 			= new Slider_model();
		$pager 				= service('pager'); 
		
		if(isset($_GET['keywords'])) 
		{
			$keywords 		= $this->request->getVar('keywords');
			$total 			= $m_slider->total_cari($keywords);
			$title 			= 'Hasil pencarian slider: '.$_GET['keywords'].' - '.$total.' ditemukan';
	        $page    		= (int) ($this->request->getGet('page') ?? 1);
	        $perPage 		= $this->website->paginasi();
	        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
	        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
	        $slider 		= $m_slider->paginasi_admin_cari($keywords,$perPage, $page);
		}else{
			$total 			= $m_slider->total();
			$title 			= 'Slider Homepage ('.$total.')';
	        $page    		= (int) ($this->request->getGet('page') ?? 1);
	        $perPage 		= $this->website->paginasi();
	        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
	        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
	        $slider 		= $m_slider->paginasi_admin($perPage, $page);
		}

		$data = [	'title'				=> $title,
					'slider'			=> $slider,
					'pagination'		=> $pager_links,
					'content'			=> 'admin/slider/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// Tambah
	public function tambah()
	{
		$m_slider 			= new Slider_model();

		// Start validasi
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'judul_slider' 	=> 'required',
				'gambar'	 	=> [
					                'uploaded[gambar]',
					                'ext_in[gambar,jpg,jpeg,gif,png,svg]',
					                'max_size[gambar,102400]',
            					],
        	])) {
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  	= $this->request->getFile('gambar');
				$namabaru 	= $avatar->getRandomName();
	            $avatar->move(WRITEPATH . '../assets/upload/image/',$namabaru);
	            $this->compressImage(WRITEPATH . '../assets/upload/image/' . $namabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/image/'.$namabaru)
			    ->fit(300, 300, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$namabaru);
	        	// masuk database
	        	$data = array(
	        		'id_user'			=> $this->session->get('id_user'),
					'judul_slider'		=> $this->request->getVar('judul_slider'),
					'isi'				=> $this->request->getVar('isi'),
					'gambar' 			=> $namabaru,
					'website'			=> $this->request->getVar('website'),
					'text_website'		=> $this->request->getVar('text_website'),
					'status_text'		=> $this->request->getVar('status_text'),
					'tanggal_post'		=> date('Y-m-d H:i:s')
	        	);
	        	$m_slider->tambah($data);
        		return redirect()->to(base_url('admin/slider'))->with('sukses', 'Data Slider Berhasil disimpan');
        	}
        }

		$data = [	'title'				=> 'Tambah Slider',
					'content'			=> 'admin/slider/tambah'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// edit
	public function edit($id_slider)
	{
		$m_slider 			= new Slider_model();
		$slider 			= $m_slider->detail($id_slider);

		// Start validasi
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'judul_slider' 	=> 'required',
				'gambar'	 	=> [
					                'ext_in[gambar,jpg,jpeg,gif,png,svg]',
					                'max_size[gambar,102400]',
            					],
        	])) {
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  	= $this->request->getFile('gambar');
				$namabaru 	= $avatar->getRandomName();
	            $avatar->move(WRITEPATH . '../assets/upload/image/',$namabaru);
	            $this->compressImage(WRITEPATH . '../assets/upload/image/' . $namabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/image/'.$namabaru)
			    ->fit(300, 300, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$namabaru);
	        	// masuk database
			    $data = array(
	        		'id_slider'			=> $id_slider,
	        		'id_user'			=> $this->session->get('id_user'),
					'judul_slider'		=> $this->request->getVar('judul_slider'),
					'isi'				=> $this->request->getVar('isi'),
					'gambar' 			=> $namabaru,
					'website'			=> $this->request->getVar('website'),
					'text_website'		=> $this->request->getVar('text_website'),
					'status_text'		=> $this->request->getVar('status_text'),
	        	);
	        	$m_slider->edit($data);
        		return redirect()->to(base_url('admin/slider'))->with('sukses', 'Data Slider Berhasil diubah');
			}else{
				$data = array(
	        		'id_slider'			=> $id_slider,
	        		'id_user'			=> $this->session->get('id_user'),
					'judul_slider'		=> $this->request->getVar('judul_slider'),
					'isi'				=> $this->request->getVar('isi'),
					'website'			=> $this->request->getVar('website'),
					'text_website'		=> $this->request->getVar('text_website'),
					'status_text'		=> $this->request->getVar('status_text'),
	        	);
	        	$m_slider->edit($data);
        		return redirect()->to(base_url('admin/slider'))->with('sukses', 'Data Slider Berhasil diubah');
			}
		}

		$data = [	'title'				=> 'Edit Slider: '.$slider->judul_slider,
					'slider'			=> $slider,
					'content'			=> 'admin/slider/edit'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// Delete
	public function delete($id_slider)
	{
		$m_slider = new Slider_model();
		$slider = $m_slider->detail($id_slider);
		if ($slider && !empty($slider->gambar)) {
			$path = WRITEPATH . '../assets/upload/image/' . $slider->gambar;
			$thumb_path = WRITEPATH . '../assets/upload/image/thumbs/' . $slider->gambar;
			if (file_exists($path)) { unlink($path); }
			if (file_exists($thumb_path)) { unlink($thumb_path); }
		}
		$m_slider->delete($id_slider);
		$this->session->setFlashdata('sukses','Data slider telah dihapus');
		return redirect()->to(base_url('admin/slider'));
	}
}
