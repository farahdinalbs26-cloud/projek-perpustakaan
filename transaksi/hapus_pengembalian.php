<?php

include "../connect.php";

if (isset($_GET['no_pengembalian'])) {

    $no_pengembalian = $_GET['no_pengembalian'];

    $sql = "DELETE FROM pengembalian
            WHERE no_pengembalian = '$no_pengembalian'";

    if (mysqli_query($conn, $sql)) {

        echo "<script>
                alert('Data pengembalian berhasil dihapus!');
                window.location='pengembalian.php';
              </script>";

    } else {

        echo "Data gagal dihapus: " . mysqli_error($conn);

    }

} else {

    header("Location: pengembalian.php");
    exit();

}
?>