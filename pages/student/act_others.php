<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
$current_page = 'assessment';
$current_dropdown = 'activities'
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
    <link rel="stylesheet" href="../../common/css/student/act_others.css">

    <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
<div class="act-container">
    <div class="act-title">
        <p>Activities & Others</p>
    </div>

    <div class="act-content">
        <div class="act-item-container">
            <div class="input-container">
                     <span class="exam custom-select-class">
                            <select  class="act-select" id="act-class" name="act-class" onchange="filterTypeAct()">
                                <option value="">Class</option>
                                <?php foreach($studentClassList as $classList){ ?>
                                    <option value="<?php echo $classList['CLASS_CODE']  ?> | <?php echo $classList['TYPE']  ?>"><?php echo $classList['CLASS_NAME'].' '.substr($classList['TYPE'], 0,3); ?></option>
                                <?php } ?>
                            </select>
                     </span>
                <small class="message message-act-class"></small>
            </div>
        </div>
        <div class="act-item-container">
            <div class="input-container">
                      <span class="exam custom-select-class">
                            <select  class="act-select" id="act-type" name="act-type">
                                <option value="">Type</option>
                            </select>
                        </span>
                <small class="message message-act-type"></small>
            </div>
            <div class="input-container">
                  <span class="exam custom-select-class">
                    <select  class="act-select" id="act-sem" name="act-seme">
                        <option value="">Term</option>
                        <option value="1">Prelims to Mid Terms</option>
                        <option value="2">Semifinals to Finals</option>
                       </select>
                    </span>
                <small class="message message-act-sem"></small>
            </div>
        </div>
        <div class="act-item-container">
            <div class="input-container">
                <input type="text" class="act-input" id="score" name="score" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Score">
                <small class="message message-act-score"></small>
            </div>
            <div class="input-container">
                <input type="text" class="act-input" id="act-date" name="act-date"  placeholder="Date of Activity">
                <small class="message message-act-date"></small>
            </div>
        </div>
        <div class="act-item-container">
            <button class="exam btn-save" style="margin: 20px" onclick="score('activity-others');">Add Score</button>
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
