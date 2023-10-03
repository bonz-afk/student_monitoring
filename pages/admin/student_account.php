<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth_user.php';
$current_page = 'account';
$current_dropdown = 'student';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="../../common/css/common.css">
        <link rel="stylesheet" href="../../common/css/nav.css">

        <style>
            .admin-student-container {
                margin-left: 400px; /* Adjust the margin to match the sidebar width */
                transition: margin-left 0.3s; /* Add smooth transition for opening/closing sidebar */
            }
            .student-content{
                width: 100%;
                margin: 100px auto;
                height: 400px;
                overflow-y: auto;
                overflow-x: hidden;
                background-color: transparent;
                max-width: 1522px;
                text-align: center;
            }

            .font-mont{
                font-size: 50px;
            }

            .admin-student-table {
                width: 100%;
                background-color: transparent;
                border-collapse: collapse;
            }

            .admin-student-table th{
                padding: 20px;
                font-size: 20px;
                width: 50%;
            }

            .admin-student-table td {
                padding: 10px; /* Add padding to create spacing */
                font-size: 20px;
                width: 50%;
            }

            .admin-student-table thead,tbody {
                text-align: center;
                padding: 20px 0;
            }
        </style>
        <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
    </head>
    <body>
    <?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
        <div class="admin-student-container">
            <div class="student-content">
                <p class="font-mont">Student List</p>
                <table class="admin-student-table">
                    <thead>
                        <tr>
                            <th>Name of Student</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($studentData as $student){ ?>
                        <tr>
                            <td><?php echo  $student['LASTNAME'].', '.$student['FIRSTNAME'].' '.substr($student['MIDDLENAME'], 0,1); ?></td>
                            <td><i class="fa-solid fa-eye fa-xl"  style="color: #800000;cursor: pointer" ></i> &nbsp; <i class="fa-solid fa-trash fa-xl"  style="color: #800000;cursor: pointer" onclick="adminStudentProcess('delete',<?php echo $student['id']; ?>)"></i></td></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <script src="../../common/js/external/jquery-3.7.1.min.js"></script>
    <script src="../../common/js/common.js"></script>
    <script src="../../common/js/nav.js"></script>
    <script src="../../common/js/external/sweetalert2.min.js"></script>
    <script></script>
    </body>
</html>
