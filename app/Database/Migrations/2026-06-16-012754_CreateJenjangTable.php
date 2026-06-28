<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJenjang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jenjang' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'nama_jenjang' => [
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
            'status_aktif' => [
                'type' => 'ENUM',
                'constraint' => ['Ya', 'Tidak'],
            ],
            'tanggal_update' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_jenjang', true);
        $this->forge->addKey('nama_jenjang', false, true);
        $this->forge->createTable('jenjang');
    }

    public function down()
    {
        $this->forge->dropTable('jenjang');
    }
}
