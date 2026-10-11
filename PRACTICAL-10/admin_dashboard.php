<?php
require_once __DIR__ . "/auth.php";
requireRole("admin");

header("Location: ../PRACTICAL-13/index.php");
exit;
?>