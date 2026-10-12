<?php
require_once __DIR__ . "/../PRACTICAL-10/auth.php";
requireRole("admin");

$conn = new mysqli("localhost", "root", "", "studenthub");

if ($conn->connect_error) {
    die("Database connection failed.");
}

$conn->set_charset("utf8mb4");

$auditDB = new mysqli("localhost", "root", "", "campuscore");

if ($auditDB->connect_error) {
    die("Audit database connection failed.");
}

$auditDB->set_charset("utf8mb4");

function getCount(mysqli $conn, string $table): int {
    $allowed = ["users", "students", "events", "registrations"];

    if (!in_array($table, $allowed, true)) {
        return 0;
    }

    $result = $conn->query("SELECT COUNT(*) AS total FROM `$table`");

    if (!$result) {
        return 0;
    }

    return (int) $result->fetch_assoc()["total"];
}

function recordAction(
    mysqli $conn,
    string $action,
    string $details
): void {
    $userId = (int) ($_SESSION["user_id"] ?? 0);
    $ip = $_SERVER["REMOTE_ADDR"] ?? "";

    $stmt = $conn->prepare(
        "INSERT INTO audit_logs
         (user_id, action, details, ip_address)
         VALUES (?, ?, ?, ?)"
    );

    if ($stmt) {
        $stmt->bind_param(
            "isss",
            $userId,
            $action,
            $details,
            $ip
        );
        $stmt->execute();
        $stmt->close();
    }
}

if (empty($_SESSION["dashboard_opened"])) {
    recordAction(
        $auditDB,
        "Dashboard opened",
        "Admin opened the Practical 14 dashboard."
    );

    $_SESSION["dashboard_opened"] = true;
}

$userDB = new mysqli("localhost", "root", "", "practical9");

if ($userDB->connect_error) {
    die("User database connection failed.");
}

$userCount = getCount($userDB, "users");
$studentCount = getCount($conn, "students");
$eventCount = getCount($conn, "events");
$registrationCount = getCount($conn, "registrations");

$latest = $conn->query(
    "SELECT registration_id, student_id, event_id, registration_date
     FROM registrations
     ORDER BY registration_id DESC
     LIMIT 5"
);

$role = $_SESSION["role"] ?? "user";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CampusCore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="topbar">
    <h2>CampusCore Admin</h2>

    <nav>
        <a href="dashboard.php">Dashboard</a>

        <a href="../PRACTICAL-13/index.php">
            Student Management
        </a>

        <?php if ($role === "admin"): ?>
            <a href="audit_logs.php">Audit Logs</a>
        <?php endif; ?>

        <a href="../PRACTICAL-10/logout.php">Logout</a>
    </nav>
</header>

<main class="container">
    <h1>Admin Dashboard</h1>

    <p class="subtitle">
        Monitor users, students, events and registrations.
    </p>

    <section class="stats">
        <div class="stat-card">
            <span>Total Users</span>
            <h2><?= $userCount ?></h2>
        </div>

        <div class="stat-card">
            <span>Total Students</span>
            <h2><?= $studentCount ?></h2>
        </div>

        <div class="stat-card">
            <span>Total Events</span>
            <h2><?= $eventCount ?></h2>
        </div>

        <div class="stat-card">
            <span>Registrations</span>
            <h2><?= $registrationCount ?></h2>
        </div>
    </section>

    <section class="panel">
        <h2>Latest Registrations</h2>

        <?php if ($latest && $latest->num_rows > 0): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Registration ID</th>
                            <th>Student ID</th>
                            <th>Event ID</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = $latest->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?= (int) $row["registration_id"] ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars((string) $row["student_id"]) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars((string) $row["event_id"]) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars((string) $row["registration_date"]) ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No registrations found.</p>
        <?php endif; ?>
    </section>
</main>

<footer>
    © 2026 Charotar University of Science & Technology
</footer>

</body>
</html>