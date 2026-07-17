<?php
/**
 * Shared Helper Functions
 */

// Start the session once, everywhere it's needed.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Cleans user input to help prevent XSS and stray whitespace.
 */
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Redirects to another page and stops execution.
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Checks whether a student is currently logged in.
 */
function isStudentLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Checks whether an admin is currently logged in.
 */
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}

/**
 * Stores a one-time flash message (e.g. "Login successful")
 * to show on the next page load, then clears it.
 */
function setFlashMessage($message, $type = 'success') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type; // success, error, info
}

function showFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $type = $_SESSION['flash_type'] ?? 'info';
        echo "<div class='alert alert-$type'>" . $_SESSION['flash_message'] . "</div>";
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
    }
}
