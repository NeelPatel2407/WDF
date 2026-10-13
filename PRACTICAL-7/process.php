<?php

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: registration.php");
    exit();
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$course = trim($_POST["course"] ?? "");
$message = trim($_POST["message"] ?? "");

$errors = [];

if ($name == "") {
    $errors[] = "Name is required.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Enter a valid email address.";
}

if (!preg_match("/^[0-9]{10}$/", $phone)) {
    $errors[] = "Phone number must contain exactly 10 digits.";
}

$courses = ["CSE", "IT", "ECE", "Mechanical"];

if (!in_array($course, $courses)) {
    $errors[] = "Please select a valid course.";
}

$name = htmlspecialchars($name);
$email = htmlspecialchars($email);
$phone = htmlspecialchars($phone);
$course = htmlspecialchars($course);
$message = htmlspecialchars($message);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Result</title>
    <link rel="stylesheet" href="registration.css">

    <style>
        .result {
            text-align: center;
        }

        .success {
            color: #15803d;
        }

        .error {
            color: #dc2626;
        }

        .result p {
            line-height: 1.6;
        }

        .result a {
            display: inline-block;
            margin-top: 15px;
            padding: 11px 20px;
            background: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 7px;
        }
    </style>
</head>

<body>

<div class="page">

    <header>
        <div class="logo">CampusCore</div>
        <p>Student Registration Portal</p>
    </header>

    <main>

        <div class="form-container result">

<?php

if (!empty($errors)) {

    echo "<h2 class='error'>Registration Failed</h2>";

    foreach ($errors as $error) {
        echo "<p class='error'>$error</p>";
    }

    echo '<a href="registration.php">Try Again</a>';

} else {

    $file = "registrations.csv";

    $handle = fopen($file, "a");

    if ($handle) {

        if (filesize($file) == 0) {
            fputcsv($handle, [
                "Name",
                "Email",
                "Phone",
                "Course",
                "Message"
            ]);
        }

        fputcsv($handle, [
            $name,
            $email,
            $phone,
            $course,
            $message
        ]);

        fclose($handle);

        echo "<h2 class='success'>Registration Successful!</h2>";
        echo "<p>Your details have been saved successfully.</p>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Course:</strong> $course</p>";

        echo '<a href="registration.php">Register Another Student</a>';

    } else {

        echo "<h2 class='error'>Storage Error</h2>";
        echo "<p>Unable to save the registration data.</p>";
    }
}

?>

        </div>

    </main>

    <footer>
        © 2026 CHARUSAT | CampusCore Student Portal
    </footer>

</div>

</body>
</html>