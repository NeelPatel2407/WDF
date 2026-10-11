
<?php
require_once "db.php";

$sql = "SELECT
            r.registration_id,
            s.name AS student_name,
            s.email,
            e.event_name,
            e.event_date,
            r.registration_date
        FROM registrations r
        INNER JOIN students s
            ON r.student_id = s.student_id
        INNER JOIN events e
            ON r.event_id = e.event_id
        ORDER BY r.registration_date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$registrations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Registrations</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
    <h1>Event Registrations</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Email</th>
            <th>Event</th>
            <th>Event Date</th>
            <th>Registered On</th>
        </tr>

        <?php foreach ($registrations as $registration): ?>
            <tr>
                <td><?= htmlspecialchars((string)$registration["registration_id"]) ?></td>
                <td><?= htmlspecialchars($registration["student_name"]) ?></td>
                <td><?= htmlspecialchars($registration["email"]) ?></td>
                <td><?= htmlspecialchars($registration["event_name"]) ?></td>
                <td><?= htmlspecialchars($registration["event_date"]) ?></td>
                <td><?= htmlspecialchars($registration["registration_date"]) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p><a href="index.php">Back to StudentHub</a></p>
</body>
</html>
