<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategoriFasilitas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kategori_fasilitas' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'slug_kategori_fasilitas' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_kategori_fasilitas' => [
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
            'status_kategori_fasilitas' => [
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
        $this->forge->addKey('id_kategori_fasilitas', true);
        $this->forge->createTable('kategori_fasilitas');
    }

    public function down()
    {
        $this->forge->dropTable('kategori_fasilitas');
    }
}
