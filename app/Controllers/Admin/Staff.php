<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Staff_model;
use App\Models\Kategori_staff_model;

class Staff extends BaseController
{

	// mainpage
	public function index()
	{
		
		$m_staff 			= new Staff_model();
		$m_kategori_staff 	= new Kategori_staff_model();
		$kategori_staff 	= $m_kategori_staff->listing();
		$pager 				= service('pager'); 
		// staff
		if(isset($_GET['keywords'])) 
		{
			$keywords 		= $this->request->getVar('keywords');
			$total 			= $m_staff->total_cari($keywords);
			$title 			= 'Hasil pencarian: '.$_GET['keywords'].' - '.$total.' ditemukan';
	        $page    		= (int) ($this->request->getGet('page') ?? 1);
	        $perPage 		= $this->website->paginasi();
	        $total   		= $total;
	        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
	        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
	        $staff 			= $m_staff->paginasi_admin_cari($keywords,$perPage, $page);
		}else{
			$total 			= $m_staff->total();
			$title 			= 'Staff dan Guru ('.$total.')';
	        $page    		= (int) ($this->request->getGet('page') ?? 1);
	        $perPage 		= $this->website->paginasi();
	        $total   		= $total;
	        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
	        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
	        $staff 			= $m_staff->paginasi_admin($perPage, $page);
		}
		// end staff
		

		$data = [	'title'			=> $title,
					'staff'			=> $staff,
					'kategori_staff'=> $kategori_staff,
					'pagination'	=> $pager_links,
					'content'		=> 'admin/staff/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// proses
	public function proses()
	{
		
		$m_kategori 	= new Kategori_staff_model();
		$m_staff 		= new Staff_model();
		// proses
		$pengalihan = $this->request->getVar('pengalihan');
		$submit 	= $this->request->getVar('submit');
		$id_staff 	= $this->request->getVar('id_staff');
		// check staff
		if(empty($this->request->getVar('id_staff')))
		{
			return redirect()->to($pengalihan)->with('warning', 'Anda belum memilih staff. Pilih salah satu staff');
		}
		// end check staff
		// proses
		if($submit=='Update') {
   			for($i=0; $i < sizeof($id_staff);$i++) {
				$data = array(	'id_staff'			=> $id_staff[$i],
								'id_user'			=> $this->session->get('id_user'),
								'id_kategori_staff'	=> $this->request->getVar('id_kategori_staff')
							);
   				$m_staff->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Staff berhasil diupdate jenis staffnya');
		}elseif($submit=='Publish') {
			for($i=0; $i < sizeof($id_staff);$i++) {
				$data = array(	'id_staff'		=> $id_staff[$i],
								'id_user'		=> $this->session->get('id_user'),
								'status_staff'	=> 'Publish'
							);
   				$m_staff->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Staff berhasil dipublikasikan');
		}elseif($submit=='Draft') {
			for($i=0; $i < sizeof($id_staff);$i++) {
				$data = array(	'id_staff'		=> $id_staff[$i],
								'id_user'		=> $this->session->get('id_user'),
								'status_staff'	=> 'Draft'
							);
   				$m_staff->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Staff berhasil tidak dipublikasikan');
		}elseif($submit=='Delete') {
			for($i=0; $i < sizeof($id_staff);$i++) {
				$data = array(	'id_staff'	=> $id_staff[$i]);
   				$m_staff->delete($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Data berhasil dihapus');
		}
		// end proses
	}

	// tambah
	public function tambah()
	{
		
		$m_staff 			= new Staff_model();
		$m_kategori_staff 	= new Kategori_staff_model();
		$staff 				= $m_staff->listing();
		$kategori_staff 	= $m_kategori_staff->listing();

		// Start validasi
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'nama' 		=> 'required',
				'gambar'	 	=> [
					                'ext_in[gambar,jpg,jpeg,gif,png,svg]',
					                'max_size[gambar,4096]',
            					],
        	])) {
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  	= $this->request->getFile('gambar');
				$namabaru 	= $avatar->getRandomName();
	            $avatar->move(WRITEPATH . '../assets/upload/staff/',$namabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/staff/'.$namabaru)
			    ->fit(300, 300, 'center')
			    ->save(WRITEPATH . '../assets/upload/staff/thumbs/'.$namabaru);
	        	// masuk database
	        	// masuk database
				$data = [	'id_user'		=> $this->session->get('id_user'),
							'id_kategori_staff'	=> $this->request->getPost('id_kategori_staff'),
							'urutan'	=> $this->request->getPost('urutan'),
							'nama'			=> $this->request->getPost('nama'),
							'jenis_kelamin'	=> $this->request->getPost('jenis_kelamin'),
							'jabatan'		=> $this->request->getPost('jabatan'),
							'alamat'		=> $this->request->getPost('alamat'),
							'telepon'		=> $this->request->getPost('telepon'),
							'website'		=> $this->request->getPost('website'),
							'email'			=> $this->request->getPost('email'),
							'keahlian'		=> $this->request->getPost('keahlian'),
							'gambar'		=> $namabaru,
							'status_staff'	=> $this->request->getPost('status_staff'),
							'tempat_lahir'	=> $this->request->getPost('tempat_lahir'),
							'tanggal_lahir'	=> date('Y-m-d',strtotime($this->request->getPost('tanggal_lahir'))),
							'tanggal_post'	=> date('Y-m-d H:i:s')
						];
				$m_staff->tambah($data);
				// masuk database
				$this->session->setFlashdata('sukses','Data telah ditambah');
				return redirect()->to(base_url('admin/staff'));
			}else{
				// masuk database
				$data = [	'id_user'		=> $this->session->get('id_user'),
							'id_kategori_staff'	=> $this->request->getPost('id_kategori_staff'),
							'urutan'	=> $this->request->getPost('urutan'),
							'nama'			=> $this->request->getPost('nama'),
							'jenis_kelamin'	=> $this->request->getPost('jenis_kelamin'),
							'jabatan'		=> $this->request->getPost('jabatan'),
							'alamat'		=> $this->request->getPost('alamat'),
							'telepon'		=> $this->request->getPost('telepon'),
							'website'		=> $this->request->getPost('website'),
							'email'			=> $this->request->getPost('email'),
							'keahlian'		=> $this->request->getPost('keahlian'),
							// 'gambar'		=> $namabaru,
							'status_staff'	=> $this->request->getPost('status_staff'),
							'tempat_lahir'	=> $this->request->getPost('tempat_lahir'),
							'tanggal_lahir'	=> date('Y-m-d',strtotime($this->request->getPost('tanggal_lahir'))),
							'tanggal_post'	=> date('Y-m-d H:i:s')
						];
				$m_staff->tambah($data);
				// masuk database
				$this->session->setFlashdata('sukses','Data telah ditambah');
				return redirect()->to(base_url('admin/staff'));
			}
	    }else{
			$data = [	'title'			=> 'Tambah Data Staff',
						'staff'			=> $staff,
						'kategori_staff'=> $kategori_staff,
						'content'		=> 'admin/staff/tambah'
					];
			echo view('admin/layout/wrapper',$data);
		}
	}

	// edit
	public function edit($id_staff)
	{
		
		$m_kategori_staff 	= new Kategori_staff_model();
		$m_staff 			= new Staff_model();
		$staff 				= $m_staff->detail($id_staff);
		$kategori_staff 	= $m_kategori_staff->listing();

		// Start validasi
		if($this->request->getMethod() === 'POST' && $this->validate(
			[
				'nama' 		=> 'required',
				'gambar'	 	=> [
					                'ext_in[gambar,jpg,jpeg,gif,png,svg]',
					                'max_size[gambar,4096]',
            					],
        	])) {
			if(!empty($_FILES['gambar']['name'])) {
				// Image upload
				$avatar  	= $this->request->getFile('gambar');
				$namabaru 	= $avatar->getRandomName();
	            $avatar->move(WRITEPATH . '../assets/upload/staff/',$namabaru);
	            // Create thumb
	            $image = \Config\Services::image()
			    ->withFile(WRITEPATH . '../assets/upload/staff/'.$namabaru)
			    ->fit(300, 300, 'center')
			    ->save(WRITEPATH . '../assets/upload/staff/thumbs/'.$namabaru);
	        	// masuk database
	        	// masuk database
				$data = [	'id_staff'		=> $id_staff,
							'id_user'		=> $this->session->get('id_user'),
							'id_kategori_staff'	=> $this->request->getPost('id_kategori_staff'),
							'urutan'		=> $this->request->getPost('urutan'),
							'nama'			=> $this->request->getPost('nama'),
							'jenis_kelamin'	=> $this->request->getPost('jenis_kelamin'),
							'jabatan'		=> $this->request->getPost('jabatan'),
							'alamat'		=> $this->request->getPost('alamat'),
							'telepon'		=> $this->request->getPost('telepon'),
							'website'		=> $this->request->getPost('website'),
							'email'			=> $this->request->getPost('email'),
							'keahlian'		=> $this->request->getPost('keahlian'),
							'gambar'		=> $namabaru,
							'status_staff'	=> $this->request->getPost('status_staff'),
							'tempat_lahir'	=> $this->request->getPost('tempat_lahir'),
							'tanggal_lahir'	=> date('Y-m-d',strtotime($this->request->getPost('tanggal_lahir'))),
						];
				$m_staff->edit($data);
				// masuk database
				$this->session->setFlashdata('sukses','Data telah disimpan');
				return redirect()->to(base_url('admin/staff'));
			}else{
				// masuk database
				$data = [	'id_staff'		=> $id_staff,
							'id_user'		=> $this->session->get('id_user'),
							'id_kategori_staff'	=> $this->request->getPost('id_kategori_staff'),
							'urutan'		=> $this->request->getPost('urutan'),
							'nama'			=> $this->request->getPost('nama'),
							'jenis_kelamin'	=> $this->request->getPost('jenis_kelamin'),
							'jabatan'		=> $this->request->getPost('jabatan'),
							'alamat'		=> $this->request->getPost('alamat'),
							'telepon'		=> $this->request->getPost('telepon'),
							'website'		=> $this->request->getPost('website'),
							'email'			=> $this->request->getPost('email'),
							'keahlian'		=> $this->request->getPost('keahlian'),
							// 'gambar'		=> $namabaru,
							'status_staff'	=> $this->request->getPost('status_staff'),
							'tempat_lahir'	=> $this->request->getPost('tempat_lahir'),
							'tanggal_lahir'	=> date('Y-m-d',strtotime($this->request->getPost('tanggal_lahir'))),
						];
				$m_staff->edit($data);
				// masuk database
				$this->session->setFlashdata('sukses','Data telah disimpan');
				return redirect()->to(base_url('admin/staff'));
			}
	    }else{
			$data = [	'title'			=> 'Edit Data Staff: '.$staff->nama,
						'staff'			=> $staff,
						'kategori_staff'=> $kategori_staff,
						'content'		=> 'admin/staff/edit'
					];
			echo view('admin/layout/wrapper',$data);
		}
	}

	// delete
	public function delete($id_staff)
	{
		
		$m_staff = new Staff_model();
		$data = ['id_staff'	=> $id_staff];
		$m_staff->delete($data);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('admin/staff'));
	}

	// template
	public function template()
	{
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		// Set headers
		$sheet->setCellValue('A1', 'Nama Lengkap');
		$sheet->setCellValue('B1', 'Kategori Staff');
		$sheet->setCellValue('C1', 'Jenis Kelamin (L/P)');
		$sheet->setCellValue('D1', 'Jabatan');
		$sheet->setCellValue('E1', 'Alamat');
		$sheet->setCellValue('F1', 'Telepon');
		$sheet->setCellValue('G1', 'Email');
		$sheet->setCellValue('H1', 'Website');
		$sheet->setCellValue('I1', 'Keahlian');
		$sheet->setCellValue('J1', 'Tempat Lahir');
		$sheet->setCellValue('K1', 'Tanggal Lahir (YYYY-MM-DD)');
		$sheet->setCellValue('L1', 'Status (Publish/Draft)');
		$sheet->setCellValue('M1', 'Urutan');
		
		// Put some sample data
		$sheet->setCellValue('A2', 'Dr. John Doe, M.Kom');
		$sheet->setCellValue('B2', 'Guru');
		$sheet->setCellValue('C2', 'L');
		$sheet->setCellValue('D2', 'Kepala Lab Komputer');
		$sheet->setCellValue('E2', 'Jl. Merdeka No. 45 Bandung');
		$sheet->setCellValue('F2', '081234567890');
		$sheet->setCellValue('G2', 'johndoe@sekolah.sch.id');
		$sheet->setCellValue('H2', 'https://johndoe.com');
		$sheet->setCellValue('I2', 'Pemrograman Web, IoT');
		$sheet->setCellValue('J2', 'Bandung');
		$sheet->setCellValue('K2', '1985-12-25');
		$sheet->setCellValue('L2', 'Publish');
		$sheet->setCellValue('M2', '1');
		
		// Set headers for download
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="template-staff.xlsx"');
		header('Cache-Control: max-age=0');
		
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		exit();
	}

	// import
	public function import()
	{
		$m_staff = new Staff_model();
		$m_kategori_staff = new Kategori_staff_model();
		
		if($this->request->getMethod() === 'POST' && $this->validate([
			'file_excel' => [
				'ext_in[file_excel,xlsx,xls,csv]',
				'max_size[file_excel,4096]',
			],
		])) {
			$file = $this->request->getFile('file_excel');
			$fileName = $file->getRandomName();
			$file->move(WRITEPATH . '../assets/upload/file/', $fileName);
			
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
			$reader->setReadDataOnly(TRUE);
			$spreadsheet = $reader->load('../assets/upload/file/' . $fileName);
			$worksheet = $spreadsheet->getActiveSheet();
			
			$successCount = 0;
			$isFirstRow = true;
			
			// Load all categories for mapping
			$kategori_list = $m_kategori_staff->listing();
			
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
				
				// Map category name to ID or create if not exists
				$kategori_name = trim($cells[1] ?? 'Guru');
				$id_kategori_staff = 0;
				foreach ($kategori_list as $kat) {
					if (strtolower($kat->nama_kategori_staff) == strtolower($kategori_name)) {
						$id_kategori_staff = $kat->id_kategori_staff;
						break;
					}
				}
				
				// If category not found, create it
				if ($id_kategori_staff == 0) {
					$new_kat = [
						'nama_kategori_staff' => $kategori_name,
						'slug_kategori_staff' => strtolower(url_title($kategori_name)),
						'urutan' => 0
					];
					$m_kategori_staff->tambah($new_kat);
					// Re-load list and get the ID
					$kategori_list = $m_kategori_staff->listing();
					foreach ($kategori_list as $kat) {
						if (strtolower($kat->nama_kategori_staff) == strtolower($kategori_name)) {
							$id_kategori_staff = $kat->id_kategori_staff;
							break;
						}
					}
				}
				
				$data = [
					'id_user' => $this->session->get('id_user'),
					'id_kategori_staff' => $id_kategori_staff,
					'nama' => $cells[0],
					'jenis_kelamin' => (!empty($cells[2]) && in_array(strtoupper($cells[2]), ['L', 'P'])) ? strtoupper($cells[2]) : 'L',
					'jabatan' => $cells[3] ?? '',
					'alamat' => $cells[4] ?? '',
					'telepon' => $cells[5] ?? '',
					'email' => $cells[6] ?? '',
					'website' => $cells[7] ?? '',
					'keahlian' => $cells[8] ?? '',
					'tempat_lahir' => $cells[9] ?? '',
					'tanggal_lahir' => !empty($cells[10]) ? date('Y-m-d', strtotime($cells[10])) : null,
					'status_staff' => (!empty($cells[11]) && in_array(ucfirst(strtolower($cells[11])), ['Publish', 'Draft'])) ? ucfirst(strtolower($cells[11])) : 'Publish',
					'urutan' => is_numeric($cells[12]) ? intval($cells[12]) : 0,
					'tanggal_post' => date('Y-m-d H:i:s')
				];
				
				$m_staff->tambah($data);
				$successCount++;
			}
			
			// Delete temporary file
			@unlink(WRITEPATH . '../assets/upload/file/' . $fileName);
			
			return redirect()->to(base_url('admin/staff'))->with('sukses', $successCount . ' data Staff berhasil diimport.');
		}
		
		$data = [
			'title' => 'Import Data Staff & Guru',
			'content' => 'admin/staff/import'
		];
		echo view('admin/layout/wrapper', $data);
	}
}