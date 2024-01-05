<?php

include_once $_SERVER['DOCUMENT_ROOT']. '../student_monitoring/lib/client.php';
$user = $_SESSION['user_id'];

$holidays = array(
    "01-01" => "New Year's Day",
    "07-04" => "Independence Day",
    "12-25" => "Christmas Day",
    "11-05" => "Holiday asdasdasd Day",
    // Add more holidays as needed
);

$currentDate = date("m-d");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $term = $_POST['term'];
    $status = 'P';
    $currentDate = date('Y-m-d');
    $explodedValues = explode("| ", $id);
//
//    if (date('w') == 0) {
//        echo json_encode(['status' => false, 'message' => 'Sunday No Attendance']);
//        exit;
//    }

    if (array_key_exists($currentDate, $holidays)) {
        echo json_encode(['status' => false, 'message' => $holidays[$currentDate] . ". It's a holiday."]);
        exit;
    }

    $explodedValues = array_map('trim', $explodedValues);
    if (count($explodedValues) == 2) {
        [$code, $type] = $explodedValues;
    } else {
        echo json_encode(['status' => false, 'message' => "Invalid Lec Lab"]);
    }

    $queryScore = "SELECT TIME_IN from tb_attendance
                            where STUDENT_ID = $user AND CLASS_CODE = '$code' AND TYPE = '$type'  AND DATE(TIME_IN) = '$currentDate'";

    $resultScore = mysqli_query($mysqli, $queryScore);
//
//    if (mysqli_num_rows($resultScore) > 0) {
//        echo json_encode(['status' => false, 'message' => 'Attendance is Already Recorded']);
//        exit;
//    }

    $sql = "INSERT INTO tb_attendance (STUDENT_ID,CLASS_CODE,TIME_IN,STATUS,TERM,TYPE) VALUES ($user,?,NOW(),?,?,'$type')";

// Create a prepared statement
    $stmtAdd = $mysqli->prepare($sql);

    if ($stmtAdd === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error ]);
        exit;
    }

// Bind parameters to the statement
    $stmtAdd->bind_param("ssi", $code,$status,$term);

// Execute the statement to insert data
    if ($stmtAdd->execute()) {
        $message = 'Successfully Attended';
        $status = true;

    } else {
        $message = errorRequest::getErrorMessage(500);
        $status = false;
    }

    echo json_encode(['status' => $status, 'message' => $message]);

}else{
    $error = errorRequest::getErrorMessage(405); // Get the error message for 405 (Method Not Allowed)
    http_response_code(405); // Set the HTTP response code
    echo json_encode(['status' => false,'message' => $error]);
    exit;
}

$stmtAdd->close();
$mysqli->close();