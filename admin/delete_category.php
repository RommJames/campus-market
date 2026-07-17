<?php
require_once __DIR__ . '/../includes/admin_auth_check.php';
require_once __DIR__ . '/../config/database.php';

$category_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

try {
    
    $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = :id");
    $stmt->execute(['id' => $category_id]);

    if ($stmt->rowCount() > 0) {
        setFlashMessage("Category deleted successfully.", "success");
    } else {
        setFlashMessage("Category not found.", "error");
    }
} catch (PDOException $e) {
    setFlashMessage("Cannot delete this category — it is still being used by existing products or services.", "error");
}

redirect('manage_categories.php');
