<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategoriStaff extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kategori_staff' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'slug_kategori_staff' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_kategori_staff' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status_kategori_staff' => [
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
        $this->forge->addKey('id_kategori_staff', true);
        $this->forge->createTable('kategori_staff');
    }

    public function down()
    {
        $this->forge->dropTable('kategori_staff');
    }
}
