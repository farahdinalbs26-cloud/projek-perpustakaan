<?php
require_once '../dashboard/fungsi.php';

$judul = 'Edit Pengembalian';
$aktif = 'pengembalian';

include '../dashboard/header.php';

$id = $_GET['id'] ?? '';

if ($id == '') {
    die('No pengembalian tidak ditemukan.');
}


/* =========================
   AMBIL DATA PENGEMBALIAN
   ========================= */

$sql = "SELECT k.*, p.NIM, p.tgl_peminjaman,
               p.batas_pengembalian, a.nama_anggota
        FROM pengembalian k
        JOIN peminjaman p ON p.no_peminjaman = k.no_peminjaman
        JOIN anggota a ON a.NIM = p.NIM
        WHERE k.no_pengembalian = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die('Data pengembalian tidak ditemukan.');
}


/* =========================
   PROSES UPDATE
   ========================= */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tgl_pengembalian = $_POST['tgl_pengembalian'];
    $kondisi_buku = $_POST['kondisi_buku'];
    $jumlah_denda = $_POST['jumlah_denda'];

    $sqlUpdate = "UPDATE pengembalian
                  SET tgl_pengembalian = ?,
                      kondisi_buku = ?,
                      jumlah_denda = ?
                  WHERE no_pengembalian = ?";

    $stmt = $pdo->prepare($sqlUpdate);

    $stmt->execute([
        $tgl_pengembalian,
        $kondisi_buku,
        $jumlah_denda,
        $id
    ]);

    echo "<script>
            alert('Data pengembalian berhasil diubah.');
            window.location='pengembalian.php';
          </script>";

    exit;
}
?>

<div class="head">
    <h1>Edit Pengembalian</h1>

    <a href="pengembalian.php" class="btn">
        Kembali
    </a>
</div>


<form method="post">

    <!-- NO PENGEMBALIAN -->

    <label>No Pengembalian</label>

    <input
        type="text"
        value="<?= e($data['no_pengembalian']) ?>"
        readonly
    >


    <br><br>


    <!-- NO PEMINJAMAN -->

    <label>No Peminjaman</label>

    <input
        type="text"
        value="<?= e($data['no_peminjaman']) ?>"
        readonly
    >


    <br><br>


    <!-- ANGGOTA -->

    <label>Anggota</label>

    <input
        type="text"
        value="<?= e($data['nama_anggota']) ?> (<?= e($data['NIM']) ?>)"
        readonly
    >


    <br><br>


    <!-- TANGGAL PENGEMBALIAN -->

    <label>Tanggal Pengembalian</label>

    <input
        type="date"
        name="tgl_pengembalian"
        value="<?= e($data['tgl_pengembalian']) ?>"
        required
    >


    <br><br>


    <!-- KONDISI BUKU -->

    <label>Kondisi Buku</label>

    <select name="kondisi_buku" required>

        <option value="Baik"
            <?= $data['kondisi_buku'] == 'Baik' ? 'selected' : '' ?>>
            Baik
        </option>

        <option value="Rusak"
            <?= $data['kondisi_buku'] == 'Rusak' ? 'selected' : '' ?>>
            Rusak
        </option>

        <option value="Hilang"
            <?= $data['kondisi_buku'] == 'Hilang' ? 'selected' : '' ?>>
            Hilang
        </option>

    </select>


    <br><br>


    <!-- DENDA -->

    <label>Jumlah Denda</label>

    <input
        type="number"
        name="jumlah_denda"
        min="0"
        value="<?= e($data['jumlah_denda']) ?>"
        required
    >


    <br><br>


    <button type="submit" class="btn ok">
        Simpan Perubahan
    </button>

    <a href="pengembalian.php" class="btn">
        Batal
    </a>

</form>


<?php include '../dashboard/footer.php'; ?>