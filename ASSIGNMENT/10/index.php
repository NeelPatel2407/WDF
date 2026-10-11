<?php
include "db.php";

if (isset($_POST["add"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $course = $_POST["course"];
    $semester = $_POST["semester"];

    $sql = "INSERT INTO students (name, email, course, semester)
            VALUES ('$name', '$email', '$course', '$semester')";

    $conn->query($sql);
}

$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>CampusCore - Student CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <header>
        <h1>Student Management</h1>
        <p>CampusCore Administration</p>
    </header>

    <main>

        <h2>Add Student</h2>

        <form method="post">

            <label>Student Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Course</label>
            <select name="course" required>
                <option value="">Select Course</option>
                <option value="B.Tech CSE">B.Tech CSE</option>
                <option value="B.Tech IT">B.Tech IT</option>
                <option value="B.Tech CE">B.Tech CE</option>
            </select>

            <label>Semester</label>
            <select name="semester" required>
                <option value="">Select Semester</option>
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
                <option value="3">Semester 3</option>
                <option value="4">Semester 4</option>
                <option value="5">Semester 5</option>
                <option value="6">Semester 6</option>
                <option value="7">Semester 7</option>
                <option value="8">Semester 8</option>
            </select>

            <button type="submit" name="add">Add Student</button>

        </form>

        <h2>Student Records</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Semester</th>
                <th>Actions</th>
            </tr>

            <?php while ($student = $result->fetch_assoc()) { ?>

            <tr>
                <td><?php echo $student["id"]; ?></td>
                <td><?php echo htmlspecialchars($student["name"]); ?></td>
                <td><?php echo htmlspecialchars($student["email"]); ?></td>
                <td><?php echo htmlspecialchars($student["course"]); ?></td>
                <td><?php echo $student["semester"]; ?></td>

                <td>
                    <a class="edit" href="edit.php?id=<?php echo $student["id"]; ?>">Edit</a>

                    <a class="delete"
                       href="delete.php?id=<?php echo $student["id"]; ?>"
                       onclick="return confirm('Delete this student?')">
                       Delete
                    </a>
                </td>
            </tr>

            <?php } ?>

        </table>

    </main>

    <footer>
        © 2026 CampusCore Student Portal
    </footer>

</div>

</body>
</html>