<?php
/**
 * Database Connection File
 * Our group uses PDO (PHP Data Objects) so we can use prepared statements
 * everywhere else in the app cause this protects against SQL injection.
 */

$host = "localhost";
$db_name = "campusmarket";
$db_user = "root";   
$db_pass = "";       

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass
    );
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {    
    
    die("Database connection failed: " . $e->getMessage());
}
