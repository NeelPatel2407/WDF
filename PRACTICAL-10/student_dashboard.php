
<?php
require_once "auth.php";

requireRole("student");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusCore | Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <header>
            <h1>CampusCore</h1>
            <p>Student Dashboard</p>
        </header>

        <main>
            <h2>Welcome, <?= htmlspecialchars($_SESSION["username"], ENT_QUOTES, "UTF-8") ?>!</h2>
            <p>You have successfully logged in as a student.</p>
            <p>Your account is protected by PHP sessions.</p>

            <form action="logout.php" method="POST">
                <button type="submit">Logout</button>
            </form>
        </main>
    </div>
</body>
</html>
