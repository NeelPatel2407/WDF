
<?php
if (session_status() === PHP_SESSION_NONE) {
    ini_set("session.use_strict_mode", "1");

    session_set_cookie_params([
        "lifetime" => 0,
        "path" => "/",
        "secure" => !empty($_SERVER["HTTPS"]) &&
                    $_SERVER["HTTPS"] !== "off",
        "httponly" => true,
        "samesite" => "Lax"
    ]);

    session_start();
}

function requireLogin(): void
{
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit;
    }

    if (
        !isset($_SESSION["last_activity"]) ||
        time() - $_SESSION["last_activity"] > 900
    ) {
        $_SESSION = [];
        session_destroy();

        header("Location: timeout.php");
        exit;
    }

    $_SESSION["last_activity"] = time();
}

function requireRole(string $role): void
{
    requireLogin();

    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== $role) {
        http_response_code(403);
        exit("403 Forbidden: You are not authorized to access this page.");
    }
}
?>
