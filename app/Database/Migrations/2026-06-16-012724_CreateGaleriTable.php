<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGaleri extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_galeri' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_kategori_galeri' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'judul_galeri' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'jenis_galeri' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'isi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'text_website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'hits' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'status_text' => [
                'type' => 'ENUM',
                'constraint' => ['Ya', 'Tidak', '', ''],
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
        $this->forge->addKey('id_galeri', true);
        $this->forge->createTable('galeri');
    }

    public function down()
    {
        $this->forge->dropTable('galeri');
    }
}
