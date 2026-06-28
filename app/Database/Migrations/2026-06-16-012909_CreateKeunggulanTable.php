<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKeunggulan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_keunggulan' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'slug_keunggulan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'judul_keunggulan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'ringkasan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'isi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status_keunggulan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'default' => 'Draft',
            ],
            'keywords' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'hits' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => '0',
            ],
            'tanggal_post' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tanggal_publish' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tanggal' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_keunggulan', true);
        $this->forge->createTable('keunggulan');
    }

    public function down()
    {
        $this->forge->dropTable('keunggulan');
    }
}
