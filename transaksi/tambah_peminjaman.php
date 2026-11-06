<?php
include "../connect.php";

if (isset($_POST['simpan'])) {

    $no_peminjaman = $_POST['no_peminjaman'];
    $NIM = $_POST['NIM'];
    $tgl_peminjaman = $_POST['tgl_peminjaman'];
    $batas_pengembalian = $_POST['batas_pengembalian'];

    $sql = "INSERT INTO peminjaman
            (no_peminjaman, NIM, tgl_peminjaman, batas_pengembalian, status_peminjaman)
            VALUES (?, ?, ?, ?, 'Dipinjam')";

    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        $no_peminjaman,
        $NIM,
        $tgl_peminjaman,
        $batas_pengembalian
    ]);

    echo "<script>
            alert('Data peminjaman berhasil ditambahkan!');
            window.location='peminjaman.php';
          </script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Peminjaman</title>

    <style>
        body {
            font-family: Arial;
            margin: 30px;
        }

        form {
            width: 400px;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input {
            width: 100%;
            padding: 9px;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background: #198754;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

<h2>Tambah Peminjaman</h2>

<form method="POST">

    <label>No Peminjaman</label>

    <input
        type="text"
        name="no_peminjaman"
        placeholder="Contoh: PJ05"
        required
    >

    <label>NIM</label>

    <input
        type="text"
        name="NIM"
        placeholder="Masukkan NIM"
        required
    >

    <label>Tanggal Peminjaman</label>

    <input
        type="date"
        name="tgl_peminjaman"
        required
    >

    <label>Batas Pengembalian</label>

    <input
        type="date"
        name="batas_pengembalian"
        required
    >

    <button type="submit" name="simpan">
        Simpan Peminjaman
    </button>

</form>

<br>

<a href="peminjaman.php">← Kembali</a>

</body>

</html>