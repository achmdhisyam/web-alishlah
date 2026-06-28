<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgramPendidikan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_program_pendidikan' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'slug_program_pendidikan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'judul_program_pendidikan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'ringkasan' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'isi' => [
                'type' => 'TEXT',
            ],
            'status_program_pendidikan' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'jenis_program_pendidikan' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'keywords' => [
                'type' => 'TEXT',
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'hits' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'urutan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'tanggal_post' => [
                'type' => 'DATETIME',
            ],
            'tanggal_publish' => [
                'type' => 'DATETIME',
            ],
            'tanggal' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_program_pendidikan', true);
        $this->forge->createTable('program_pendidikan');
    }

    public function down()
    {
        $this->forge->dropTable('program_pendidikan');
    }
}
