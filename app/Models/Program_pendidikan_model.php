<?php 
namespace App\Models;

use CodeIgniter\Model;

// [REFACTORING] Model, tabel, dan field diubah total dari jenjang_pendidikan menjadi program_pendidikan
class Program_pendidikan_model extends Model
{

    protected $table = 'program_pendidikan';
    protected $primaryKey = 'id_program_pendidikan';
    protected $allowedFields = [];

    // Listing
    public function listing()
    {
        $this->table('program_pendidikan');
        $this->select('program_pendidikan.*, users.nama');
        $this->join('users','users.id_user = program_pendidikan.id_user','LEFT');
        $this->orderBy('program_pendidikan.id_program_pendidikan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function paginasi_admin($limit,$start)
    {
        $this->table('program_pendidikan');
        $this->select('program_pendidikan.*, users.nama');
        $this->join('users','users.id_user = program_pendidikan.id_user','LEFT');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('program_pendidikan.id_program_pendidikan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function paginasi_admin_cari($keywords,$limit,$start)
    {
        $this->table('program_pendidikan');
        $this->select('program_pendidikan.*, users.nama');
        $this->join('users','users.id_user = program_pendidikan.id_user','LEFT');
        $this->like('program_pendidikan.judul_program_pendidikan',$keywords,'BOTH');
        $this->orLike('program_pendidikan.isi',$keywords,'BOTH');
        $this->orLike('program_pendidikan.keywords',$keywords,'BOTH');
        $this->orLike('program_pendidikan.ringkasan',$keywords,'BOTH');
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('program_pendidikan.id_program_pendidikan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // Listing
    public function total_cari($keywords)
    {
        $this->table('program_pendidikan');
        $this->select('program_pendidikan.*, users.nama');
        $this->join('users','users.id_user = program_pendidikan.id_user','LEFT');
        $this->like('program_pendidikan.judul_program_pendidikan',$keywords,'BOTH');
        $this->orLike('program_pendidikan.isi',$keywords,'BOTH');
        $this->orLike('program_pendidikan.keywords',$keywords,'BOTH');
        $this->orLike('program_pendidikan.ringkasan',$keywords,'BOTH');
        $this->orderBy('program_pendidikan.id_program_pendidikan','DESC');
        $query = $this->get();
        return $query->getNumRows();
    }

    // home
    public function main()
    {
        $this->table('program_pendidikan');
        $this->select('program_pendidikan.*, users.nama');
        $this->join('users','users.id_user = program_pendidikan.id_user','LEFT');
        $this->where( [  'status_program_pendidikan' => 'Publish']);
        $this->orderBy('program_pendidikan.urutan','ASC');
        $query = $this->get();
        return $query->getResult();
    }

    // home
    public function beranda($jenis_program_pendidikan,$jumlah)
    {
        $this->table('program_pendidikan');
        $this->select('program_pendidikan.*, users.nama');
        $this->join('users','users.id_user = program_pendidikan.id_user','LEFT');
        $this->where( [     'status_program_pendidikan' => 'Publish',
                            'jenis_program_pendidikan'  => $jenis_program_pendidikan]);
        $this->orderBy('program_pendidikan.tanggal_publish','DESC');
        $this->limit($jumlah);
        $query = $this->get();
        return $query->getResult();
    }

    // home
    public function sidebar()
    {
        $this->table('program_pendidikan');
        $this->select('program_pendidikan.*, users.nama');
        $this->join('users','users.id_user = program_pendidikan.id_user','LEFT');
        $this->where( [  'status_program_pendidikan' => 'Publish',
                            'jenis_program_pendidikan'  => 'Program Pendidikan']);
        $this->orderBy('program_pendidikan.tanggal_publish','DESC');
        $this->limit(10);
        $query = $this->get();
        return $query->getResult();
    }


    // home
    public function home()
    {
        $this->table('program_pendidikan');
        $this->select('program_pendidikan.*, users.nama');
        $this->join('users','users.id_user = program_pendidikan.id_user','LEFT');
        $this->where( [     'status_program_pendidikan' => 'Publish',
                            'jenis_program_pendidikan'  => 'Program Pendidikan']);
        $this->orderBy('program_pendidikan.tanggal_publish','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // home
    public function jenis_publish($jenis_program_pendidikan)
    {
        $this->table('program_pendidikan');
        $this->select('program_pendidikan.*, users.nama');
        $this->join('users','users.id_user = program_pendidikan.id_user','LEFT');
        $this->where( [     'status_program_pendidikan'    => 'Publish',
                            'jenis_program_pendidikan'  => $jenis_program_pendidikan
                        ]);
        $this->orderBy('program_pendidikan.urutan','ASC');
        $query = $this->get();
        return $query->getResult();
    }



    // total


    // total

    // author
    public function author_all($id_user)
    {
        $this->table('program_pendidikan');
        $this->select('program_pendidikan.*, users.nama');
        $this->join('users','users.id_user = program_pendidikan.id_user','LEFT');
        $this->where( [  'program_pendidikan.id_user'    => $id_user]);
        $this->orderBy('program_pendidikan.id_program_pendidikan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // total
    public function total_author($id_user)
    {
        $this->table('program_pendidikan')->where('id_user',$id_user);
        $query = $this->get();
        return $query->getNumRows();
    }


    // total
    public function total_jenis_program_pendidikan($jenis_program_pendidikan)
    {
        $this->table('program_pendidikan')->where('jenis_program_pendidikan',$jenis_program_pendidikan);
        $query = $this->get();
        return $query->getNumRows();
    }

    // status_program_pendidikan
    public function status_program_pendidikan_all($status_program_pendidikan,$limit,$start)
    {
        $this->table('program_pendidikan');
        $this->select('program_pendidikan.*, users.nama');
        $this->join('users','users.id_user = program_pendidikan.id_user','LEFT');
        $this->where( [  'program_pendidikan.status_program_pendidikan'    => $status_program_pendidikan]);
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('program_pendidikan.id_program_pendidikan','DESC');
        $query = $this->get();
        return $query->getResult();
    }

    // jenis_status_program_pendidikan_all
    public function jenis_status_program_pendidikan_all($jenis_program_pendidikan,$status_program_pendidikan,$limit,$start)
    {
        $this->table('program_pendidikan');
        $this->select('program_pendidikan.*, users.nama');
        $this->join('users','users.id_user = program_pendidikan.id_user','LEFT');
        $this->where( [     'program_pendidikan.status_program_pendidikan'    => $status_program_pendidikan,
                            'program_pendidikan.jenis_program_pendidikan'     => $jenis_program_pendidikan
                        ]);
        $this->limit((int)$limit,(int)$start);
        $this->orderBy('program_pendidikan.id_program_pendidikan','DESC');
        $query = $this->get();
        return $query->getResult();
    }


    // total
    public function total_jenis_status_program_pendidikan($jenis_program_pendidikan,$status_program_pendidikan)
    {
        $this->table('program_pendidikan')->where('jenis_program_pendidikan',$jenis_program_pendidikan)->where('status_program_pendidikan',$status_program_pendidikan);
        $query = $this->get();
        return $query->getNumRows();
    }

    // status_program_pendidikan
    public function total_status_program_pendidikan($status_program_pendidikan)
    {
        $this->table('program_pendidikan')->where('status_program_pendidikan',$status_program_pendidikan);
        $query = $this->get();
        return $query->getNumRows();
    }

    // total
    public function total()
    {
        $this->table('program_pendidikan');
        $query = $this->get();
        return $query->getNumRows();
    }

    // detail
    public function detail($id_program_pendidikan)
    {
        $this->table('program_pendidikan');
        $this->select('program_pendidikan.*, users.nama');
        $this->join('users','users.id_user = program_pendidikan.id_user','LEFT');
        $this->where('program_pendidikan.id_program_pendidikan',$id_program_pendidikan);
        $this->orderBy('program_pendidikan.id_program_pendidikan','DESC');
        $query = $this->get();
        return $query->getRow();
    }

    // detail
    public function detail2($id_program_pendidikan)
    {
        $this->table('program_pendidikan');
        $this->select('*');
        $this->where('program_pendidikan.id_program_pendidikan',$id_program_pendidikan);
        $query = $this->get();
        return $query->getRow();
    }

    // read
    public function read($slug_program_pendidikan)
    {
        $this->table('program_pendidikan');
        $this->select('program_pendidikan.*, users.nama');
        $this->join('users','users.id_user = program_pendidikan.id_user','LEFT');
        $this->where('program_pendidikan.slug_program_pendidikan',$slug_program_pendidikan);
        $this->where('program_pendidikan.status_program_pendidikan','Publish');
        $this->orderBy('program_pendidikan.id_program_pendidikan','DESC');
        $query = $this->get();
        return $query->getRow();
    }

    // tambah
    public function tambah($data)
    {
        $builder = $this->db->table('program_pendidikan');
        $builder->insert($data);
    }

    // tambah
    public function edit($data)
    {
        $builder = $this->db->table('program_pendidikan');
        $builder->where('id_program_pendidikan',$data['id_program_pendidikan']);
        $builder->update($data);
    }

    // testing
    public function copypaste($data)
    {
        $builder = $this->db->table('program_pendidikan');
        $builder->insert($data);
    }

}