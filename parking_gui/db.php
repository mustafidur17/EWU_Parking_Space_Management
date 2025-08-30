<?php
// db.php — simple MySQLi connection helper
$host = "localhost";   // change if needed
$user = "root";        // XAMPP/WAMP default
$pass = "";            // XAMPP/WAMP default (empty). If you set a password, put it here.
$dbname = "ewu_parking_space_management";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>