<?php
include "../connect.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Peminjaman</title>
</head>

<body>

<h2>Data Peminjaman</h2>

<a href="tambah_peminjaman.php">Tambah Peminjaman</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">

<tr>
    <th>No Peminjaman</th>
    <th>NIM</th>
    <th>Tanggal Peminjaman</th>
    <th>Batas Pengembalian</th>
    <th>Status Peminjaman</th>
    <th>Aksi</th>
</tr>

<?php

$sql = "SELECT * FROM peminjaman ORDER BY no_peminjaman DESC";
$result = mysqli_query($conn, $sql);

while ($data = mysqli_fetch_assoc($result)) {
?>

<tr>
    <td><?= $data['no_peminjaman']; ?></td>
    <td><?= $data['NIM']; ?></td>
    <td><?= $data['tgl_peminjaman']; ?></td>
    <td><?= $data['batas_pengembalian']; ?></td>
    <td><?= $data['status_peminjaman']; ?></td>

    <td>
        <a href="hapus_peminjaman.php?no_peminjaman=<?= $data['no_peminjaman']; ?>"
           onclick="return confirm('Yakin ingin menghapus data ini?')">
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