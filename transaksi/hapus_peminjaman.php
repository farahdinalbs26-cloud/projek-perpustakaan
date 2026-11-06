<?php
require_once '../dashboard/fungsi.php';
$id = $_GET['id'] ?? '';

if ($id) {
  // Kembalikan Stok Buku
  $detail = all("SELECT no_buku FROM detail_peminjaman WHERE no_peminjaman = ?", 's', $id);
  foreach ($detail as $d) {
    q("UPDATE buku SET stok_buku = stok_buku + 1 WHERE no_buku = ?", 's', $d['no_buku']);
  }

  // Hapus detail dan peminjaman
  q("DELETE FROM detail_peminjaman WHERE no_peminjaman = ?", 's', $id);
  q("DELETE FROM peminjaman WHERE no_peminjaman = ?", 's', $id);

  redirect('peminjaman.php', 'Transaksi peminjaman berhasil dihapus.');
} else {
  redirect('peminjaman.php');
}