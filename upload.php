<?php
require_once 'includes/header.php';

// Proses upload di sini
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $upload_dir = 'assets/uploads/';
    $file_name = basename($_FILES['photo']['name']);
    $target_file = $upload_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $caption = $_POST['caption'];

    // Validasi sederhana
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if($check !== false) {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Simpan info foto ke database
            require_once 'config/database.php';
            $stmt = $pdo->prepare("INSERT INTO photos (filename, caption) VALUES (?, ?)");
            $stmt->execute([$file_name, $caption]);
            $upload_success = "Foto berhasil diunggah!";
        } else {
            $upload_error = "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    } else {
        $upload_error = "File yang diunggah bukan gambar.";
    }
}
?>

<div class="container">
    <h1>Unggah Foto Baru</h1>
    
    <?php if (isset($upload_success)): ?>
        <p class="success-message"><?php echo $upload_success; ?></p>
    <?php endif; ?>
    <?php if (isset($upload_error)): ?>
        <p class="error-message"><?php echo $upload_error; ?></p>
    <?php endif; ?>

    <form action="upload.php" method="post" enctype="multipart/form-data" class="upload-form">
        <div class="form-group">
            <label for="photo">Pilih Foto:</label>
            <input type="file" name="photo" id="photo" required>
        </div>
        <div class="form-group">
            <label for="caption">Keterangan Foto:</label>
            <input type="text" name="caption" id="caption" placeholder="Masukkan keterangan foto">
        </div>
        <button type="submit" class="submit-btn">Unggah</button>
    </form>
    <br>
    <a href="index.php">&larr; Kembali ke Galeri</a>
</div>

<!-- Tambahkan sedikit CSS untuk form -->
<style>
    .upload-form { max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; }
    .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
    .submit-btn { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
    .success-message { color: green; text-align: center; }
    .error-message { color: red; text-align: center; }
</style>
</body>
</html>