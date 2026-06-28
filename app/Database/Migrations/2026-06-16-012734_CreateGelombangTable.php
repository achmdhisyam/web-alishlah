<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGelombang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_gelombang' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'tahun_ajaran' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'tahap' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'tahun' => [
                'type' => 'YEAR',
                'constraint' => 4,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'isi' => [
                'type' => 'TEXT',
            ],
            'tanggal_buka' => [
                'type' => 'DATE',
            ],
            'tanggal_tutup' => [
                'type' => 'DATE',
            ],
            'tanggal_pengumuman' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'status_gelombang' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'tanggal' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_gelombang', true);
        $this->forge->createTable('gelombang');
    }

    public function down()
    {
        $this->forge->dropTable('gelombang');
    }
}
