
<?php
require_once "db.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header("Location: index.php?message=" . urlencode("Invalid student ID."));
    exit;
}

$stmt = $conn->prepare(
    "SELECT name, email, course, semester FROM students WHERE id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$student) {
    $conn->close();
    header("Location: index.php?message=" . urlencode("Student not found."));
    exit;
}

$name = $student["name"];
$email = $student["email"];
$course = $student["course"];
$semester = (int)$student["semester"];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $course = trim($_POST["course"] ?? "");
    $semester = (int)($_POST["semester"] ?? 0);

    if ($name === "" || strlen($name) > 100) {
        $errors[] = "Enter a valid name.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
        $errors[] = "Enter a valid email address.";
    }

    if (!in_array($course, ["B.Tech CSE", "B.Tech IT", "B.Tech CE"], true)) {
        $errors[] = "Select a valid course.";
    }

    if ($semester < 1 || $semester > 8) {
        $errors[] = "Semester must be between 1 and 8.";
    }

    if (!$errors) {
        try {
            $stmt = $conn->prepare(
                "UPDATE students
                 SET name = ?, email = ?, course = ?, semester = ?
                 WHERE id = ?"
            );
            $stmt->bind_param("sssii", $name, $email, $course, $semester, $id);
            $stmt->execute();
            $stmt->close();
            $conn->close();

            header("Location: index.php?message=" . urlencode("Student updated successfully."));
            exit;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {
                $errors[] = "This email is already used by another student.";
            } else {
                $errors[] = "Unable to update the student.";
                error_log($e->getMessage());
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container form-container">
    <header>
        <h1>Edit Student</h1>
        <p>Update student details</p>
    </header>

    <main>
        <?php foreach ($errors as $error): ?>
            <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></p>
        <?php endforeach; ?>

        <form method="POST">
            <label for="name">Full Name</label>
            <input id="name" type="text" name="name" maxlength="100"
                   value="<?= htmlspecialchars($name, ENT_QUOTES, "UTF-8") ?>" required>

            <label for="email">Email</label>
            <input id="email" type="email" name="email" maxlength="100"
                   value="<?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?>" required>

            <label for="course">Course</label>
            <select id="course" name="course" required>
                <?php foreach (["B.Tech CSE", "B.Tech IT", "B.Tech CE"] as $item): ?>
                    <option value="<?= $item ?>" <?= $course === $item ? "selected" : "" ?>>
                        <?= $item ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="semester">Semester</label>
            <select id="semester" name="semester" required>
                <?php for ($i = 1; $i <= 8; $i++): ?>
                    <option value="<?= $i ?>" <?= $semester === $i ? "selected" : "" ?>>
                        <?= $i ?>
                    </option>
                <?php endfor; ?>
            </select>

            <button type="submit">Save Changes</button>
            <a class="button secondary" href="index.php">Cancel</a>
        </form>
    </main>
</div>
</body>
</html>

<?php $conn->close(); ?>
