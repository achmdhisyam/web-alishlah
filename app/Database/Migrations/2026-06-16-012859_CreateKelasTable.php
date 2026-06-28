<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_jenjang' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nama_kelas' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status_kelas' => [
                'type' => 'ENUM',
                'constraint' => ['Aktif', 'Non Aktif'],
                'default' => 'Aktif',
            ],
            'keterangan' => [
                'type' => 'TEXT',
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
        $this->forge->addKey('id_kelas', true);
        $this->forge->createTable('kelas');
    }

    public function down()
    {
        $this->forge->dropTable('kelas');
    }
}
