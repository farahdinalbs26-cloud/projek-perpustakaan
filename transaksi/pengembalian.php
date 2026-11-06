<?php
include "../connect.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pengembalian</title>
</head>

<body>

<h2>Data Pengembalian</h2>

<a href="tambah_pengembalian.php">Tambah Pengembalian</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">

<tr>
    <th>No Pengembalian</th>
    <th>No Peminjaman</th>
    <th>Tanggal Pengembalian</th>
    <th>Jumlah Denda</th>
    <th>Kondisi Buku</th>
    <th>Aksi</th>
</tr>

<?php

$sql = "SELECT * FROM pengembalian ORDER BY no_pengembalian DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

while ($data = mysqli_fetch_assoc($result)) {
?>

<tr>
    <td><?= $data['no_pengembalian']; ?></td>
    <td><?= $data['no_peminjaman']; ?></td>
    <td><?= $data['tgl_pengembalian']; ?></td>
    <td>Rp <?= number_format($data['jumlah_denda'], 0, ',', '.'); ?></td>
    <td><?= $data['kondisi_buku']; ?></td>

    <td>
        <a href="hapus_pengembalian.php?no_pengembalian=<?= $data['no_pengembalian']; ?>"
           onclick="return confirm('Yakin ingin menghapus data pengembalian ini?')">
            Hapus
        </a>
    </td>
</tr>

<?php
}
?>

</table>

<br>

<a href="../index.php">Kembali ke Dashboard</a>

</body>
</html>