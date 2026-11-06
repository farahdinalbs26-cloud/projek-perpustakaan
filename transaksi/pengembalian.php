<?php
require_once '../dashboard/fungsi.php';
$judul = 'Pengembalian Buku';
$aktif = 'pengembalian';
include '../dashboard/header.php';

$sql = "SELECT k.*, p.NIM, p.tgl_peminjaman, p.batas_pengembalian, a.nama_anggota
        FROM pengembalian k
        JOIN peminjaman p ON p.no_peminjaman = k.no_peminjaman
        JOIN anggota a ON a.NIM = p.NIM
        ORDER BY k.no_pengembalian DESC";

$pengembalian = all($sql);
?>

<div class="head">
  
  <a href="tambah_pengembalian.php" class="btn ok">+ Input Pengembalian</a>
</div>

<input type="text" id="cari" class="cari" placeholder="Cari riwayat pengembalian...">

<table class="data">
  <thead>
    <tr>
      <th>No Pengembalian</th>
      <th>No Pinjam</th>
      <th>Anggota</th>
      <th>Tgl Kembali</th>
      <th>Kondisi Buku</th>
      <th>Denda Dibayar</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($pengembalian as $r): ?>
    <tr>
      <td><b><?= e($r['no_pengembalian']) ?></b></td>
      <td><?= e($r['no_peminjaman']) ?></td>
      <td><?= e($r['nama_anggota']) ?></td>
      <td><?= tgl($r['tgl_pengembalian']) ?></td>
      <td><?= e($r['kondisi_buku']) ?></td>
      <td><b style="color:var(--merah);"><?= rp($r['jumlah_denda']) ?></b></td>
      <td>
        <a href="hapus_pengembalian.php?id=<?= urlencode($r['no_pengembalian']) ?>" class="btn sm danger" data-confirm="Hapus riwayat pengembalian ini?">Hapus</a>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$pengembalian): ?>
    <tr><td colspan="7">Belum ada data pengembalian.</td></tr>
  <?php endif; ?>
  </tbody>
</table>

<?php include '../dashboard/footer.php'; ?>