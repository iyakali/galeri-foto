<?php
// index.php

require_once 'config/database.php';
require_once 'includes/header.php';

// Buat ID unik untuk user jika belum ada (untuk fitur favorit)
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = uniqid('user_');
}

// Ambil semua foto dari database
 $stmt = $pdo->query("SELECT * FROM photos ORDER BY created_at DESC");
 $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil ID foto yang sudah difavoritkan oleh user ini
 $stmt_fav = $pdo->prepare("SELECT photo_id FROM favorites WHERE session_id = ?");
 $stmt_fav->execute([$_SESSION['user_id']]);
 $favorited_photos = $stmt_fav->fetchAll(PDO::FETCH_COLUMN, 0);

?>


<div class="container">
    <h1>Galeri Foto</h1>
    <div class="gallery-grid">
        <?php foreach ($photos as $photo): ?>
            <div class="photo-card">
                <div class="photo-wrapper" data-src="assets/uploads/<?php echo htmlspecialchars($photo['filename']); ?>">
                    <img src="assets/uploads/<?php echo htmlspecialchars($photo['filename']); ?>" alt="<?php echo htmlspecialchars($photo['caption']); ?>">
                 </div>
                         <div class="photo-info">
                    <p class="photo-caption"><?php echo htmlspecialchars($photo['caption']); ?></p>
                    <div class="photo-actions">
                        <button class="like-btn" data-id="<?php echo $photo['id']; ?>">
                            <i class="far fa-thumbs-up"></i>
                            <span class="like-count"><?php echo $photo['likes_count']; ?></span>
                        </button>
                        <button class="favorite-btn <?php echo in_array($photo['id'], $favorited_photos) ? 'favorited' : ''; ?>" data-id="<?php echo $photo['id']; ?>">
                            <i class="<?php echo in_array($photo['id'], $favorited_photos) ? 'fas' : 'far'; ?> fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="assets/js/main.js"></script>
</body>
</html>