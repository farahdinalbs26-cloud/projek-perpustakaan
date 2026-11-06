<?php
include "../connect.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pengembalian</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            font-size: 25px;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 16px;
        }

        input,
        select {
            width: 400px;
            padding: 10px;
            border: 1px solid #aaa;
            font-size: 14px;
            box-sizing: border-box;
        }

        select {
            background-color: white;
        }

        .form-group {
            margin-bottom: 15px;
        }

        button {
            background-color: #198754;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            margin-top: 5px;
        }

        button:hover {
            background-color: #157347;
        }

        .kembali {
            display: inline-block;
            margin-top: 20px;
            color: #6f42c1;
            text-decoration: underline;
        }
    </style>
</head>

<body>

<h2>Tambah Pengembalian</h2>

<form action="proses_pengembalian.php" method="POST">

    <div class="form-group">
        <label>No Pengembalian</label>

        <input type="text"
               name="no_pengembalian"
               placeholder="Contoh: PB01"
               required>
    </div>

    <div class="form-group">
        <label>No Peminjaman</label>

        <select name="no_peminjaman" required>

            <option value="">-- Pilih No Peminjaman --</option>

            <?php

            $sql = "SELECT no_peminjaman, NIM
                    FROM peminjaman
                    WHERE status_peminjaman = 'Dipinjam'
                    ORDER BY no_peminjaman ASC";

            $result = mysqli_query($conn, $sql);

            while ($data = mysqli_fetch_assoc($result)) {
            ?>

                <option value="<?= $data['no_peminjaman']; ?>">
                    <?= $data['no_peminjaman']; ?> - <?= $data['NIM']; ?>
                </option>

            <?php
            }
            ?>

        </select>
    </div>

    <div class="form-group">
        <label>Tanggal Pengembalian</label>

        <input type="date"
               name="tgl_pengembalian"
               value="<?= date('Y-m-d'); ?>"
               required>
    </div>

    <div class="form-group">
        <label>Kondisi Buku</label>

        <select name="kondisi_buku" required>

            <option value="">-- Pilih Kondisi Buku --</option>
            <option value="Baik">Baik</option>
            <option value="Rusak">Rusak</option>
            <option value="Hilang">Hilang</option>

        </select>
    </div>

    <button type="submit" name="simpan">
        Simpan Pengembalian
    </button>

</form>

<a href="pengembalian.php" class="kembali">
    ← Kembali
</a>

</body>
</html>