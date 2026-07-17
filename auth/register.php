<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name      = sanitize($_POST['full_name']);
    $email          = sanitize($_POST['email']);
    $student_id     = sanitize($_POST['student_id']);
    $contact_number = sanitize($_POST['contact_number']);
    $password       = $_POST['password'];          // not sanitized before hashing
    $confirm_pass   = $_POST['confirm_password'];

    if ($student_id === '') {
        $student_id = null;
    }

    // --- Validation ---
    if (empty($full_name) || empty($email) || empty($password)) {
        $errors[] = "Full name, email, and password are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if ($password !== $confirm_pass) {
        $errors[] = "Passwords do not match.";
    }

    // Check if email is already registered
    if (empty($errors)) {
        $checkStmt = $conn->prepare("SELECT user_id FROM users WHERE email = :email");
        $checkStmt->execute(['email' => $email]);

        if ($checkStmt->rowCount() > 0) {
            $errors[] = "This email is already registered.";
        }
    }

    // Check if Student ID is already registered
    if (empty($errors) && $student_id !== null) {
        $checkIdStmt = $conn->prepare("SELECT user_id FROM users WHERE student_id = :student_id");
        $checkIdStmt->execute(['student_id' => $student_id]);

        if ($checkIdStmt->rowCount() > 0) {
            $errors[] = "This Student ID is already registered.";
        }
    }

    // If no errors, insert the new user
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertStmt = $conn->prepare(
            "INSERT INTO users (full_name, email, password, student_id, contact_number)
             VALUES (:full_name, :email, :password, :student_id, :contact_number)"
        );

        try {
            $insertStmt->execute([
                'full_name'      => $full_name,
                'email'          => $email,
                'password'       => $hashedPassword,
                'student_id'     => $student_id,
                'contact_number' => $contact_number
            ]);

            setFlashMessage("Registration successful! Please log in.", "success");
            redirect('login.php');

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $errors[] = "That email or Student ID was just registered by someone else. Please try again.";
            } else {
                $errors[] = "Something went wrong while registering. Please try again.";
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/register.css" />
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
  </head>

  <body>
    <div class="login-wrapper">
      <div class="login-left">
        <h1>CampusMarket</h1>
        <p>Join the CIIT marketplace.</p>
      </div>

      <div class="login-right">
        <div class="login-card">
          <h2>Create Account</h2>
          <p class="text-secondary mb-4">It only takes a minute to get started.</p>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger py-2 px-3 mb-3">
                <ul class="mb-0 ps-3">
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
          <?php endif; ?>

          <form method="POST" action="register.php">
            <div class="mb-3">
                <label>Full Name</label>
                <input class="form-control" name="full_name" placeholder="Juan Dela Cruz" value="<?= isset($full_name) ? sanitize($full_name) : '' ?>" required />
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input class="form-control" name="email" placeholder="you@student.ciit.edu.ph" value="<?= isset($email) ? sanitize($email) : '' ?>" required />
            </div>
            <div class="mb-3">
                <label>Student ID <span class="text-muted small">(optional)</span></label>
                <input class="form-control" name="student_id" placeholder="2023-00145" value="<?= isset($_POST['student_id']) ? sanitize($_POST['student_id']) : '' ?>" />
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="At least 6 characters" required />
            </div>
            <div class="mb-4">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Re-enter your password" required />
            </div>
            <button type="submit" class="btn btn-primary-custom w-100">Create Account</button>
          </form>

          <div class="text-center mt-4">
            Already have an account?
            <a href="login.php"> Login </a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
