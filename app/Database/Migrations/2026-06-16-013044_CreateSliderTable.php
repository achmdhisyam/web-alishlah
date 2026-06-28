<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSlider extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_slider' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'judul_slider' => [
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
            'text_website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->addKey('id_slider', true);
        $this->forge->createTable('slider');
    }

    public function down()
    {
        $this->forge->dropTable('slider');
    }
}
