<?php 
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Akun_model;

class Akun_pendaftar extends BaseController
{
    // INDEX asli (tidak diubah)
    public function index()
    {
        $m_akun = new Akun_model();
        $pager  = service('pager'); 

        if(isset($_GET['keywords'])) {
            $keywords    = $this->request->getVar('keywords');
            $total       = $m_akun->total_cari($keywords);
            $title       = 'Hasil pencarian: '.$_GET['keywords'].' - '.$total.' ditemukan';
            $page        = (int) ($this->request->getGet('page') ?? 1);
            $perPage     = $this->website->paginasi();
            $pager_links = $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
            $page        = ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
            $akun        = $m_akun->paginasi_admin_cari($keywords,$perPage, $page);
        } else {
            $total       = $m_akun->total();
            $title       = 'Data Akun Pendaftar ('.$total.')';
            $page        = (int) ($this->request->getGet('page') ?? 1);
            $perPage     = $this->website->paginasi();
            $pager_links = $pager->makeLinks($page, $perPage, $total,'bootstrap_pagination');
            $page        = ($this->request->getGet('page'))?($this->request->getGet('page')-1)*$perPage:0;
            $akun        = $m_akun->paginasi_admin($perPage, $page);
        }

        $data = [   
            'title'      => $title,
            'akun'       => $akun,
            'pagination' => $pager_links,
            'content'    => 'admin/akun_pendaftar/index'
        ];
        return view('admin/layout/wrapper',$data);
    }

    // FORM TAMBAH
    public function tambah()
    {
        $data = [
            'title'   => 'Tambah Akun Pendaftar',
            'content' => 'admin/akun_pendaftar/tambah'
        ];
        return view('admin/layout/wrapper',$data);
    }

    // SIMPAN DATA BARU
    public function store()
    {
        $m_akun = new Akun_model();
        $data = [
            'nama'          => $this->request->getPost('nama'),
            'email'         => $this->request->getPost('email'),
            'username'      => $this->request->getPost('username'),
            'password'      => sha1($this->request->getPost('password')), // sesuai DB
            'password_hint' => $this->request->getPost('password'),
            'jenis_akun'    => $this->request->getPost('jenis_akun'),
            'status_akun'   => $this->request->getPost('status_akun'),
            'tanggal_post'  => date('Y-m-d H:i:s')
        ];
        $m_akun->tambah($data);

        return redirect()->to(base_url('admin/akun_pendaftar'))->with('sukses','Data berhasil ditambahkan');
    }

    // FORM EDIT
    public function edit($id)
    {
        $m_akun = new Akun_model();
        $akun   = $m_akun->detail($id);

        $data = [
            'title'   => 'Edit Akun Pendaftar',
            'akun'    => $akun,
            'content' => 'admin/akun_pendaftar/edit'
        ];
        return view('admin/layout/wrapper',$data);
    }

    // UPDATE DATA
    public function update($id)
    {
        $m_akun = new Akun_model();
        $data = [
            'id_akun'     => $id,
            'nama'        => $this->request->getPost('nama'),
            'email'       => $this->request->getPost('email'),
            'username'    => $this->request->getPost('username'),
            'jenis_akun'  => $this->request->getPost('jenis_akun'),
            'status_akun' => $this->request->getPost('status_akun')
        ];

        if($this->request->getPost('password') != '') {
            $data['password']      = sha1($this->request->getPost('password'));
            $data['password_hint'] = $this->request->getPost('password');
        }

        $m_akun->edit($data);
        return redirect()->to(base_url('admin/akun_pendaftar'))->with('sukses','Data berhasil diupdate');
    }

    // HAPUS DATA
    public function delete($id)
    {
        $this->db->table('akun')->delete(['id_akun'=>$id]);
        return redirect()->to(base_url('admin/akun_pendaftar'))->with('sukses','Data berhasil dihapus');
    }

	// PROSES
	public function proses()
	{
    $m_akun = new Akun_model();

    // Ambil data dari form
    $id_akun    = $this->request->getPost('id_akun');
    $pengalihan = $this->request->getPost('pengalihan');
    $submit     = $this->request->getPost('submit');

    // Kalau tidak ada yang dipilih
    if (empty($id_akun)) {
        return redirect()->to($pengalihan)->with('warning','Anda belum memilih data');
    }

    // Jika pilih Delete
    if ($submit == "Delete") {
        foreach($id_akun as $id) {
            $this->db->table('akun')->delete(['id_akun'=>$id]);
        }
        return redirect()->to($pengalihan)->with('sukses','Data berhasil dihapus');
    }

    // Jika pilih Draft
    if ($submit == "Draft") {
        foreach($id_akun as $id) {
            $m_akun->edit([
                'id_akun'     => $id,
                'status_akun' => 'Menunggu'
            ]);
        }
        return redirect()->to($pengalihan)->with('sukses','Status berhasil diubah ke Menunggu');
    }

    // Jika pilih Publish
    if ($submit == "Publish") {
        foreach($id_akun as $id) {
            $m_akun->edit([
                'id_akun'     => $id,
                'status_akun' => 'Aktif'
            ]);
        }
        return redirect()->to($pengalihan)->with('sukses','Status berhasil diubah ke Aktif');
    }

    // Jika pilih Update manual status
    if ($submit == "Update") {
        $status = $this->request->getPost('status_akun');
        foreach($id_akun as $id) {
            $m_akun->edit([
                'id_akun'     => $id,
                'status_akun' => $status
            ]);
        }
        return redirect()->to($pengalihan)->with('sukses','Status berhasil diupdate');
    }

    // Default
    return redirect()->to($pengalihan)->with('warning','Tidak ada aksi yang dilakukan');
	}

}
