
<?php
require_once "db.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    exit("Invalid event ID.");
}

$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();

if (!$event) {
    exit("Event not found.");
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $event_date = $_POST["event_date"] ?? "";
    $venue = trim($_POST["venue"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $status = $_POST["status"] ?? "";
    $posterName = $event["poster"];

    if (
        $title === "" || $description === "" ||
        $event_date === "" || $venue === "" ||
        $category === "" ||
        !in_array($status, ["Open", "Closed"], true)
    ) {
        $error = "Please fill in all fields correctly.";
    } elseif (
        !DateTime::createFromFormat("!Y-m-d", $event_date) ||
        DateTime::createFromFormat("!Y-m-d", $event_date)->format("Y-m-d") !== $event_date
    ) {
        $error = "Please enter a valid event date.";
    }

    if ($error === "" && !empty($_FILES["poster"]["name"])) {
        $file = $_FILES["poster"];

        if ($file["error"] !== UPLOAD_ERR_OK) {
            $error = "Poster upload failed.";
        } elseif ($file["size"] > 2 * 1024 * 1024) {
            $error = "Poster must be 2 MB or less.";
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
                    $error = "Could not create the uploads folder.";
                } elseif (!is_writable($uploadDir)) {
                    $error = "The uploads folder is not writable.";
                } else {
                    $newPoster = bin2hex(random_bytes(16)) . "." . $allowed[$mime];

                    if (move_uploaded_file($file["tmp_name"], $uploadDir . $newPoster)) {
                        $posterName = $newPoster;
                    } else {
                        $error = "Could not save the new poster.";
                    }
                }
            }
        }
    }

    if ($error === "") {
        $stmt = $conn->prepare(
            "UPDATE events
             SET title = ?, description = ?, event_date = ?,
                 venue = ?, category = ?, status = ?, poster = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "sssssssi",
            $title,
            $description,
            $event_date,
            $venue,
            $category,
            $status,
            $posterName,
            $id
        );

        if ($stmt->execute()) {
            if (
                $posterName !== $event["poster"] &&
                !empty($event["poster"])
            ) {
                $oldPath = __DIR__ . "/uploads/" . basename($event["poster"]);

                if (is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            header("Location: index.php?message=" . urlencode("Event updated successfully!"));
            exit;
        }

        if (
            $posterName !== $event["poster"] &&
            $posterName !== null
        ) {
            $newPath = __DIR__ . "/uploads/" . basename($posterName);

            if (is_file($newPath)) {
                unlink($newPath);
            }
        }

        $error = "Could not update the event.";
    }

    $event["title"] = $title;
    $event["description"] = $description;
    $event["event_date"] = $event_date;
    $event["venue"] = $venue;
    $event["category"] = $category;
    $event["status"] = $status;
    $event["poster"] = $posterName;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - CampusCore</title>
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

        .current-poster {
            width: 150px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
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
    <h1>Edit Campus Event</h1>

    <form class="event-form" method="POST" enctype="multipart/form-data">

        <?php if ($error !== ""): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <label for="title">Event Title</label>
        <input id="title" name="title" required
               value="<?= htmlspecialchars($event["title"]) ?>">

        <label for="description">Description</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($event["description"]) ?></textarea>

        <label for="event_date">Event Date</label>
        <input type="date" id="event_date" name="event_date" required
               value="<?= htmlspecialchars($event["event_date"]) ?>">

        <label for="venue">Venue</label>
        <input id="venue" name="venue" required
               value="<?= htmlspecialchars($event["venue"] ?? "Campus") ?>">

        <label for="category">Category</label>
        <select id="category" name="category" required>
            <?php foreach (["Technical", "Cultural", "Sports", "Workshop", "Other"] as $item): ?>
                <option value="<?= $item ?>"
                    <?= $event["category"] === $item ? "selected" : "" ?>>
                    <?= $item ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="status">Status</label>
        <select id="status" name="status">
            <option value="Open" <?= $event["status"] === "Open" ? "selected" : "" ?>>Open</option>
            <option value="Closed" <?= $event["status"] === "Closed" ? "selected" : "" ?>>Closed</option>
        </select>

        <?php if (!empty($event["poster"])): ?>
            <label>Current Poster</label>
            <img class="current-poster"
                 src="uploads/<?= rawurlencode(basename($event["poster"])) ?>"
                 alt="Current event poster">
        <?php endif; ?>

        <label for="poster">Replace Poster (optional, max 2 MB)</label>
        <input type="file" id="poster" name="poster"
               accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

        <div class="form-actions">
            <button type="submit">Update Event</button>
            <a href="index.php" class="reset">Cancel</a>
        </div>
    </form>
</div>

<p class="footer">
    © 2026 Charotar University of Science &amp; Technology. All Rights Reserved
</p>

</body>
</html>
