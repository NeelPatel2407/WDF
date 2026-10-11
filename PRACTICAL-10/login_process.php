
<?php
session_start();

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

if ($username === "" || $password === "") {
    $_SESSION["login_error"] = "Please enter username and password.";
    header("Location: login.php");
    exit;
}

$sql = "SELECT user_id, username, email, password, role
        FROM users
        WHERE username = ? OR email = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $username);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !password_verify($password, $user["password"])) {
    $_SESSION["login_error"] = "Invalid username or password.";
    header("Location: login.php");
    exit;
}

if (!in_array($user["role"], ["student", "admin"], true)) {
    $_SESSION["login_error"] = "Invalid account role.";
    header("Location: login.php");
    exit;
}

session_regenerate_id(true);

$_SESSION["user_id"] = $user["user_id"];
$_SESSION["username"] = $user["username"];
$_SESSION["role"] = $user["role"];
$_SESSION["last_activity"] = time();

$stmt->close();
$conn->close();



if ($user["role"] === "admin") {
    header("Location: admin_dashboard.php");
} elseif ($user["role"] === "student") {
    header("Location: http://127.0.0.1:5500/PRACTICAL-2/dashboard.html");
} else {
    $_SESSION["login_error"] = "Invalid account role.";
    header("Location: login.php");
}
exit;

?>
