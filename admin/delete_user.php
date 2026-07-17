<?php
require_once __DIR__ . '/../includes/admin_auth_check.php';
require_once __DIR__ . '/../config/database.php';

$user_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $conn->prepare("DELETE FROM users WHERE user_id = :id");
$stmt->execute(['id' => $user_id]);

if ($stmt->rowCount() > 0) {
    setFlashMessage("User deleted successfully.", "success");
} else {
    setFlashMessage("User not found.", "error");
}

redirect('manage_users.php');
