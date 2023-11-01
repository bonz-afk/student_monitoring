<?php

$query = 'SELECT * FROM tb_course WHERE STATUS = "ON" AND COLLEGE_ID = 2';
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die('Database query failed: ' . mysqli_error($mysqli));
}

// Fetch and store the result data as an array
$courseData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $courseData[] = $row;
}

