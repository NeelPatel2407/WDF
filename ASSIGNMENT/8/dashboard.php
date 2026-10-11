<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CampusCore - Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <header>
        <h1>CampusCore</h1>
        <p>Student Dashboard</p>
    </header>

    <main class="dashboard">
        <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>

        <p>You have successfully logged in.</p>

        <div class="box">
            <h3>Session Status</h3>
            <p>Login session is active.</p>
        </div>

        <a class="logout" href="logout.php">Logout</a>
    </main>

    <footer>
        © 2026 CampusCore Student Portal
    </footer>
</div>

</body>
</html>