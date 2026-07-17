<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/database.php';

$errors = [];

$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name      = sanitize($_POST['full_name']);
    $student_id     = sanitize($_POST['student_id']);
    $contact_number = sanitize($_POST['contact_number']);

    if ($student_id === '') {
        $student_id = null;
    }

    if (empty($full_name)) {
        $errors[] = "Full name is required.";
    }

    if (empty($errors) && $student_id !== null) {
        $checkIdStmt = $conn->prepare(
            "SELECT user_id FROM users WHERE student_id = :student_id AND user_id != :user_id"
        );
        $checkIdStmt->execute(['student_id' => $student_id, 'user_id' => $_SESSION['user_id']]);

        if ($checkIdStmt->rowCount() > 0) {
            $errors[] = "This Student ID is already registered to another account.";
        }
    }

    if (empty($errors)) {
        $updateStmt = $conn->prepare(
            "UPDATE users SET full_name = :full_name, student_id = :student_id, contact_number = :contact_number
             WHERE user_id = :user_id"
        );

        try {
            $updateStmt->execute([
                'full_name'      => $full_name,
                'student_id'     => $student_id,
                'contact_number' => $contact_number,
                'user_id'        => $_SESSION['user_id']
            ]);

            $_SESSION['user_name'] = $full_name;
            setFlashMessage("Profile updated successfully!", "success");
            redirect('profile.php');

        } catch (PDOException $e) {
            $errors[] = ($e->getCode() == 23000)
                ? "That Student ID was just taken by someone else. Please try again."
                : "Something went wrong while updating your profile.";
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-4">

    <div class="page-header text-center">
        <h1>My Profile</h1>
        <p>Keep your account details up to date.</p>
    </div>

    <div class="form-card">

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger py-2 px-3 mb-3">
                <ul class="mb-0 ps-3">
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="profile.php">
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control" value="<?= sanitize($user['full_name']) ?>" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control" value="<?= sanitize($user['email']) ?>" disabled>
                <p class="form-text-hint">Your email can't be changed.</p>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label>Student ID</label>
                    <input type="text" name="student_id" class="form-control" value="<?= sanitize($user['student_id']) ?>">
                </div>
                <div class="col-md-6">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" value="<?= sanitize($user['contact_number']) ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary-custom w-100">Update Profile</button>
        </form>
    </div>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
