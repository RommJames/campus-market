<?php
require_once __DIR__ . '/../includes/functions.php';

$_SESSION = [];
session_destroy();

session_start();
setFlashMessage("You have been logged out.", "info");
redirect('login.php');
