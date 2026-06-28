<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePopup extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_popup' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'judul_popup' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
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
            'status_text' => [
                'type' => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
                'default' => 'Ya',
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
        $this->forge->addKey('id_popup', true);
        $this->forge->createTable('popup');
    }

    public function down()
    {
        $this->forge->dropTable('popup');
    }
}
