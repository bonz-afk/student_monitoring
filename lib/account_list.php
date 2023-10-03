<?php

$query = 'SELECT * FROM tb_account where TYPE != "ADMIN"';
$result = mysqli_query($mysqli, $query);

if (!$result) {
    die('Database query failed: ' . mysqli_error($mysqli));
}

// Fetch and store the result data as an array
$accountData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $accountData[] = $row;
}

