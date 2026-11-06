<?php
require_once '../dashboard/fungsi.php';
$judul = 'Input Pengembalian';
$aktif = 'pengembalian';

$selectedNo = $_GET['no'] ?? '';

// Ambil Peminjaman Yang Belum Selesai
$peminjamanBelum = all("SELECT p.*, a.nama_anggota 
                        FROM peminjaman p 
                        JOIN anggota a ON a.NIM = p.NIM 
                        WHERE p.status_peminjaman != 'Selesai' 
                        ORDER BY p.no_peminjaman DESC");

include '../dashboard/header.php';
?>

<div class="head"><h1>Form Pengembalian Buku</h1></div>

<form method="post" action="proses_pengembalian.php" id="form-kembali" class="box" 
      data-perhari="<?= DENDA_PER_HARI ?>" 
      data-kondisi='<?= json_encode(DENDA_KONDISI) ?>'>

  <label>No Pengembalian</label>
  <input type="text" name="no_pengembalian" value="<?= e(kodeBaru('pengembalian', 'no_pengembalian', 'KB')) ?>" readonly style="background:#eee;">

  <label>Pilih Transaksi Peminjaman</label>
  <select name="no_peminjaman" required>
    <option value="">-- Pilih Transaksi Peminjaman --</option>
    <?php foreach ($peminjamanBelum as $p): ?>
      <option value="<?= e($p['no_peminjaman']) ?>" 
              data-batas="<?= e($p['batas_pengembalian']) ?>"
              <?= ($selectedNo == $p['no_peminjaman']) ? 'selected' : '' ?>>
        <?= e($p['no_peminjaman']) ?> - <?= e($p['nama_anggota']) ?> (Batas: <?= tgl($p['batas_pengembalian']) ?>)
      </option>
    <?php endforeach; ?>
  </select>

  <label>Tanggal Pengembalian</label>
  <input type="date" name="tgl_pengembalian" value="<?= date('Y-m-d') ?>" required>

  <label>Kondisi Buku DitERIMA</label>
  <select name="kondisi_buku" required>
    <option value="Baik">Baik (Denda Kondisi: Rp 0)</option>
    <option value="Rusak">Rusak (Denda Kondisi: <?= rp(DENDA_KONDISI['Rusak']) ?>)</option>
    <option value="Hilang">Hilang (Denda Kondisi: <?= rp(DENDA_KONDISI['Hilang']) ?>)</option>
  </select>

  <label>Perkiraan Total Denda (Otomatis Hitung):</label>
  <div id="preview" class="preview">Rp 0</div>

  <div class="actions">
    <button type="submit" class="btn ok">Proses Pengembalian</button>
    <a href="pengembalian.php" class="btn alt">Batal</a>
  </div>
</form>

<?php include '../dashboard/footer.php'; ?>