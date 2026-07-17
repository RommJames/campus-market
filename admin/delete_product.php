<?php
require_once __DIR__ . '/../includes/admin_auth_check.php';
require_once __DIR__ . '/../config/database.php';

$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// No user_id check here on purpose — admins are allowed to moderate
// and remove ANY product listing, not just their own.
$stmt = $conn->prepare("DELETE FROM products WHERE product_id = :id");
$stmt->execute(['id' => $product_id]);

if ($stmt->rowCount() > 0) {
    setFlashMessage("Product removed successfully.", "success");
} else {
    setFlashMessage("Product not found.", "error");
}

redirect('manage_products.php');
