<?php
require_once __DIR__ . '/../includes/admin_auth_check.php';
require_once __DIR__ . '/../config/database.php';

$service_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $conn->prepare("DELETE FROM services WHERE service_id = :id");
$stmt->execute(['id' => $service_id]);

if ($stmt->rowCount() > 0) {
    setFlashMessage("Service removed successfully.", "success");
} else {
    setFlashMessage("Service not found.", "error");
}

redirect('manage_services.php');
