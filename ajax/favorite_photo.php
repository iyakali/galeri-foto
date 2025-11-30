<?php
// ajax/favorite_photo.php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['photo_id'], $_POST['action'])) {
    $photoId = (int)$_POST['photo_id'];
    $action = $_POST['action'];
    $userId = $_SESSION['user_id'];

    if ($action === 'add') {
        // Tambahkan ke favorit
        $stmt = $pdo->prepare("INSERT IGNORE INTO favorites (photo_id, session_id) VALUES (?, ?)");
        $stmt->execute([$photoId, $userId]);
    } elseif ($action === 'remove') {
        // Hapus dari favorit
        $stmt = $pdo->prepare("DELETE FROM favorites WHERE photo_id = ? AND session_id = ?");
        $stmt->execute([$photoId, $userId]);
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>