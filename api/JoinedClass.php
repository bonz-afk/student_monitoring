<?php
include_once $_SERVER['DOCUMENT_ROOT']. '../student_monitoring/lib/client.php';


if(isset($_POST['process'])){
    $classProcess = $_POST['process'];
}

if($classProcess == 'leave'){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $classId = trim($_POST['id']);
        $classStatus = 'OFF';

        $sql = "UPDATE tb_class_enrolled SET STATUS = ? WHERE CLASS_ID IN (SELECT id FROM tb_class where CLASS_CODE = '$classId')";

        // Create a prepared statement
        $stmtDel = $mysqli->prepare($sql);

        if ($stmtDel === false) {
            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
            exit;
        }

        // Bind parameters to the statement
        $stmtDel->bind_param("s", $classStatus);

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

        $checkCode = "SELECT id from tb_class where CLASS_CODE = '$code'";

        $resultCode = mysqli_query($mysqli, $checkCode);
        $checkCodeCount = mysqli_num_rows($resultCode);

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

                    $ids = [];

                    while ($row = mysqli_fetch_assoc($resultCode)) {
                        $ids[] = $row['id'];
                    }

                    $sqlUpdate = "UPDATE tb_class_enrolled SET STATUS = ? WHERE CLASS_ID = ? AND STUDENT = ?";

                    foreach ($ids as $listId) {
                        $stmtUpdate = $mysqli->prepare($sqlUpdate);

                        if ($stmtUpdate === false) {
                            echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
                            exit;
                        }

                        $stmtUpdate->bind_param("sii", $classStatus, $listId,  $studentId);

                        if ($stmtUpdate->execute()) {
                            $message = 'Success waiting for Professor / Teacher to accept your request'; // Update message text
                            $status = true;
                        } else {
                            $message = 'Error Joining class'; // Update message text
                            $status = false;
                            break; // Exit the loop on the first failure
                        }
                    }
                    echo json_encode(['status' => $status, 'message' => $message]);
                }
                else{
                    if ($checkCodeCount) {
                        $ids = [];

                        while ($row = mysqli_fetch_assoc($resultCode)) {
                            $ids[] = $row['id'];
                        }

                        // Prepare the insert statement outside the loop
                        $insertSql = "INSERT INTO tb_class_enrolled (CLASS_ID, STUDENT, STATUS, CREATED_AT) VALUES (?, ?, ?, NOW())";


                        foreach ($ids as $listId) {
                            $stmtInsert = $mysqli->prepare($insertSql);

                            if ($stmtInsert === false) {
                                echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
                                exit;
                            }

                            $stmtInsert->bind_param("iss", $listId, $studentId, $classStatus);

                            if ($stmtInsert->execute()) {
                                $message = 'Success waiting for Professor / Teacher to accept your request'; // Update message text
                                $status = true;
                            } else {
                                $message = 'Error Joining class'; // Update message text
                                $status = false;
                                break; // Exit the loop on the first failure
                            }
                        }

                        // Close the statement
                        $stmtInsert->close();

                        echo json_encode(['status' => $status, 'message' => $message]);
                    }
                }
            }
            else{
                echo json_encode(['status' => false, 'message' => 'No Existing Code']);
                exit;
            }
        }
        else {
            echo "Query failed: " . mysqli_error($mysqli);
        }
    }
}

if($classProcess == 'join_change'){
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
            LEFT join tb_course c on c.COURSE_CODE = a.COURSE_CODE
            WHERE u.ID = ? AND e.STATUS <> 'OFF' AND c.STATUS = 'ON' $queryString
            GROUP BY a.CLASS_NAME";

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