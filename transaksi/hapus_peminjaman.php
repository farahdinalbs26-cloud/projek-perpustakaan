<?php

include "../connect.php";

if (isset($_GET['no_peminjaman'])) {

    $no_peminjaman = $_GET['no_peminjaman'];

    $sql = "DELETE FROM peminjaman
            WHERE no_peminjaman = '$no_peminjaman'";

    if (mysqli_query($conn, $sql)) {

        echo "<script>
                alert('Data peminjaman berhasil dihapus!');
                window.location='peminjaman.php';
              </script>";

    } else {

        echo "Data gagal dihapus: " . mysqli_error($conn);

    }

} else {

    header("Location: peminjaman.php");
    exit();

}
?>