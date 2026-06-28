<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAgama extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_agama' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nama_agama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'urutan' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'tanggal_update' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_agama', true);
        $this->forge->addKey('nama_agama', false, true);
        $this->forge->createTable('agama');
    }

    public function down()
    {
        $this->forge->dropTable('agama');
    }
}
