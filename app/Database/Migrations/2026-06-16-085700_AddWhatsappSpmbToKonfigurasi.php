<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWhatsappSpmbToKonfigurasi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('konfigurasi', [
            'whatsapp_spmb' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'email_admin_spmb',
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('konfigurasi', 'whatsapp_spmb');
    }
}
