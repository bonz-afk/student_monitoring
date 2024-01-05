<?php

include_once $_SERVER['DOCUMENT_ROOT']. '../student_monitoring/lib/client.php';
$user = $_SESSION['user_id'];
$process = $_POST['process'];


if($process == 'quiz-exam'){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $class = trim($_POST['classId']);
        $score = trim($_POST['score']);
        $term = trim($_POST['term']);
        $examDate = trim($_POST['examDate']);
        $type = trim($_POST['type']);

        $explodedValues = explode("| ", $class);


        $explodedValues = array_map('trim', $explodedValues);
        if (count($explodedValues) == 2) {
            [$code, $classType] = $explodedValues;
        } else {
            echo json_encode(['status' => false, 'message' => "Invalid Lec Lab"]);
        }

        $queryScore = "SELECT EXAM_DATE from tb_score
                            where STUDENT_ID = $user AND CLASS_CODE = '$code' AND CLASS_TYPE = '$classType' AND EXAM_DATE = '$examDate'";

        $resultScore = mysqli_query($mysqli, $queryScore);

        if (mysqli_num_rows($resultScore) > 0) {
            echo json_encode(['status' => false, 'message' => 'Score is Already Recorded']);
            exit;
        }

        if ($type === 'PE' || $type === 'ME' || $type === 'SE' || $type === 'FE') {
            // Check if the type exists in the database
            $checkTypeQuery = "SELECT COUNT(*) as typeCount FROM tb_score 
                where STUDENT_ID = $user AND CLASS_CODE = '$code' AND CLASS_TYPE = '$classType' AND TERM = $term";
            $checkTypeResult = mysqli_query($mysqli, $checkTypeQuery);

            if (!$checkTypeResult) {
                echo json_encode(['status' => false, 'message' => 'Error checking type: ' . mysqli_error($mysqli)]);
                exit;
            }

            $typeCount = mysqli_fetch_assoc($checkTypeResult)['typeCount'];

            if ($typeCount > 0) {
                // The type already exists, send an alert or handle accordingly
                echo json_encode(['status' => false, 'message' => 'Score is Already Recorded']);
                exit;
            }
        }

        $sql = "INSERT INTO tb_score (CLASS_CODE,STUDENT_ID,TYPE,SCORE,TERM,EXAM_DATE,CREATED_DATE,CLASS_TYPE) VALUES (?,?,?,?,?,?,NOW(),'$classType')";

// Create a prepared statement
        $stmtAdd = $mysqli->prepare($sql);

        if ($stmtAdd === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error ]);
            exit;
        }

// Bind parameters to the statement
        $stmtAdd->bind_param("sisiss", $code,$user, $type, $score, $term, $examDate);

// Execute the statement to insert data
        if ($stmtAdd->execute()) {
            $message = 'Score Added';
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
}

if($process == 'activity-others'){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $class = trim($_POST['classId']);
        $score = trim($_POST['score']);
        $term = trim($_POST['term']);
        $examDate = trim($_POST['examDate']);
        $type = trim($_POST['type']);

        $explodedValues = explode("| ", $class);

        $explodedValues = array_map('trim', $explodedValues);
        if (count($explodedValues) == 2) {
            [$code, $classType] = $explodedValues;
        } else {
            echo json_encode(['status' => false, 'message' => "Invalid Lec Lab"]);
        }

        $queryScore = "SELECT EXAM_DATE from tb_score
                            where STUDENT_ID = $user AND CLASS_CODE = '$code' AND CLASS_TYPE = '$type' AND EXAM_DATE = '$examDate'";

        $resultScore = mysqli_query($mysqli, $queryScore);

        if (mysqli_num_rows($resultScore) > 0) {
            echo json_encode(['status' => false, 'message' => 'Score is Already Recorded']);
            exit;
        }

        $sql = "INSERT INTO tb_score (CLASS_CODE,STUDENT_ID,TYPE,SCORE,TERM,EXAM_DATE,CREATED_DATE,CLASS_TYPE) VALUES (?,?,?,?,?,?,NOW(),'$classType')";

// Create a prepared statement
        $stmtAddAct = $mysqli->prepare($sql);

        if ($stmtAddAct === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error ]);
            exit;
        }

// Bind parameters to the statement
        $stmtAddAct->bind_param("sisiss", $code,$user, $type, $score, $term, $examDate);

// Execute the statement to insert data
        if ($stmtAddAct->execute()) {
            $message = 'Score Added';
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

    $stmtAddAct->close();
}

$mysqli->close();