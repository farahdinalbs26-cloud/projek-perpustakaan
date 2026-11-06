<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "perpustakaan";

$conn = mysqli_connect($host, $user, $pass, $db, 8111);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>