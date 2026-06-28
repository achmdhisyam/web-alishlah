<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProfil extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_profil' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'slug_profil' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'judul_profil' => [
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
            'status_profil' => [
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
        $this->forge->addKey('id_profil', true);
        $this->forge->createTable('profil');
    }

    public function down()
    {
        $this->forge->dropTable('profil');
    }
}
