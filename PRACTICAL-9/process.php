
<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: register.php");
    exit;
}

$firstName = trim($_POST["firstName"] ?? "");
$lastName = trim($_POST["lastName"] ?? "");
$username = trim($_POST["username"] ?? "");
$email = trim($_POST["email"] ?? "");
$mobile = trim($_POST["mobile"] ?? "");
$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirmPassword"] ?? "";
$course = trim($_POST["course"] ?? "");
$year = trim($_POST["year"] ?? "");
$gender = $_POST["gender"] ?? "";
$terms = $_POST["terms"] ?? "";

$errors = [];

if (!preg_match("/^[A-Za-z ]{1,50}$/", $firstName)) {
    $errors[] = "Enter a valid first name.";
}

if (!preg_match("/^[A-Za-z ]{1,50}$/", $lastName)) {
    $errors[] = "Enter a valid last name.";
}

if (!preg_match("/^[A-Za-z0-9_]{3,50}$/", $username)) {
    $errors[] = "Username must contain 3-50 letters, numbers or underscores.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
    $errors[] = "Enter a valid email address.";
}

if (!preg_match("/^[0-9]{10}$/", $mobile)) {
    $errors[] = "Mobile number must contain exactly 10 digits.";
}

if (
    strlen($password) < 8 ||
    strlen($password) > 16 ||
    !preg_match("/[A-Z]/", $password) ||
    !preg_match("/[a-z]/", $password) ||
    !preg_match("/[0-9]/", $password) ||
    !preg_match('/[!@#$%^&*(),.?":{}|<>_\-]/', $password)
) {
    $errors[] = "Password must be 8-16 characters and include uppercase, lowercase, a number and a special character.";
}

if ($password !== $confirmPassword) {
    $errors[] = "Passwords do not match.";
}

if (!in_array($course, ["B.Tech CSE", "B.Tech IT", "B.Tech CE"], true)) {
    $errors[] = "Select a valid course.";
}

if (!in_array($year, [
    "First Year", "Second Year", "Third Year", "Fourth Year"
], true)) {
    $errors[] = "Select a valid year.";
}

if (!in_array($gender, ["Male", "Female", "Other"], true)) {
    $errors[] = "Select a valid gender.";
}

if ($terms !== "yes") {
    $errors[] = "You must accept the Terms and Conditions.";
}


if (!empty($errors)) {
    http_response_code(400);

    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration Error - CampusCore</title>
        <link rel="stylesheet" href="message.css">
    </head>
    <body>
        <div class="message-container">
            <header class="message-header">
                <h1>CampusCore</h1>
                <p>CHARUSAT Student Portal</p>
            </header>
            <main class="message-content">
                <h2>Registration Unsuccessful</h2>
                <p>Please correct the following issues and try again.</p>
                <ul class="error-list">';

    foreach ($errors as $error) {
        echo '<li>' .
            htmlspecialchars($error, ENT_QUOTES, "UTF-8") .
            '</li>';
    }

    echo '</ul>
            <center>
                <a class="message-button" href="register.php">
                    Back to Registration
                </a>
            </center>
            </main>
            <footer class="message-footer">
                © 2026 Charotar University of Science & Technology
            </footer>
        </div>
    </body>
    </html>';

    exit;
}

try {
    $check = $conn->prepare(
        "SELECT user_id FROM users WHERE username = ? OR email = ?"
    );
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->close();

        echo "<h2>Registration failed</h2>";
        echo "<p>That username or email is already registered.</p>";
        echo "<p><a href='register.php'>Try again</a></p>";
        exit;
    }

    $check->close();

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO users
        (first_name, last_name, username, email, mobile, password, course, study_year, gender)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssssssss",
        $firstName,
        $lastName,
        $username,
        $email,
        $mobile,
        $passwordHash,
        $course,
        $year,
        $gender
    );

    
        $stmt->execute();
        $stmt->close();
        $conn->close();

        echo "<script>
            alert('Your registration is done! Now login.');
            window.location.href = 'http://localhost/WDF/PRACTICAL-10/login.php';
        </script>";
        exit;


} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());

    if (isset($stmt)) {
        $stmt->close();
    }

    $conn->close();

    if ($e->getCode() === 1062) {
        echo "<h2>Registration failed</h2>";
        echo "<p>That username or email is already registered.</p>";
        echo "<p><a href='register.php'>Try again</a></p>";
    } else {
        http_response_code(500);
        echo "Something went wrong. Please try again later.";
    }
}
?>
