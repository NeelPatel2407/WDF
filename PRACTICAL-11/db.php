
<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "student_management";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    die("Database connection failed. Check your database name and MySQL settings.");
}
?>
