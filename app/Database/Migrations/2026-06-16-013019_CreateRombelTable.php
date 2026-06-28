<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRombel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rombel' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_tahun' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'tahun_mulai' => [
                'type' => 'YEAR',
                'constraint' => 4,
            ],
            'tahun_selesai' => [
                'type' => 'YEAR',
                'constraint' => 4,
            ],
            'status_rombel' => [
                'type' => 'ENUM',
                'constraint' => ['Aktif', 'Selesai', 'Non Aktif'],
                'default' => 'Aktif',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_update' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_rombel', true);
        $this->forge->createTable('rombel');
    }

    public function down()
    {
        $this->forge->dropTable('rombel');
    }
}
