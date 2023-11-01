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
    <style>
        .main-account {
            transition: margin-left 0.3s; /* Add smooth transition for opening/closing sidebar */
        }
        .account-container-title{
            display: flex;
            justify-content: center;
        }
        .account-title{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .account-title p {
            font-size: 45px;
            font-weight: 900;
            font-family: 'Montserrat', sans-serif;
        }

        .account-button-content{
            display: flex;
            justify-content: space-between;
            max-width: 1522px;
            margin: 0 auto;
        }

        .account-button-content > div:first-child {
            align-self: flex-start;
        }

        .account-button-content > div:last-child {
            align-self: center;
        }


        .table-container {
            width: 100%;
            margin: 0 auto;
            height: 400px;
            overflow: auto;
            background-color: #FFFFFF;
            max-width: 1522px;
        }

        .course-table {
            width: 100%;
            background-color: #FFFFFF;
            border-collapse: collapse;
        }

        .course-table th{
            padding: 20px;
            font-size: 20px;
        }

        .course-table td {
            padding: 10px; /* Add padding to create spacing */
            font-size: 20px;
        }

        .course-table thead,tbody {
            text-align: center;
            padding: 20px 0;
        }

        .college-body{
            overflow: hidden;
        }

        .account-title img {
            width: 250px;
            height: 250px;
        }

        @media only screen and (max-height: 771px) {
            .college-body{
                overflow: scroll;
            }
            .table-container{
                height: 100%;
            }
        }

        @media  only screen and (max-width: 1148px) {
        .main-account{
            display: block;
            margin-left: 0 !important;
        }

           .main-account.hide{
               display: none;
            }
        }

        @media only screen and (max-width: 1336px) {
            .account-title p {
                font-size: 40px;
            }
            .account-title img {
                width: 100px;
                height: 100px;
            }
            .table-container{
                max-width: 670px;
            }
            .account-button-content{
                justify-content: space-evenly;
                gap: 0 !important;
            }

        }
        @media only screen and (max-width: 1336px) {
            .account-title p {
                font-size: 40px;
            }
            .account-title img {
                width: 100px;
                height: 100px;
            }
            .table-container{
                max-width: 670px;
            }
            .account-button-content{
                justify-content: space-evenly;
                gap: 0 !important;
            }
        }
        @media only screen and (min-width: 1337px) and (max-width: 2000px) {
            .account-title p {
                font-size: 50px;
            }
            .account-title img {
                width: 150px;
                height: 150px;
            }
            .table-container{
                max-width: 770px;
            }
            .account-button-content{
                justify-content: space-evenly;
                gap: 0 !important;
            }
            .modal-content{
                width: 750px;

            }
            .modal-content p{
                font-size: 30px;

            }
        }

        @media only screen and (max-width: 1200px) {
            .account-title p {
                font-size: 30px;
            }
            .account-title img {
                width: 100px;
                height: 100px;
            }
            .table-container{
                max-width: 565px;
            }
            .account-button-content{
                justify-content: space-evenly;
                gap: 0 !important;
            }
        }

        .edit-course{
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        .account-button-content.hide {
            gap: 300px;
        }

        .add-course{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .edit-course > input, .add-course > input{
            width: 100%;
            height: 35px;
            max-width: 630px;
            margin: 10px 0;
            border-radius: 5px;
            border: 0;
            background-color: #e0e2e4;
            padding: 10px;
            text-indent: 10px;
            font-size: 20px;
            color: #800000;
        }

        .edit-course > edit-save-container,  .add-course > add-save-container{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 0;
        }

        .edit-course > input:focus, .add-course > input:focus{
            outline: 0;
        }

        .edit-course > input::placeholder,.add-course > input::placeholder{
            color: #800000;
            opacity: .7;
            font-size: 15px;
        }

        small.code-message.error,small.desc-message.error,small.code-message-edit.error,small.desc-message-edit.error {
            align-self: start;
            margin-left: 95px;
            color: red;
        }

        .code-message.valid,.desc-message.valid,small.code-message-edit.valid,small.desc-message-edit.valid{
            color: #5cb85c;
            align-self: start;
            margin-left: 95px;
        }

        .account-button-content div{
            cursor: pointer;
        }
    </style>
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
        <div>
            <img src="../../common/images/logo/dropdown-logo.svg" class="button-content-item" width="80" height="80" onclick="sort('course')" />
        </div>
        <div>
            <button class="btn-maroon openModalBtn" data-modal="addCourseModal">Add Course</button>
        </div>
    </div>
    <div class="table-container">
        <table class="course-table">
            <thead>
            <tr>
                <th>Course Code</th>
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
                    <input type="text" id="college_id" name="college_id" value="2" hidden>
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
