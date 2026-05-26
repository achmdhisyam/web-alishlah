ALTER TABLE siswa
ADD COLUMN tempat_lahir_ayah VARCHAR(255) NULL AFTER nama_ayah,
ADD COLUMN tanggal_lahir_ayah DATE NULL AFTER tempat_lahir_ayah,
ADD COLUMN status_wn_ayah ENUM('WNI','WNA') NULL DEFAULT 'WNI' AFTER id_agama_ayah,
ADD COLUMN penghasilan_ayah VARCHAR(100) NULL AFTER id_pekerjaan_ayah,
ADD COLUMN status_hidup_ayah ENUM('Hidup','Meninggal') NULL DEFAULT 'Hidup' AFTER penghasilan_ayah,

ADD COLUMN tempat_lahir_ibu VARCHAR(255) NULL AFTER nama_ibu,
ADD COLUMN tanggal_lahir_ibu DATE NULL AFTER tempat_lahir_ibu,
ADD COLUMN status_wn_ibu ENUM('WNI','WNA') NULL DEFAULT 'WNI' AFTER id_agama_ibu,
ADD COLUMN penghasilan_ibu VARCHAR(100) NULL AFTER id_pekerjaan_ibu,
ADD COLUMN status_hidup_ibu ENUM('Hidup','Meninggal') NULL DEFAULT 'Hidup' AFTER penghasilan_ibu,

ADD COLUMN tempat_lahir_wali VARCHAR(255) NULL AFTER nama_wali,
ADD COLUMN tanggal_lahir_wali DATE NULL AFTER tempat_lahir_wali,
ADD COLUMN status_wn_wali ENUM('WNI','WNA') NULL DEFAULT 'WNI' AFTER id_agama_wali,
ADD COLUMN penghasilan_wali VARCHAR(100) NULL AFTER id_pekerjaan_wali;
