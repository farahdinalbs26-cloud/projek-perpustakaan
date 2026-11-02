<?php
include '../connect.php';   // Keluar dari folder dashboard untuk mengambil connect.php
include 'template.php';     // Mengambil template.php di folder yang sama

ob_start();
?>

<h2>Selamat Datang di Sistem Informasi Perpustakaan</h2>
<p>Silakan pilih menu di atas untuk mengelola data perpustakaan.</p>

<?php
$konten = ob_get_clean();
tampilkan_halaman("Dashboard", $konten);
?>