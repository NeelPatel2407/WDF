<?php
include "db.php";

$id = $_GET["id"];

$result = $conn->query("SELECT * FROM students WHERE id=$id");
$student = $result->fetch_assoc();

if (isset($_POST["update"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $course = $_POST["course"];
    $semester = $_POST["semester"];

    $sql = "UPDATE students SET
            name='$name',
            email='$email',
            course='$course',
            semester='$semester'
            WHERE id=$id";

    $conn->query($sql);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <header>
        <h1>Edit Student</h1>
        <p>CampusCore Administration</p>
    </header>

    <main>

        <form method="post">

            <label>Student Name</label>
            <input type="text" name="name"
                   value="<?php echo htmlspecialchars($student["name"]); ?>"
                   required>

            <label>Email</label>
            <input type="email" name="email"
                   value="<?php echo htmlspecialchars($student["email"]); ?>"
                   required>

            <label>Course</label>
            <select name="course">
                <option <?php if ($student["course"] == "B.Tech CSE") echo "selected"; ?>>B.Tech CSE</option>
                <option <?php if ($student["course"] == "B.Tech IT") echo "selected"; ?>>B.Tech IT</option>
                <option <?php if ($student["course"] == "B.Tech CE") echo "selected"; ?>>B.Tech CE</option>
            </select>

            <label>Semester</label>
            <select name="semester">
                <?php for ($i = 1; $i <= 8; $i++) { ?>
                    <option value="<?php echo $i; ?>"
                        <?php if ($student["semester"] == $i) echo "selected"; ?>>
                        Semester <?php echo $i; ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit" name="update">Update Student</button>

        </form>

    </main>

    <footer>
        © 2026 CampusCore Student Portal
    </footer>

</div>

</body>
</html>