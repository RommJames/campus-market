<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$service_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $conn->prepare(
    "DELETE FROM services WHERE service_id = :id AND user_id = :user_id"
);
$stmt->execute(['id' => $service_id, 'user_id' => $_SESSION['user_id']]);

if ($stmt->rowCount() > 0) {
    setFlashMessage("Service deleted successfully.", "success");
} else {
    setFlashMessage("Service not found or you don't have permission to delete it.", "error");
}

redirect('my_services.php');
