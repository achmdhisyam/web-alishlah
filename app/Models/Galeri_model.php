<?php namespace App\Models;

use CodeIgniter\Model;

class Galeri_model extends Model
{

	protected $table = 'galeri';
    protected $primaryKey = 'id_galeri';
    protected $allowedFields = [];

    // Listing
    public function listing()
    {
        $builder = $this->db->table('galeri');
        $builder->select('galeri.*, kategori_galeri.nama_kategori_galeri, kategori_galeri.slug_kategori_galeri, users.nama');
        $builder->join('kategori_galeri','kategori_galeri.id_kategori_galeri = galeri.id_kategori_galeri','LEFT');
        $builder->join('users','users.id_user = galeri.id_user','LEFT');
        $builder->orderBy('galeri.id_galeri','DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    // jenis
    public function jenis_galeri_depan($jenis_galeri)
    {
        $builder = $this->db->table('galeri');
        $builder->select('galeri.*, kategori_galeri.nama_kategori_galeri, kategori_galeri.slug_kategori_galeri, users.nama');
        $builder->join('kategori_galeri','kategori_galeri.id_kategori_galeri = galeri.id_kategori_galeri','LEFT');
        $builder->join('users','users.id_user = galeri.id_user','LEFT');
        $builder->where('galeri.jenis_galeri',$jenis_galeri);
        $builder->limit(5);
        $builder->orderBy('galeri.id_galeri','DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    // home
    public function home($limit)
    {
        $builder = $this->db->table('galeri');
        $builder->select('galeri.*, kategori_galeri.nama_kategori_galeri, kategori_galeri.slug_kategori_galeri, users.nama');
        $builder->join('kategori_galeri','kategori_galeri.id_kategori_galeri = galeri.id_kategori_galeri','LEFT');
        $builder->join('users','users.id_user = galeri.id_user','LEFT');
        $this->limit((int)$limit);
        $builder->orderBy('galeri.id_galeri','DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    // jenis_galeri_pop
    public function jenis_galeri_pop($jenis_galeri)
    {
        $builder = $this->db->table('galeri');
        $builder->select('galeri.*, kategori_galeri.nama_kategori_galeri, kategori_galeri.slug_kategori_galeri, users.nama');
        $builder->join('kategori_galeri','kategori_galeri.id_kategori_galeri = galeri.id_kategori_galeri','LEFT');
        $builder->join('users','users.id_user = galeri.id_user','LEFT');
        $builder->where('galeri.jenis_galeri',$jenis_galeri);
        $builder->orderBy('galeri.id_galeri','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    public function jenis_galeri_list($jenis_galeri)
    {
        return $this->db->table('galeri')
            ->where('jenis_galeri', $jenis_galeri)
            ->orderBy('id_galeri', 'DESC')
            ->get()
            ->getResult();
    }


    // Listing
    public function paginasi_admin($limit,$start)
    {
        $this->table('galeri');
        $this->select('galeri.*, kategori_galeri.nama_kategori_galeri, kategori_galeri.slug_kategori_galeri, users.nama');
        $this->join('kategori_galeri','kategori_galeri.id_kategori_galeri = galeri.id_kategori_galeri','LEFT');
        $this->join('users','users.id_user = galeri.id_user','LEFT');
        $this->where('galeri.jenis_galeri', 'Galeri');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('galeri.id_galeri','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function paginasi_admin_cari($keywords,$limit,$start)
    {
        $this->table('galeri');
        $this->select('galeri.*, kategori_galeri.nama_kategori_galeri, kategori_galeri.slug_kategori_galeri, users.nama');
        $this->join('kategori_galeri','kategori_galeri.id_kategori_galeri = galeri.id_kategori_galeri','LEFT');
        $this->join('users','users.id_user = galeri.id_user','LEFT');
        $this->where('galeri.jenis_galeri', 'Galeri');
        $this->groupStart()
             ->like('galeri.judul_galeri',$keywords,'BOTH')
             ->orLike('galeri.isi',$keywords,'BOTH')
        ->groupEnd();
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('galeri.id_galeri','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function total_cari($keywords)
    {
        $this->table('galeri');
        $this->select('galeri.*, kategori_galeri.nama_kategori_galeri, kategori_galeri.slug_kategori_galeri, users.nama AS nama_user');
        $this->join('kategori_galeri','kategori_galeri.id_kategori_galeri = galeri.id_kategori_galeri','LEFT');
        $this->join('users','users.id_user = galeri.id_user','LEFT');
        $this->where('galeri.jenis_galeri', 'Galeri');
        $this->groupStart()
             ->like('galeri.judul_galeri',$keywords,'BOTH')
             ->orLike('galeri.isi',$keywords,'BOTH')
        ->groupEnd();
        $this->orderBy('galeri.id_galeri','DESC');
        $query = $this->get();
        return $query->getNumRows();
    }

    // total
    public function total()
    {
        $builder = $this->db->table('galeri');
        $builder->where('jenis_galeri', 'Galeri');
        $query = $builder->get();
        return $query->getNumRows();
    }

    // total per jenis
    public function total_jenis($jenis_galeri)
    {
        $builder = $this->db->table('galeri');
        $builder->where('jenis_galeri', $jenis_galeri);
        $query = $builder->get();
        return $query->getNumRows();
    }

    // paginasi per jenis
    public function paginasi_jenis($jenis_galeri, $limit, $start)
    {
        $this->table('galeri');
        $this->select('galeri.*, kategori_galeri.nama_kategori_galeri, kategori_galeri.slug_kategori_galeri, users.nama');
        $this->join('kategori_galeri','kategori_galeri.id_kategori_galeri = galeri.id_kategori_galeri','LEFT');
        $this->join('users','users.id_user = galeri.id_user','LEFT');
        $this->where('galeri.jenis_galeri', $jenis_galeri);
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('galeri.id_galeri','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // detail
    public function detail($id_galeri)
    {
        $builder = $this->db->table('galeri');
        $builder->select('galeri.*, kategori_galeri.nama_kategori_galeri, kategori_galeri.slug_kategori_galeri, users.nama');
        $builder->join('kategori_galeri','kategori_galeri.id_kategori_galeri = galeri.id_kategori_galeri','LEFT');
        $builder->join('users','users.id_user = galeri.id_user','LEFT');
        $builder->where('galeri.id_galeri',$id_galeri);
        $builder->orderBy('galeri.id_galeri','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    // tambah
    public function tambah($data)
    {
        $builder = $this->db->table('galeri');
        $builder->insert($data);
    }

    // tambah
    public function edit($data)
    {
        $builder = $this->db->table('galeri');
        $builder->where('id_galeri',$data['id_galeri']);
        $builder->update($data);
    }
    
    // slider
    public function slider()
    {
        $builder = $this->db->table('galeri');
        $builder->where('jenis_galeri','Homepage');
        $builder->orderBy('galeri.id_galeri','DESC');
        $builder->limit(5);
        $query = $builder->get();
        return $query->getRow();
    }

    // galeri
    public function jenis_galeri($jenis_galeri)
    {
        $builder = $this->db->table('galeri');
        $builder->where('jenis_galeri',$jenis_galeri);
        $builder->limit(5);
        $builder->orderBy('galeri.id_galeri','DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    // galeri
    public function jenis_galeri_1($jenis_galeri)
    {
        $builder = $this->db->table('galeri');
        $builder->where('jenis_galeri',$jenis_galeri);
        $builder->orderBy('galeri.id_galeri','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    // galeri
    public function galeri()
    {
        $builder = $this->db->table('galeri');
        $builder->where('jenis_galeri','Galeri');
        $builder->orderBy('galeri.id_galeri','DESC');
        $query = $builder->get();
        return $query->getResult();
    }
}