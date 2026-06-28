<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePortfolio extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_portfolio' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_kategori_portfolio' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'judul_portfolio' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'jenis_portfolio' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'isi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'text_website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'hits' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'status_text' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'status_portfolio' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'tanggal_post' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tanggal' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_portfolio', true);
        $this->forge->createTable('portfolio');
    }

    public function down()
    {
        $this->forge->dropTable('portfolio');
    }
}
