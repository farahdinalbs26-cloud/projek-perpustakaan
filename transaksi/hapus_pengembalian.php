<?php
require_once '../dashboard/fungsi.php';
$id = $_GET['id'] ?? '';

if ($id) {
  $kembali = one("SELECT no_peminjaman FROM pengembalian WHERE no_pengembalian = ?", 's', $id);
  if ($kembali) {
    // Kembalikan status peminjaman jadi Dipinjam
    q("UPDATE peminjaman SET status_peminjaman = 'Dipinjam' WHERE no_peminjaman = ?", 's', $kembali['no_peminjaman']);
    q("DELETE FROM pengembalian WHERE no_pengembalian = ?", 's', $id);
  }
  redirect('pengembalian.php', 'Data pengembalian berhasil dihapus.');
} else {
  redirect('pengembalian.php');
}