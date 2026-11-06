<?php
require_once '../dashboard/fungsi.php';
$judul = 'Data Kategori';
$aktif = 'kategori';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $noKat   = trim($_POST['no_kategori'] ?? '');
  $namaKat = trim($_POST['nama_kategori_buku'] ?? '');

  if (one("SELECT 1 FROM kategori WHERE no_kategori = ?", 's', $noKat)) {
    $err = "Kode kategori '$noKat' sudah ada!";
  } else {
    q("INSERT INTO kategori (no_kategori, nama_kategori_buku) VALUES (?, ?)", 'ss', $noKat, $namaKat);
    redirect('kategori.php', 'Kategori berhasil ditambahkan!');
  }
}

$kategori = all("SELECT * FROM kategori ORDER BY no_kategori ASC");
include '../dashboard/header.php';
?>

<div class="head"><h1>Kelola Kategori Buku</h1></div>

<?php if ($err): ?>
  <div class="alert err"><?= e($err) ?></div>
<?php endif; ?>

<div class="grid">
  <!-- Form Tambah Kategori (Kiri) -->
  <form method="post" class="box">
    <h3>Tambah Kategori</h3>
    <label>No Kategori</label>
    <input type="text" name="no_kategori" value="<?= v('no_kategori') ?>" placeholder="Misal: K05" maxlength="10" required>

    <label>Nama Kategori</label>
    <input type="text" name="nama_kategori_buku" value="<?= v('nama_kategori_buku') ?>" placeholder="Nama Kategori" maxlength="50" required>

    <div class="actions">
      <button type="submit" class="btn ok">Simpan</button>
    </div>
  </form>

  <!-- Tabel Kategori (Kanan) -->
  <div>
    <input type="text" id="cari" class="cari" placeholder="Cari kategori...">
    <table class="data">
      <thead>
        <tr>
          <th>No</th>
          <th>No Kategori</th>
          <th>Nama Kategori Buku</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($kategori as $i => $r): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= e($r['no_kategori']) ?></td>
          <td><?= e($r['nama_kategori_buku']) ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$kategori): ?>
        <tr><td colspan="3">Belum ada data kategori.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include '../dashboard/footer.php'; ?>