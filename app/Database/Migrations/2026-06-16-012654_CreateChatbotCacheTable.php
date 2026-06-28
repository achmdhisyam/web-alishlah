<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChatbotCache extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'query_hash' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
            ],
            'user_query' => [
                'type' => 'TEXT',
            ],
            'reply_text' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'expired_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('query_hash', false, true);
        $this->forge->createTable('chatbot_cache');
    }

    public function down()
    {
        $this->forge->dropTable('chatbot_cache');
    }
}
