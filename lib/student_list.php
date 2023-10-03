<?php

$query = 'SELECT * FROM tb_user where STATUS ="ON" AND ROLE = "STUDENT"';
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die('Database query failed: ' . mysqli_error($mysqli));
}

// Fetch and store the result data as an array
$studentData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $studentData[] = $row;
}


