<?php
require_once '../dashboard/fungsi.php';
$nim = $_GET['nim'] ?? '';

if ($nim) {
  try {
    q("DELETE FROM anggota WHERE NIM = ?", 's', $nim);
    redirect('anggota.php', 'Anggota berhasil dihapus.');
  } catch (Exception $e) {
    redirect('anggota.php', 'Anggota tidak dapat dihapus karena masih memiliki riwayat transaksi.');
  }
} else {
  redirect('anggota.php');
}