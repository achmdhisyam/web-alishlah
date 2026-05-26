ALTER TABLE konfigurasi ADD COLUMN IF NOT EXISTS rincian_administrasi LONGTEXT;
UPDATE konfigurasi SET rincian_administrasi = '<table class="table table-bordered table-sm printer mt-2">
  <thead>
    <tr>
      <th colspan="3" class="bg-secondary text-white text-center">
        1. ADMINISTRASI KEUANGAN UMUM
      </th>
    </tr>
    <tr>
      <th>JENIS PEMBAYARAN</th>
      <th>PEREMPUAN</th>
      <th>LAKI-LAKI</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Pendaftaran Peserta Didik Baru</td><td>Rp 150.000</td><td>Rp 150.000</td></tr>
    <tr><td>Masa Ta''aruf Siswa Madrasah (MATSAMA)</td><td>Rp 150.000</td><td>Rp 150.000</td></tr>
    <tr><td>Penguatan Karakter Peserta Didik Baru</td><td>Rp 250.000</td><td>Rp 250.000</td></tr>
    <tr><td>Kaos Olahraga</td><td>Rp 175.000</td><td>Rp 175.000</td></tr>
    <tr><td>Seragam sekolah 3 stel</td><td>Rp 825.000</td><td>Rp 825.000</td></tr>
    <tr><td>Atribut Seragam</td><td>Rp 200.000</td><td>Rp 200.000</td></tr>
    <tr><td>Peci hitam &amp; ikat pinggang</td><td>-</td><td>Rp 70.000</td></tr>
    <tr><td>Kerudung (3 buah)</td><td>Rp 150.000</td><td>-</td></tr>
    <tr><td>Administrasi Sekolah</td><td>Rp 200.000</td><td>Rp 200.000</td></tr>
    <tr><td>Ta''aruf Santri Baru</td><td>Rp 50.000</td><td>Rp 50.000</td></tr>
    <tr><td>Almari</td><td>Rp 400.000</td><td>Rp 400.000</td></tr>
    <tr><td>Seragam Pondok Pesantren</td><td>Rp 135.000</td><td>Rp 135.000</td></tr>
    <tr><td><strong>J U M L A H</strong></td><td><strong>Rp 2.685.000</strong></td><td><strong>Rp 2.605.000</strong></td></tr>
  </tbody>
</table>

<table class="table table-bordered table-sm printer mt-2">
  <thead>
    <tr>
      <th colspan="2" class="bg-light">NB : Administrasi sekolah dan atribut seragam meliputi hal-hal sebagai berikut :</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td width="50%">
        <strong>ATRIBUT SERAGAM</strong>
        <ul>
          <li>Kaos kaki : 2 pcs</li>
          <li>Bed lembaga &amp; Bed kelas</li>
          <li>Bed nama</li>
          <li>Atribut pramuka:
            <ul>
              <li>Hasduk dan Ring</li>
              <li>Topi</li>
              <li>Pin</li>
              <li>Tongkat</li>
              <li>Tali</li>
              <li>Bedge Pramuka</li>
            </ul>
          </li>
        </ul>
      </td>
      <td width="50%">
        <strong>ADMINISTRASI SEKOLAH MELIPUTI</strong>
        <ul>
          <li>Buku pribadi siswa</li>
          <li>Lembar Ulangan</li>
          <li>KTS</li>
          <li>Rapor UKS</li>
          <li>Buku UKS</li>
        </ul>
      </td>
    </tr>
  </tbody>
</table>

<table class="table table-bordered table-sm printer mt-2">
  <thead>
    <tr>
      <th class="bg-secondary text-white text-center">2. ADMINISTRASI KEUANGAN KHUSUS</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>- Infaq Gedung : Rp 2.200.000 (pembayaran dapat diangsur selama 1 tahun)</td>
    </tr>
  </tbody>
</table>

<table class="table table-bordered table-sm printer mt-2">
  <thead>
    <tr>
      <th colspan="3" class="bg-secondary text-white text-center">CATATAN</th>
    </tr>
    <tr>
      <th class="text-center">JALUR INDEN</th>
      <th class="text-center">GELOMBANG 1</th>
      <th class="text-center">GELOMBANG 2</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Tanggal 20 Oktober - 20 Desember 2025</td>
      <td>Tanggal 21 Desember 2025 - 20 Maret 2026</td>
      <td>Tanggal 21 Maret - 10 Juni 2026</td>
    </tr>
    <tr>
      <td>Potongan Rp. 1.000.000,-</td>
      <td>Potongan Rp. 500.000,-</td>
      <td>-</td>
    </tr>
    <tr>
      <td>Melunasi administrasi keuangan umum terakhir 20 Desember 2025.</td>
      <td>Melunasi 50% dari administrasi keuangan umum terakhir 20 Maret 2026.</td>
      <td>Melunasi 50% dari administrasi keuangan umum terakhir 10 Juni 2026.</td>
    </tr>
  </tbody>
</table>' WHERE id_konfigurasi = 1;
