<?php 
namespace App\Models;

use CodeIgniter\Model;

class Siswa_model extends Model
{

   public function __construct()
    {
        parent::__construct();
        $this->db               = \Config\Database::connect();
    }

    protected $table            = 'siswa';
    protected $primaryKey       = 'id_siswa';
    protected $allowedFields    = ['*'];

    private function _applyBaseJoins($builder)
    {
        $builder->select('siswa.*,
            agama.nama_agama,
            agama_ayah.nama_agama AS agama_ayah,
            agama_ibu.nama_agama AS agama_ibu,
            agama_wali.nama_agama AS agama_wali,
            pekerjaan_ayah.nama_pekerjaan AS pekerjaan_ayah,
            pekerjaan_ayah.nama_pekerjaan AS nama_pekerjaan,
            pekerjaan_ibu.nama_pekerjaan AS pekerjaan_ibu,
            pekerjaan_wali.nama_pekerjaan AS pekerjaan_wali,
            jenjang_ayah.nama_jenjang AS jenjang_ayah,
            jenjang_ibu.nama_jenjang AS jenjang_ibu,
            jenjang_wali.nama_jenjang AS jenjang_wali,
            gelombang.tahun_ajaran,
            kelas.nama_kelas,
            jenjang.nama_jenjang,
            hubungan.nama_hubungan,
            akun.nama AS nama_akun, akun.email AS email_akun, akun.username,
            program_pendidikan.judul_program_pendidikan,
            gelombang.judul,
            gelombang.tanggal_buka,
            gelombang.tanggal_tutup,
            gelombang.tanggal_pengumuman');
        $builder->join('agama', 'agama.id_agama = siswa.id_agama', 'LEFT');
        $builder->join('agama agama_ayah', 'agama_ayah.id_agama = siswa.id_agama_ayah', 'LEFT');
        $builder->join('agama agama_ibu', 'agama_ibu.id_agama = siswa.id_agama_ibu', 'LEFT');
        $builder->join('agama agama_wali', 'agama_wali.id_agama = siswa.id_agama_wali', 'LEFT');
        $builder->join('pekerjaan pekerjaan_ayah', 'pekerjaan_ayah.id_pekerjaan = siswa.id_pekerjaan_ayah', 'LEFT');
        $builder->join('pekerjaan pekerjaan_ibu', 'pekerjaan_ibu.id_pekerjaan = siswa.id_pekerjaan_ibu', 'LEFT');
        $builder->join('pekerjaan pekerjaan_wali', 'pekerjaan_wali.id_pekerjaan = siswa.id_pekerjaan_wali', 'LEFT');
        $builder->join('jenjang jenjang_ayah', 'jenjang_ayah.id_jenjang = siswa.id_jenjang_ayah', 'LEFT');
        $builder->join('jenjang jenjang_ibu', 'jenjang_ibu.id_jenjang = siswa.id_jenjang_ibu', 'LEFT');
        $builder->join('jenjang jenjang_wali', 'jenjang_wali.id_jenjang = siswa.id_jenjang_wali', 'LEFT');
        $builder->join('tahun', 'tahun.id_tahun = siswa.id_tahun', 'LEFT');
        $builder->join('kelas', 'kelas.id_kelas = siswa.id_kelas', 'LEFT');
        $builder->join('jenjang', 'jenjang.id_jenjang = siswa.id_jenjang', 'LEFT');
        $builder->join('hubungan', 'hubungan.id_hubungan = siswa.id_hubungan', 'LEFT');
        $builder->join('akun', 'akun.id_akun = siswa.id_akun', 'LEFT');
        $builder->join('program_pendidikan', 'program_pendidikan.id_program_pendidikan = siswa.id_program_pendidikan', 'LEFT');
        $builder->join('gelombang', 'gelombang.id_gelombang = siswa.id_gelombang', 'LEFT');
    }

    // listing
    public function listing()
    {
        $builder = $this->db->table('siswa');
        $this->_applyBaseJoins($builder);
        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    // status_siswa
    public function status_siswa($status_siswa)
    {
        $builder = $this->db->table('siswa');
        $this->_applyBaseJoins($builder);
        $builder->where('status_siswa',$status_siswa);
        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getResult();
    }

     // status_siswa
    public function akun($id_akun)
    {
        $builder = $this->db->table('siswa');
        $this->_applyBaseJoins($builder);
        $builder->where('siswa.id_akun',$id_akun);
        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    // gelombang
    public function gelombang($id_gelombang)
    {
        $builder = $this->db->table('siswa s');
        $builder->select('jp.judul_program_pendidikan, jp.id_program_pendidikan, s.status_pendaftaran, COUNT(s.id_siswa) AS jumlah_siswa');
        $builder->join('program_pendidikan jp', 's.id_program_pendidikan = jp.id_program_pendidikan');
        $builder->where('s.id_gelombang',$id_gelombang);
        $builder->groupBy('jp.judul_program_pendidikan, jp.id_program_pendidikan, s.status_pendaftaran');
        $builder->orderBy('jp.judul_program_pendidikan, s.status_pendaftaran');
        $query = $builder->get();
        return $query->getResult();
    }


    // gelombang_status_siswa
    public function gelombang_status_siswa($id_gelombang,$status_pendaftaran,$id_program_pendidikan)
    {
        $builder = $this->db->table('siswa');
        $this->_applyBaseJoins($builder);
        $builder->where('siswa.id_gelombang',$id_gelombang);

        if($status_pendaftaran != 'Semua') {
            $builder->where('status_pendaftaran',$status_pendaftaran);
        }
        if($id_program_pendidikan != 'Semua') {
            $builder->where('siswa.id_program_pendidikan',$id_program_pendidikan);
        }

        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    // total_gelombang_status_siswa
    public function total_gelombang_status_siswa($id_gelombang,$status_pendaftaran,$id_program_pendidikan)
    {
        $builder = $this->db->table('siswa');
        $builder->select('COUNT(*) AS total');
        $builder->where('id_gelombang',$id_gelombang);
        if($status_pendaftaran != 'Semua') {
            $builder->where('status_pendaftaran',$status_pendaftaran);
        }
        if($id_program_pendidikan != 'Semua') {
            $builder->where('id_program_pendidikan',$id_program_pendidikan);
        }
        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    // status_siswa_gelombang
    public function status_siswa_gelombang($status_siswa,$id_gelombang)
    {
        $builder = $this->db->table('siswa');
        $builder->select('COUNT(*) AS total');

        if($status_siswa != 'Semua') {
            $builder->where('status_siswa',$status_siswa);
        }
        
        $builder->where('id_gelombang',$id_gelombang);
        $query = $builder->get();
        return $query->getRow();
    }

    // paginasi
    public function paginasi($limit,$start)
    {
        $builder = $this->db->table('siswa');
        $this->_applyBaseJoins($builder);
        $builder->limit($limit,$start);
        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    // paginasi
    public function paginasi_cari($keywords,$limit,$start)
    {
        $builder = $this->db->table('siswa');
        $this->_applyBaseJoins($builder);
        $builder->like('siswa.nama_siswa',$keywords,'BOTH');
        $builder->orLike('siswa.email',$keywords,'BOTH');
        $builder->orLike('siswa.nama_ayah',$keywords,'BOTH');
        $builder->orLike('siswa.nama_ibu',$keywords,'BOTH');
        $builder->orLike('siswa.nama_wali',$keywords,'BOTH');
        $builder->orLike('siswa.alamat',$keywords,'BOTH');
        $builder->orLike('siswa.telepon',$keywords,'BOTH');
        $builder->limit($limit,$start);
        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    // total
    public function total_cari($keywords)
    {
        $builder = $this->db->table('siswa');
        $builder->select('COUNT(*) AS total');
        $builder->like('siswa.nama_siswa',$keywords,'BOTH');
        $builder->orLike('siswa.email',$keywords,'BOTH');
        $builder->orLike('siswa.nama_ayah',$keywords,'BOTH');
        $builder->orLike('siswa.nama_ibu',$keywords,'BOTH');
        $builder->orLike('siswa.nama_wali',$keywords,'BOTH');
        $builder->orLike('siswa.alamat',$keywords,'BOTH');
        $builder->orLike('siswa.telepon',$keywords,'BOTH');
        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    // total
    public function total()
    {
        $builder = $this->db->table('siswa');
        $builder->select('COUNT(*) AS total');
        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    // last_id
    public function last_id()
    {
        $builder = $this->db->table('siswa');
        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    // detail
    public function detail($id_siswa)
    {
        $builder = $this->db->table('siswa');
        $this->_applyBaseJoins($builder);
        $builder->where('siswa.id_siswa',$id_siswa);
        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    // listing
    public function login($username,$password)
    {
        $builder = $this->db->table('siswa');
        $this->_applyBaseJoins($builder);
        $builder->where([   'siswa.email'     => $username,
                            'siswa.password'  => $password
                        ]);
        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    // listing
    public function login_nis($username,$password)
    {
        $builder = $this->db->table('siswa');
        $this->_applyBaseJoins($builder);
        $builder->where([   'siswa.nis'       => $username,
                            'siswa.password'  => $password
                        ]);
        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    // read
    public function read($slug_siswa)
    {
        $builder = $this->db->table('siswa');
        $this->_applyBaseJoins($builder);
        $builder->where('slug_siswa',$slug_siswa);
        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    // read
    public function kode_siswa($kode_siswa)
    {
        $builder = $this->db->table('siswa');
        $this->_applyBaseJoins($builder);
        $builder->where('kode_siswa',$kode_siswa);
        $builder->orderBy('siswa.id_siswa','DESC');
        $query = $builder->get();
        return $query->getRow();
    }

    // edit
    public function edit($data)
    {
        $builder = $this->db->table('siswa');
        $builder->where('siswa.id_siswa',$data['id_siswa']);
        $builder->update($data);
    }

    // hapus
    public function hapus($data)
    {
        $builder = $this->db->table('siswa');
        $builder->where('slug_siswa',$data['slug_siswa']);
        $builder->where('id_akun',$data['id_akun']);
        $builder->delete();
    }

    // tambah
    public function tambah($data)
    {
        $builder = $this->db->table('siswa');
        $builder->insert($data);
    }

    // tambah  log
    public function siswa_log($data)
    {
        $builder = $this->db->table('siswa_logs');
        $builder->insert($data);
    }

    public function getSiswaBySlugAndAkun($slug, $id_akun)
{
    $builder = $this->db->table('siswa');
    $builder->where('siswa.slug_siswa', $slug);
    $builder->where('siswa.id_akun', $id_akun);
    return $builder->get()->getRow();
}

}