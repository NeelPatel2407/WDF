<?php
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once __DIR__ . "/db.php";

$search = trim($_GET["search"] ?? "");
$course = trim($_GET["course"] ?? "");

$sql = "SELECT id, name, email, course, semester, created_at
        FROM students
        WHERE (name LIKE ? OR email LIKE ? OR course LIKE ?)";

$searchTerm = "%" . $search . "%";
$params = [$searchTerm, $searchTerm, $searchTerm];
$types = "sss";

if ($course !== "") {
    $sql .= " AND course = ?";
    $params[] = $course;
    $types .= "s";
}

$sql .= " ORDER BY id ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$courses = ["B.Tech CSE", "B.Tech IT", "B.Tech CE"];
$message = $_GET["message"] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <header>
        <h1>Student Management</h1>
        <p>CampusCore</p>
    </header>

    <main>

        <?php if ($message !== ""): ?>
            <p class="message">
                <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
            </p>
        <?php endif; ?>

        <div class="top-actions">
            <a class="button"
               href="http://127.0.0.1:5500/PRACTICAL-2/Home.html">
                Home
            </a>

            <a class="button" href="add.php">
                + Add Student
            </a>

            <a class="button" href="export.php">
                Export CSV
            </a>
        </div>

        <form method="GET" class="search-form">

            <input
                type="text"
                name="search"
                placeholder="Search name, email or course"
                value="<?= htmlspecialchars($search, ENT_QUOTES, "UTF-8") ?>"
            >

            <select name="course">
                <option value="">All Courses</option>

                <?php foreach ($courses as $item): ?>
                    <option
                        value="<?= htmlspecialchars($item, ENT_QUOTES, "UTF-8") ?>"
                        <?= $course === $item ? "selected" : "" ?>>
                        <?= htmlspecialchars($item, ENT_QUOTES, "UTF-8") ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Search</button>

            <a class="button secondary" href="index.php">
                Reset
            </a>

        </form>

        <p>
            Total records displayed:
            <strong><?= $result->num_rows ?></strong>
        </p>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Semester</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php if ($result->num_rows > 0): ?>

                    <?php while ($student = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?= (int)$student["id"] ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student["name"], ENT_QUOTES, "UTF-8") ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student["email"], ENT_QUOTES, "UTF-8") ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student["course"], ENT_QUOTES, "UTF-8") ?>
                            </td>

                            <td>
                                <?= (int)$student["semester"] ?>
                            </td>

                            <td class="actions">
                                <a class="edit"
                                   href="edit.php?id=<?= (int)$student["id"] ?>">
                                    Edit
                                </a>

                                <form
                                    action="delete.php"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this student?');">

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?= (int)$student["id"] ?>">

                                    <button class="delete" type="submit">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="6">No student records found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </main>

    <footer>
        © 2026 CampusCore - Student Management
    </footer>

</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>