<?php
require_once __DIR__ . '/includes/functions.php';

if (isStudentLoggedIn()) {
    redirect('student/dashboard.php');
} elseif (isAdminLoggedIn()) {
    redirect('admin/dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CampusMarket - Student Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/forms.css">
    <link rel="shortcut icon" href="assets/favicon.png" type="image/x-icon">
</head>
<body>
<div class="login-wrapper">

    <div class="login-left">
        <h1>CampusMarket</h1>
        <p>The marketplace built exclusively for CIIT students — buy, sell, rent, and exchange academic materials, entertainment &amp; media equipment, and creative services.</p>
    </div>

    <div class="login-right">
        <div class="login-card text-center">
            <h2>Get Started</h2>
            <p class="text-secondary mb-4">Log in to your account or create a new one.</p>

            <a href="auth/login.php" class="btn btn-primary-custom w-100 mb-3">Login</a>
            <a href="auth/register.php" class="btn btn-outline-custom w-100">Create an Account</a>

            <hr class="form-section-divider">

            <p class="text-secondary small mb-0">
                <i class="bi bi-book"></i> Academic materials &nbsp;•&nbsp;
                <i class="bi bi-camera-reels"></i> Media equipment &nbsp;•&nbsp;
                <i class="bi bi-stars"></i> Creative services
            </p>
        </div>
    </div>

</div>
</body>
</html>
