<?php 
namespace App\Models;

use CodeIgniter\Model;

class Sambutan_model extends Model
{
    protected $table = 'sambutan';
    protected $primaryKey = 'id_sambutan';
    protected $allowedFields = [];

    // Listing
    public function listing()
    {
        $this->table('sambutan');
        $this->select('sambutan.*, users.nama');
        $this->join('users','users.id_user = sambutan.id_user','LEFT');
        $this->orderBy('sambutan.id_sambutan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function paginasi_admin($limit,$start)
    {
        $this->table('sambutan');
        $this->select('sambutan.*, users.nama');
        $this->join('users','users.id_user = sambutan.id_user','LEFT');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('sambutan.id_sambutan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function paginasi_admin_cari($keywords,$limit,$start)
    {
        $this->table('sambutan');
        $this->select('sambutan.*, users.nama');
        $this->join('users','users.id_user = sambutan.id_user','LEFT');
        $this->like('sambutan.judul_sambutan',$keywords,'BOTH');
        $this->orLike('sambutan.isi',$keywords,'BOTH');
        $this->orLike('sambutan.keywords',$keywords,'BOTH');
        $this->orLike('sambutan.ringkasan',$keywords,'BOTH');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('sambutan.id_sambutan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function total_cari($keywords)
    {
        $this->table('sambutan');
        $this->select('sambutan.*, users.nama');
        $this->join('users','users.id_user = sambutan.id_user','LEFT');
        $this->like('sambutan.judul_sambutan',$keywords,'BOTH');
        $this->orLike('sambutan.isi',$keywords,'BOTH');
        $this->orLike('sambutan.keywords',$keywords,'BOTH');
        $this->orLike('sambutan.ringkasan',$keywords,'BOTH');
        $this->orderBy('sambutan.id_sambutan','DESC');
        $query = $this->get();
        return $query->getNumRows();
    }

    // home
    public function main()
    {
        $this->table('sambutan');
        $this->select('sambutan.*, users.nama');
        $this->join('users','users.id_user = sambutan.id_user','LEFT');
        $this->where( [  'status_sambutan' => 'Publish']);
        $this->orderBy('sambutan.id_sambutan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // author
    public function author_all($id_user)
    {
        $this->table('sambutan');
        $this->select('sambutan.*, users.nama');
        $this->join('users','users.id_user = sambutan.id_user','LEFT');
        $this->where( [  'sambutan.id_user' => $id_user]);
        $this->orderBy('sambutan.id_sambutan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // total
    public function total_author($id_user)
    {
        $this->table('sambutan')->where('id_user',$id_user);
        $query = $this->get();
        return $query->getNumRows();
    }

    // status_sambutan
    public function status_sambutan_all($status_sambutan,$limit,$start)
    {
        $this->table('sambutan');
        $this->select('sambutan.*, users.nama');
        $this->join('users','users.id_user = sambutan.id_user','LEFT');
        $this->where( [  'sambutan.status_sambutan' => $status_sambutan]);
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('sambutan.id_sambutan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // total
    public function total_status_sambutan($status_sambutan)
    {
        $this->table('sambutan')->where('status_sambutan',$status_sambutan);
        $query = $this->get();
        return $query->getNumRows();
    }

    // total
    public function total()
    {
        $this->table('sambutan');
        $query = $this->get();
        return $query->getNumRows();
    }

    // detail
    public function detail($id_sambutan)
    {
        $this->table('sambutan');
        $this->select('sambutan.*, users.nama');
        $this->join('users','users.id_user = sambutan.id_user','LEFT');
        $this->where('sambutan.id_sambutan',$id_sambutan);
        $this->orderBy('sambutan.id_sambutan','DESC');
        $query = $this->get();
        return $query->getRow();
    }

    // detail2
    public function detail2($id_sambutan)
    {
        $this->table('sambutan');
        $this->select('*');
        $this->where('sambutan.id_sambutan',$id_sambutan);
        $query = $this->get();
        return $query->getRow();
    }

    // read
    public function read($slug_sambutan)
    {
        $this->table('sambutan');
        $this->select('sambutan.*, users.nama');
        $this->join('users','users.id_user = sambutan.id_user','LEFT');
        $this->where('sambutan.slug_sambutan',$slug_sambutan);
        $this->where('sambutan.status_sambutan','Publish');
        $this->orderBy('sambutan.id_sambutan','DESC');
        $query = $this->get();
        return $query->getRow();
    }

    // tambah
    public function tambah($data)
    {
        $builder = $this->db->table('sambutan');
        $builder->insert($data);
    }

    // edit
    public function edit($data)
    {
        $builder = $this->db->table('sambutan');
        $builder->where('id_sambutan',$data['id_sambutan']);
        $builder->update($data);
    }

    // delete
    public function hapus($data)
    {
        $builder = $this->db->table('sambutan');
        $builder->where('id_sambutan',$data['id_sambutan']);
        $builder->delete();
    }
}
