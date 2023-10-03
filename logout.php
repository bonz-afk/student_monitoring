<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
if (isset($_SESSION['user_id'])) {
    session_destroy();
        header("Location: http://localhost/student_monitoring/login.php");
    exit;
}
