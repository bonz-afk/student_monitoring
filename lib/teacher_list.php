<?php

$query = 'SELECT * FROM tb_user where STATUS ="ON" AND ROLE = "TEACHER"';
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die('Database query failed: ' . mysqli_error($mysqli));
}

// Fetch and store the result data as an array
$teacherData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $teacherData[] = $row;
}


