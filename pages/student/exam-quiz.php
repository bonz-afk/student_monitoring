<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/student_monitoring/lib/client.php';
include_once $_SERVER['DOCUMENT_ROOT']. '/student_monitoring/lib/auth.php';
$current_page = 'assessment';
$current_dropdown = 'exam'
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
    <link rel="stylesheet" href="../../common/css/student/exam-quiz.css">

    <script src="https://kit.fontawesome.com/0dffe12a1d.js" crossorigin="anonymous"></script>
</head>
    <body>
    <?php include_once $_SERVER["DOCUMENT_ROOT"]. "/student_monitoring/nav.php"?>
    <div class="exam-container">
        <div class="exam-title">
            <p>Exam & Quizzes</p>
        </div>

        <div class="exam-content">
            <div class="exam-item-container">
                <div class="input-container">
                     <span class="exam custom-select-class">
                            <select  class="exam-select" id="exam-class" name="exam-class">
                                <option value="">Class</option>
                                <?php foreach($studentClassList as $classList){ ?>
                                    <option value="<?php echo $classList['CLASS_CODE']  ?> | <?php echo $classList['TYPE']  ?>"><?php echo $classList['CLASS_NAME'].' '.substr($classList['TYPE'], 0,3); ?></option>
                                <?php } ?>
                            </select>
                     </span>
                    <small class="message message-exam-class"></small>
                </div>
            </div>
            <div class="exam-item-container">
                <div class="input-container">
                      <span class="exam custom-select-class">
                            <select  class="exam-select" id="exam-type" name="exam-type">
                                <option value="">Type</option>
                                <option value="PE">Prelim Exam</option>
                                <option value="ME">Midterm Exam</option>
                                <option value="SE">Semifinals Exam</option>
                                <option value="FE">Finals Exam</option>
                                <option value="QUIZ">Quiz</option>
                            </select>
                        </span>
                    <small class="message message-exam-type"></small>
                </div>
                <div class="input-container">
                  <span class="exam custom-select-class">
                    <select  class="exam-select" id="exam-sem" name="exam-seme">
                        <option value="">Term</option>
                        <option value="1">Prelims to Mid Terms</option>
                        <option value="2">Semifinals to Finals</option>
                    </select>
                  </span>
                    <small class="message message-exam-sem"></small>
                </div>
            </div>
            <div class="exam-item-container">
                <div class="input-container">
                    <input type="text" class="exam-input" id="score" name="score" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Score">
                    <small class="message message-exam-score"></small>
                </div>
                <div class="input-container">
                    <input type="text" class="exam-input" id="exam-date" name="exam-date"  placeholder="Date of Examination">
                    <small class="message message-exam-date"></small>
                </div>
            </div>
            <div class="exam-item-container">
                <button class="exam btn-save" style="margin: 20px" onclick="score('quiz-exam');">Add Score</button>
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
