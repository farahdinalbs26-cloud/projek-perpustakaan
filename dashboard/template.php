<?php
// dashboard/template.php
function tampilkan_halaman($judul_halaman, $konten_halaman) {
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul_halaman; ?> - Sistem Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- NAVBAR / HEADER -->
    <header>
        <div class="logo">
            <h2>Perpustakaan Digital</h2>
        </div>
        <nav>
            <ul>
                <li><a href="../dashboard/index.php">Dashboard</a></li>
                <li><a href="../modul_buku/buku.php">Data Buku</a></li>
                <li><a href="../modul_anggota/anggota.php">Data Anggota</a></li>
                <li><a href="../modul_transaksi/peminjaman.php">Peminjaman</a></li>
            </ul>
        </nav>
    </header>

    <!-- KONTEN UTAMA -->
    <main class="container">
        <?php echo $konten_halaman; ?>
    </main>

    <!-- FOOTER -->
    <footer>
        <p>&copy; <?= date('Y'); ?> Tim Proyek Perpustakaan. All Rights Reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
<?php
}
?>