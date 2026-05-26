<?php 
namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\Visi_misi_model;
use App\Models\User_model;

class Visi_misi extends BaseController
{
	// index
	public function index()
	{
		$m_visi_misi 	= new Visi_misi_model();
		
		if ($m_visi_misi->total() == 0) {
			$data_default = [
				'id_user'			=> $this->session->get('id_user'),
				'slug_visi_misi'	=> 'visi-misi',
				'judul_visi_misi'	=> 'Visi & Misi',
				'ringkasan'			=> 'Visi Sekolah...',
				'isi'				=> 'Misi Sekolah...',
				'status_visi_misi'	=> 'Publish',
				'gambar'			=> '',
				'tanggal_post'		=> date('Y-m-d H:i:s'),
				'tanggal_publish'	=> date('Y-m-d H:i:s')
			];
			$m_visi_misi->tambah($data_default);
		}

		$list = $m_visi_misi->listing();
		$visi_misi = $list[0];
		
		return redirect()->to(base_url('admin/visi_misi/edit/'.$visi_misi->id_visi_misi));
	}

	// status_visi_misi
	public function status_visi_misi($status_visi_misi)
	{
		$m_visi_misi 	= new Visi_misi_model();
		$total 			= $m_visi_misi->total_status_visi_misi($status_visi_misi);
		$pager 			= service('pager');
        $page    		= (int) ($this->request->getGet('page') ?? 1);
        $perPage 		= $this->website->paginasi();
        $pager_links 	= $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
        $page 			= ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
        $visi_misi 		= $m_visi_misi->status_visi_misi_all($status_visi_misi,$perPage, $page);

		$data = [	'title'			=> $status_visi_misi.' ('.$total.')',
					'visi_misi'		=> $visi_misi,
					'pagination'	=> $pager_links,
					'content'		=> 'admin/visi_misi/index'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// Tambah
	public function tambah()
	{
		$m_visi_misi 	= new Visi_misi_model();

		// Start validasi
		if(strtolower($this->request->getMethod()) === 'post' && $this->validate(
			[
				'judul_visi_misi' 	=> 'required',
        	])) {
			$data = array(
				'id_user'			=> $this->session->get('id_user'),
				'slug_visi_misi'	=> strtolower(url_title($this->request->getVar('judul_visi_misi'))),
				'judul_visi_misi'	=> $this->request->getVar('judul_visi_misi'),
				'ringkasan'			=> $this->request->getVar('ringkasan'),
				'isi'				=> $this->request->getVar('isi'),
				'status_visi_misi'	=> $this->request->getVar('status_visi_misi'),
				'keywords'			=> $this->request->getVar('keywords') ?? '',
				'gambar'			=> '',
				'tanggal_post'		=> date('Y-m-d H:i:s'),
				'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
			);
			$m_visi_misi->tambah($data);
			return redirect()->to(base_url('admin/visi_misi'))->with('sukses', 'Data Berhasil di Simpan');
	    }

		$data = [	'title'			=> 'Tambah Visi & Misi',
					'content'		=> 'admin/visi_misi/tambah'
				];
		echo view('admin/layout/wrapper',$data);
	}

	// edit
	public function edit($id_visi_misi)
	{
		$m_visi_misi 	= new Visi_misi_model();
		$visi_misi 		= $m_visi_misi->detail($id_visi_misi);
		// Start validasi
		if(strtolower($this->request->getMethod()) === 'post' && $this->validate(
			[
				'judul_visi_misi' 	=> 'required',
        	])) {
			$data = array(
				'id_visi_misi'		=> $id_visi_misi,
				'id_user'			=> $this->session->get('id_user'),
				'slug_visi_misi'	=> strtolower(url_title($this->request->getVar('judul_visi_misi'))),
				'judul_visi_misi'	=> $this->request->getVar('judul_visi_misi'),
				'ringkasan'			=> $this->request->getVar('ringkasan'),
				'isi'				=> $this->request->getVar('isi'),
				'status_visi_misi'	=> $this->request->getVar('status_visi_misi'),
				'keywords'			=> $this->request->getVar('keywords') ?? '',
				'tanggal_publish'	=> date('Y-m-d',strtotime($this->request->getVar('tanggal_publish'))).' '.date('H:i',strtotime($this->request->getVar('jam')))
			);
			$m_visi_misi->edit($data);
			return redirect()->to(base_url('admin/visi_misi/edit/'.$id_visi_misi))->with('sukses', 'Data Berhasil di Simpan');
	    }

		$data = [	'title'			=> 'Edit Visi & Misi',
					'visi_misi'		=> $visi_misi,
					'content'		=> 'admin/visi_misi/edit'
				];
		echo view('admin/layout/wrapper',$data);
	}


	// proses
	public function proses()
	{
		$m_visi_misi 	= new Visi_misi_model();
		$pengalihan = $this->request->getVar('pengalihan');
		$submit 	= $this->request->getVar('submit');
		$id_visi_misi 	= $this->request->getVar('id_visi_misi');
		
		if(empty($this->request->getVar('id_visi_misi')))
		{
			return redirect()->to($pengalihan)->with('warning', 'Anda belum memilih data Visi & Misi.');
		}
		
		if($submit=='Publish') {
			for($i=0; $i < sizeof($id_visi_misi);$i++) {
				$data = array(	'id_visi_misi'		=> $id_visi_misi[$i],
								'id_user'		=> $this->session->get('id_user'),
								'status_visi_misi'	=> 'Publish'
							);
   				$m_visi_misi->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Visi & Misi berhasil dipublikasikan');
		}elseif($submit=='Draft') {
			for($i=0; $i < sizeof($id_visi_misi);$i++) {
				$data = array(	'id_visi_misi'		=> $id_visi_misi[$i],
								'id_user'		=> $this->session->get('id_user'),
								'status_visi_misi'	=> 'Draft'
							);
   				$m_visi_misi->edit($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Visi & Misi berhasil di-draft');
		}elseif($submit=='Delete') {
			for($i=0; $i < sizeof($id_visi_misi);$i++) {
				$data = array(	'id_visi_misi'	=> $id_visi_misi[$i]);
   				$m_visi_misi->hapus($data);
   			}
   			return redirect()->to($pengalihan)->with('sukses', 'Data berhasil dihapus');
		}
	}
	
	// Delete
	public function delete($id_visi_misi)
	{
		$m_visi_misi = new Visi_misi_model();
		$data = ['id_visi_misi'	=> $id_visi_misi];
		$m_visi_misi->hapus($data);
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('admin/visi_misi'));
	}
}
