<?php
include_once $_SERVER['DOCUMENT_ROOT']. '../student_monitoring/lib/client.php';

$courseID = $_POST['courseID'];

$query = "SELECT * FROM tb_course WHERE ID = $courseID";
$result = mysqli_query($mysqli, $query);

if (!$result) {
    echo json_encode(['status' => false, 'message' => 'Error in statement: ' . $mysqli->error]);
} else {
    $courseData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $courseData[] = $row;
    }
    echo json_encode(['status' => true, 'courseData' => $courseData]);
}

// Close the database connection
$mysqli->close();
