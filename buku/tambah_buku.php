<?php
require_once '../dashboard/fungsi.php';
$judul = 'Tambah Buku';
$aktif = 'buku';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $no        = trim($_POST['no_buku'] ?? '');
  $judulBuku = trim($_POST['judul_buku'] ?? '');
  $penulis   = trim($_POST['penulis'] ?? '');
  $penerbit  = trim($_POST['penerbit'] ?? '');
  $th        = (int)($_POST['th_terbit'] ?? 0);
  $isbn      = trim($_POST['ISBN'] ?? '');
  $stok      = (int)($_POST['stok_buku'] ?? 0);
  $desk      = trim($_POST['deskripsi_buku'] ?? '');
  $noKat     = trim($_POST['no_kategori'] ?? '');

  if (one("SELECT 1 FROM buku WHERE no_buku = ?", 's', $no)) {
    $err = "No Buku '$no' sudah digunakan. Gunakan nomor lain.";
  } else {
    q("INSERT INTO buku (no_buku, judul_buku, penulis, penerbit, th_terbit, ISBN, stok_buku, deskripsi_buku, no_kategori) 
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", 
       'ssssisiss', $no, $judulBuku, $penulis, $penerbit, $th, $isbn, $stok, $desk, $noKat);
    redirect('buku.php', 'Buku berhasil ditambahkan!');
  }
}

$kategori = all("SELECT * FROM kategori ORDER BY nama_kategori_buku ASC");
include '../dashboard/header.php';
?>

<div class="head"><h1>Tambah Buku</h1></div>

<?php if ($err): ?>
  <div class="alert err"><?= e($err) ?></div>
<?php endif; ?>

<form method="post" class="box">
  <label>No Buku</label>
  <input type="text" name="no_buku" value="<?= v('no_buku') ?>" maxlength="10" required>

  <label>Judul Buku</label>
  <input type="text" name="judul_buku" value="<?= v('judul_buku') ?>" maxlength="150" required>

  <label>Penulis</label>
  <input type="text" name="penulis" value="<?= v('penulis') ?>" maxlength="100">

  <label>Penerbit</label>
  <input type="text" name="penerbit" value="<?= v('penerbit') ?>" maxlength="100">

  <label>Tahun Terbit</label>
  <input type="number" name="th_terbit" value="<?= v('th_terbit', date('Y')) ?>" min="1900" max="2100">

  <label>ISBN</label>
  <input type="text" name="ISBN" value="<?= v('ISBN') ?>" maxlength="20">

  <label>Stok Buku</label>
  <input type="number" name="stok_buku" value="<?= v('stok_buku', '0') ?>" min="0" required>

  <label>Kategori Buku</label>
  <select name="no_kategori" required>
    <option value="">-- Pilih Kategori --</option>
    <?php foreach ($kategori as $k): ?>
      <option value="<?= e($k['no_kategori']) ?>" <?= ($_POST['no_kategori'] ?? '') == $k['no_kategori'] ? 'selected' : '' ?>>
        <?= e($k['nama_kategori_buku']) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <label>Deskripsi Buku</label>
  <textarea name="deskripsi_buku" rows="4"><?= v('deskripsi_buku') ?></textarea>

  <div class="actions">
    <button type="submit" class="btn ok">Simpan</button>
    <a href="buku.php" class="btn alt">Batal</a>
  </div>
</form>

<?php include '../dashboard/footer.php'; ?>