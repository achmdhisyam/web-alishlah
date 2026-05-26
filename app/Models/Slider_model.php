<?php namespace App\Models;

use CodeIgniter\Model;

class Slider_model extends Model
{
    protected $table = 'slider';
    protected $primaryKey = 'id_slider';
    protected $allowedFields = [];

    // Listing
    public function listing()
    {
        $builder = $this->db->table('slider');
        $builder->select('slider.*, slider.judul_slider AS judul_galeri, users.nama');
        $builder->join('users','users.id_user = slider.id_user','LEFT');
        $builder->orderBy('slider.id_slider','DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    // paginasi_admin
    public function paginasi_admin($limit,$start)
    {
        $this->table('slider');
        $this->select('slider.*, slider.judul_slider AS judul_galeri, users.nama');
        $this->join('users','users.id_user = slider.id_user','LEFT');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('slider.id_slider','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // paginasi_admin_cari
    public function paginasi_admin_cari($keywords,$limit,$start)
    {
        $this->table('slider');
        $this->select('slider.*, slider.judul_slider AS judul_galeri, users.nama');
        $this->join('users','users.id_user = slider.id_user','LEFT');
        $this->groupStart()
             ->like('slider.judul_slider',$keywords,'BOTH')
             ->orLike('slider.website',$keywords,'BOTH')
             ->orLike('slider.isi',$keywords,'BOTH')
        ->groupEnd();
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('slider.id_slider','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // total_cari
    public function total_cari($keywords)
    {
        $this->table('slider');
        $this->select('slider.*, slider.judul_slider AS judul_galeri, users.nama AS nama_user');
        $this->join('users','users.id_user = slider.id_user','LEFT');
        $this->groupStart()
             ->like('slider.judul_slider',$keywords,'BOTH')
             ->orLike('slider.website',$keywords,'BOTH')
             ->orLike('slider.isi',$keywords,'BOTH')
        ->groupEnd();
        $this->orderBy('slider.id_slider','DESC');
        $query = $this->get();
        return $query->getNumRows();
    }

    // total
    public function total()
    {
        $builder = $this->db->table('slider');
        $query = $builder->get();
        return $query->getNumRows();
    }

    // detail
    public function detail($id_slider)
    {
        $builder = $this->db->table('slider');
        $builder->select('slider.*, slider.judul_slider AS judul_galeri, users.nama');
        $builder->join('users','users.id_user = slider.id_user','LEFT');
        $builder->where('slider.id_slider',$id_slider);
        $builder->orderBy('slider.id_slider','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    // tambah
    public function tambah($data)
    {
        $builder = $this->db->table('slider');
        $builder->insert($data);
    }

    // edit
    public function edit($data)
    {
        $builder = $this->db->table('slider');
        $builder->where('id_slider',$data['id_slider']);
        $builder->update($data);
    }
}
