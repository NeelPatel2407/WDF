
<?php
require_once "db.php";

$errors = [];
$name = "";
$email = "";
$course = "";
$semester = "";

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
                "INSERT INTO students (name, email, course, semester)
                 VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("sssi", $name, $email, $course, $semester);
            $stmt->execute();
            $stmt->close();
            $conn->close();

            header("Location: index.php?message=" . urlencode("Student added successfully."));
            exit;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {
                $errors[] = "This email is already registered.";
            } else {
                $errors[] = "Unable to add the student. Please try again.";
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
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container form-container">
    <header>
        <h1>Add Student</h1>
        <p>Enter student details</p>
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
                <option value="">Select Course</option>
                <?php foreach (["B.Tech CSE", "B.Tech IT", "B.Tech CE"] as $item): ?>
                    <option value="<?= $item ?>" <?= $course === $item ? "selected" : "" ?>>
                        <?= $item ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="semester">Semester</label>
            <select id="semester" name="semester" required>
                <option value="">Select Semester</option>
                <?php for ($i = 1; $i <= 8; $i++): ?>
                    <option value="<?= $i ?>" <?= $semester === $i ? "selected" : "" ?>>
                        <?= $i ?>
                    </option>
                <?php endfor; ?>
            </select>

            <button type="submit">Add Student</button>
            <a class="button secondary" href="index.php">Cancel</a>
        </form>
    </main>
</div>
</body>
</html>
