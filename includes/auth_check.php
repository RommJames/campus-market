<?php
/**
 * Student Access Guard
 */
require_once __DIR__ . '/functions.php';

if (!isStudentLoggedIn()) {
    setFlashMessage("Please log in to continue.", "error");
    redirect('/campus-market/auth/login.php');
}
