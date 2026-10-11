
<?php
require_once "db.php";

$stmt = $pdo->prepare(
    "SELECT student_id, name, email, phone, course
     FROM students
     ORDER BY student_id"
);

$stmt->execute();
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Records</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 25px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #e8f0fe;
        }
    </style>
</head>
<body>
    <h1>Student Records</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Course</th>
        </tr>

        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= htmlspecialchars((string)$student["student_id"]) ?></td>
                <td><?= htmlspecialchars($student["name"]) ?></td>
                <td><?= htmlspecialchars($student["email"]) ?></td>
                <td><?= htmlspecialchars($student["phone"] ?? "") ?></td>
                <td><?= htmlspecialchars($student["course"]) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p><a href="index.php">Back to StudentHub</a></p>
</body>
</html>
