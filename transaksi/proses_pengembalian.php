<?php
require_once '../dashboard/fungsi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $noKembali  = trim($_POST['no_pengembalian'] ?? '');
  $noPinjam   = trim($_POST['no_peminjaman'] ?? '');
  $tglKembali = $_POST['tgl_pengembalian'] ?? date('Y-m-d');
  $kondisi    = $_POST['kondisi_buku'] ?? 'Baik';

  $pinjam = one("SELECT * FROM peminjaman WHERE no_peminjaman = ?", 's', $noPinjam);

  if ($pinjam) {
    // Hitung total denda (Terlambat + Kondisi Buku)
    $hitung = hitungDenda($pinjam['batas_pengembalian'], $tglKembali, $kondisi);
    $dendaFinal = $hitung['denda'];

    // 1. Simpan Ke Tabel Pengembalian
    q("INSERT INTO pengembalian (no_pengembalian, no_peminjaman, tgl_pengembalian, jumlah_denda, kondisi_buku) 
       VALUES (?, ?, ?, ?, ?)", 'sssds', $noKembali, $noPinjam, $tglKembali, $dendaFinal, $kondisi);

    // 2. Update Status Peminjaman Menjadi 'Selesai'
    q("UPDATE peminjaman SET status_peminjaman = 'Selesai' WHERE no_peminjaman = ?", 's', $noPinjam);

    // 3. Kembalikan Stok Buku
    $detail = all("SELECT no_buku FROM detail_peminjaman WHERE no_peminjaman = ?", 's', $noPinjam);
    foreach ($detail as $d) {
      q("UPDATE buku SET stok_buku = stok_buku + 1 WHERE no_buku = ?", 's', $d['no_buku']);
    }

    redirect('pengembalian.php', 'Pengembalian buku berhasil diproses!');
  } else {
    redirect('pengembalian.php', 'Data peminjaman tidak ditemukan!');
  }
} else {
  redirect('pengembalian.php');
}