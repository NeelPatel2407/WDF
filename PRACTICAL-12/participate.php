
<?php
require_once "db.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = filter_input(INPUT_POST, "event_id", FILTER_VALIDATE_INT);
}

if (!$id || $id < 1) {
    exit("Invalid event ID.");
}

$stmt = $conn->prepare("SELECT id, title, event_date, venue, status FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();

if (!$event) {
    exit("Event not found.");
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($event["status"] !== "Open") {
        $error = "Registration for this event is closed.";
    } elseif ($name === "" || strlen($name) > 100) {
        $error = "Enter a name of up to 100 characters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
        $error = "Enter a valid email address.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO event_registrations(event_id, event_name, student_name, email)
            VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("isss", $id, $event["title"], $name, $email);


        if ($stmt->execute()) {
            $success = "Registration successful! You are registered for this event.";
        } elseif ($stmt->errno === 1062) {
            $error = "This email is already registered for this event.";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration - CampusCore</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .registration-form {
            max-width: 550px;
            margin: 25px auto;
            padding: 25px;
            background: white;
            border: 1px solid #fed7aa;
            border-radius: 14px;
            box-shadow: 0 5px 16px rgba(154,52,18,.1);
        }

        .registration-form label {
            display: block;
            margin: 16px 0 7px;
            color: #9a3412;
            font-weight: bold;
        }

        .registration-form input {
            width: 100%;
        }

        .registration-form button {
            margin-top: 20px;
        }

        .form-message {
            padding: 12px;
            border-radius: 8px;
            margin: 15px 0;
        }

        .form-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .form-success {
            background: #dcfce7;
            color: #166534;
        }
    </style>
</head>
<body>

<div class="topbar">
    <h2>CampusCore</h2>
    <nav>
        <a href="index.php">Back to Events</a>
    </nav>
</div>

<div class="container">
    <h1>Event Registration</h1>

    <form class="registration-form" method="POST">
        <h2><?= htmlspecialchars($event["title"], ENT_QUOTES, "UTF-8") ?></h2>

        <p>
            <strong>Date:</strong>
            <?= date("d M Y", strtotime($event["event_date"])) ?>
        </p>

        <p>
            <strong>Venue:</strong>
            <?= htmlspecialchars($event["venue"] ?? "Campus", ENT_QUOTES, "UTF-8") ?>
        </p>

        <?php if ($error !== ""): ?>
            <div class="form-message form-error">
                <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
            </div>
        <?php endif; ?>

        <?php if ($success !== ""): ?>
            <div class="form-message form-success">
                <?= htmlspecialchars($success, ENT_QUOTES, "UTF-8") ?>
            </div>
        <?php endif; ?>

        <?php if ($event["status"] === "Open" && $success === ""): ?>
            <input type="hidden" name="event_id" value="<?= (int)$event["id"] ?>">

            <label for="name">Student Name</label>
            <input
                type="text"
                id="name"
                name="name"
                maxlength="100"
                required
                value="<?= htmlspecialchars($_POST["name"] ?? "", ENT_QUOTES, "UTF-8") ?>"
            >

            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                maxlength="150"
                required
                value="<?= htmlspecialchars($_POST["email"] ?? "", ENT_QUOTES, "UTF-8") ?>"
            >

            <button type="submit">Submit Registration</button>
        <?php elseif ($event["status"] !== "Open"): ?>
            <p class="closed">Registration is closed for this event.</p>
        <?php endif; ?>
    </form>
</div>

<p class="footer">
    © 2026 Charotar University of Science &amp; Technology. All Rights Reserved
</p>

</body>
</html>
