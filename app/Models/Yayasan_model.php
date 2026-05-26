<?php 
namespace App\Models;

use CodeIgniter\Model;

class Yayasan_model extends Model
{
    protected $table = 'yayasan';
    protected $primaryKey = 'id_yayasan';
    protected $allowedFields = [];

    // Listing
    public function listing()
    {
        $this->table('yayasan');
        $this->select('yayasan.*, users.nama');
        $this->join('users','users.id_user = yayasan.id_user','LEFT');
        $this->orderBy('yayasan.id_yayasan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function paginasi_admin($limit,$start)
    {
        $this->table('yayasan');
        $this->select('yayasan.*, users.nama');
        $this->join('users','users.id_user = yayasan.id_user','LEFT');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('yayasan.id_yayasan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function paginasi_admin_cari($keywords,$limit,$start)
    {
        $this->table('yayasan');
        $this->select('yayasan.*, users.nama');
        $this->join('users','users.id_user = yayasan.id_user','LEFT');
        $this->like('yayasan.judul_yayasan',$keywords,'BOTH');
        $this->orLike('yayasan.isi',$keywords,'BOTH');
        $this->orLike('yayasan.keywords',$keywords,'BOTH');
        $this->orLike('yayasan.ringkasan',$keywords,'BOTH');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('yayasan.id_yayasan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function total_cari($keywords)
    {
        $this->table('yayasan');
        $this->select('yayasan.*, users.nama');
        $this->join('users','users.id_user = yayasan.id_user','LEFT');
        $this->like('yayasan.judul_yayasan',$keywords,'BOTH');
        $this->orLike('yayasan.isi',$keywords,'BOTH');
        $this->orLike('yayasan.keywords',$keywords,'BOTH');
        $this->orLike('yayasan.ringkasan',$keywords,'BOTH');
        $this->orderBy('yayasan.id_yayasan','DESC');
        $query = $this->get();
        return $query->getNumRows();
    }

    // home
    public function main()
    {
        $this->table('yayasan');
        $this->select('yayasan.*, users.nama');
        $this->join('users','users.id_user = yayasan.id_user','LEFT');
        $this->where( [  'status_yayasan' => 'Publish']);
        $this->orderBy('yayasan.urutan','ASC');
        $query = $this->get();
        return $query->getResult();
    }

    // home
    public function beranda($jumlah)
    {
        $this->table('yayasan');
        $this->select('yayasan.*, users.nama');
        $this->join('users','users.id_user = yayasan.id_user','LEFT');
        $this->where( [  'status_yayasan' => 'Publish']);
        $this->orderBy('yayasan.tanggal_publish','DESC');
        $this->limit($jumlah);
        $query = $this->get();
        return $query->getResult();
    }

    // author
    public function author_all($id_user)
    {
        $this->table('yayasan');
        $this->select('yayasan.*, users.nama');
        $this->join('users','users.id_user = yayasan.id_user','LEFT');
        $this->where( [  'yayasan.id_user' => $id_user]);
        $this->orderBy('yayasan.id_yayasan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // total
    public function total_author($id_user)
    {
        $this->table('yayasan')->where('id_user',$id_user);
        $query = $this->get();
        return $query->getNumRows();
    }

    // status_yayasan
    public function status_yayasan_all($status_yayasan,$limit,$start)
    {
        $this->table('yayasan');
        $this->select('yayasan.*, users.nama');
        $this->join('users','users.id_user = yayasan.id_user','LEFT');
        $this->where( [  'yayasan.status_yayasan' => $status_yayasan]);
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('yayasan.id_yayasan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // total
    public function total_status_yayasan($status_yayasan)
    {
        $this->table('yayasan')->where('status_yayasan',$status_yayasan);
        $query = $this->get();
        return $query->getNumRows();
    }

    // total
    public function total()
    {
        $this->table('yayasan');
        $query = $this->get();
        return $query->getNumRows();
    }

    // detail
    public function detail($id_yayasan)
    {
        $this->table('yayasan');
        $this->select('yayasan.*, users.nama');
        $this->join('users','users.id_user = yayasan.id_user','LEFT');
        $this->where('yayasan.id_yayasan',$id_yayasan);
        $this->orderBy('yayasan.id_yayasan','DESC');
        $query = $this->get();
        return $query->getRow();
    }

    // detail2
    public function detail2($id_yayasan)
    {
        $this->table('yayasan');
        $this->select('*');
        $this->where('yayasan.id_yayasan',$id_yayasan);
        $query = $this->get();
        return $query->getRow();
    }

    // read
    public function read($slug_yayasan)
    {
        $this->table('yayasan');
        $this->select('yayasan.*, users.nama');
        $this->join('users','users.id_user = yayasan.id_user','LEFT');
        $this->where('yayasan.slug_yayasan',$slug_yayasan);
        $this->where('yayasan.status_yayasan','Publish');
        $this->orderBy('yayasan.id_yayasan','DESC');
        $query = $this->get();
        return $query->getRow();
    }

    // tambah
    public function tambah($data)
    {
        $builder = $this->db->table('yayasan');
        $builder->insert($data);
    }

    // edit
    public function edit($data)
    {
        $builder = $this->db->table('yayasan');
        $builder->where('id_yayasan',$data['id_yayasan']);
        $builder->update($data);
    }

    // delete
    public function hapus($data)
    {
        $builder = $this->db->table('yayasan');
        $builder->where('id_yayasan',$data['id_yayasan']);
        $builder->delete();
    }
}
