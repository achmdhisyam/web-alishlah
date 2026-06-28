<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePekerjaan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pekerjaan' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nama_pekerjaan' => [
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
        $this->forge->addKey('id_pekerjaan', true);
        $this->forge->addKey('nama_pekerjaan', false, true);
        $this->forge->createTable('pekerjaan');
    }

    public function down()
    {
        $this->forge->dropTable('pekerjaan');
    }
}
