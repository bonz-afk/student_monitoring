<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth_user.php';
$current_page = 'college';
$current_dropdown = 'computer_studies';
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    <link rel="stylesheet" href="../../common/css/admin/computer_studies.css">

    <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
</head>
<body class="college-body">
<?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
<div class="main-account">
    <div class="account-container-title">
        <div class="account-title">
            <img src="../../common/images/logo/css-logo.png"  />

            <p>College Of Computer Studies</p>
        </div>
    </div>
    <div class="account-button-content">
        <div style="width: 100%">
        </div>
        <div>
            <button class="btn-maroon openModalBtn" data-modal="addCourseModal" style="margin-bottom: 10px">Add Course</button>
        </div>
    </div>
    <div class="table-container">
        <table class="course-table">
            <thead>
            <tr>
                <th>
                    <div class="sorting">
                        <img src="../../common/images/logo/dropdown-logo.svg" class="button-content-item" width="50" height="50" onclick="sort('course')">
                        <span>Course Code</span>
                    </div>
                </th>
                <th>Course Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($courseData as $course) {?>
            <tr>

                <td><?php echo $course['COURSE_CODE'] ?></td>
                <td><?php echo $course['COURSE_DESC'] ?></td>
                <td><i  class="fa-solid fa-pen-to-square fa-xl openModalBtn" style="color: #800000;cursor: pointer" data-modal="myModal" onclick="showCourse(<?php echo $course['ID']; ?>,2)"></i>
                    <i class="fa-solid fa-trash fa-xl"  style="color: #800000;cursor: pointer" onclick="courseProcess('delete',<?php echo $course['ID']; ?>)"></i></td>
                <?php } ?>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="modal" id="addCourseModal">
    <div class="modal-content">
        <div class="modal-title">
            <p>Add Course</p>
        </div>
        <div class="modal-body">
            <form id="addCourse">
                <div class="add-course">
                    <input type="text" id="college_id" name="college_id" value="2" readonly hidden>
                    <input type="text" class="" id="add_course_code" name="add_course_code" maxlength="255" placeholder="Course Code">
                    <small class="code-message"></small>
                    <input type="text" class="" id="add_course_desc" name="add_course_desc"  maxlength="255" placeholder="Course Description">
                    <small class="desc-message"></small>
                    <div class="add-save-container">
                        <button type="button" class="btn-save" onclick="courseProcess('add')">Save</button>
                        <button type="button" class="closeModalBtn btn-cancel">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="myModal">
    <div class="modal-content">
        <div class="modal-title">
            <p>Edit Course</p>
        </div>
        <div class="modal-body">
            <form>
                <div class="edit-course">
                    <input type="text" id="course_id" hidden>
                    <input type="text" class="" id="course_code_edit" name="course_code_edit" placeholder="Course Code">
                    <small class="code-message-edit"></small>
                    <input type="text" class="" id="course_desc_edit" name="course_desc_edit" placeholder="Course Description">
                    <small class="desc-message-edit"></small>
                    <div class="edit-save-container">
                        <button type="button" class="btn-save" onclick="courseProcess('edit')">Save</button>
                        <button type="button" class="closeModalBtn btn-cancel">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../../common/js/external/jquery-3.7.1.min.js"></script>
<script src="../../common/js/common.js"></script>
<script src="../../common/js/nav.js"></script>
<script src="../../common/js/modal.js"></script>
<script src="../../common/js/external/sweetalert2.min.js"></script>
</body>
</html>
