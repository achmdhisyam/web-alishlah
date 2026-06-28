<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelurahan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kelurahan' => [
                'type' => 'VARCHAR',
                'constraint' => 13,
            ],
            'id_kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => 13,
            ],
            'nama_kelurahan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id_kelurahan', false, true);
        $this->forge->createTable('kelurahan');
    }

    public function down()
    {
        $this->forge->dropTable('kelurahan');
    }
}
