<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_id = (int) $_POST['product_id'];
    $user_id = $_SESSION['user_id'];

    // Check if it's already favorited
    $checkStmt = $conn->prepare(
        "SELECT favorite_id FROM favorites WHERE user_id = :user_id AND product_id = :product_id"
    );
    $checkStmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        // Already favorited -> remove it
        $deleteStmt = $conn->prepare("DELETE FROM favorites WHERE favorite_id = :id");
        $deleteStmt->execute(['id' => $existing['favorite_id']]);
        setFlashMessage("Removed from favorites.", "info");
    } else {
        // Not favorited yet -> add it
        $insertStmt = $conn->prepare(
            "INSERT INTO favorites (user_id, product_id) VALUES (:user_id, :product_id)"
        );
        $insertStmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
        setFlashMessage("Added to favorites!", "success");
    }

    redirect("product_details.php?id=$product_id");
}
