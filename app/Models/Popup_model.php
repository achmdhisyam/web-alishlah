<?php namespace App\Models;

use CodeIgniter\Model;

class Popup_model extends Model
{
    protected $table = 'popup';
    protected $primaryKey = 'id_popup';
    protected $allowedFields = [];

    // Listing
    public function listing()
    {
        $builder = $this->db->table('popup');
        $builder->select('popup.*, popup.judul_popup AS judul_galeri, users.nama');
        $builder->join('users','users.id_user = popup.id_user','LEFT');
        $builder->orderBy('popup.id_popup','DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    // active popup (only get the single latest active popup for display on homepage)
    public function popup_active()
    {
        $builder = $this->db->table('popup');
        $builder->select('popup.*, popup.judul_popup AS judul_galeri, users.nama');
        $builder->join('users','users.id_user = popup.id_user','LEFT');
        $builder->where('popup.status_text', 'Ya');
        $builder->orderBy('popup.id_popup','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    // paginasi_admin
    public function paginasi_admin($limit,$start)
    {
        $this->table('popup');
        $this->select('popup.*, popup.judul_popup AS judul_galeri, users.nama');
        $this->join('users','users.id_user = popup.id_user','LEFT');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('popup.id_popup','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // paginasi_admin_cari
    public function paginasi_admin_cari($keywords,$limit,$start)
    {
        $this->table('popup');
        $this->select('popup.*, popup.judul_popup AS judul_galeri, users.nama');
        $this->join('users','users.id_user = popup.id_user','LEFT');
        $this->groupStart()
             ->like('popup.judul_popup',$keywords,'BOTH')
             ->orLike('popup.website',$keywords,'BOTH')
             ->orLike('popup.isi',$keywords,'BOTH')
        ->groupEnd();
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('popup.id_popup','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // total_cari
    public function total_cari($keywords)
    {
        $this->table('popup');
        $this->select('popup.*, popup.judul_popup AS judul_galeri, users.nama AS nama_user');
        $this->join('users','users.id_user = popup.id_user','LEFT');
        $this->groupStart()
             ->like('popup.judul_popup',$keywords,'BOTH')
             ->orLike('popup.website',$keywords,'BOTH')
             ->orLike('popup.isi',$keywords,'BOTH')
        ->groupEnd();
        $this->orderBy('popup.id_popup','DESC');
        $query = $this->get();
        return $query->getNumRows();
    }

    // total
    public function total()
    {
        $builder = $this->db->table('popup');
        $query = $builder->get();
        return $query->getNumRows();
    }

    // detail
    public function detail($id_popup)
    {
        $builder = $this->db->table('popup');
        $builder->select('popup.*, popup.judul_popup AS judul_galeri, users.nama');
        $builder->join('users','users.id_user = popup.id_user','LEFT');
        $builder->where('popup.id_popup',$id_popup);
        $builder->orderBy('popup.id_popup','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    // tambah
    public function tambah($data)
    {
        $builder = $this->db->table('popup');
        $builder->insert($data);
    }

    // edit
    public function edit($data)
    {
        $builder = $this->db->table('popup');
        $builder->where('id_popup',$data['id_popup']);
        $builder->update($data);
    }
}
