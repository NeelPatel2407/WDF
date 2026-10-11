
<?php
require_once "db.php";

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "POST request required."
    ]);
    exit;
}

$eventId = filter_input(INPUT_POST, "event_id", FILTER_VALIDATE_INT);
$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

if (!$eventId || !$email) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Invalid event or email."
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare(
        "SELECT student_id FROM students WHERE email = ?"
    );
    $stmt->execute([$email]);
    $student = $stmt->fetch();

    if (!$student) {
        http_response_code(404);
        echo json_encode([
            "success" => false,
            "message" => "Student not found."
        ]);
        exit;
    }

    $stmt = $pdo->prepare(
        "INSERT INTO registrations (student_id, event_id)
         VALUES (?, ?)"
    );
    $stmt->execute([$student["student_id"], $eventId]);

    echo json_encode([
        "success" => true,
        "message" => "Registration saved successfully."
    ]);

} catch (PDOException $e) {
    if ($e->getCode() === "23000") {
        http_response_code(409);
        echo json_encode([
            "success" => false,
            "message" => "Already registered for this event."
        ]);
    } else {
        error_log($e->getMessage());
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Unable to save registration."
        ]);
    }
}
?>
