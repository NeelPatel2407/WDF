
<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header("Location: index.php?message=" . urlencode("Invalid event ID."));
    exit;
}

$stmt = $conn->prepare("SELECT poster FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();

if (!$event) {
    header("Location: index.php?message=" . urlencode("Event not found."));
    exit;
}

$stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if (!empty($event["poster"])) {
        $posterPath = __DIR__ . "/uploads/" . basename($event["poster"]);

        if (is_file($posterPath)) {
            unlink($posterPath);
        }
    }

    header("Location: index.php?message=" . urlencode("Event deleted successfully."));
    exit;
}

header("Location: index.php?message=" . urlencode("Could not delete the event."));
exit;
?>
