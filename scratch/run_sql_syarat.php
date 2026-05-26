<?php
$conn = mysqli_connect("localhost", "root", "", "javawebmedia_sekolah", 3307);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql1 = "ALTER TABLE konfigurasi ADD COLUMN IF NOT EXISTS syarat_pendaftaran LONGTEXT;";
mysqli_query($conn, $sql1);

$syarat = '<table class="table table-bordered table-sm printer mt-2">
  <thead>
    <tr>
      <th class="bg-secondary text-white text-center">SYARAT PENDAFTARAN</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        1. Mengisi Formulir Pendaftaran santri/siswa baru<br>
        2. Membayar Administrasi Keuangan Umum dan Khusus (terlampir)<br>
        3. Melampirkan berkas sebagai berikut :
        <ul>
          <li>Foto Copy Ijazah SMP/MTs yang dilegalisir : 4 Lembar</li>
          <li>Foto Copy NISN : 2 Lembar</li>
          <li>Foto Copy Akte Kelahiran : 2 Lembar</li>
          <li>Foto Copy KK (Kartu keluarga) : 2 Lembar</li>
          <li>Foto Copy KTP Ayah dan Ibu : 2 Lembar</li>
          <li>Foto Copy Kartu KIP, KKS dan PKH Bagi yang memiliki : 2 Lembar</li>
          <li>Foto hitam putih Ukuran 3 x 4 : 2 Lembar</li>
        </ul>
      </td>
    </tr>
  </tbody>
</table>';

$stmt = $conn->prepare("UPDATE konfigurasi SET syarat_pendaftaran = ? WHERE id_konfigurasi = 1");
$stmt->bind_param("s", $syarat);
$stmt->execute();
$stmt->close();
mysqli_close($conn);
echo "Syarat pendaftaran updated.";
?>
