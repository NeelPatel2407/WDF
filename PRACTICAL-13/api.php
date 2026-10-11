<?php
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . "/../PRACTICAL-10/auth.php";

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    echo json_encode(["error" => "Please log in first"]);
    exit;
}

try {
    requireRole("admin");
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(["error" => "Authentication error"]);
    exit;
}

require_once __DIR__ . "/db.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    $result = $conn->query(
        "SELECT * FROM students ORDER BY id ASC"
    );

    $students = [];

    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    echo json_encode($students);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid JSON data"]);
    exit;
}

if ($method === "POST") {
    $name = trim($data["name"] ?? "");
    $email = trim($data["email"] ?? "");
    $course = trim($data["course"] ?? "");

    if ($name === "" || $email === "" || $course === "") {
        http_response_code(400);
        echo json_encode(["error" => "All fields are required"]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid email address"]);
        exit;
    }

    $stmt = $conn->prepare(
        "INSERT INTO students (name, email, course) VALUES (?, ?, ?)"
    );

    $stmt->bind_param("sss", $name, $email, $course);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode([
            "message" => "Student added successfully",
            "id" => $conn->insert_id
        ]);
    } else {
        http_response_code(409);
        echo json_encode([
            "error" => "Email already exists or could not be added"
        ]);
    }

    exit;
}

if ($method === "PUT") {
    $id = filter_var(
        $data["id"] ?? null,
        FILTER_VALIDATE_INT
    );

    $name = trim($data["name"] ?? "");
    $email = trim($data["email"] ?? "");
    $course = trim($data["course"] ?? "");

    if (!$id || $id < 1 || $name === "" ||
        $email === "" || $course === "") {
        http_response_code(400);
        echo json_encode([
            "error" => "Valid ID and all fields are required"
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid email address"]);
        exit;
    }

    $stmt = $conn->prepare(
        "UPDATE students
         SET name = ?, email = ?, course = ?
         WHERE id = ?"
    );

    $stmt->bind_param("sssi", $name, $email, $course, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                "message" => "Student updated successfully"
            ]);
        } else {
            $check = $conn->prepare(
                "SELECT id FROM students WHERE id = ?"
            );

            $check->bind_param("i", $id);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                echo json_encode([
                    "message" => "No changes were made"
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "error" => "Student not found"
                ]);
            }
        }
    } else {
        http_response_code(409);
        echo json_encode([
            "error" => "Email already exists or update failed"
        ]);
    }

    exit;
}

if ($method === "DELETE") {
    $id = filter_var(
        $data["id"] ?? null,
        FILTER_VALIDATE_INT
    );

    if (!$id || $id < 1) {
        http_response_code(400);
        echo json_encode([
            "error" => "Valid student ID is required"
        ]);
        exit;
    }

    $stmt = $conn->prepare(
        "DELETE FROM students WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "message" => "Student deleted successfully"
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            "error" => "Student not found"
        ]);
    }

    exit;
}

http_response_code(405);
echo json_encode(["error" => "Method not allowed"]);
?>