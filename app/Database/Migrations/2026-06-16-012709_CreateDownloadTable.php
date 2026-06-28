<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDownload extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_download' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_kategori_download' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'judul_download' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'jenis_download' => [
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
            'hits' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'file_ext' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'file_size' => [
                'type' => 'DECIMAL',
                'constraint' => '4,3',
            ],
            'status_download' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'tanggal_post' => [
                'type' => 'DATETIME',
            ],
            'tanggal' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_download', true);
        $this->forge->createTable('download');
    }

    public function down()
    {
        $this->forge->dropTable('download');
    }
}
