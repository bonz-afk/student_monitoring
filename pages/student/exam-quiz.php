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
    <style>
        .exam-container{
            transition: margin-left 0.3s;
        }

        .exam-content{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 100%;
            margin: 0 auto;
            overflow-y: auto;
            overflow-x: hidden;
            background-color: #FFFFFF;
            border-radius: 20px;
            max-width: 1522px;
        }

        .exam-item-container{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 25px;
            /* flex-wrap: wrap; */
            width: 800px;
        }

        .exam-title{
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .exam-title p{
            font-size: 45px;
            font-weight: 900;
            font-family: 'Montserrat', sans-serif;
        }

        .exam.custom-select-class{
            display: block;
            position: relative;
            width: 100%;
            background-color: #e0e2e4;
            border-radius: 5px;
            cursor: pointer;
            margin: 15px 0;
            max-width: 370px;
        }

        .exam-select:focus{
            outline: 0;
        }

        .exam-select {
            appearance: none;
            width: 100%;
            height: 35px;
            margin: 10px 0;
            border-radius: 5px;
            border: 0;
            background-color: transparent;
            text-indent: 10px;
            font-size: 20px;
            color: #800000;
            padding: 0 48px 0 0;
            cursor: pointer;
        }

        .exam-form{
            display: flex;
            margin: 0 auto;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        .exam-input{
            width: 100%;
            height: 35px;
            max-width: 350px;
            margin: 10px 0;
            border-radius: 5px;
            border: 0;
            background-color: #e0e2e4;
            padding: 10px;
            text-indent: 10px;
            font-size: 20px;
            color: #800000;
        }

        .exam-input::placeholder{
            color: #800000;
        }

        .exam-input:focus,.college-select:focus{
            outline: 0;
        }
        .exam.btn-save{
            padding: 15px 70px;
        }

        .exam-item-container:first-child{
            margin-top: 40px;
        }

        @media only screen and (max-width: 1518px) {
            .exam-content{
                max-width: 700px;
            }
            .exam-item-container{
                gap: 0 !important;
                flex-wrap: wrap;
                margin: 0 auto;
                width: 100%;
                display: flex;
            }
            .input-container{
                align-items: center !important;
            }
        }


        @media only screen and (max-width: 802px) {
            .exam-content{
                max-width: 600px !important;
            }
        }

        @media only screen and (max-width: 616px) {
            .exam-content{
                max-width: 350px !important;
            }
            .exam-input,.content-with-valid{
                max-width: 200px !important;
            }

            .exam.custom-select-class,.content-with-valid{
                max-width: 223px !important;
            }
        }

        .content-with-valid {
            display: flex;
            justify-content: center;
            align-items: start;
            flex-direction: column;
            max-width: 370px;
            width: 100%;
        }

        .input-container{
            display: flex;
            width: 100%;
            justify-content: space-around;
            align-items: start;
            flex-direction: column;
            margin: 0 auto;
        }
    </style>
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
                                    <option value="<?php echo $classList['classId'] ?>"><?php echo $classList['CLASS_NAME'].' '.substr($classList['TYPE'], 0,3) ?></option>
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
