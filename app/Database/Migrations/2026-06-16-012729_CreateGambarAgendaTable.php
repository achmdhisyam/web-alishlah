<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGambarAgenda extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_gambar_agenda' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_agenda' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nama_gambar_agenda' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'gambar' => [
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
            'tanggal' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_gambar_agenda', true);
        $this->forge->createTable('gambar_agenda');
    }

    public function down()
    {
        $this->forge->dropTable('gambar_agenda');
    }
}
