<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHubungan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_hubungan' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'nama_hubungan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'keterangan' => [
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
        $this->forge->addKey('id_hubungan', true);
        $this->forge->addKey('nama_hubungan', false, true);
        $this->forge->createTable('hubungan');
    }

    public function down()
    {
        $this->forge->dropTable('hubungan');
    }
}
