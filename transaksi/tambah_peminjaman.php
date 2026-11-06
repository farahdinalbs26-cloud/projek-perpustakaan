<?php
require_once '../dashboard/fungsi.php';
$judul = 'Catat Peminjaman';
$aktif = 'peminjaman';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $no         = trim($_POST['no_peminjaman'] ?? '');
  $nim        = trim($_POST['NIM'] ?? '');
  $tglPinjam  = $_POST['tgl_peminjaman'] ?? '';
  $batas      = $_POST['batas_pengembalian'] ?? '';
  $bukuDipilih = $_POST['buku'] ?? [];

  if (empty($nim) || empty($bukuDipilih)) {
    $err = "Pilih anggota dan minimal 1 buku yang ingin dipinjam!";
  } else {
    // Simpan Ke Tabel Peminjaman
    q("INSERT INTO peminjaman (no_peminjaman, NIM, tgl_peminjaman, batas_pengembalian, status_peminjaman) 
       VALUES (?, ?, ?, ?, 'Dipinjam')", 'ssss', $no, $nim, $tglPinjam, $batas);

    // Simpan Ke Tabel Detail Peminjaman & Kurangi Stok Buku
    foreach ($bukuDipilih as $noBuku) {
      q("INSERT INTO detail_peminjaman (no_peminjaman, no_buku) VALUES (?, ?)", 'ss', $no, $noBuku);
      q("UPDATE buku SET stok_buku = stok_buku - 1 WHERE no_buku = ? AND stok_buku > 0", 's', $noBuku);
    }

    redirect('peminjaman.php', 'Transaksi peminjaman berhasil dicatat!');
  }
}

$kodeOtomatis = kodeBaru('peminjaman', 'no_peminjaman', 'PJ');
$anggota = all("SELECT * FROM anggota WHERE status_anggota = 'Aktif' ORDER BY nama_anggota ASC");
$buku = all("SELECT b.*, k.nama_kategori_buku FROM buku b LEFT JOIN kategori k ON k.no_kategori = b.no_kategori WHERE b.stok_buku > 0 ORDER BY b.judul_buku ASC");

include '../dashboard/header.php';
?>

<div class="head"><h1>Catat Peminjaman Buku</h1></div>

<?php if ($err): ?>
  <div class="alert err"><?= e($err) ?></div>
<?php endif; ?>

<form method="post" class="box">
  <label>No Peminjaman</label>
  <input type="text" name="no_peminjaman" value="<?= e($kodeOtomatis) ?>" readonly style="background:#eee;">

  <label>Anggota Peminjam</label>
  <select name="NIM" required>
    <option value="">-- Pilih Anggota --</option>
    <?php foreach ($anggota as $a): ?>
      <option value="<?= e($a['NIM']) ?>" <?= ($_POST['NIM'] ?? '') == $a['NIM'] ? 'selected' : '' ?>>
        <?= e($a['NIM']) ?> - <?= e($a['nama_anggota']) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <label>Tanggal Pinjam</label>
  <input type="date" id="tgl_peminjaman" name="tgl_peminjaman" value="<?= date('Y-m-d') ?>" data-lama="7" required>

  <label>Batas Pengembalian (Otomatis 7 Hari)</label>
  <input type="date" id="batas_pengembalian" name="batas_pengembalian" value="<?= date('Y-m-d', strtotime('+7 days')) ?>" required>

  <label>Pilih Buku Yang Dipinjam</label>
  <div class="checks">
    <?php foreach ($buku as $b): ?>
      <label>
        <input type="checkbox" name="buku[]" value="<?= e($b['no_buku']) ?>">
        <b><?= e($b['judul_buku']) ?></b> (Stok: <?= $b['stok_buku'] ?>) - <span class="small"><?= e($b['nama_kategori_buku'] ?? '-') ?></span>
      </label>
    <?php endforeach; ?>
    <?php if (!$buku): ?>
      <p class="small">Tidak ada buku yang tersedia (stok habis).</p>
    <?php endif; ?>
  </div>

  <div class="actions">
    <button type="submit" class="btn ok">Simpan Transaksi</button>
    <a href="peminjaman.php" class="btn alt">Batal</a>
  </div>
</form>

<?php include '../dashboard/footer.php'; ?>