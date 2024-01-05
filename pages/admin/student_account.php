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
        <link rel="stylesheet" href="../../common/css/modal.css">
        <link rel="stylesheet" href="../../common/css/admin/student_account.css">

        <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
    </head>
    <body>
    <?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
        <div class="admin-student-container">
            <div class="student-content">
                <p class="font-mont">Student List</p>
                <div class="table-container">
                    <table class="admin-student-table">
                        <thead>
                        <tr>
                            <th>
                                <div class="sorting">
                                    <img src="../../common/images/logo/dropdown-logo.svg" class="button-content-item" width="50" height="50" onclick="sort('student-account')">
                                    <span>Name of Student</span>
                                </div>
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($studentData as $student){ ?>
                            <tr>
                                <td id="fullval<?php echo $student['id']; ?>" data-fullname="<?php echo  $student['fullname']; ?>"><?php echo  $student['fullname']; ?></td>
                                <td><i class="fa-solid fa-eye fa-xl openModalBtn" data-modal="adminViewStudent" onclick="adminStudentProcess('view',<?php echo $student['id']; ?>)"  style="color: #800000;cursor: pointer" ></i> &nbsp; <i class="fa-solid fa-trash fa-xl"  style="color: #800000;cursor: pointer" onclick="adminStudentProcess('delete',<?php echo $student['id']; ?>)"></i></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <div class="modal" id="adminViewStudent">
        <div class="modal-content">
            <div class="modal-title">
                <p>Enrolled Classes</p>
                <p id="student_name"></p>
            </div>
            <div class="modal-body">
                 <span class="custom-select-class">
                     <input type="text" id="student_id" readonly  hidden>
                     <select  class="student-account-select" id="student-account-select" name="student-account-select" onchange="academicYear('view','student')">
                         <option value="">Academic Year</option>
                         <?php foreach($academicYear as $year){ ?>
                             <option value="<?php echo $year['ACADEMIC_YEAR'] ?>"><?php echo $year['ACADEMIC_YEAR'] ?></option>
                         <?php } ?>
                     </select>
                 </span>
                <div class="table-container">
                    <table class="admin-student-table-data">
                        <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>Course</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="../../common/js/external/jquery-3.7.1.min.js"></script>
    <script src="../../common/js/common.js"></script>
    <script src="../../common/js/nav.js"></script>
    <script src="../../common/js/modal.js"></script>
    <script src="../../common/js/external/sweetalert2.min.js"></script>
    <script></script>
    </body>
</html>
