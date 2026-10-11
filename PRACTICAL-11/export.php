
<?php
require_once "db.php";

header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=students.csv");

$output = fopen("php://output", "w");

fputcsv($output, ["ID", "Name", "Email", "Course", "Semester", "Created At"]);

$result = $conn->query(
    "SELECT id, name, email, course, semester, created_at
     FROM students
     ORDER BY id"
);

while ($student = $result->fetch_assoc()) {
    fputcsv($output, [
        $student["id"],
        $student["name"],
        $student["email"],
        $student["course"],
        $student["semester"],
        $student["created_at"]
    ]);
}

fclose($output);
$conn->close();
exit;
?>
