<?php
include "../connect.php";

if (isset($_POST['simpan'])) {

    $no_pengembalian = $_POST['no_pengembalian'];
    $no_peminjaman = $_POST['no_peminjaman'];
    $tgl_pengembalian = $_POST['tgl_pengembalian'];
    $kondisi_buku = $_POST['kondisi_buku'];

    // Ambil batas pengembalian
    $sql = "SELECT batas_pengembalian
            FROM peminjaman
            WHERE no_peminjaman = '$no_peminjaman'";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }

    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        die("Data peminjaman tidak ditemukan.");
    }

    // Hitung denda
    $batas = new DateTime($data['batas_pengembalian']);
    $tanggal_kembali = new DateTime($tgl_pengembalian);

    $denda = 0;

    if ($tanggal_kembali > $batas) {

        $selisih = $batas->diff($tanggal_kembali);

        $jumlah_hari = $selisih->days;

        // Denda Rp10.000 per hari
        $denda = $jumlah_hari * 10000;
    }

    // Simpan ke tabel pengembalian
    $sql = "INSERT INTO pengembalian
            (
                no_pengembalian,
                no_peminjaman,
                tgl_pengembalian,
                jumlah_denda,
                kondisi_buku
            )
            VALUES
            (
                '$no_pengembalian',
                '$no_peminjaman',
                '$tgl_pengembalian',
                '$denda',
                '$kondisi_buku'
            )";

    if (!mysqli_query($conn, $sql)) {
        die("Gagal menyimpan pengembalian: " . mysqli_error($conn));
    }

    // Ubah status peminjaman
    if ($denda > 0) {
        $status = "Terlambat";
    } else {
        $status = "Selesai";
    }

    $sql = "UPDATE peminjaman
            SET status_peminjaman = '$status'
            WHERE no_peminjaman = '$no_peminjaman'";

    if (!mysqli_query($conn, $sql)) {
        die("Gagal mengubah status: " . mysqli_error($conn));
    }

    // Kembali ke halaman pengembalian
    echo "<script>
            alert('Pengembalian berhasil disimpan! Denda: Rp " . 
            number_format($denda, 0, ',', '.') . "');
            window.location='pengembalian.php';
          </script>";

} else {

    header("Location: tambah_pengembalian.php");
    exit();

}
?>