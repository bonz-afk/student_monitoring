<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth_teacher.php';
$current_page = 'assessment';
$current_dropdown = null;
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
    <link rel="stylesheet" href="../../common/css/teacher/assessment.css">

    <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
<div class="class-teacher-container">
    <div class="class-title">
        <img src="../../common/images/logo/css-logo.png"  />

        <p>College Of Computer Studies</p>
    </div>
    <div class="teacher-content">
        <div class="class-button-content">
            <div class="select-container">
                <span class="classes custom-select-class">
                     <select  class="teacher-account-select" id="teacher-year--select" name="teacher-year--select" onchange="enrolledStudentFilter('search_filter')">
                         <option value="">Academic Year</option>
                         <?php foreach($academicYear as $year){ ?>
                             <option value="<?php echo $year['ACADEMIC_YEAR'] ?>"><?php echo $year['ACADEMIC_YEAR'] ?></option>
                         <?php } ?>
                     </select>
                </span>
            </div>
            <input class="search-input" id="search-input" placeholder="Search" onkeyup="enrolledStudentFilter('search_filter')">
        </div>
        <div class="table-container">
            <table class="student-enrolled-table" >
                <thead>
                <tr>
                    <th>
                        <div class="sorting">
                            <img  id="sort-img" src="../../common/images/logo/dropdown-logo.svg" class="sort" width="50" height="50" onclick="sort('student_classes_enrolled')">
                            <span>Student</span>
                        </div>
                    </th>
                    <th>Class</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($studentEnrolled as $science) {?>
                    <tr>
                        <td><?php echo $science['fullname']; ?></td>
                        <td><?php echo $science['CLASS_NAME']; ?></td>
                        <td><?php echo $science['type_formatted']; ?></td>
                        <td> <i class="fas fa-clipboard-user fa-xl openModalBtn" data-modal="studentAttendance"   style="color: #800000;cursor: pointer" onclick="studentClassDetails('attendance','<?php echo $science['enrollClass']; ?>','<?php echo $science['CLASS_CODE']; ?>', <?php echo $science['uid']; ?>,'<?php echo $science['TYPE']; ?>')"></i> &nbsp; <i class="fa-solid fa-newspaper fa-xl openModalBtn" data-modal="studentScore"   style="color: #800000;cursor: pointer" onclick="studentClassDetails('score',<?php echo $science['enrollClass']; ?>,'<?php echo $science['CLASS_CODE']; ?>', <?php echo $science['uid']; ?>,'<?php echo $science['TYPE']; ?>')" ></i> &nbsp; <i class="fa-solid fa-computer fa-xl openModalBtn" data-modal="studentOthers"  style="color: #800000;cursor: pointer" onclick="studentClassDetails('others',<?php echo $science['enrollClass']; ?>,'<?php echo $science['CLASS_CODE']; ?>', <?php echo $science['uid']; ?>,'<?php echo $science['TYPE']; ?>')"></i></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/modal/student_attendance_modal.php'; ?>
<script src="../../common/js/external/jquery-3.7.1.min.js"></script>
<script src="../../common/js/common.js"></script>
<script src="../../common/js/nav.js"></script>
<script src="../../common/js/modal.js"></script>
<script src="../../common/js/external/sweetalert2.min.js"></script>
</body>
</html>
