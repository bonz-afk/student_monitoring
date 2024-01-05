<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth_user.php';
$current_page = 'account';
$current_dropdown = 'teacher';
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
        <link rel="stylesheet" href="../../common/css/admin/teacher_account.css">

        <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
        <div class="admin-teacher-container">
            <p class="teacher font-mont" style="text-align: center; margin: 100px auto;">Teacher List</p>
            <div class="teacher-content">
                <div class="teacher-sort">
                    <img src="../../common/images/logo/dropdown-logo.svg" class="button-content-item" width="80" height="80" onclick="sort('teacher-account')" />
                </div>
               <div class="table-container">
                   <table class="admin-teacher-table" >
                       <thead>
                       <tr>
                           <th>Name of teacher</th>
                           <th></th>
                       </tr>
                       </thead>
                       <tbody>
                       <?php foreach($teacherData as $teacher){ ?>
                           <tr>
                               <td id="fullteacher<?php echo $teacher['id']; ?>" data-teachername="<?php echo  $teacher['LASTNAME'].', '.$teacher['FIRSTNAME'].' '.substr($teacher['MIDDLENAME'], 0,1); ?>"><?php echo  $teacher['LASTNAME'].', '.$teacher['FIRSTNAME'].' '.substr($teacher['MIDDLENAME'], 0,1); ?></td>
                               <td><i class="fa-solid fa-eye fa-xl openModalBtn" data-modal="adminViewTeacher" onclick="adminTeacherProcess('view',<?php echo $teacher['id']; ?>)"  style="color: #800000;cursor: pointer" ></i> &nbsp; <i class="fa-solid fa-trash fa-xl"  style="color: #800000;cursor: pointer" onclick="adminTeacherProcess('delete',<?php echo $teacher['id']; ?>)"></i></td>
                           </tr>
                       <?php } ?>
                       </tbody>
                   </table>
               </div>
            </div>
        </div>
        <div class="modal" id="adminViewTeacher">
            <div class="modal-content">
                <div class="modal-title">
                    <p>List of Classes</p>
                    <p id="teacher_name"></p>
                </div>
                <div class="modal-body">
                 <span class="custom-select-class">
                     <input type="text" id="teacher_id" readonly hidden >
                     <select  class="teacher-account-select" id="teacher-account-select" name="teacher-account-select" onchange="academicYear('view','teacher')">
                         <option value="">Academic Year</option>
                         <?php foreach($academicYear as $year){ ?>
                             <option value="<?php echo $year['ACADEMIC_YEAR'] ?>"><?php echo $year['ACADEMIC_YEAR'] ?></option>
                         <?php } ?>
                     </select>
                 </span>
                    <div class="table-container">
                        <table class="admin-teacher-table-data">
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
    </body>
</html>
