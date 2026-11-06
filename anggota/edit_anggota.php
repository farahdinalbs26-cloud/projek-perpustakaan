<?php
require_once '../dashboard/fungsi.php';
$nim = $_GET['nim'] ?? '';
$anggota = one("SELECT * FROM anggota WHERE NIM = ?", 's', $nim);

if (!$anggota) {
  redirect('anggota.php', 'Anggota tidak ditemukan.');
}

$judul = 'Edit Anggota';
$aktif = 'anggota';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama   = trim($_POST['nama_anggota'] ?? '');
  $jk     = $_POST['jenis_kelamin'] ?? 'Laki-laki';
  $alamat = trim($_POST['alamat'] ?? '');
  $status = $_POST['status_anggota'] ?? 'Aktif';
  $email  = trim($_POST['email'] ?? '');
  $hp     = trim($_POST['no_hp'] ?? '');

  q("UPDATE anggota SET nama_anggota = ?, jenis_kelamin = ?, alamat = ?,
                        status_anggota = ?, email = ?, no_hp = ?
     WHERE NIM = ?",
    'sssssss', $nama, $jk, $alamat, $status, $email, $hp, $nim);

  redirect('anggota.php', 'Data anggota berhasil diperbarui!');
}

include '../dashboard/header.php';
?>

<div class="head"><h1>Edit Anggota</h1></div>

<form method="post" class="box">
  <label>NIM</label>
  <input type="text" value="<?= e($anggota['NIM']) ?>" readonly style="background:#eee;">

  <label>Nama Anggota</label>
  <input type="text" name="nama_anggota" value="<?= e($anggota['nama_anggota']) ?>" maxlength="100" required>

  <label>Jenis Kelamin</label>
  <select name="jenis_kelamin" required>
    <option value="Laki-laki" <?= $anggota['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
    <option value="Perempuan" <?= $anggota['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
  </select>

  <label>Alamat</label>
  <textarea name="alamat" rows="3"><?= e($anggota['alamat']) ?></textarea>

  <label>Email</label>
  <input type="email" name="email" value="<?= e($anggota['email']) ?>" maxlength="100">

  <label>No HP</label>
  <input type="text" name="no_hp" value="<?= e($anggota['no_hp']) ?>" maxlength="20">

  <label>Status</label>
  <select name="status_anggota">
    <option value="Aktif" <?= $anggota['status_anggota'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
    <option value="Non-Aktif" <?= $anggota['status_anggota'] == 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
  </select>

  <div class="actions">
    <button type="submit" class="btn ok">Simpan Perubahan</button>
    <a href="anggota.php" class="btn alt">Batal</a>
  </div>
</form>

<?php include '../dashboard/footer.php'; ?>