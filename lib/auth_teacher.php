<?php

if($_SESSION['role'] == 'STUDENT'){
    header('location:  http://localhost/student_monitoring/pages/student');
    exit();
}