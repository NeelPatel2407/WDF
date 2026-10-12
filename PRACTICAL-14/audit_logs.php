<?php
require_once __DIR__ . "/../PRACTICAL-10/auth.php";
requireRole("admin");

$conn = new mysqli("localhost", "root", "", "campuscore");

if ($conn->connect_error) {
    die("Database connection failed.");
}

$conn->set_charset("utf8mb4");

$result = $conn->query(
    "SELECT id, user_id, action, details, ip_address, created_at
     FROM audit_logs
     ORDER BY id DESC
     LIMIT 100"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs - CampusCore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="topbar">
    <h2>CampusCore Admin</h2>

    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="audit_logs.php">Audit Logs</a>
        <a href="../PRACTICAL-10/logout.php">Logout</a>
    </nav>
</header>

<main class="container">
    <h1>Audit Logs</h1>
    <p class="subtitle">Recent administrative activity.</p>

    <section class="panel">
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Action</th>
                            <th>Details</th>
                            <th>IP Address</th>
                            <th>Date and Time</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= (int) $row["id"] ?></td>
                                <td><?= htmlspecialchars((string) $row["user_id"]) ?></td>
                                <td><?= htmlspecialchars($row["action"]) ?></td>
                                <td><?= htmlspecialchars((string) $row["details"]) ?></td>
                                <td><?= htmlspecialchars((string) $row["ip_address"]) ?></td>
                                <td><?= htmlspecialchars($row["created_at"]) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No audit records available yet.</p>
        <?php endif; ?>
    </section>
</main>

<footer>
    © 2026 Charotar University of Science & Technology
</footer>

</body>
</html>