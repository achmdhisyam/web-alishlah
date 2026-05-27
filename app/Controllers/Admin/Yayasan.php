<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Yayasan_model;
use App\Models\User_model;

class Yayasan extends BaseController
{
	// index
	public function index()
	{
		$m_yayasan 		= new Yayasan_model();
		$pager 			= service('pager'); 
		
		if(isset($_GET['keywords'])) 
		{
			$keywords 		= $this->request->getVar('keywords');
			$total 			= $m_yayasan->total_cari($keywords);
			$title 			= 'Hasil pencarian: '.$_GET['keywords'].' - '.$total.' ditemukan';
	        $page    		= (int) ($this->request->getGet('page') ?? 1);
	        $perPage 		= $this->website->paginasi();
	        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
	        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
	        $yayasan 		= $m_yayasan->paginasi_admin_cari($keywords,$perPage, $page);
		}else{
			$total 			= $m_yayasan->total();
			$title 			= 'Informasi Yayasan ('.$total.')';
	        $page    		= (int) ($this->request->getGet('page') ?? 1);
	        $perPage 		= $this->website->paginasi();
	        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
	        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
	        $yayasan 		= $m_yayasan->paginasi_admin($perPage, $page);
		}
		
		$data = [	'title'			=> $title,
					'yayasan'		=> $yayasan,
					'pagination'	=> $pager_links,
					'content'		=> 'admin/yayasan/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// status_yayasan
	public function status_yayasan($status_yayasan)
	{
		$m_yayasan 		= new Yayasan_model();
		$total 			= $m_yayasan->total_status_yayasan($status_yayasan);
		$pager 			= service('pager');
        $page    		= (int) ($this->request->getGet('page') ?? 1);
        $perPage 		= $this->website->paginasi();
        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
        $yayasan 		= $m_yayasan->status_yayasan_all($status_yayasan,$perPage, $page);

		$data = [	'title'			=> $status_yayasan.' ('.$total.')',
					'yayasan'		=> $yayasan,
					'pagination'	=> $pager_links,
					'content'		=> 'admin/yayasan/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// author
	public function author($id_user)
	{
		$m_yayasan 		= new Yayasan_model();
		$m_user 		= new User_model();
		$user 			= $m_user->detail($id_user);
		$yayasan 		= $m_yayasan->author_all($id_user);
		$total 			= $m_yayasan->total_author($id_user);

		$data = [	'title'					=> $user->nama.' ('.$total.')',
					'yayasan'	=> $yayasan,
					'content'				=> 'admin/yayasan/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// Tambah
	public function tambah()
	{
		$m_yayasan 		= new Yayasan_model();

		// Start validasi
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'judul_yayasan' 	=> 'required',
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
			    ->fit(100, 100, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$namabaru);
	        	// masuk database
	        	$data = array(
	        		'id_user'					=> $this->session->get('id_user'),
					'slug_yayasan'	=> strtolower(url_title($this->request->getVar('judul_yayasan'))),
					'judul_yayasan'	=> $this->request->getVar('judul_yayasan'),
					'ringkasan'			=> $this->request->getVar('ringkasan'),
					'isi'				=> $this->request->getVar('isi'),
					'status_yayasan'		=> $this->request->getVar('status_yayasan'),
					'keywords'			=> $this->request->getVar('keywords'),
					'icon'				=> $this->request->getVar('icon'),
					'gambar' 			=> $namabaru,
					'urutan'			=> $this->request->getVar('urutan'),
					'tanggal_post'		=> date('Y-m-d H:i:s'),
					'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
	        	);
	        	$m_yayasan->tambah($data);
	        	return redirect()->to(base_url('admin/yayasan'))->with('sukses', 'Data Berhasil di Simpan');
	        }else{
	        	$data = array(
	        		'id_user'			=> $this->session->get('id_user'),
					'slug_yayasan'		=> strtolower(url_title($this->request->getVar('judul_yayasan'))),
					'judul_yayasan'		=> $this->request->getVar('judul_yayasan'),
					'ringkasan'			=> $this->request->getVar('ringkasan'),
					'isi'				=> $this->request->getVar('isi'),
					'status_yayasan'		=> $this->request->getVar('status_yayasan'),
					'keywords'			=> $this->request->getVar('keywords'),
					'icon'				=> $this->request->getVar('icon'),
					'urutan'			=> $this->request->getVar('urutan'),
					'tanggal_post'		=> date('Y-m-d H:i:s'),
					'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
	        	);
	        	$m_yayasan->tambah($data);
	        	return redirect()->to(base_url('admin/yayasan'))->with('sukses', 'Data Berhasil di Simpan');
	        }
	    }

		$data = [	'title'			=> 'Tambah Yayasan',
					'content'		=> 'admin/yayasan/tambah'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// edit
	public function edit($id_yayasan)
	{
		$m_yayasan 		= new Yayasan_model();
		$yayasan 		= $m_yayasan->detail($id_yayasan);
		// Start validasi
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'judul_yayasan' 	=> 'required',
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
			    ->fit(100, 100, 'center')
			    ->save(WRITEPATH . '../assets/upload/image/thumbs/'.$namabaru);
	        	// masuk database
	        	$data = array(
	        		'id_yayasan'			=> $id_yayasan,
	        		'id_user'			=> $this->session->get('id_user'),
					'slug_yayasan'		=> strtolower(url_title($this->request->getVar('judul_yayasan'))),
					'judul_yayasan'		=> $this->request->getVar('judul_yayasan'),
					'ringkasan'			=> $this->request->getVar('ringkasan'),
					'isi'				=> $this->request->getVar('isi'),
					'status_yayasan'		=> $this->request->getVar('status_yayasan'),
					'keywords'			=> $this->request->getVar('keywords'),
					'icon'				=> $this->request->getVar('icon'),
					'urutan'			=> $this->request->getVar('urutan'),
					'gambar' 			=> $namabaru,
					'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
	        	);
	        	$m_yayasan->edit($data);
       		 	return redirect()->to(base_url('admin/yayasan'))->with('sukses', 'Data Berhasil di Simpan');
	        }else{
	        	$data = array(
	        		'id_yayasan'			=> $id_yayasan,
	        		'id_user'			=> $this->session->get('id_user'),
					'slug_yayasan'		=> strtolower(url_title($this->request->getVar('judul_yayasan'))),
					'judul_yayasan'		=> $this->request->getVar('judul_yayasan'),
					'ringkasan'			=> $this->request->getVar('ringkasan'),
					'isi'				=> $this->request->getVar('isi'),
					'status_yayasan'		=> $this->request->getVar('status_yayasan'),
					'keywords'			=> $this->request->getVar('keywords'),
					'icon'				=> $this->request->getVar('icon'),
					'urutan'			=> $this->request->getVar('urutan'),
					'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
	        	);
	        	$m_yayasan->edit($data);
       		 	return redirect()->to(base_url('admin/yayasan'))->with('sukses', 'Data Berhasil di Simpan');
	        }
	    }

		$data = [	'title'			=> 'Edit Yayasan: '.$yayasan->judul_yayasan,
					'yayasan'		=> $yayasan,
					'content'		=> 'admin/yayasan/edit'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// proses
	public function proses()
	{
		$m_yayasan 		= new Yayasan_model();
		$pengalihan = $this->request->getVar('pengalihan');
		$submit 	= $this->request->getVar('submit');
		$id_yayasan 	= $this->request->getVar('id_yayasan');
		
		if(empty($this->request->getVar('id_yayasan')))
		{
			return redirect()->to($pengalihan)->with('warning', 'Anda belum memilih data Yayasan.');
		}
		
		if($submit=='Publish') {
			for($i=0; $i < sizeof($id_yayasan);$i++) {
				$data = array(	'id_yayasan'		=> $id_yayasan[$i],
								'id_user'		=> $this->session->get('id_user'),
								'status_yayasan'	=> 'Publish'
							);
   				$m_yayasan->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Yayasan berhasil dipublikasikan');
		}elseif($submit=='Draft') {
			for($i=0; $i < sizeof($id_yayasan);$i++) {
				$data = array(	'id_yayasan'		=> $id_yayasan[$i],
								'id_user'		=> $this->session->get('id_user'),
								'status_yayasan'	=> 'Draft'
							);
   				$m_yayasan->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Yayasan berhasil di-draft');
		}elseif($submit=='Delete') {
			for($i=0; $i < sizeof($id_yayasan);$i++) {
				$data = array(	'id_yayasan'	=> $id_yayasan[$i]);
   				$m_yayasan->hapus($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Data berhasil dihapus');
		}
	}
	
	// Delete
	public function delete($id_yayasan)
	{
		$m_yayasan = new Yayasan_model();
		$data = ['id_yayasan'	=> $id_yayasan];
		$m_yayasan->hapus($data);
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('admin/yayasan'));
	}

	// template
	public function template()
	{
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		// Set headers
		$sheet->setCellValue('A1', 'Judul Yayasan');
		$sheet->setCellValue('B1', 'Ringkasan');
		$sheet->setCellValue('C1', 'Isi Konten');
		$sheet->setCellValue('D1', 'Status (Publish/Draft)');
		$sheet->setCellValue('E1', 'Icon');
		$sheet->setCellValue('F1', 'Urutan');
		$sheet->setCellValue('G1', 'Keywords');
		
		// Put some sample data
		$sheet->setCellValue('A2', 'Sejarah Singkat Yayasan');
		$sheet->setCellValue('B2', 'Deskripsi singkat mengenai sejarah yayasan.');
		$sheet->setCellValue('C2', '<p>Ini adalah isi lengkap konten sejarah yayasan dengan format HTML.</p>');
		$sheet->setCellValue('D2', 'Publish');
		$sheet->setCellValue('E2', 'fas fa-landmark');
		$sheet->setCellValue('F2', '1');
		$sheet->setCellValue('G2', 'sejarah, yayasan, profil');
		
		// Set headers for download
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="template-yayasan.xlsx"');
		header('Cache-Control: max-age=0');
		
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		exit();
	}

	// import
	public function import()
	{
		$m_yayasan = new Yayasan_model();
		
		if($this->request->getMethod() === 'POST' && $this->validate([
			'file_excel' => [
				'ext_in[file_excel,xlsx,xls,csv]',
				'max_size[file_excel,102400]',
			],
		])) {
			$file = $this->request->getFile('file_excel');
			$fileName = $file->getRandomName();
			$file->move(WRITEPATH . '../assets/upload/file/', $fileName);
			$this->compressImage(WRITEPATH . '../assets/upload/file/' . $fileName);
			
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
			$reader->setReadDataOnly(TRUE);
			$spreadsheet = $reader->load('../assets/upload/file/' . $fileName);
			$worksheet = $spreadsheet->getActiveSheet();
			
			$successCount = 0;
			$isFirstRow = true;
			
			foreach ($worksheet->getRowIterator() as $row) {
				if ($isFirstRow) {
					$isFirstRow = false;
					continue; // skip header row
				}
				
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(FALSE);
				
				$cells = [];
				foreach ($cellIterator as $cell) {
					$cells[] = $cell->getValue();
				}
				
				// check if row is empty
				if (empty($cells[0])) {
					continue;
				}
				
				$data = [
					'id_user' => $this->session->get('id_user'),
					'slug_yayasan' => strtolower(url_title($cells[0])),
					'judul_yayasan' => $cells[0],
					'ringkasan' => $cells[1] ?? '',
					'isi' => $cells[2] ?? '',
					'status_yayasan' => (!empty($cells[3]) && in_array(ucfirst(strtolower($cells[3])), ['Publish', 'Draft'])) ? ucfirst(strtolower($cells[3])) : 'Publish',
					'icon' => $cells[4] ?? '',
					'urutan' => is_numeric($cells[5]) ? intval($cells[5]) : 0,
					'keywords' => $cells[6] ?? '',
					'tanggal_post' => date('Y-m-d H:i:s'),
					'tanggal_publish' => date('Y-m-d H:i:s')
				];
				
				$m_yayasan->tambah($data);
				$successCount++;
			}
			
			// Delete temporary file
			@unlink(WRITEPATH . '../assets/upload/file/' . $fileName);
			
			return redirect()->to(base_url('admin/yayasan'))->with('sukses', $successCount . ' data Yayasan berhasil diimport.');
		}
		
		$data = [
			'title' => 'Import Data Yayasan',
			'content' => 'admin/yayasan/import'
		];
		echo view('admin/layout/wrapper', $data);
	}
}
