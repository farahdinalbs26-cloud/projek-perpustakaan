<?php
require_once '../dashboard/fungsi.php';
$judul = 'Data Anggota';
$aktif = 'anggota';
include '../dashboard/header.php';

$anggota = all("SELECT * FROM anggota ORDER BY NIM ASC");
?>

<div class="head">
  <h1>Data Anggota</h1>
  <a href="tambah_anggota.php" class="btn ok">+ Tambah Anggota</a>
</div>

<input type="text" id="cari" class="cari" placeholder="Cari anggota...">

<table class="data">
  <thead>
    <tr>
      <th>No</th>
      <th>NIM</th>
      <th>Nama</th>
      <th>Jenis Kelamin</th>
      <th>Alamat</th>
      <th>Email</th>
      <th>No HP</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($anggota as $i => $r): ?>
    <tr>
      <td><?= $i + 1 ?></td>
      <td><?= e($r['NIM']) ?></td>
      <td><?= e($r['nama_anggota']) ?></td>
      <td><?= e($r['jenis_kelamin']) ?></td>
      <td><?= e($r['alamat']) ?></td>
      <td><?= e($r['email']) ?></td>
      <td><?= e($r['no_hp']) ?></td>
      <td><?= badge($r['status_anggota']) ?></td>
      <td>
        <a href="edit_anggota.php?nim=<?= urlencode($r['NIM']) ?>" class="btn sm">Edit</a>
        <a href="hapus_anggota.php?nim=<?= urlencode($r['NIM']) ?>" class="btn sm danger" data-confirm="Yakin ingin menghapus anggota ini?">Hapus</a>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$anggota): ?>
    <tr><td colspan="9">Belum ada data anggota.</td></tr>
  <?php endif; ?>
  </tbody>
</table>

<?php include '../dashboard/footer.php'; ?>