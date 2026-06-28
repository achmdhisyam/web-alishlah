<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserLogs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user_log' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_updates' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_user_log', true);
        $this->forge->createTable('user_logs');
    }

    public function down()
    {
        $this->forge->dropTable('user_logs');
    }
}
