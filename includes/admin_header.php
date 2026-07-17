<?php
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusMarket - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">        
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/components.css">
    <link rel="stylesheet" href="../assets/css/forms.css">
    <link rel="stylesheet" href="../assets/css/listings.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
</head>
<body>
<header>
  <nav class="navbar navbar-expand-xl bg-white shadow-sm py-3">
    <div class="container">
      <a class="navbar-brand fw-bold fs-3" href="/campus-market/admin/dashboard.php">
        <span class="text-primary">Campus</span>Market
      </a>

      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbar"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item mx-2">
            <a class="nav-link active" href="/campus-market/admin/dashboard.php">Admin Dashboard</a>
          </li>

          <li class="nav-item mx-2">
            <a class="nav-link"href="/campus-market/admin/manage_users.php">Manage Users</a>
          </li>

          <li class="nav-item mx-2">
            <a class="nav-link" href="/campus-market/admin/manage_products.php">Manage Products</a>
          </li>

          <li class="nav-item mx-2">
            <a class="nav-link"href="/campus-market/admin/manage_services.php">Manage Services</a> 
          </li>

          <li class="nav-item mx-2">
            <a class="nav-link" href="/campus-market/admin/manage_categories.php">Manage Categories</a>
          </li>

          <li class="nav-item ms-3">
            <a class="btn btn-primary-custom" href="/campus-market/admin/reports.php">Reports</a>
          </li>
          <li class="nav-item ms-3">
            <a class="btn btn-primary-custom" href="/campus-market/auth/logout.php">Logout </a>
          </li>
          <?php if (isAdminLoggedIn()): ?>
            <li class="nav-item ms-3 text-secondary small d-flex align-items-center">
                <?= sanitize($_SESSION['admin_username']) ?>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
    <?php showFlashMessage(); ?>
</header>
<main>
