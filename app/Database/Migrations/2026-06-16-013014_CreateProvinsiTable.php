<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProvinsi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_provinsi' => [
                'type' => 'VARCHAR',
                'constraint' => 13,
            ],
            'nama_provinsi' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id_provinsi', false, true);
        $this->forge->createTable('provinsi');
    }

    public function down()
    {
        $this->forge->dropTable('provinsi');
    }
}
