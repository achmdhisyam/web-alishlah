<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKecamatan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => 13,
            ],
            'id_kabupaten' => [
                'type' => 'VARCHAR',
                'constraint' => 13,
            ],
            'nama_kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ]
        ]);

        $this->forge->createTable('kecamatan');
    }

    public function down()
    {
        $this->forge->dropTable('kecamatan');
    }
}
