<?php
// DASHBOARD: ringkasan jumlah data + 5 peminjaman terbaru
require_once __DIR__ . '/fungsi.php';
$judul = 'Dashboard';
$aktif = 'dashboard';
include __DIR__ . '/header.php';

// Fungsi kecil untuk menghitung hasil query COUNT/SUM
function hitung($sql) { return one($sql)['n'] ?? 0; }

$kartu = [
  // [judul kartu, isi, warna]
  ['Total Anggota',    hitung("SELECT COUNT(*) n FROM anggota"), ''],
  ['Total Buku',       hitung("SELECT COUNT(*) n FROM buku"), 'green'],
  ['Total Kategori',   hitung("SELECT COUNT(*) n FROM kategori"), ''],
  ['Total Transaksi',  hitung("SELECT COUNT(*) n FROM peminjaman"), 'orange'],
  ['Sedang Dipinjam',  hitung("SELECT COUNT(*) n FROM peminjaman WHERE status_peminjaman='Dipinjam'"), ''],
  ['Terlambat (belum kembali)', hitung("SELECT COUNT(*) n FROM peminjaman p WHERE p.status_peminjaman='Terlambat'
       AND NOT EXISTS (SELECT 1 FROM pengembalian k WHERE k.no_peminjaman=p.no_peminjaman)"), 'red'],
  ['Total Denda',      rp(hitung("SELECT COALESCE(SUM(jumlah_denda),0) n FROM pengembalian")), 'red'],
];

$terbaru = all("SELECT p.*, a.nama_anggota FROM peminjaman p
                JOIN anggota a ON a.NIM = p.NIM ORDER BY p.no_peminjaman DESC LIMIT 5");
?>

<div class="head"><h1>Dashboard</h1></div>

<div class="cards">
  <?php foreach ($kartu as $k): ?>
    <div class="card <?= $k[2] ?>"><?= e($k[0]) ?><b><?= e($k[1]) ?></b></div>
  <?php endforeach; ?>
</div>

<h3>Peminjaman Terbaru</h3>
<table>
  <thead><tr><th>No</th><th>Anggota</th><th>Tgl Pinjam</th><th>Batas Kembali</th><th>Status</th></tr></thead>
  <tbody>
  <?php foreach ($terbaru as $r): ?>
    <tr>
      <td><?= e($r['no_peminjaman']) ?></td>
      <td><?= e($r['nama_anggota']) ?></td>
      <td><?= tgl($r['tgl_peminjaman']) ?></td>
      <td><?= tgl($r['batas_pengembalian']) ?></td>
      <td><?= badge($r['status_peminjaman']) ?></td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$terbaru): ?><tr><td colspan="5">Belum ada transaksi.</td></tr><?php endif; ?>
  </tbody>
</table>

<p class="small">
  Aturan denda: <?= rp(DENDA_PER_HARI) ?> per hari terlambat, ditambah denda kondisi buku
  (Rusak <?= rp(DENDA_KONDISI['Rusak']) ?>, Hilang <?= rp(DENDA_KONDISI['Hilang']) ?>).
</p>

<?php include __DIR__ . '/footer.php'; ?>
