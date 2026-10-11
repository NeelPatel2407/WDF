<?php
require_once "db.php";

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");

try {
    $stmt = $pdo->prepare(
        "SELECT event_id, event_name, event_date,
                venue, category, description
         FROM events
         ORDER BY event_date"
    );

    $stmt->execute();
    $events = $stmt->fetchAll();

    $result = [];

    foreach ($events as $event) {
        $result[] = [
            "id" => $event["event_id"],
            "title" => $event["event_name"],
            "date" => $event["event_date"],
            "venue" => $event["venue"],
            "category" => $event["category"],
            "description" => $event["description"] ?? ""
        ];
    }

    echo json_encode($result);

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);

    echo json_encode([
        "error" => "Unable to load events."
    ]);
}
?>