<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (empty($_SESSION['user_id'])) {
    header("Location: http://localhost/student_monitoring/login.php");
    // Use the header function to redirect
    exit; // Terminate script execution after redirection
}
