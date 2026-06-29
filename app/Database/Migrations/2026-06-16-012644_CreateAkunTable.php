<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAkun extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_akun' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nis' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
            ],
            'nisn' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
            ],
            'jenis_akun' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'status_akun' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
            ],
            'password_hint' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
            ],
            'telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 300,
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kode_akun' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'link_reset' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'autologin_token' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
            ],
            'autologin_expires' => [
                'type' => 'DATETIME',
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
        $this->forge->addKey('id_akun', true);
        $this->forge->addKey('username', false, true);
        $this->forge->createTable('akun');
    }

    public function down()
    {
        $this->forge->dropTable('akun');
    }
}
