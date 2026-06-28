<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAgenda extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_agenda' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_kategori_agenda' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'slug_agenda' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kode_agenda' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama_agenda' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status_agenda' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'status_pendaftaran' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'urutan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'isi' => [
                'type' => 'TEXT',
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'keywords' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'default' => 'NULL',
            ],
            'harga' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'harga_diskon' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'tanggal_mulai' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'jam_mulai' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'jam_selesai' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'tanggal_buka' => [
                'type' => 'DATE',
            ],
            'tanggal_tutup' => [
                'type' => 'DATE',
            ],
            'nama_tempat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'google_map' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'link_google_map' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'hotel' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'hits' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'null' => true,
            ],
            'tanggal_post' => [
                'type' => 'DATETIME',
            ],
            'tanggal' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_agenda', true);
        $this->forge->createTable('agenda');
    }

    public function down()
    {
        $this->forge->dropTable('agenda');
    }
}
