<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDokumen extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_dokumen' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_akun' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_siswa' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_jenis_dokumen' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'kode_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_size' => [
                'type' => 'DECIMAL',
                'constraint' => '4,3',
            ],
            'file_ext' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'status_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'status_verifikasi' => [
                'type' => 'ENUM',
                'constraint' => ['Menunggu', 'Disetujui', 'Ditolak'],
                'null' => true,
                'default' => 'Menunggu',
            ],
            'catatan_verifikasi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_post' => [
                'type' => 'DATETIME',
            ],
            'tanggal_update' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_dokumen', true);
        $this->forge->addKey('kode_dokumen', false, true);
        $this->forge->createTable('dokumen');
    }

    public function down()
    {
        $this->forge->dropTable('dokumen');
    }
}
