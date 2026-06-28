<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePeriode extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_periode' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'slug_periode' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'urutan' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nama_periode' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id_periode', true);
        $this->forge->addKey('nama_periode', false, true);
        $this->forge->createTable('periode');
    }

    public function down()
    {
        $this->forge->dropTable('periode');
    }
}
