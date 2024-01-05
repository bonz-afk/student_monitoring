<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
$current_page = 'student-monitoring';
$current_dropdown = null;
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
    <link rel="stylesheet" href="../../common/css/student/student_monitoring.css">
    <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
    <div class="monitoring-container">
        <div class="monitoring-title">
            <p>Student Monitoring</p>
        </div>
       <div class="monitoring-content">
           <form id="pdfForm" method="post" action="http://localhost/student_monitoring/generate_pdf.php" target="_blank" style="width: 100%">
               <div class="form-container">
                   <div class="pdfContainer">
                     <span class="nav custom-select-class">
                         <select  class="nav-pdf" id="monitoring_year" name="monitoring_year" onclick="filterClasses('filter-class-year')">
                             <option value="">Academic Year</option>
                             <?php foreach($academicYear as $year){ ?>
                                 <option value="<?php echo $year['ACADEMIC_YEAR'] ?>"><?php echo $year['ACADEMIC_YEAR'] ?></option>
                             <?php }?>
                         </select>
                     </span>
                   </div>
                   <div class="pdfContainer">
                     <span class="nav custom-select-class">
                         <select  class="nav-pdf" id="monitoring_class" name="monitoring_class">
                             <option value="">Class</option>
                         </select>
                     </span>
                   </div>
               </div>
               <div class="form-container" style="margin-bottom: 20px">
                   <label for="option1">
                       <input type="radio" class="radio-input" id="option1" name="options" value="LABORATORY" checked>
                       Laboratory
                   </label>

                   <label for="option2">
                       <input type="radio" class="radio-input" id="option2" name="options" value="LECTURE">
                       Lecture
                   </label>

               </div>
               <div class="form-container">
                   <button type="button" class="monitoring btn-maroon" onclick="generatePDF()">Generate Report</button>
               </div>
           </form>
       </div>
    </div>
<script src="../../common/js/external/jquery-3.7.1.min.js"></script>
<script src="../../common/js/common.js"></script>
<script src="../../common/js/nav.js"></script>
<script src="../../common/js/modal.js"></script>
<script src="../../common/js/external/sweetalert2.min.js"></script>
</body>
</html>
