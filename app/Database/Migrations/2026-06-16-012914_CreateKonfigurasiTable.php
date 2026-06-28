<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKonfigurasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_konfigurasi' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'namaweb' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'singkatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tagline' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'tentang' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'email_cadangan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'whatsapp' => [
                'type' => 'VARCHAR',
                'constraint' => 24,
            ],
            'pesan_whatsapp' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'hp' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'icon_chatbot' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'keywords' => [
                'type' => 'VARCHAR',
                'constraint' => 400,
                'null' => true,
            ],
            'metatext' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'facebook' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'twitter' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'instagram' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'youtube' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tiktok' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'nama_facebook' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'nama_twitter' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'nama_instagram' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'nama_youtube' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'nama_tiktok' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'google_map' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'protocol' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'smtp_host' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'smtp_port' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'smtp_timeout' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'smtp_user' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'smtp_pass' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'smtp_crypto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'paginasi' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => '12',
            ],
            'paginasi_depan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'banner' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'link_text' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'link_website' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'link_video' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ringkasan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'fitur_pendaftaran' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'mulai_pendaftaran' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'selesai_pendaftaran' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'pengumuman_pendaftaran' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'keterangan_pendaftaran' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'menu_home' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'Publish',
            ],
            'menu_berita' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'Publish',
            ],
            'menu_profil' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'Publish',
            ],
            'menu_prestasi' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'Publish',
            ],
            'menu_galeri' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'Publish',
            ],
            'menu_unduhan' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'Publish',
            ],
            'menu_tautan' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'Publish',
            ],
            'menu_kontak' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'Publish',
            ],
            'menu_jenjang' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'letak_menu' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'Tautan',
            ],
            'login' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tanggal' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'rincian_administrasi' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'syarat_pendaftaran' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'google_client_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'google_client_secret' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'email_admin_spmb' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ]
        ]);
        $this->forge->addKey('id_konfigurasi', true);
        $this->forge->createTable('konfigurasi');
    }

    public function down()
    {
        $this->forge->dropTable('konfigurasi');
    }
}
