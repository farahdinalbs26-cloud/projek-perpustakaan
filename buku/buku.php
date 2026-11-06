<?php
require_once '../dashboard/fungsi.php';
$judul = 'Data Buku';
$aktif = 'buku';
include '../dashboard/header.php';

$buku = all("SELECT b.*, k.nama_kategori_buku 
             FROM buku b 
             LEFT JOIN kategori k ON b.no_kategori = k.no_kategori 
             ORDER BY b.no_buku ASC");
?>

<div class="head">
  <h1>Data Buku</h1>
  <div>
    <a href="kategori.php" class="btn alt">Kelola Kategori</a>
    <a href="tambah_buku.php" class="btn ok">+ Tambah Buku</a>
  </div>
</div>

<input type="text" id="cari" class="cari" placeholder="Cari buku...">

<table class="data">
  <thead>
    <tr>
      <th>No</th>
      <th>No Buku</th>
      <th>Judul</th>
      <th>Penulis</th>
      <th>Penerbit</th>
      <th>Tahun</th>
      <th>ISBN</th>
      <th>Stok</th>
      <th>Kategori</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($buku as $i => $r): ?>
    <tr>
      <td><?= $i + 1 ?></td>
      <td><?= e($r['no_buku']) ?></td>
      <td><?= e($r['judul_buku']) ?></td>
      <td><?= e($r['penulis']) ?></td>
      <td><?= e($r['penerbit']) ?></td>
      <td><?= e($r['th_terbit']) ?></td>
      <td><?= e($r['ISBN']) ?></td>
      <td><?= e($r['stok_buku']) ?></td>
      <td><?= e($r['nama_kategori_buku'] ?? '-') ?></td>
      <td>
        <a href="edit_buku.php?id=<?= urlencode($r['no_buku']) ?>" class="btn sm">Edit</a>
        <a href="hapus_buku.php?id=<?= urlencode($r['no_buku']) ?>" class="btn sm danger" data-confirm="Yakin ingin menghapus buku ini?">Hapus</a>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$buku): ?>
    <tr><td colspan="10">Belum ada data buku.</td></tr>
  <?php endif; ?>
  </tbody>
</table>

<?php include '../dashboard/footer.php'; ?>