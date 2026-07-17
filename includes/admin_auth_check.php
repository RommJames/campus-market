<?php
/**
 * Admin Access Guard
 */
require_once __DIR__ . '/functions.php';

if (!isAdminLoggedIn()) {
    setFlashMessage("Please log in as admin to continue.", "error");
    redirect('/campus-market/auth/login.php');
}
