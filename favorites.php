<?php
// favorites.php

require_once 'config/database.php';
require_once 'includes/header.php';

// Pastikan user sudah memiliki ID session
if (!isset($_SESSION['user_id'])) {
    // Redirect ke halaman utama jika tidak ada session
    header('Location: index.php');
    exit();
}

// Ambil foto-foto yang difavoritkan user ini dengan JOIN
 $stmt = $pdo->prepare("
    SELECT p.* 
    FROM photos p
    JOIN favorites f ON p.id = f.photo_id
    WHERE f.session_id = ?
    ORDER BY f.created_at DESC
");
 $stmt->execute([$_SESSION['user_id']]);
 $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil ID foto yang sudah difavoritkan (sama seperti di index.php)
 $stmt_fav = $pdo->prepare("SELECT photo_id FROM favorites WHERE session_id = ?");
 $stmt_fav->execute([$_SESSION['user_id']]);
 $favorited_photos = $stmt_fav->fetchAll(PDO::FETCH_COLUMN, 0);

?>

<div class="container">
    <h1>Foto Favorit Saya</h1>
    <?php if (empty($favorites)): ?>
        <p>Anda belum memiliki foto favorit.</p>
    <?php else: ?>
        <div class="gallery-grid">
            <?php foreach ($favorites as $photo): ?>
                <div class="photo-card">
                    <div class="photo-wrapper" data-src="assets/uploads/<?php echo htmlspecialchars($photo['filename']); ?>">
                    <img src="assets/uploads/<?php echo htmlspecialchars($photo['filename']); ?>" alt="<?php echo htmlspecialchars($photo['caption']); ?>">
                 </div>
                    <div class="photo-info">
                        <p class="photo-caption"><?php echo htmlspecialchars($photo['caption']); ?></p>
                        <div class="photo-actions">
                            <!-- Tombol like dinonaktifkan di halaman favorit -->
                            <button class="like-btn" disabled>
                                <i class="fas fa-thumbs-up"></i>
                                <span class="like-count"><?php echo $photo['likes_count']; ?></span>
                            </button>
                            <button class="favorite-btn favorited" data-id="<?php echo $photo['id']; ?>">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <br>
    <a href="index.php">&larr; Kembali ke Galeri</a>
</div>

<script src="assets/js/main.js"></script>
</body>
</html>