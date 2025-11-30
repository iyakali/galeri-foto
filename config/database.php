<?php
// config/database.php

// Konfigurasi database
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // User default XAMPP
define('DB_PASS', ''); // Password default XAMPP kosong
define('DB_NAME', 'db_galeri');

// Membuat koneksi dengan PDO
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    // Set mode error PDO ke Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Tidak bisa terkoneksi. " . $e->getMessage());
}
?>