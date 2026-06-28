<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubMenu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sub_menu' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'id_menu' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'nama_sub_menu' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'link' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'urutan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'status_sub_menu' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'tanggal_update' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_sub_menu', true);
        $this->forge->createTable('sub_menu');
    }

    public function down()
    {
        $this->forge->dropTable('sub_menu');
    }
}
