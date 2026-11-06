<?php
require_once '../dashboard/fungsi.php';
$judul = 'Tambah Anggota';
$aktif = 'anggota';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nim    = trim($_POST['NIM'] ?? '');
  $nama   = trim($_POST['nama_anggota'] ?? '');
  $jk     = $_POST['jenis_kelamin'] ?? 'Laki-laki';
  $alamat = trim($_POST['alamat'] ?? '');
  $status = $_POST['status_anggota'] ?? 'Aktif';
  $email  = trim($_POST['email'] ?? '');
  $hp     = trim($_POST['no_hp'] ?? '');

  if (one("SELECT 1 FROM anggota WHERE NIM = ?", 's', $nim)) {
    $err = "NIM '$nim' sudah terdaftar. Gunakan NIM lain.";
  } else {
    q("INSERT INTO anggota (NIM, nama_anggota, jenis_kelamin, alamat, status_anggota, email, no_hp)
       VALUES (?, ?, ?, ?, ?, ?, ?)",
      'sssssss', $nim, $nama, $jk, $alamat, $status, $email, $hp);
    redirect('anggota.php', 'Anggota berhasil ditambahkan!');
  }
}

include '../dashboard/header.php';
?>

<div class="head"><h1>Tambah Anggota</h1></div>

<?php if ($err): ?>
  <div class="alert err"><?= e($err) ?></div>
<?php endif; ?>

<form method="post" class="box">
  <label>NIM</label>
  <input type="text" name="NIM" value="<?= v('NIM') ?>" maxlength="20" required>

  <label>Nama Anggota</label>
  <input type="text" name="nama_anggota" value="<?= v('nama_anggota') ?>" maxlength="100" required>

  <label>Jenis Kelamin</label>
  <select name="jenis_kelamin" required>
    <option value="Laki-laki" <?= v('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
    <option value="Perempuan" <?= v('jenis_kelamin') == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
  </select>

  <label>Alamat</label>
  <textarea name="alamat" rows="3"><?= v('alamat') ?></textarea>

  <label>Email</label>
  <input type="email" name="email" value="<?= v('email') ?>" maxlength="100">

  <label>No HP</label>
  <input type="text" name="no_hp" value="<?= v('no_hp') ?>" maxlength="20">

  <label>Status</label>
  <select name="status_anggota">
    <option value="Aktif" <?= v('status_anggota', 'Aktif') == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
    <option value="Non-Aktif" <?= v('status_anggota') == 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
  </select>

  <div class="actions">
    <button type="submit" class="btn ok">Simpan</button>
    <a href="anggota.php" class="btn alt">Batal</a>
  </div>
</form>

<?php include '../dashboard/footer.php'; ?>