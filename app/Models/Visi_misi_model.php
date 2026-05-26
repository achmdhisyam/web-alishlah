<?php 
namespace App\Models;

use CodeIgniter\Model;

class Visi_misi_model extends Model
{
    protected $table = 'visi_misi';
    protected $primaryKey = 'id_visi_misi';
    protected $allowedFields = [];

    // Listing
    public function listing()
    {
        $this->table('visi_misi');
        $this->select('visi_misi.*, users.nama');
        $this->join('users','users.id_user = visi_misi.id_user','LEFT');
        $this->orderBy('visi_misi.id_visi_misi','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function paginasi_admin($limit,$start)
    {
        $this->table('visi_misi');
        $this->select('visi_misi.*, users.nama');
        $this->join('users','users.id_user = visi_misi.id_user','LEFT');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('visi_misi.id_visi_misi','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function paginasi_admin_cari($keywords,$limit,$start)
    {
        $this->table('visi_misi');
        $this->select('visi_misi.*, users.nama');
        $this->join('users','users.id_user = visi_misi.id_user','LEFT');
        $this->like('visi_misi.judul_visi_misi',$keywords,'BOTH');
        $this->orLike('visi_misi.isi',$keywords,'BOTH');
        $this->orLike('visi_misi.keywords',$keywords,'BOTH');
        $this->orLike('visi_misi.ringkasan',$keywords,'BOTH');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('visi_misi.id_visi_misi','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function total_cari($keywords)
    {
        $this->table('visi_misi');
        $this->select('visi_misi.*, users.nama');
        $this->join('users','users.id_user = visi_misi.id_user','LEFT');
        $this->like('visi_misi.judul_visi_misi',$keywords,'BOTH');
        $this->orLike('visi_misi.isi',$keywords,'BOTH');
        $this->orLike('visi_misi.keywords',$keywords,'BOTH');
        $this->orLike('visi_misi.ringkasan',$keywords,'BOTH');
        $this->orderBy('visi_misi.id_visi_misi','DESC');
        $query = $this->get();
        return $query->getNumRows();
    }

    // home
    public function main()
    {
        $this->table('visi_misi');
        $this->select('visi_misi.*, users.nama');
        $this->join('users','users.id_user = visi_misi.id_user','LEFT');
        $this->where( [  'status_visi_misi' => 'Publish']);
        $this->orderBy('visi_misi.id_visi_misi','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // author
    public function author_all($id_user)
    {
        $this->table('visi_misi');
        $this->select('visi_misi.*, users.nama');
        $this->join('users','users.id_user = visi_misi.id_user','LEFT');
        $this->where( [  'visi_misi.id_user' => $id_user]);
        $this->orderBy('visi_misi.id_visi_misi','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // total
    public function total_author($id_user)
    {
        $this->table('visi_misi')->where('id_user',$id_user);
        $query = $this->get();
        return $query->getNumRows();
    }

    // status_visi_misi
    public function status_visi_misi_all($status_visi_misi,$limit,$start)
    {
        $this->table('visi_misi');
        $this->select('visi_misi.*, users.nama');
        $this->join('users','users.id_user = visi_misi.id_user','LEFT');
        $this->where( [  'visi_misi.status_visi_misi' => $status_visi_misi]);
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('visi_misi.id_visi_misi','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // total
    public function total_status_visi_misi($status_visi_misi)
    {
        $this->table('visi_misi')->where('status_visi_misi',$status_visi_misi);
        $query = $this->get();
        return $query->getNumRows();
    }

    // total
    public function total()
    {
        $this->table('visi_misi');
        $query = $this->get();
        return $query->getNumRows();
    }

    // detail
    public function detail($id_visi_misi)
    {
        $this->table('visi_misi');
        $this->select('visi_misi.*, users.nama');
        $this->join('users','users.id_user = visi_misi.id_user','LEFT');
        $this->where('visi_misi.id_visi_misi',$id_visi_misi);
        $this->orderBy('visi_misi.id_visi_misi','DESC');
        $query = $this->get();
        return $query->getRow();
    }

    // detail2
    public function detail2($id_visi_misi)
    {
        $this->table('visi_misi');
        $this->select('*');
        $this->where('visi_misi.id_visi_misi',$id_visi_misi);
        $query = $this->get();
        return $query->getRow();
    }

    // read
    public function read($slug_visi_misi)
    {
        $this->table('visi_misi');
        $this->select('visi_misi.*, users.nama');
        $this->join('users','users.id_user = visi_misi.id_user','LEFT');
        $this->where('visi_misi.slug_visi_misi',$slug_visi_misi);
        $this->where('visi_misi.status_visi_misi','Publish');
        $this->orderBy('visi_misi.id_visi_misi','DESC');
        $query = $this->get();
        return $query->getRow();
    }

    // tambah
    public function tambah($data)
    {
        $builder = $this->db->table('visi_misi');
        $builder->insert($data);
    }

    // edit
    public function edit($data)
    {
        $builder = $this->db->table('visi_misi');
        $builder->where('id_visi_misi',$data['id_visi_misi']);
        $builder->update($data);
    }

    // delete
    public function hapus($data)
    {
        $builder = $this->db->table('visi_misi');
        $builder->where('id_visi_misi',$data['id_visi_misi']);
        $builder->delete();
    }
}
