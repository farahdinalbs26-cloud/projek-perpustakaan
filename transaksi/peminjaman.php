<?php
require_once '../dashboard/fungsi.php';
$judul = 'Peminjaman Buku';
$aktif = 'peminjaman';
include '../dashboard/header.php';

$sql = "SELECT p.*, a.nama_anggota, 
               GROUP_CONCAT(b.judul_buku SEPARATOR ', ') AS daftar_buku
        FROM peminjaman p
        JOIN anggota a ON a.NIM = p.NIM
        LEFT JOIN detail_peminjaman dp ON dp.no_peminjaman = p.no_peminjaman
        LEFT JOIN buku b ON b.no_buku = dp.no_buku
        GROUP BY p.no_peminjaman
        ORDER BY p.no_peminjaman DESC";

$peminjaman = all($sql);
?>

<div class="head">
  <h1>Data Peminjaman</h1>
  <a href="tambah_peminjaman.php" class="btn ok">+ Catat Peminjaman</a>
</div>

<input type="text" id="cari" class="cari" placeholder="Cari peminjaman...">

<table class="data">
  <thead>
    <tr>
      <th>No Transaksi</th>
      <th>Anggota</th>
      <th>Buku Dipinjam</th>
      <th>Tgl Pinjam</th>
      <th>Batas Kembali</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($peminjaman as $r): ?>
    <tr>
      <td><b><?= e($r['no_peminjaman']) ?></b></td>
      <td><?= e($r['nama_anggota']) ?> (<?= e($r['NIM']) ?>)</td>
      <td><?= e($r['daftar_buku'] ?? '-') ?></td>
      <td><?= tgl($r['tgl_peminjaman']) ?></td>
      <td><?= tgl($r['batas_pengembalian']) ?></td>
      <td><?= badge($r['status_peminjaman']) ?></td>
      <td>
  <?php if ($r['status_peminjaman'] != 'Selesai'): ?>
    <a href="tambah_pengembalian.php?no=<?= urlencode($r['no_peminjaman']) ?>" class="btn sm ok">
      Kembalikan
    </a>
  <?php else: ?>
    <span class="small" style="color:var(--hijau);">Sudah Kembali</span>
  <?php endif; ?>

  <a href="edit_peminjaman.php?id=<?= urlencode($r['no_peminjaman']) ?>" class="btn sm">
    Edit
  </a>

  <a href="hapus_peminjaman.php?id=<?= urlencode($r['no_peminjaman']) ?>"
     class="btn sm danger"
     data-confirm="Hapus transaksi ini beserta detailnya?">
    Hapus
  </a>
</td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$peminjaman): ?>
    <tr><td colspan="7">Belum ada transaksi peminjaman.</td></tr>
  <?php endif; ?>
  </tbody>
</table>

<?php include '../dashboard/footer.php'; ?>