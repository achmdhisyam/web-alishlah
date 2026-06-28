<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTahun extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tahun' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nama_tahun' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tahun_mulai' => [
                'type' => 'YEAR',
                'constraint' => 4,
            ],
            'tahun_selesai' => [
                'type' => 'YEAR',
                'constraint' => 4,
            ],
            'keterangan' => [
                'type' => 'TEXT',
            ],
            'tanggal_update' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_tahun', true);
        $this->forge->addKey('nama_tahun', false, true);
        $this->forge->addKey(['tahun_mulai', 'tahun_selesai'], false, true);
        $this->forge->createTable('tahun');
    }

    public function down()
    {
        $this->forge->dropTable('tahun');
    }
}
