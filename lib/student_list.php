<?php

$query = "SELECT *, CONCAT(
                UPPER(SUBSTRING(LASTNAME, 1, 1)), LOWER(SUBSTRING(LASTNAME, 2)),
                ' ',
                UPPER(SUBSTRING(FIRSTNAME, 1, 1)), LOWER(SUBSTRING(FIRSTNAME, 2)),
                ' ',
                UPPER(LEFT(MIDDLENAME, 1)),'.'
            ) as fullname FROM tb_user where STATUS = 'ON' AND ROLE = 'STUDENT'";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die('Database query failed: ' . mysqli_error($mysqli));
}

// Fetch and store the result data as an array
$studentData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $studentData[] = $row;
}


$yearList = "SELECT DISTINCT ACADEMIC_YEAR FROM tb_class";
$resultYear = mysqli_query($mysqli, $yearList);

if (!$resultYear) {
    die('Database query failed: ' . mysqli_error($mysqli));
}

// Fetch and store the result data as an array
$academicYear = array();
while ($row = mysqli_fetch_assoc($resultYear)) {
    $academicYear[] = $row;
}
