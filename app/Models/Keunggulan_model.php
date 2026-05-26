<?php 
namespace App\Models;

use CodeIgniter\Model;

class Keunggulan_model extends Model
{
    protected $table = 'keunggulan';
    protected $primaryKey = 'id_keunggulan';
    protected $allowedFields = [];

    // Listing
    public function listing()
    {
        $this->table('keunggulan');
        $this->select('keunggulan.*, users.nama');
        $this->join('users','users.id_user = keunggulan.id_user','LEFT');
        $this->orderBy('keunggulan.id_keunggulan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function paginasi_admin($limit,$start)
    {
        $this->table('keunggulan');
        $this->select('keunggulan.*, users.nama');
        $this->join('users','users.id_user = keunggulan.id_user','LEFT');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('keunggulan.id_keunggulan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function paginasi_admin_cari($keywords,$limit,$start)
    {
        $this->table('keunggulan');
        $this->select('keunggulan.*, users.nama');
        $this->join('users','users.id_user = keunggulan.id_user','LEFT');
        $this->like('keunggulan.judul_keunggulan',$keywords,'BOTH');
        $this->orLike('keunggulan.isi',$keywords,'BOTH');
        $this->orLike('keunggulan.keywords',$keywords,'BOTH');
        $this->orLike('keunggulan.ringkasan',$keywords,'BOTH');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('keunggulan.id_keunggulan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function total_cari($keywords)
    {
        $this->table('keunggulan');
        $this->select('keunggulan.*, users.nama');
        $this->join('users','users.id_user = keunggulan.id_user','LEFT');
        $this->like('keunggulan.judul_keunggulan',$keywords,'BOTH');
        $this->orLike('keunggulan.isi',$keywords,'BOTH');
        $this->orLike('keunggulan.keywords',$keywords,'BOTH');
        $this->orLike('keunggulan.ringkasan',$keywords,'BOTH');
        $this->orderBy('keunggulan.id_keunggulan','DESC');
        $query = $this->get();
        return $query->getNumRows();
    }

    // home
    public function main()
    {
        $this->table('keunggulan');
        $this->select('keunggulan.*, users.nama');
        $this->join('users','users.id_user = keunggulan.id_user','LEFT');
        $this->where( [  'status_keunggulan' => 'Publish']);
        $this->orderBy('keunggulan.id_keunggulan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // author
    public function author_all($id_user)
    {
        $this->table('keunggulan');
        $this->select('keunggulan.*, users.nama');
        $this->join('users','users.id_user = keunggulan.id_user','LEFT');
        $this->where( [  'keunggulan.id_user' => $id_user]);
        $this->orderBy('keunggulan.id_keunggulan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // total
    public function total_author($id_user)
    {
        $this->table('keunggulan')->where('id_user',$id_user);
        $query = $this->get();
        return $query->getNumRows();
    }

    // status_keunggulan
    public function status_keunggulan_all($status_keunggulan,$limit,$start)
    {
        $this->table('keunggulan');
        $this->select('keunggulan.*, users.nama');
        $this->join('users','users.id_user = keunggulan.id_user','LEFT');
        $this->where( [  'keunggulan.status_keunggulan' => $status_keunggulan]);
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('keunggulan.id_keunggulan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // total
    public function total_status_keunggulan($status_keunggulan)
    {
        $this->table('keunggulan')->where('status_keunggulan',$status_keunggulan);
        $query = $this->get();
        return $query->getNumRows();
    }

    // total
    public function total()
    {
        $this->table('keunggulan');
        $query = $this->get();
        return $query->getNumRows();
    }

    // detail
    public function detail($id_keunggulan)
    {
        $this->table('keunggulan');
        $this->select('keunggulan.*, users.nama');
        $this->join('users','users.id_user = keunggulan.id_user','LEFT');
        $this->where('keunggulan.id_keunggulan',$id_keunggulan);
        $this->orderBy('keunggulan.id_keunggulan','DESC');
        $query = $this->get();
        return $query->getRow();
    }

    // detail2
    public function detail2($id_keunggulan)
    {
        $this->table('keunggulan');
        $this->select('*');
        $this->where('keunggulan.id_keunggulan',$id_keunggulan);
        $query = $this->get();
        return $query->getRow();
    }

    // read
    public function read($slug_keunggulan)
    {
        $this->table('keunggulan');
        $this->select('keunggulan.*, users.nama');
        $this->join('users','users.id_user = keunggulan.id_user','LEFT');
        $this->where('keunggulan.slug_keunggulan',$slug_keunggulan);
        $this->where('keunggulan.status_keunggulan','Publish');
        $this->orderBy('keunggulan.id_keunggulan','DESC');
        $query = $this->get();
        return $query->getRow();
    }

    // tambah
    public function tambah($data)
    {
        $builder = $this->db->table('keunggulan');
        $builder->insert($data);
    }

    // edit
    public function edit($data)
    {
        $builder = $this->db->table('keunggulan');
        $builder->where('id_keunggulan',$data['id_keunggulan']);
        $builder->update($data);
    }

    // delete
    public function hapus($data)
    {
        $builder = $this->db->table('keunggulan');
        $builder->where('id_keunggulan',$data['id_keunggulan']);
        $builder->delete();
    }
}
