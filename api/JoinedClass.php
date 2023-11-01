<?php
include_once $_SERVER['DOCUMENT_ROOT']. '../student_monitoring/lib/client.php';


if(isset($_POST['process'])){
    $classProcess = $_POST['process'];
}

if($classProcess == 'leave'){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $classId = trim($_POST['id']);
        $classStatus = 'OFF';

        $sql = "UPDATE tb_class_enrolled SET STATUS = ? WHERE ID = ?";

        // Create a prepared statement
        $stmtDel = $mysqli->prepare($sql);

        if ($stmtDel === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
            exit;
        }

        // Bind parameters to the statement
        $stmtDel->bind_param("si", $classStatus, $classId);

        // Execute the statement
        if ($stmtDel->execute()) {
            $message = 'Successfully Leave'; // Update message text
            $status = true;
        } else {
            $message = 'Error Leaving class'; // Update message text
            $status = false;
        }

        echo json_encode(['status' => $status, 'message' => $message]);
    } else {
        $error = errorRequest::getErrorMessage(405); // Get the error message for 405 (Method Not Allowed)
        http_response_code(405); // Set the HTTP response code
        echo json_encode(['status' => false, 'error' => $error]);
        exit;
    }

    $stmtDel->close();
}

if($classProcess == 'join'){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $studentId = $_SESSION['user_id'];
        $classStatus = 'PENDING';
        $code = trim($_POST['code']);

        $selectClass = "SELECT id FROM tb_class where CLASS_CODE = '$code' AND STATUS = 'ON'";

        $resultClass = mysqli_query($mysqli, $selectClass);

        if ($resultClass) {
            if (mysqli_num_rows($resultClass) > 0) {
                while ($row = mysqli_fetch_assoc($resultClass)) {
                    $classId = $row['id'];
                }

                $selectClassExisting = "SELECT id FROM tb_class_enrolled where CLASS_ID = $classId AND STUDENT = $studentId";
                $resultClassExisting = mysqli_query($mysqli, $selectClassExisting);

                if (mysqli_num_rows($resultClassExisting) > 0) {
                    while ($row = mysqli_fetch_assoc($resultClassExisting)) {
                        $enrolledId = $row['id'];
                    }

                    $sqlUpdate = "UPDATE tb_class_enrolled SET STATUS = ? WHERE id = ? AND CLASS_ID = ? AND STUDENT = ?";

                    $stmtUpdate = $mysqli->prepare($sqlUpdate);

                    if ($stmtUpdate === false) {
                        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
                        exit;
                    }

                    $stmtUpdate->bind_param("siii", $classStatus, $enrolledId, $classId, $studentId);

                    if ($stmtUpdate->execute()) {
                        $message = 'Successfully Join'; // Update message text
                        $status = true;
                    }
                    else {
                        $message = 'Error Joining class'; // Update message text
                        $status = false;
                    }

                    echo json_encode(['status' => $status, 'message' => $message]);
                }
                else{
                    $insertSql = "INSERT INTO tb_class_enrolled (CLASS_ID,STUDENT,STATUS,CREATED_AT)
                               VALUES  (?,?,?,NOW())";

                    $stmtInsert = $mysqli->prepare($insertSql);

                    if ($stmtInsert === false) {
                        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
                        exit;
                    }

                    $stmtInsert->bind_param("sii", $classId, $studentId, $classStatus);

                    if ($stmtInsert->execute()) {
                        $message = 'Success waiting for Professor / Teacher to accept your request'; // Update message text
                        $status = true;
                    }
                    else {
                        $message = 'Error Joining class'; // Update message text
                        $status = false;
                    }

                    echo json_encode(['status' => $status, 'message' => $message]);
                }
            }
        } else {
            echo "Query failed: " . mysqli_error($mysqli);
        }
//
    }
}

if($classProcess == 'change'){
    if (!empty($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $academic = $_POST['academic'];

        if (empty($academic)) {
            $queryString = "";
        } else {
            $queryString = "AND a.ACADEMIC_YEAR = '$academic'";
        }

        $sql = "SELECT 
            e.id as enrolledId,c.COURSE_CODE as c_code, c.COURSE_DESC,a.CLASS_NAME,a.SECTION,e.STATUS as statusEnroll FROM tb_class_enrolled as e
            LEFT join tb_user as u on u.id = e.STUDENT
            LEFT join tb_class as a on a.id = e.CLASS_ID
            LEFT join tb_course c on c.ID = e.id
            WHERE u.ID = ? AND e.STATUS <> 'OFF' AND c.STATUS = 'ON'  $queryString";

        // Create a prepared statement
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            die('Database query failed: ' . mysqli_error($mysqli));
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $joinClass = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $joinClass[] = $row;
        }
        // Check if any data was found
        if (empty($joinClass)) {
            // No data found, return a message
            $response = array("message" => "No data available.");
        } else {
            // Send the data as JSON response
            header('Content-Type: application/json');
            echo json_encode($joinClass);
        }
    }
}
$mysqli->close();