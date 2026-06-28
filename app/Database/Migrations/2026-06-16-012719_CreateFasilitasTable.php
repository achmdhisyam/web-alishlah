<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFasilitas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_fasilitas' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_kategori_fasilitas' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'slug_fasilitas' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'judul_fasilitas' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'kode_nomor_fasilitas' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'kondisi_fasilitas' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'tahun_fasilitas' => [
                'type' => 'YEAR',
                'constraint' => 4,
                'null' => true,
            ],
            'tanggal_fasilitas' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'isi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
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
                'constraint' => ['Ya', 'Tidak'],
                'null' => true,
            ],
            'status_fasilitas' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
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
        $this->forge->addKey('id_fasilitas', true);
        $this->forge->addKey('slug_fasilitas', false, true);
        $this->forge->createTable('fasilitas');
    }

    public function down()
    {
        $this->forge->dropTable('fasilitas');
    }
}
