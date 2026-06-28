<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBerita extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_berita' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_kategori' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'slug_berita' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'judul_berita' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'ringkasan' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'isi' => [
                'type' => 'TEXT',
            ],
            'status_berita' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'jenis_berita' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'keywords' => [
                'type' => 'TEXT',
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'hits' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'urutan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'tanggal_post' => [
                'type' => 'DATETIME',
            ],
            'tanggal_publish' => [
                'type' => 'DATETIME',
            ],
            'tanggal' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_berita', true);
        $this->forge->createTable('berita');
    }

    public function down()
    {
        $this->forge->dropTable('berita');
    }
}
