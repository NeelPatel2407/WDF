<?php
$conn = new mysqli("localhost", "root", "", "campuscore");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
