<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrestasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_prestasi' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_kategori_prestasi' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'slug_prestasi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'judul_prestasi' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'nama_penerima' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'penyelenggara' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'hadiah_prestasi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'jenjang_prestasi' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'tahun_prestasi' => [
                'type' => 'YEAR',
                'constraint' => 4,
                'null' => true,
            ],
            'tanggal_prestasi' => [
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
            'status_prestasi' => [
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
        $this->forge->addKey('id_prestasi', true);
        $this->forge->addKey('slug_prestasi', false, true);
        $this->forge->createTable('prestasi');
    }

    public function down()
    {
        $this->forge->dropTable('prestasi');
    }
}
