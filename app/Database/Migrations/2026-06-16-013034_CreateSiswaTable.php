<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_siswa' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'id_gelombang' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_agama' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'id_agama_ayah' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'status_wn_ayah' => [
                'type' => 'ENUM',
                'constraint' => ['WNI', 'WNA'],
                'null' => true,
                'default' => 'WNI',
            ],
            'id_agama_ibu' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'status_wn_ibu' => [
                'type' => 'ENUM',
                'constraint' => ['WNI', 'WNA'],
                'null' => true,
                'default' => 'WNI',
            ],
            'id_agama_wali' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'status_wn_wali' => [
                'type' => 'ENUM',
                'constraint' => ['WNI', 'WNA'],
                'null' => true,
                'default' => 'WNI',
            ],
            'id_pekerjaan_ayah' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'penghasilan_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'status_hidup_ayah' => [
                'type' => 'ENUM',
                'constraint' => ['Hidup', 'Meninggal'],
                'null' => true,
                'default' => 'Hidup',
            ],
            'id_pekerjaan_ibu' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'penghasilan_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'status_hidup_ibu' => [
                'type' => 'ENUM',
                'constraint' => ['Hidup', 'Meninggal'],
                'null' => true,
                'default' => 'Hidup',
            ],
            'id_pekerjaan_wali' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'penghasilan_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'id_jenjang_ayah' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'id_jenjang_ibu' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'id_jenjang_wali' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'id_tahun' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'id_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'id_jenjang' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'id_hubungan' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_akun' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_program_pendidikan' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'kode_siswa' => [
                'type' => 'VARCHAR',
                'constraint' => 8,
            ],
            'slug_siswa' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nis' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'nisn' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'status_wn' => [
                'type' => 'ENUM',
                'constraint' => ['WNI', 'WNA'],
                'default' => 'WNI',
            ],
            'negara_asal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'nama_siswa' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_panggilan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 300,
                'null' => true,
            ],
            'rt' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'rw' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'kelurahan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kabupaten' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'provinsi' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'kode_pos' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
            ],
            'password_hint' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['Laki-laki', 'Perempuan', 'L', 'P'],
            ],
            'berkebutuhan_khusus' => [
                'type' => 'ENUM',
                'constraint' => ['Tidak', 'Ya'],
                'default' => 'Tidak',
            ],
            'isi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nama_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tempat_lahir_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tanggal_lahir_ayah' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'nama_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tempat_lahir_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tanggal_lahir_ibu' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'nama_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tempat_lahir_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tanggal_lahir_wali' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'alamat_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'rt_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'rw_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'kelurahan_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kecamatan_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kabupaten_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'provinsi_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kode_pos_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'alamat_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'rt_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'rw_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'kelurahan_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kecamatan_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kabupaten_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'provinsi_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kode_pos_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'alamat_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'rt_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'rw_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'kelurahan_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kecamatan_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kabupaten_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'provinsi_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kode_pos_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'telepon_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'telepon_ibu' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'telepon_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'goldar_siswa' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'hobi_siswa' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'penyakit_siswa' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tinggi' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'berat' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'ukuran_seragam' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'kelompok' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'tanggal_masuk' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'jenis_siswa' => [
                'type' => 'ENUM',
                'constraint' => ['Langsung', 'Pindahan', 'Lainnya'],
                'default' => 'Langsung',
            ],
            'asal_sekolah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'alamat_sekolah_asal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'dari_kelompok' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tanggal_pindah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'anak_ke' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'jumlah_saudara' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'status_siswa' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status_pendaftaran' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'identitas_wali' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'tanggal_baca' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tanggal_post' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tanggal' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'email_pendaftaran_sent' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true,
                'default' => '0',
            ],
            'email_pengumuman_sent' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true,
                'default' => '0',
            ]
        ]);
        $this->forge->addKey('id_siswa', true);
        $this->forge->createTable('siswa');
    }

    public function down()
    {
        $this->forge->dropTable('siswa');
    }
}
