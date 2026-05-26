<?php 
namespace App\Models;

use CodeIgniter\Model;

class Profil_model extends Model
{
    protected $table = 'profil';
    protected $primaryKey = 'id_profil';
    protected $allowedFields = [];

    // Listing
    public function listing()
    {
        $this->table('profil');
        $this->select('profil.*, users.nama');
        $this->join('users','users.id_user = profil.id_user','LEFT');
        $this->orderBy('profil.id_profil','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function paginasi_admin($limit,$start)
    {
        $this->table('profil');
        $this->select('profil.*, users.nama');
        $this->join('users','users.id_user = profil.id_user','LEFT');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('profil.id_profil','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function paginasi_admin_cari($keywords,$limit,$start)
    {
        $this->table('profil');
        $this->select('profil.*, users.nama');
        $this->join('users','users.id_user = profil.id_user','LEFT');
        $this->like('profil.judul_profil',$keywords,'BOTH');
        $this->orLike('profil.isi',$keywords,'BOTH');
        $this->orLike('profil.keywords',$keywords,'BOTH');
        $this->orLike('profil.ringkasan',$keywords,'BOTH');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('profil.id_profil','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function total_cari($keywords)
    {
        $this->table('profil');
        $this->select('profil.*, users.nama');
        $this->join('users','users.id_user = profil.id_user','LEFT');
        $this->like('profil.judul_profil',$keywords,'BOTH');
        $this->orLike('profil.isi',$keywords,'BOTH');
        $this->orLike('profil.keywords',$keywords,'BOTH');
        $this->orLike('profil.ringkasan',$keywords,'BOTH');
        $this->orderBy('profil.id_profil','DESC');
        $query = $this->get();
        return $query->getNumRows();
    }

    // home
    public function main()
    {
        $this->table('profil');
        $this->select('profil.*, users.nama');
        $this->join('users','users.id_user = profil.id_user','LEFT');
        $this->where( [  'status_profil' => 'Publish']);
        $this->orderBy('profil.id_profil','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // author
    public function author_all($id_user)
    {
        $this->table('profil');
        $this->select('profil.*, users.nama');
        $this->join('users','users.id_user = profil.id_user','LEFT');
        $this->where( [  'profil.id_user' => $id_user]);
        $this->orderBy('profil.id_profil','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // total
    public function total_author($id_user)
    {
        $this->table('profil')->where('id_user',$id_user);
        $query = $this->get();
        return $query->getNumRows();
    }

    // status_profil
    public function status_profil_all($status_profil,$limit,$start)
    {
        $this->table('profil');
        $this->select('profil.*, users.nama');
        $this->join('users','users.id_user = profil.id_user','LEFT');
        $this->where( [  'profil.status_profil' => $status_profil]);
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('profil.id_profil','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // total
    public function total_status_profil($status_profil)
    {
        $this->table('profil')->where('status_profil',$status_profil);
        $query = $this->get();
        return $query->getNumRows();
    }

    // total
    public function total()
    {
        $this->table('profil');
        $query = $this->get();
        return $query->getNumRows();
    }

    // detail
    public function detail($id_profil)
    {
        $this->table('profil');
        $this->select('profil.*, users.nama');
        $this->join('users','users.id_user = profil.id_user','LEFT');
        $this->where('profil.id_profil',$id_profil);
        $this->orderBy('profil.id_profil','DESC');
        $query = $this->get();
        return $query->getRow();
    }

    // detail2
    public function detail2($id_profil)
    {
        $this->table('profil');
        $this->select('*');
        $this->where('profil.id_profil',$id_profil);
        $query = $this->get();
        return $query->getRow();
    }

    // read
    public function read($slug_profil)
    {
        $this->table('profil');
        $this->select('profil.*, users.nama');
        $this->join('users','users.id_user = profil.id_user','LEFT');
        $this->where('profil.slug_profil',$slug_profil);
        $this->where('profil.status_profil','Publish');
        $this->orderBy('profil.id_profil','DESC');
        $query = $this->get();
        return $query->getRow();
    }

    // tambah
    public function tambah($data)
    {
        $builder = $this->db->table('profil');
        $builder->insert($data);
    }

    // edit
    public function edit($data)
    {
        $builder = $this->db->table('profil');
        $builder->where('id_profil',$data['id_profil']);
        $builder->update($data);
    }

    // delete
    public function hapus($data)
    {
        $builder = $this->db->table('profil');
        $builder->where('id_profil',$data['id_profil']);
        $builder->delete();
    }
}
