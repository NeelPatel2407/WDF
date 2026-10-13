<?php
require_once __DIR__ . "/auth.php";
requireRole("admin");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusCore Admin Portal</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #26334a;
        }

        .container {
            max-width: 800px;
            margin: 70px auto;
            padding: 30px;
            text-align: center;
        }

        h1 {
            color: #4f46e5;
        }

        .cards {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 35px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            width: 300px;
            box-shadow: 0 4px 12px #00000012;
        }

        .card a {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 20px;
            background: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 7px;
        }

        .card a:hover {
            background: #3730a3;
        }

        .logout {
            display: inline-block;
            margin-top: 30px;
            color: #dc2626;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>CampusCore Admin Portal</h1>

    <p>Welcome, <?= htmlspecialchars($_SESSION["username"], ENT_QUOTES, "UTF-8") ?>!</p>
    <p>Select the practical you want to open.</p>

    <div class="cards">
        <div class="card">
            <h2>Practical 13</h2>
            <p>Student Management using PHP JSON API and Fetch-based CRUD.</p>
            <a href="../PRACTICAL-13/index.php">Open Practical 13</a>
        </div>

        <div class="card">
            <h2>Practical 14</h2>
            <p>Admin dashboard with statistics and audit logs.</p>
            <a href="../PRACTICAL-14/dashboard.php">Open Practical 14</a>
        </div>
    </div>

    <a class="logout" href="logout.php">Logout</a>
</div>
</body>
</html>