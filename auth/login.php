<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = sanitize($_POST['email']);
    $password = $_POST['password'];

    // --- 1. Check if it's an admin login (by username match) ---
    $adminStmt = $conn->prepare("SELECT * FROM admin WHERE username = :username");
    $adminStmt->execute(['username' => $email]);
    $admin = $adminStmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_username'] = $admin['username'];

        setFlashMessage("Welcome back, admin!", "success");
        redirect('../admin/dashboard.php');
    }

    // --- 2. Otherwise, check if it's a student login (by email) ---
    $userStmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $userStmt->execute(['email' => $email]);
    $user = $userStmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['full_name'];

        setFlashMessage("Welcome back, " . $user['full_name'] . "!", "success");
        redirect('../student/dashboard.php');
    }

    // --- 3. Neither matched ---
    if (empty($errors)) {
        $errors[] = "Invalid email/username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusMarket | Login</title>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">        
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
</head>

<body>

<div class="login-wrapper">

    <div class="login-left">

        <h1>CampusMarket</h1>

        <p>
            Buy, Sell, and Exchange
            with fellow CIIT students.
        </p>


    </div>
    
    <div class="login-right">
        <div class="login-card">
            <h2>Welcome Back</h2>
            <p class="text-secondary">Login to continue.</p>

            <?php showFlashMessage(); ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger py-2 px-3 mb-3">
                    <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label>Email or Admin Username</label>
                    <input
                    type="text"
                    name="email"
                    class="form-control"
                    placeholder="Enter your email or username"
                    value="<?= isset($_POST['email']) ? sanitize($_POST['email']) : '' ?>">
                </div>
                <div class="mb-4">
                    <label>Password</label>
                    <input
                    type="password"
                     name="password"
                    class="form-control"
                    placeholder="Enter your password">
                </div>
                <button class="btn btn-primary-custom w-100" type="submit">
                    Login
                </button>
            </form>
            <div class="text-center mt-4">
                Don't have an account?
                <a href="register.php">
                    Register
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>