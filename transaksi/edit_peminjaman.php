<?php
require_once '../dashboard/fungsi.php';

$judul = 'Edit Peminjaman';
$aktif = 'peminjaman';

include '../dashboard/header.php';

$id = $_GET['id'] ?? '';

if ($id == '') {
    die('No peminjaman tidak ditemukan.');
}

/* =========================
   AMBIL DATA PEMINJAMAN
   ========================= */
$sql = "SELECT p.*, a.nama_anggota
        FROM peminjaman p
        JOIN anggota a ON a.NIM = p.NIM
        WHERE p.no_peminjaman = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die('Data peminjaman tidak ditemukan.');
}


/* =========================
   AMBIL DATA BUKU
   ========================= */
$sqlBuku = "SELECT dp.no_buku
            FROM detail_peminjaman dp
            WHERE dp.no_peminjaman = ?";

$stmtBuku = $pdo->prepare($sqlBuku);
$stmtBuku->execute([$id]);
$bukuDipinjam = $stmtBuku->fetchAll(PDO::FETCH_COLUMN);


/* =========================
   PROSES UPDATE
   ========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $NIM = $_POST['NIM'];
    $tgl_peminjaman = $_POST['tgl_peminjaman'];
    $batas_pengembalian = $_POST['batas_pengembalian'];
    $status_peminjaman = $_POST['status_peminjaman'];

    $buku = $_POST['buku'] ?? [];

    try {

        $pdo->beginTransaction();

        /* UPDATE PEMINJAMAN */
        $sqlUpdate = "UPDATE peminjaman
                      SET NIM = ?,
                          tgl_peminjaman = ?,
                          batas_pengembalian = ?,
                          status_peminjaman = ?
                      WHERE no_peminjaman = ?";

        $stmt = $pdo->prepare($sqlUpdate);

        $stmt->execute([
            $NIM,
            $tgl_peminjaman,
            $batas_pengembalian,
            $status_peminjaman,
            $id
        ]);


        /* HAPUS DETAIL LAMA */
        $sqlDelete = "DELETE FROM detail_peminjaman
                      WHERE no_peminjaman = ?";

        $stmt = $pdo->prepare($sqlDelete);
        $stmt->execute([$id]);


        /* MASUKKAN DETAIL BUKU BARU */
        if (!empty($buku)) {

            $sqlInsert = "INSERT INTO detail_peminjaman
                          (no_peminjaman, no_buku)
                          VALUES (?, ?)";

            $stmt = $pdo->prepare($sqlInsert);

            foreach ($buku as $no_buku) {
                $stmt->execute([
                    $id,
                    $no_buku
                ]);
            }
        }

        $pdo->commit();

        echo "<script>
                alert('Data peminjaman berhasil diubah.');
                window.location='peminjaman.php';
              </script>";
        exit;

    } catch (Exception $e) {

        $pdo->rollBack();

        echo "<script>
                alert('Gagal mengubah data: " . addslashes($e->getMessage()) . "');
              </script>";
    }
}


/* =========================
   AMBIL SEMUA ANGGOTA
   ========================= */
$anggota = all("
    SELECT NIM, nama_anggota
    FROM anggota
    ORDER BY nama_anggota
");


/* =========================
   AMBIL SEMUA BUKU
   ========================= */
$buku = all("
    SELECT no_buku, judul_buku
    FROM buku
    ORDER BY judul_buku
");
?>

<div class="head">
    <h1>Edit Peminjaman</h1>

    <a href="peminjaman.php" class="btn">
        Kembali
    </a>
</div>

<form method="post">

    <label>Anggota</label>

    <select name="NIM" required>

        <option value="">-- Pilih Anggota --</option>

        <?php foreach ($anggota as $a): ?>

            <option value="<?= e($a['NIM']) ?>"
                <?= $a['NIM'] == $data['NIM'] ? 'selected' : '' ?>>

                <?= e($a['nama_anggota']) ?>
                (<?= e($a['NIM']) ?>)

            </option>

        <?php endforeach; ?>

    </select>


    <br><br>


    <label>Tanggal Peminjaman</label>

    <input
        type="date"
        name="tgl_peminjaman"
        value="<?= e($data['tgl_peminjaman']) ?>"
        required
    >


    <br><br>


    <label>Batas Pengembalian</label>

    <input
        type="date"
        name="batas_pengembalian"
        value="<?= e($data['batas_pengembalian']) ?>"
        required
    >


    <br><br>


    <label>Status Peminjaman</label>

    <select name="status_peminjaman" required>

        <option value="Dipinjam"
            <?= $data['status_peminjaman'] == 'Dipinjam' ? 'selected' : '' ?>>
            Dipinjam
        </option>

        <option value="Selesai"
            <?= $data['status_peminjaman'] == 'Selesai' ? 'selected' : '' ?>>
            Selesai
        </option>

    </select>


    <br><br>


    <label>Buku yang Dipinjam</label>

    <div>

        <?php foreach ($buku as $b): ?>

            <label style="display:block; margin:8px 0;">

                <input
                    type="checkbox"
                    name="buku[]"
                    value="<?= e($b['no_buku']) ?>"
                    <?= in_array($b['no_buku'], $bukuDipinjam) ? 'checked' : '' ?>
                >

                <?= e($b['judul_buku']) ?>

            </label>

        <?php endforeach; ?>

    </div>


    <br>

    <button type="submit" class="btn ok">
        Simpan Perubahan
    </button>

    <a href="peminjaman.php" class="btn">
        Batal
    </a>

</form>

<?php include '../dashboard/footer.php'; ?>