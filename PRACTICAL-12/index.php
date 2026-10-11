
<?php
require_once "db.php";

$search = trim($_GET['search'] ?? '');
$category = $_GET['category'] ?? '';
$status = $_GET['status'] ?? '';

$sql = "SELECT * FROM events WHERE 1=1";
$params = [];
$types = "";

if ($search !== '') {
    $sql .= " AND (title LIKE ? OR description LIKE ?)";
    $value = "%$search%";
    $params[] = $value;
    $params[] = $value;
    $types .= "ss";
}

if ($category !== '') {
    $sql .= " AND category = ?";
    $params[] = $category;
    $types .= "s";
}

if ($status !== '') {
    $sql .= " AND status = ?";
    $params[] = $status;
    $types .= "s";
}

$sql .= " ORDER BY event_date ASC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$categories = $conn->query(
    "SELECT DISTINCT category FROM events ORDER BY category"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - CampusCore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="topbar">
    <h2>CampusCore</h2>

    <nav>
        <a href="http://127.0.0.1:5500/PRACTICAL-2/dashboard.html">Dashboard</a>
        <a href="http://127.0.0.1:5500/PRACTICAL-2/profile.html">Profile</a>
        <a href="http://127.0.0.1:5500/PRACTICAL-2/course_registration.html">Courses</a>
        <a href="http://127.0.0.1:5500/PRACTICAL-2/exam_schedule.html">Exams</a>
        <a href="http://127.0.0.1:5500/PRACTICAL-2/fees_payment.html">Fees</a>
        <a href="http://127.0.0.1:5500/PRACTICAL-2/about_faculty.html">Faculty</a>
        <a href="http://127.0.0.1:5500/PRACTICAL-2/feedback.html">Feedback</a>
        <a href="http://127.0.0.1:5500/PRACTICAL-2/Contactsupport%26FAQ.html">Help &amp; FAQ</a>
        <a href="http://127.0.0.1:5500/PRACTICAL-2/Home.html">Logout</a>
    </nav>
</div>

<div class="container">

    <h1>Upcoming Campus Events</h1>

    <?php if (isset($_GET['message'])): ?>
        <div class="message">
            <?= htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <form method="GET" action="index.php" class="filters">
        <input
            type="text"
            name="search"
            placeholder="Search events..."
            value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
        >

        <select name="category">
            <option value="">All Categories</option>

            <?php while ($row = $categories->fetch_assoc()): ?>
                <option
                    value="<?= htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8') ?>"
                    <?= $category === $row['category'] ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endwhile; ?>
        </select>

        <select name="status">
            <option value="">All Statuses</option>
            <option value="Open" <?= $status === 'Open' ? 'selected' : '' ?>>Open</option>
            <option value="Closed" <?= $status === 'Closed' ? 'selected' : '' ?>>Closed</option>
        </select>

        <button type="submit">Search</button>
        <a class="reset" href="index.php">Reset</a>
    </form>

    <div class="actions">
        <a class="button" href="add.php">+ Add Event</a>
    </div>

    <div class="event-list">

        <?php if ($result->num_rows > 0): ?>

            <?php while ($event = $result->fetch_assoc()): ?>

                <div class="event-card">

                    <?php if (!empty($event['poster'])): ?>
                        <img
                            class="poster"
                            src="uploads/<?= rawurlencode(basename($event['poster'])) ?>"
                            alt="<?= htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8') ?>"
                        >
                    <?php endif; ?>

                    <div class="event-info">

                        <h2><?= htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8') ?></h2>

                        <p>
                            <strong>Date:</strong>
                            <?= date('d M Y', strtotime($event['event_date'])) ?>
                        </p>

                        <p>
                            <strong>Venue:</strong>
                            <?= htmlspecialchars($event['venue'] ?? 'Campus', ENT_QUOTES, 'UTF-8') ?>
                        </p>

                        <p>
                            <strong>Category:</strong>
                            <?= htmlspecialchars($event['category'], ENT_QUOTES, 'UTF-8') ?>
                        </p>

                        <p>
                            <strong>Status:</strong>
                            <span class="<?= $event['status'] === 'Open' ? 'open' : 'closed' ?>">
                                <?= htmlspecialchars($event['status'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </p>

                        <p>
                            <?= nl2br(htmlspecialchars($event['description'], ENT_QUOTES, 'UTF-8')) ?>
                        </p>

                        <?php if ($event['status'] === 'Open'): ?>
                            <a
                                href="participate.php?id=<?= (int)$event['id'] ?>"
                                class="participate-btn"
                            >Participate</a>
                        <?php else: ?>
                            <button type="button" class="participate-btn" disabled>
                                Registration Closed
                            </button>
                        <?php endif; ?>

                        <div class="event-actions">
                            <a href="edit.php?id=<?= (int)$event['id'] ?>">Edit</a>

                            <form
                                action="delete.php"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this event?')"
                            >
                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= (int)$event['id'] ?>"
                                >
                                <button type="submit">Delete</button>
                            </form>
                        </div>

                    </div>
                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <p class="empty">No events found.</p>

        <?php endif; ?>

    </div>
</div>

<p class="footer">
    © 2026 Charotar University of Science &amp; Technology. All Rights Reserved
</p>

</body>
</html>
