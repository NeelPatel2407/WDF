
<?php
session_start();

if (isset($_SESSION["user_id"])) {
    if ($_SESSION["role"] === "admin") {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: student_dashboard.php");
    }
    exit;
}

$error = $_SESSION["login_error"] ?? "";
unset($_SESSION["login_error"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CampusCore</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<table class="login-table">
    <tr>
        <td class="features">
            <h1>CampusCore</h1>
            <p>CHARUSAT Student Portal</p>
            <hr>

            <h3>Student Services</h3>
            <ul>
                <li>Academic Dashboard</li>
                <li>Course Registration</li>
                <li>Exam Schedule</li>
                <li>Fees Payment</li>
                <li>Campus Events</li>
                <li>Faculty Information</li>
            </ul>
        </td>

        <td class="login-box">
            <h2>Student Login</h2>
            <p>Sign in to access your student account.</p>

            <nav>
                <a href="http://127.0.0.1:5500/PRACTICAL-02/Home.html">Home</a>
                <a href="../PRACTICAL-09/register.php">Register</a>
                <a href="http://127.0.0.1:5500/PRACTICAL-02/Contactsupport%26FAQ.html">Help & FAQ</a>
            </nav>

            <?php if ($error !== ""): ?>
                <p class="error">
                    <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
                </p>
            <?php endif; ?>

            <br>

            <form action="login_process.php" method="POST">
                <label for="username">Student ID or Email</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Enter Student ID or Email"
                    autocomplete="username"
                    required
                >

                <br><br>

                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter Password"
                    autocomplete="current-password"
                    required
                >

                <br><br>

                <label>
                    <input type="checkbox" name="remember_me" value="1">
                    Remember Me
                </label>

                <br><br>

                <button type="submit">Login</button>
            </form>

            <br>

            <a href="http://127.0.0.1:5500/PRACTICAL-02/Forgot_Password.html">Forgot Password?</a>

            <br><br>

            <p>
                New student?
                <a href="../PRACTICAL-09/register.php">Register</a>
            </p>
        </td>
    </tr>
</table>

<p class="footer">
    © 2026 Charotar University of Science & Technology. All Rights Reserved
</p>

<script src="../PRACTICAL-04/login.js"></script>
</body>
</html>
