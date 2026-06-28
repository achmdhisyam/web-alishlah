<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSekolah extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sekolah' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nama_sekolah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_sekolah_cover' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_singkat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nis' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status_sekolah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kelurahan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kabupaten' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'provinsi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kode_pos' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
            ],
            'telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'luas_tanah' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'luas_bangunan' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'status_tanah' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'imb' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'nomor_sertifikat' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'nama_yayasan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_berdiri' => [
                'type' => 'DATE',
            ],
            'tahun_berdiri' => [
                'type' => 'YEAR',
                'constraint' => 4,
            ],
            'nama_kepsek' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'jumlah_rombel' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'jumlah_murid' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'jumlah_pegawai' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nilai_akreditasi' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'tahun_akreditasi' => [
                'type' => 'YEAR',
                'constraint' => 4,
            ],
            'tanggal_berlaku' => [
                'type' => 'DATE',
            ],
            'tanggal_kadaluarsa' => [
                'type' => 'DATE',
            ],
            'nomor_izin' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'keterangan' => [
                'type' => 'TEXT',
            ],
            'nama_footer' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_cover' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kota_cover' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_post' => [
                'type' => 'DATETIME',
            ],
            'tanggal_update' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_sekolah', true);
        $this->forge->createTable('sekolah');
    }

    public function down()
    {
        $this->forge->dropTable('sekolah');
    }
}
