<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStaffRombel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_staff_rombel' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_rombel' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_tahun' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_staff' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'id_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'status_staff_rombel' => [
                'type' => 'ENUM',
                'constraint' => ['Aktif', 'Lulus', 'Non Aktif', 'Pindah Sekolah', 'Meninggal'],
                'default' => 'Aktif',
            ],
            'status_guru_rombel' => [
                'type' => 'ENUM',
                'constraint' => ['Wali', 'Guru'],
            ],
            'keterangan' => [
                'type' => 'TEXT',
            ],
            'tanggal_update' => [
                'type' => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id_staff_rombel', true);
        $this->forge->createTable('staff_rombel');
    }

    public function down()
    {
        $this->forge->dropTable('staff_rombel');
    }
}
