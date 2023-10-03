<?php
if($_SESSION['role'] != 'ADMIN'){
        header('location:  http://localhost/student_monitoring/index.php');
    exit();
}