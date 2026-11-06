<?php
require_once '../dashboard/fungsi.php';
$id = $_GET['id'] ?? '';

if ($id) {
  try {
    q("DELETE FROM buku WHERE no_buku = ?", 's', $id);
    redirect('buku.php', 'Buku berhasil dihapus.');
  } catch (Exception $e) {
    redirect('buku.php', 'Buku tidak dapat dihapus karena masih terikat transaksi.');
  }
} else {
  redirect('buku.php');
}