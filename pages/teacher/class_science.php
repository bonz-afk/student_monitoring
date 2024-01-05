<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth_teacher.php';
$current_page = 'classes';
$current_dropdown = 'class_science';
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
    <link rel="stylesheet" href="../../common/css/teacher/class_science.css">
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
            <div style="width: 100%">
                <span class="classes custom-select-class">
                     <select  class="teacher-account-select" id="teacher-class-select" name="teacher-class-select" onchange="classYearChange('class_change')">
                         <option value="">Academic Year</option>
                         <?php foreach($academicYear as $year){ ?>
                             <option value="<?php echo $year['ACADEMIC_YEAR'] ?>"><?php echo $year['ACADEMIC_YEAR'] ?></option>
                         <?php } ?>
                     </select>
                </span>
            </div>
            <div>
                <button class="btn-maroon openModalBtn" data-modal="addClassModal">Create Class</button>
            </div>
        </div>
        <div class="table-container">
            <table class="class-teacher-table" >
                <thead>
                <tr>
                    <th>
                        <div class="sorting">
                            <img src="../../common/images/logo/dropdown-logo.svg" class="button-content-item" width="50" height="50" onclick="sort('class-teacher')">
                            <span>Class Name</span>
                        </div>
                    </th>
                    <th>Course</th>
                    <th>Type</th>
                    <th>Term</th>
                    <th>Year</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                   <?php foreach ($classScienceData as $science) {?>
                       <tr>
                           <td><?php echo $science['CLASS_NAME']; ?></td>
                           <td><?php echo $science['COURSE_CODE']; ?></td>
                           <td><?php echo $science['type_formatted']; ?></td>
                           <td><?php echo $science['SEMESTER'] == 1 ? 'I' : 'II'; ?></td>
                           <td><?php echo $science['ACADEMIC_YEAR']; ?></td>
                           <td> <i class="fa-solid fa-eye fa-xl openModalBtn" data-modal="classView" onclick="createClass('student-class-science',<?php echo $science['id'];?>)"  style="color: #800000;cursor: pointer" ></i> &nbsp; <i class="fa-solid fa-pen-to-square fa-xl openModalBtn" data-modal="classEdit" onclick="createClass('view',<?php echo $science['id'];?>)"  style="color: #800000;cursor: pointer" ></i> &nbsp; <i class="fa-solid fa-trash fa-xl"  style="color: #800000;cursor: pointer" onclick="createClass('delete',<?php echo $science['id'];?>)"></i></td>
                       </tr>
                   <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/modal/science_class_modal.php'; ?>
<script src="../../common/js/external/jquery-3.7.1.min.js"></script>
<script src="../../common/js/common.js"></script>
<script src="../../common/js/nav.js"></script>
<script src="../../common/js/modal.js"></script>
<script src="../../common/js/external/sweetalert2.min.js"></script>
</body>
</html>
