<?php
// includes/header.php
session_start(); // Memulai session untuk fitur favorit
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Ikon dari Font Awesome untuk tombol like dan favorit -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php" class="logo">GaleriKu</a>
            <div class="nav-links">
                <a href="index.php">Galeri</a>
                <a href="favorites.php">Favorit Saya</a>
                <a href="upload.php">Unggah Foto</a> 
            </div>
        </nav>
    </header>
    <main>

    <div id="photo-lightbox" class="lightbox">
    <span class="lightbox-close">&times;</span>
    <div class="lightbox-content">
        <img class="lightbox-image" src="" alt="">
    </div>
</div>

</body>
</html>