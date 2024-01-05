<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
$current_page = 'college-classes';
$current_dropdown = 'class_science'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Monitoring</title>
    <link rel="stylesheet" href="../../common/css/common.css">
    <link rel="stylesheet" href="../../common/css/nav.css">
    <link rel="stylesheet" href="../../common/css/modal.css">
    <link rel="stylesheet" href="../../common/css/student/class_science.css">
    <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
<div class="join-class-container">
    <div class="join-title">
        <img src="../../common/images/logo/css-logo.png"  />

        <p>College Of Computer Studies</p>
    </div>
    <div class="join-class-content">
        <div class="join-button-content">
            <div style="width: 100%">
                <span class="custom-select-class">
                     <input type="text" id="student_id" readonly  hidden>
                     <select  class="student-account-select" id="join-class-select" name="join-class-select" onchange="classYearChange('join_change')">
                         <option value="">Academic Year</option>
                         <?php foreach($academicYear as $year){ ?>
                             <option value="<?php echo $year['ACADEMIC_YEAR'] ?>"><?php echo $year['ACADEMIC_YEAR'] ?></option>
                         <?php } ?>
                     </select>
                </span>
            </div>
            <div>
                <button class="btn-maroon openModalBtn" data-modal="joinClass">Join Class</button>
            </div>
        </div>
        <div class="table-container">
            <table class="join-teacher-table" >
                <thead>
                <tr>
                    <th>
                        <div class="sorting">
                            <img  id="sort-img" src="../../common/images/logo/dropdown-logo.svg" class="sort" width="50" height="50" onclick="sort('join-class-science');">
                            <span>Class Name</span>
                        </div>
                    </th>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($joinClass as $science) {?>
                    <tr>
                        <td><?php echo $science['CLASS_NAME'];  ?></td>
                        <td><?php echo $science['c_code']; ?></td>
                        <td><?php echo $science['SECTION']; ?></td>
                        <td><?php echo $science['statusEnroll'] == 'ON' ? 'Joined' : 'Pending'; ?></td>
                        <td> <i class="fa-solid fa-trash fa-xl"  style="color: #800000;cursor: pointer" onclick="joinedClasses('leave','<?php echo $science['CLASS_CODE'];?>')"></i></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/modal/student_science_class_modal.php'; ?>
<script src="../../common/js/external/jquery-3.7.1.min.js"></script>
<script src="../../common/js/common.js"></script>
<script src="../../common/js/nav.js"></script>
<script src="../../common/js/modal.js"></script>
<script src="../../common/js/external/sweetalert2.min.js"></script>
</body>
</html>
