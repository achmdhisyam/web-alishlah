<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLinkWebsite extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_link_website' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'slug_link_website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_link_website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'keterangan' => [
                'type' => 'TEXT',
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
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'link_website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'metode_link' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'status_link_website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_post' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tanggal' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_link_website', true);
        $this->forge->createTable('link_website');
    }

    public function down()
    {
        $this->forge->dropTable('link_website');
    }
}
