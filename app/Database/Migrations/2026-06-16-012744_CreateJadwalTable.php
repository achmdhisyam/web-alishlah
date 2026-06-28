<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwal extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jadwal' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_agenda' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nama_jadwal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'pembicara' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'peserta' => [
                'type' => 'TEXT',
            ],
            'tanggal_mulai' => [
                'type' => 'DATE',
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
            ],
            'jam_mulai' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'jam_selesai' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nama_tempat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tanggal_post' => [
                'type' => 'DATETIME',
            ],
            'tanggal_update' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_jadwal', true);
        $this->forge->createTable('jadwal');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal');
    }
}
