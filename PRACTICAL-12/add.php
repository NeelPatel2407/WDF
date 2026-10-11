
<?php
require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $event_date = $_POST["event_date"] ?? "";
    $category = trim($_POST["category"] ?? "");
    $status = $_POST["status"] ?? "Open";
    $venue = trim($_POST["venue"] ?? "");
    $posterName = null;

    if (
        $title === "" || $description === "" ||
        $event_date === "" || $category === "" ||
        $venue === "" || !in_array($status, ["Open", "Closed"], true)
    ) {
        $error = "Please fill in all fields correctly.";
    } elseif (!empty($_FILES["poster"]["name"])) {
        $file = $_FILES["poster"];

        if ($file["error"] !== UPLOAD_ERR_OK) {
            $error = "Poster upload failed.";
        } elseif ($file["size"] > 2 * 1024 * 1024) {
            $error = "Poster size must be 2 MB or less.";
        } else {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file["tmp_name"]);

            $allowed = [
                "image/jpeg" => "jpg",
                "image/png" => "png",
                "image/webp" => "webp"
            ];

            $imageInfo = getimagesize($file["tmp_name"]);

            if (
                !isset($allowed[$mime]) ||
                $imageInfo === false ||
                $imageInfo["mime"] !== $mime
            ) {
                $error = "Only valid JPG, PNG, and WebP images are allowed.";
            } else {
                $uploadDir = __DIR__ . "/uploads/";

                if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                    $error = "Could not create the upload directory.";
                } elseif (!is_writable($uploadDir)) {
                    $error = "The upload directory is not writable.";
                } else {
                    $posterName = bin2hex(random_bytes(16)) . "." . $allowed[$mime];

                    if (!move_uploaded_file(
                        $file["tmp_name"],
                        $uploadDir . $posterName
                    )) {
                        $error = "Could not save the poster.";
                    }
                }
            }
        }
    }

    if ($error === "") {
        $stmt = $conn->prepare(
            "INSERT INTO events (title, description, event_date, category, status, poster)
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssssss",
            $title,
            $description,
            $event_date,
            $category,
            $status,
            $posterName
        );

        if ($stmt->execute()) {
            header("Location: index.php?message=" . urlencode("Event added successfully!"));
            exit;
        }

        if ($posterName !== null && is_file(__DIR__ . "/uploads/" . $posterName)) {
            unlink(__DIR__ . "/uploads/" . $posterName);
        }

        $error = "Could not add the event.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event - CampusCore</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .event-form {
            max-width: 650px;
            margin: 25px auto;
            padding: 25px;
            background: white;
            border: 1px solid #fed7aa;
            border-radius: 13px;
            box-shadow: 0 8px 24px rgba(154,52,18,.1);
        }

        .event-form label {
            display: block;
            margin: 15px 0 7px;
            color: #9a3412;
            font-weight: bold;
        }

        .event-form input,
        .event-form select,
        .event-form textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #fed7aa;
            border-radius: 7px;
            font: inherit;
        }

        .event-form textarea {
            min-height: 110px;
            resize: vertical;
        }

        .error {
            padding: 12px;
            margin: 15px 0;
            color: #991b1b;
            background: #fee2e2;
            border-radius: 8px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 22px;
        }
    </style>
</head>
<body>

<div class="topbar">
    <h2>CampusCore</h2>
    <nav>
        <a href="index.php">Events</a>
    </nav>
</div>

<div class="container">
    <h1>Add Campus Event</h1>

    <form class="event-form" method="POST" enctype="multipart/form-data">

        <?php if ($error !== ""): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <label for="title">Event Title</label>
        <input id="title" name="title" required
               value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">

        <label for="description">Description</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>

        <label for="event_date">Event Date</label>
        <input type="date" id="event_date" name="event_date" required
               value="<?= htmlspecialchars($_POST['event_date'] ?? '') ?>">

        <label for="venue">Venue</label>
        <input id="venue" name="venue" required
               value="<?= htmlspecialchars($_POST['venue'] ?? '') ?>">

        <label for="category">Category</label>
        <select id="category" name="category" required>
            <option value="">Select Category</option>
            <?php foreach (["Technical", "Cultural", "Sports", "Workshop", "Other"] as $item): ?>
                <option value="<?= $item ?>"
                    <?= ($_POST['category'] ?? '') === $item ? 'selected' : '' ?>>
                    <?= $item ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="status">Event Status</label>
        <select id="status" name="status">
            <option value="Open" <?= ($_POST['status'] ?? 'Open') === 'Open' ? 'selected' : '' ?>>Open</option>
            <option value="Closed" <?= ($_POST['status'] ?? '') === 'Closed' ? 'selected' : '' ?>>Closed</option>
        </select>

        <label for="poster">Event Poster (JPG, PNG, WebP; max 2 MB)</label>
        <input type="file" id="poster" name="poster"
               accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

        <div class="form-actions">
            <button type="submit">Save Event</button>
            <a href="index.php" class="reset">Cancel</a>
        </div>
    </form>
</div>

<p class="footer">
    © 2026 Charotar University of Science &amp; Technology. All Rights Reserved
</p>

</body>
</html>
