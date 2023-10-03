<?php
include_once $_SERVER['DOCUMENT_ROOT']. '../student_monitoring/lib/client.php';

$email = trim($_POST['email']);
$pass = trim($_POST['password']);
$role = trim($_POST['type']);
$fname = strtoupper(trim($_POST['fname']));
$mname = strtoupper(trim($_POST['mname']));
$lname = strtoupper(trim($_POST['lname']));


$inputPasswordHash = strtoupper(hash('sha256', 'bonz'.$pass));

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $query = "SELECT email FROM tb_user WHERE email = '$email'";

// Execute the query
        $result = mysqli_query($mysqli, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                echo json_encode(['status' => false, 'message' => 'Email Already Exist']);
                exit;
            }
        } else {
            echo json_encode(['status' => false, 'message' => mysqli_error($mysqli).'1']);
            exit;
        }


        $sql = "INSERT INTO tb_user (email, password, role, CREATED_AT, STATUS, FIRSTNAME, MIDDLENAME, LASTNAME) VALUES (?, ?, ?, NOW(), 'ON', ?, ? , ?)";

    // Create a prepared statement
        $stmtAdd = $mysqli->prepare($sql);

        if ($stmtAdd === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error ]);
            exit;
        }

    // Bind parameters to the statement
        $stmtAdd->bind_param("ssssss", $email, $inputPasswordHash,$role,$fname,$mname,$lname);

    // Execute the statement to insert data
        if ($stmtAdd->execute()) {
            $message = 'Successfully Added';
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