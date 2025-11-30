<?php
// ajax/like_photo.php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['photo_id'])) {
    $photoId = (int)$_POST['photo_id'];

    // Update jumlah like di database
    $stmt = $pdo->prepare("UPDATE photos SET likes_count = likes_count + 1 WHERE id = ?");
    $stmt->execute([$photoId]);

    // Ambil jumlah like terbaru untuk dikembalikan ke JS
    $stmt = $pdo->prepare("SELECT likes_count FROM photos WHERE id = ?");
    $stmt->execute([$photoId]);
    $photo = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'new_like_count' => $photo['likes_count']]);
} else {
    echo json_encode(['success' => false]);
}
?>