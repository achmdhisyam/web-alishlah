<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Program_pendidikan_model;
use App\Models\User_model;

class Program_pendidikan extends BaseController
{
	
	// index
	public function index()
	{
		
		$m_program_pendidikan 		= new Program_pendidikan_model();
		$pager 			= service('pager'); 
		// program_pendidikan
		if(isset($_GET['keywords'])) 
		{
			$keywords 		= $this->request->getVar('keywords');
			$total 			= $m_program_pendidikan->total_cari($keywords);
			$title 			= 'Hasil pencarian: '.$_GET['keywords'].' - '.$total.' ditemukan';
	        $page    		= (int) ($this->request->getGet('page') ?? 1);
	        $perPage 		= $this->website->paginasi();
	        $total   		= $total;
	        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
	        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
	        $program_pendidikan 		= $m_program_pendidikan->paginasi_admin_cari($keywords,$perPage, $page);
		}else{
			$total 			= $m_program_pendidikan->total();
			$title 			= 'Program Pendidikan ('.$total.')';
	        $page    		= (int) ($this->request->getGet('page') ?? 1);
	        $perPage 		= $this->website->paginasi();
	        $total   		= $total;
	        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
	        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
	        $program_pendidikan 		= $m_program_pendidikan->paginasi_admin($perPage, $page);
		}
		// end program_pendidikan
		
		$data = [	'title'			=> $title,
					'program_pendidikan'		=> $program_pendidikan,
					'pagination'	=> $pager_links,
					'content'		=> 'admin/program_pendidikan/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// testing
	public function testing()
	{
		$data = [	'title'			=> 'Unggah media',
				];
		echo view('admin/program_pendidikan/unggah',$data);
	}

	// jenis_program_pendidikan
	public function jenis_program_pendidikan($jenis_program_pendidikan)
	{
		
		$m_program_pendidikan 		= new Program_pendidikan_model();
		$total 			= $m_program_pendidikan->total_jenis_program_pendidikan($jenis_program_pendidikan);
		$pager 			= service('pager');
        $page    		= (int) ($this->request->getGet('page') ?? 1);
        $perPage 		= $this->website->paginasi();
        $total   		= $total;
        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
        $program_pendidikan 		= $m_program_pendidikan->jenis_program_pendidikan_all($jenis_program_pendidikan,$perPage, $page);

		$data = [	'title'			=> $jenis_program_pendidikan.' ('.$total.')',
					'program_pendidikan'		=> $program_pendidikan,
					'pagination'	=> $pager_links,
					'content'		=> 'admin/program_pendidikan/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// status_program_pendidikan
	public function status_program_pendidikan($status_program_pendidikan)
	{
		
		$m_program_pendidikan 		= new Program_pendidikan_model();
		$total 			= $m_program_pendidikan->total_status_program_pendidikan($status_program_pendidikan);
		$pager 			= service('pager');
        $page    		= (int) ($this->request->getGet('page') ?? 1);
        $perPage 		= $this->website->paginasi();
        $total   		= $total;
        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
        $program_pendidikan 		= $m_program_pendidikan->status_program_pendidikan_all($status_program_pendidikan,$perPage, $page);

		$data = [	'title'			=> $status_program_pendidikan.' ('.$total.')',
					'program_pendidikan'		=> $program_pendidikan,
					'pagination'	=> $pager_links,
					'content'		=> 'admin/program_pendidikan/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// author
	public function author($id_user)
	{
		$m_program_pendidikan 		= new Program_pendidikan_model();
		$m_user 		= new User_model();
		$user 			= $m_user->detail($id_user);
		$program_pendidikan 		= $m_program_pendidikan->author_all($id_user);
		$total 			= $m_program_pendidikan->total_author($id_user);

		$data = [	'title'					=> $user->nama.' ('.$total.')',
					'program_pendidikan'	=> $program_pendidikan,
					'content'				=> 'admin/program_pendidikan/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// Tambah
	public function tambah()
	{
		$m_program_pendidikan 		= new Program_pendidikan_model();

		// Start validasi
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'judul_program_pendidikan' 	=> 'required',
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
					'slug_program_pendidikan'	=> strtolower(url_title($this->request->getVar('judul_program_pendidikan'))),
					'judul_program_pendidikan'	=> $this->request->getVar('judul_program_pendidikan'),
					'ringkasan'			=> $this->request->getVar('ringkasan'),
					'isi'				=> $this->request->getVar('isi'),
					'status_program_pendidikan'		=> $this->request->getVar('status_program_pendidikan'),
					'jenis_program_pendidikan'		=> 'Program Pendidikan',
					'keywords'			=> $this->request->getVar('keywords'),
					'icon'				=> $this->request->getVar('icon'),
					'gambar' 			=> $namabaru,
					'urutan'			=> $this->request->getVar('urutan'),
					'tanggal_post'		=> date('Y-m-d H:i:s'),
					'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
	        	);
	        	$m_program_pendidikan->tambah($data);
	        	return redirect()->to(base_url('admin/program_pendidikan'))->with('sukses', 'Data Berhasil di Simpan');
	        }else{
	        	$data = array(
	        		'id_user'			=> $this->session->get('id_user'),
					'slug_program_pendidikan'		=> strtolower(url_title($this->request->getVar('judul_program_pendidikan'))),
					'judul_program_pendidikan'		=> $this->request->getVar('judul_program_pendidikan'),
					'ringkasan'			=> $this->request->getVar('ringkasan'),
					'isi'				=> $this->request->getVar('isi'),
					'status_program_pendidikan'		=> $this->request->getVar('status_program_pendidikan'),
					'jenis_program_pendidikan'		=> 'Program Pendidikan',
					'keywords'			=> $this->request->getVar('keywords'),
					'icon'				=> $this->request->getVar('icon'),
					'urutan'			=> $this->request->getVar('urutan'),
					'tanggal_post'		=> date('Y-m-d H:i:s'),
					'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
	        	);
	        	$m_program_pendidikan->tambah($data);
	        	return redirect()->to(base_url('admin/program_pendidikan'))->with('sukses', 'Data Berhasil di Simpan');
	        }
	    }


		$data = [	'title'			=> 'Tambah Program_pendidikan',
					'content'		=> 'admin/program_pendidikan/tambah'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// edit
	public function edit($id_program_pendidikan)
	{
		$m_program_pendidikan 		= new Program_pendidikan_model();
		$program_pendidikan 		= $m_program_pendidikan->detail($id_program_pendidikan);
		// Start validasi
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'judul_program_pendidikan' 	=> 'required',
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
	        		'id_program_pendidikan'			=> $id_program_pendidikan,
	        		'id_user'			=> $this->session->get('id_user'),
					'slug_program_pendidikan'		=> strtolower(url_title($this->request->getVar('judul_program_pendidikan'))),
					'judul_program_pendidikan'		=> $this->request->getVar('judul_program_pendidikan'),
					'ringkasan'			=> $this->request->getVar('ringkasan'),
					'isi'				=> $this->request->getVar('isi'),
					'status_program_pendidikan'		=> $this->request->getVar('status_program_pendidikan'),
					'jenis_program_pendidikan'		=> 'Program Pendidikan',
					'keywords'			=> $this->request->getVar('keywords'),
					'icon'				=> $this->request->getVar('icon'),
					'urutan'			=> $this->request->getVar('urutan'),
					'gambar' 			=> $namabaru,
					'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
	        	);
	        	$m_program_pendidikan->edit($data);
       		 	return redirect()->to(base_url('admin/program_pendidikan'))->with('sukses', 'Data Berhasil di Simpan');
	        }else{
	        	$data = array(
	        		'id_program_pendidikan'			=> $id_program_pendidikan,
	        		'id_user'			=> $this->session->get('id_user'),
					'slug_program_pendidikan'		=> strtolower(url_title($this->request->getVar('judul_program_pendidikan'))),
					'judul_program_pendidikan'		=> $this->request->getVar('judul_program_pendidikan'),
					'ringkasan'			=> $this->request->getVar('ringkasan'),
					'isi'				=> $this->request->getVar('isi'),
					'status_program_pendidikan'		=> $this->request->getVar('status_program_pendidikan'),
					'jenis_program_pendidikan'		=> 'Program Pendidikan',
					'keywords'			=> $this->request->getVar('keywords'),
					'icon'				=> $this->request->getVar('icon'),
					'urutan'			=> $this->request->getVar('urutan'),
					'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
	        	);
	        	$m_program_pendidikan->edit($data);
       		 	return redirect()->to(base_url('admin/program_pendidikan'))->with('sukses', 'Data Berhasil di Simpan');
	        }
	    }

		$data = [	'title'			=> 'Edit Program_pendidikan: '.$program_pendidikan->judul_program_pendidikan,
					'program_pendidikan'		=> $program_pendidikan,
					'content'		=> 'admin/program_pendidikan/edit'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// proses
	public function proses()
	{
		$m_program_pendidikan 		= new Program_pendidikan_model();
		// proses
		$pengalihan = $this->request->getVar('pengalihan');
		$submit 	= $this->request->getVar('submit');
		$id_program_pendidikan 	= $this->request->getVar('id_program_pendidikan');
		// check program_pendidikan
		if(empty($this->request->getVar('id_program_pendidikan')))
		{
			return redirect()->to($pengalihan)->with('warning', 'Anda belum memilih program_pendidikan. Pilih salah satu program_pendidikan');
		}
		// end check program_pendidikan
		// proses
		if($submit=='Update') {
   			for($i=0; $i < sizeof($id_program_pendidikan);$i++) {
				$data = array(	'id_program_pendidikan'		=> $id_program_pendidikan[$i],
								'id_user'		=> $this->session->get('id_user'),
								'jenis_program_pendidikan'	=> $this->request->getVar('jenis_program_pendidikan')
							);
   				$m_program_pendidikan->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Program_pendidikan berhasil diupdate jenis program_pendidikannya');
		}elseif($submit=='Publish') {
			for($i=0; $i < sizeof($id_program_pendidikan);$i++) {
				$data = array(	'id_program_pendidikan'		=> $id_program_pendidikan[$i],
								'id_user'		=> $this->session->get('id_user'),
								'status_program_pendidikan'	=> 'Publish'
							);
   				$m_program_pendidikan->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Program_pendidikan berhasil dipublikasikan');
		}elseif($submit=='Draft') {
			for($i=0; $i < sizeof($id_program_pendidikan);$i++) {
				$data = array(	'id_program_pendidikan'		=> $id_program_pendidikan[$i],
								'id_user'		=> $this->session->get('id_user'),
								'status_program_pendidikan'	=> 'Draft'
							);
   				$m_program_pendidikan->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Program_pendidikan berhasil tidak dipublikasikan');
		}elseif($submit=='Delete') {
			for($i=0; $i < sizeof($id_program_pendidikan);$i++) {
				$data = array(	'id_program_pendidikan'	=> $id_program_pendidikan[$i]);
   				$m_program_pendidikan->delete($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Data berhasil dihapus');
		}
		// end proses
	}
	
	// Delete
	public function delete($id_program_pendidikan)
	{
		
		$m_program_pendidikan = new Program_pendidikan_model();
		$data = ['id_program_pendidikan'	=> $id_program_pendidikan];
		$m_program_pendidikan->delete($data);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('admin/program_pendidikan'));
	}

	// template
	public function template()
	{
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		// Set headers
		$sheet->setCellValue('A1', 'Judul Program');
		$sheet->setCellValue('B1', 'Ringkasan');
		$sheet->setCellValue('C1', 'Isi Konten');
		$sheet->setCellValue('D1', 'Status (Publish/Draft)');
		$sheet->setCellValue('E1', 'Icon');
		$sheet->setCellValue('F1', 'Urutan');
		$sheet->setCellValue('G1', 'Keywords');
		
		// Put some sample data
		$sheet->setCellValue('A2', 'Program Kelas Unggulan');
		$sheet->setCellValue('B2', 'Deskripsi singkat program kelas unggulan.');
		$sheet->setCellValue('C2', '<p>Ini adalah isi lengkap konten program kelas unggulan dengan format HTML.</p>');
		$sheet->setCellValue('D2', 'Publish');
		$sheet->setCellValue('E2', 'fas fa-star');
		$sheet->setCellValue('F2', '1');
		$sheet->setCellValue('G2', 'unggulan, program, sekolah');
		
		// Set headers for download
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="template-program-pendidikan.xlsx"');
		header('Cache-Control: max-age=0');
		
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		exit();
	}

	// import
	public function import()
	{
		$m_program_pendidikan = new Program_pendidikan_model();
		
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
					'slug_program_pendidikan' => strtolower(url_title($cells[0])),
					'judul_program_pendidikan' => $cells[0],
					'ringkasan' => $cells[1] ?? '',
					'isi' => $cells[2] ?? '',
					'status_program_pendidikan' => (!empty($cells[3]) && in_array(ucfirst(strtolower($cells[3])), ['Publish', 'Draft'])) ? ucfirst(strtolower($cells[3])) : 'Publish',
					'jenis_program_pendidikan' => 'Program Pendidikan',
					'icon' => $cells[4] ?? '',
					'urutan' => is_numeric($cells[5]) ? intval($cells[5]) : 0,
					'keywords' => $cells[6] ?? '',
					'tanggal_post' => date('Y-m-d H:i:s'),
					'tanggal_publish' => date('Y-m-d H:i:s')
				];
				
				$m_program_pendidikan->tambah($data);
				$successCount++;
			}
			
			// Delete temporary file
			@unlink(WRITEPATH . '../assets/upload/file/' . $fileName);
			
			return redirect()->to(base_url('admin/program_pendidikan'))->with('sukses', $successCount . ' data Program Pendidikan berhasil diimport.');
		}
		
		$data = [
			'title' => 'Import Program Pendidikan',
			'content' => 'admin/program_pendidikan/import'
		];
		echo view('admin/layout/wrapper', $data);
	}
}