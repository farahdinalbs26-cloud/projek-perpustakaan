<?php
require_once '../dashboard/fungsi.php';
$id = $_GET['id'] ?? '';
$buku = one("SELECT * FROM buku WHERE no_buku = ?", 's', $id);

if (!$buku) {
  redirect('buku.php', 'Buku tidak ditemukan.');
}

$judul = 'Edit Buku';
$aktif = 'buku';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $judulBuku = trim($_POST['judul_buku'] ?? '');
  $penulis   = trim($_POST['penulis'] ?? '');
  $penerbit  = trim($_POST['penerbit'] ?? '');
  $th        = (int)($_POST['th_terbit'] ?? 0);
  $isbn      = trim($_POST['ISBN'] ?? '');
  $stok      = (int)($_POST['stok_buku'] ?? 0);
  $desk      = trim($_POST['deskripsi_buku'] ?? '');
  $noKat     = trim($_POST['no_kategori'] ?? '');

  q("UPDATE buku SET 
        judul_buku = ?, penulis = ?, penerbit = ?, th_terbit = ?, 
        ISBN = ?, stok_buku = ?, deskripsi_buku = ?, no_kategori = ? 
     WHERE no_buku = ?", 
     'sssisisss', $judulBuku, $penulis, $penerbit, $th, $isbn, $stok, $desk, $noKat, $id);
  
  redirect('buku.php', 'Buku berhasil diperbarui!');
}

$kategori = all("SELECT * FROM kategori ORDER BY nama_kategori_buku ASC");
include '../dashboard/header.php';
?>

<div class="head"><h1>Edit Buku</h1></div>

<?php if ($err): ?>
  <div class="alert err"><?= e($err) ?></div>
<?php endif; ?>

<form method="post" class="box">
  <label>No Buku</label>
  <input type="text" value="<?= e($buku['no_buku']) ?>" readonly style="background:#eee;">

  <label>Judul Buku</label>
  <input type="text" name="judul_buku" value="<?= e($buku['judul_buku']) ?>" maxlength="150" required>

  <label>Penulis</label>
  <input type="text" name="penulis" value="<?= e($buku['penulis']) ?>" maxlength="100">

  <label>Penerbit</label>
  <input type="text" name="penerbit" value="<?= e($buku['penerbit']) ?>" maxlength="100">

  <label>Tahun Terbit</label>
  <input type="number" name="th_terbit" value="<?= e($buku['th_terbit']) ?>" min="1900" max="2100">

  <label>ISBN</label>
  <input type="text" name="ISBN" value="<?= e($buku['ISBN']) ?>" maxlength="20">

  <label>Stok Buku</label>
  <input type="number" name="stok_buku" value="<?= e($buku['stok_buku']) ?>" min="0" required>

  <label>Kategori Buku</label>
  <select name="no_kategori" required>
    <option value="">-- Pilih Kategori --</option>
    <?php foreach ($kategori as $k): ?>
      <option value="<?= e($k['no_kategori']) ?>" <?= $buku['no_kategori'] == $k['no_kategori'] ? 'selected' : '' ?>>
        <?= e($k['nama_kategori_buku']) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <label>Deskripsi Buku</label>
  <textarea name="deskripsi_buku" rows="4"><?= e($buku['deskripsi_buku']) ?></textarea>

  <div class="actions">
    <button type="submit" class="btn ok">Simpan Perubahan</button>
    <a href="buku.php" class="btn alt">Batal</a>
  </div>
</form>

<?php include '../dashboard/footer.php'; ?>