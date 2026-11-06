<?php
// HEADER: bagian atas semua halaman (navbar). Dipanggil oleh setiap halaman dengan include.
// Sebelum include, halaman mengisi $judul (judul tab) dan $aktif (menu yang menyala).
require_once __DIR__ . '/fungsi.php';
syncTerlambat();   // peminjaman yang lewat batas otomatis jadi "Terlambat"
$judul = $judul ?? 'Perpustakaan';
$aktif = $aktif ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($judul) ?> - Perpustakaan</title>
  <link rel="stylesheet" href="../dashboard/style.css">
</head>
<body>

<nav class="nav">
  <span class="brand">Perpustakaan</span>
  <a href="../dashboard/index.php"      class="<?= $aktif == 'dashboard'    ? 'active' : '' ?>">Dashboard</a>
  <a href="../buku/buku.php"            class="<?= $aktif == 'buku'         ? 'active' : '' ?>">Buku</a>
  <a href="../buku/kategori.php"        class="<?= $aktif == 'kategori'     ? 'active' : '' ?>">Kategori</a>
  <a href="../anggota/anggota.php"      class="<?= $aktif == 'anggota'      ? 'active' : '' ?>">Anggota</a>
  <a href="../transaksi/peminjaman.php"   class="<?= $aktif == 'peminjaman'   ? 'active' : '' ?>">Peminjaman</a>
  <a href="../transaksi/pengembalian.php" class="<?= $aktif == 'pengembalian' ? 'active' : '' ?>">Pengembalian</a>
</nav>

<main class="container">
<?php if (!empty($_GET['msg'])): ?>
  <div class="alert"><?= e($_GET['msg']) ?></div>
<?php endif; ?>
