<?php
$employee = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee = [
        "id" => $_POST["id"],
        "name" => $_POST["name"],
        "email" => $_POST["email"],
        "department" => $_POST["department"],
        "salary" => $_POST["salary"]
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CampusCore - Employee Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Employee Data Entry</h1>
        <p>CampusCore Administration</p>
    </header>

    <main>
        <form method="post">
            <label>Employee ID</label>
            <input type="text" name="id" required>

            <label>Employee Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Department</label>
            <select name="department" required>
                <option value="">Select Department</option>
                <option value="CSE">CSE</option>
                <option value="IT">IT</option>
                <option value="CE">CE</option>
                <option value="HR">HR</option>
            </select>

            <label>Salary</label>
            <input type="number" name="salary" required>

            <button type="submit">Add Employee</button>
        </form>

        <?php if ($employee != null) { ?>

        <h2>Employee Details</h2>

        <table>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Salary</th>
            </tr>

            <tr>
                <td><?php echo $employee["id"]; ?></td>
                <td><?php echo $employee["name"]; ?></td>
                <td><?php echo $employee["email"]; ?></td>
                <td><?php echo $employee["department"]; ?></td>
                <td>₹<?php echo $employee["salary"]; ?></td>
            </tr>
        </table>

        <?php } ?>
    </main>

    <footer>
        © 2026 CampusCore Student Portal
    </footer>
</div>

</body>
</html>