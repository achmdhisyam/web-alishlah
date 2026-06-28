<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJenisDokumen extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jenis_dokumen' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'slug_jenis_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_jenis_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status_jenis_dokumen' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'urutan' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tanggal_post' => [
                'type' => 'DATETIME',
            ],
            'tanggal' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_jenis_dokumen', true);
        $this->forge->createTable('jenis_dokumen');
    }

    public function down()
    {
        $this->forge->dropTable('jenis_dokumen');
    }
}
