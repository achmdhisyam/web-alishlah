<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVideo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_video' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'slug_video' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'video' => [
                'type' => 'TEXT',
            ],
            'status_video' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'posisi_video' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'urutan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'hits' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'tanggal_post' => [
                'type' => 'DATETIME',
            ],
            'tanggal' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_video', true);
        $this->forge->createTable('video');
    }

    public function down()
    {
        $this->forge->dropTable('video');
    }
}
