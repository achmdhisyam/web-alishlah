<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEkstrakurikuler extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_ekstrakurikuler' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_kategori_ekstrakurikuler' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'slug_ekstrakurikuler' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'judul_ekstrakurikuler' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'nama_penanggung_jawab' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
            'status_ekstrakurikuler' => [
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
        $this->forge->addKey('id_ekstrakurikuler', true);
        $this->forge->addKey('slug_ekstrakurikuler', false, true);
        $this->forge->createTable('ekstrakurikuler');
    }

    public function down()
    {
        $this->forge->dropTable('ekstrakurikuler');
    }
}
