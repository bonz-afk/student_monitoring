<?php
// path/to/your-php-script.php
include_once $_SERVER['DOCUMENT_ROOT'] . '../student_monitoring/lib/client.php';
require_once __DIR__ . '/vendor/autoload.php'; // Adjust the path as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['user_id'];
    $classCode = $_POST['monitoring_class'];
    $yearHear = $_POST['monitoring_year'];
    $options = $_POST['options'];

    $sql = "SELECT
                CONCAT(
                    UPPER(SUBSTRING(u.LASTNAME, 1, 1)), LOWER(SUBSTRING(u.LASTNAME, 2)),
                    ' ',
                    UPPER(SUBSTRING(u.FIRSTNAME, 1, 1)), LOWER(SUBSTRING(u.FIRSTNAME, 2)),
                    ' ',
                    UPPER(LEFT(u.MIDDLENAME, 1)),'.'
                ) as fullname , CONCAT(c.PROGRAM,' ',c.Year,'-',c.SECTION) as progyearsec,
                            c.ACADEMIC_YEAR,c.SEMESTER,a.COURSE_CODE,a.COURSE_DESC,c.TYPE
                
                FROM
                  `tb_class_enrolled` as e
                  LEFT JOIN tb_class as c on c.id = e.CLASS_ID
                  LEFT JOIN tb_course as a ON a.COURSE_CODE = c.COURSE_CODE
                  LEFT JOIN tb_user as u on u.id = e.STUDENT
                  WHERE e.STUDENT = $id AND c.CLASS_CODE = ? AND c.TYPE = '$options' AND c.ACADEMIC_YEAR = '$yearHear'";

    $stmtStudent = $mysqli->prepare($sql);

    $stmtStudent->bind_param("s", $classCode);
    $stmtStudent->execute();

    if ($stmtStudent === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
    }

    $result = $stmtStudent->get_result();

// Fetch Results
    $studentInfo = array();
    while ($row = $result->fetch_assoc()) {
        $studentInfo[] = $row;
        $fullname = $row['fullname'];
        $progyear = $row['progyearsec'];
        $year = $row['ACADEMIC_YEAR'];
        $term = $row['SEMESTER'];
        $code = $row['COURSE_CODE'];
        $desc = $row['COURSE_DESC'];
        $type = $row['TYPE'];

        $html = '
            <style>
                 body {
                    font-family: DejaVuSans;
                }
        
            </style>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 70%">
                        <img src="' . __DIR__ . '/common/images/logo/lpu-logo.png" alt="Logo" width="250" height="250">
                    </td>
                    <td style="width: 30%;text-align: right;">
                        <p>FM-LPU-VPAR-33/D1</p>
                        <p> Office of the VP for Academic & Research </p>
                        <p style="font-size:13px;">Telephone No. (043) 723-0706 loc. 110/109</p>
                    </td>
                </tr>
            </table>   
            <div style="text-align: center; margin-top: -10px;">
                <h1 style="text-align: center; margin-top: -50px;">Student Progress Monitoring Sheet</h1>
            </div>   
            
            <div style="text-align: center;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th style="width: 60px; text-align: left; font-weight: bold;">NAME:</th>
                        <th style="border-bottom: 1px solid #000000; text-align: left;">' . $fullname . '</th>
                        <th style="width: 200px; text-align: left; font-weight: bold;">PROGRAM/YEAR/SECTION:</th>
                        <th style="border-bottom: 1px solid #000000; text-align: left;">' . $progyear . '</th>
                        <th style="width: 135px; text-align: left; font-weight: bold;">SCHOOL YEAR:</th>
                        <th style="border-bottom: 1px solid #000000; text-align: left;">' . $year . '</th>
                        <th style="width: 80px; text-align: left; font-weight: bold;">TERM:</th>
                        <th style="text-align: left;">' . ($term == 1 ? '&#9745;' : '&#9744;') . ' FIRST &nbsp; ' . ($term == 2 ? '&#9745;' : '&#9744;') . ' SECOND  &nbsp; ' . ($term == 3 ? '&#9745;' : '&#9744;') . ' SUMMER</th>
                    </tr>
                </table>
            
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                    <tr>
                        <th style="width: 130px; text-align: left; font-weight: bold;">COURSE CODE:</th>
                        <th style="border-bottom: 1px solid #000000; text-align: left;">' . $code . '</th>
                        <th style="width: 200px; text-align: left; font-weight: bold;">COURSE DESCRIPTION:</th>
                        <th style="border-bottom: 1px solid #000000; text-align: left;">' . $desc . '</th>
                        <th style="text-align: left; font-weight: bold;">' . ($type == 'LECTURE' ? '&#9745;' : '&#9744;') . ' LECTURE &nbsp; ' . ($type == 'LABORATORY' ? '&#9745;' : '&#9744;') . ' LABORATORY &nbsp;&#9744; RLE</th>
                    </tr>
                </table>
            </div>
        ';
    }

    $sqlMajor = "SELECT 
            s.STUDENT_ID,
            s.CLASS_ID,
            SUM(CASE WHEN s.TYPE = 'PE' THEN s.SCORE ELSE 0 END) AS PE,
            SUM(CASE WHEN s.TYPE = 'ME' THEN s.SCORE ELSE 0 END) AS ME,
            SUM(CASE WHEN s.TYPE = 'SE' THEN s.SCORE ELSE 0 END) AS SE,
            SUM(CASE WHEN s.TYPE = 'FE' THEN s.SCORE ELSE 0 END) AS FE
        FROM tb_score AS s
        LEFT JOIN tb_class AS c ON c.CLASS_CODE = s.CLASS_CODE
        LEFT JOIN tb_user AS u ON u.id = s.STUDENT_ID
        WHERE s.STUDENT_ID = $id AND c.CLASS_CODE = ? AND (s.TYPE = 'PE' OR s.TYPE = 'ME'  OR s.TYPE = 'SE' OR s.TYPE = 'FE') AND c.TYPE = '$options' AND s.CLASS_TYPE = '$options'
        GROUP BY s.STUDENT_ID, s.CLASS_ID";

    $stmtMajor = $mysqli->prepare($sqlMajor);

    $stmtMajor->bind_param("s", $classCode);
    $stmtMajor->execute();

    if ($stmtMajor === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
        exit;
    }

    $resultMajor = $stmtMajor->get_result();

// Fetch Results
    $studentMajorData = array();
    while ($row = $resultMajor->fetch_assoc()) {
        $studentMajorData[] = $row;
        $PE = $row['PE'];
        $ME = $row['ME'];
        $SE = $row['SE'];
        $FE = $row['FE'];
    }

    if (empty($studentMajorData)) {
        $html .= '
                <div style="text-align: center; margin-top: 10px;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 20%; vertical-align: top;">
                                    <table border="1" style="width: 100%; border-collapse: collapse;">
                                        <tr>
                                            <th rowspan="3" style="width: 100px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">MAJOR EXAM</th>
                                        </tr>
                                        <tr>
                                            <th>PE</th>
                                            <th>ME</th>
                                            <th>SE</th>
                                            <th>FE</th>
                                        </tr>
                                        <tr>
                                            <th>0</th>
                                            <th>0</th>
                                            <th>0</th>
                                            <th>0</th>
                                        </tr>
                                    </table>
                                </td>
                                <td></td>
            ';
    } else {
        $html .= '
                <div style="text-align: center; margin-top: 10px;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 20%; vertical-align: top;">
                                    <table border="1" style="width: 100%; border-collapse: collapse;">
                                        <tr>
                                            <th rowspan="3" style="width: 100px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">MAJOR EXAM</th>
                                        </tr>
                                        <tr>
                                            <th>PE</th>
                                            <th>ME</th>
                                            <th>SE</th>
                                            <th>FE</th>
                                        </tr>
                                        <tr>
                                            <th>' . $PE . '</th>
                                            <th>' . $ME . '</th>
                                            <th>' . $SE . '</th>
                                            <th>' . $FE . '</th>
                                        </tr>
                                    </table>
                                </td>
                                <td></td>
            ';
    }

    //term prelims-

    $sqlAtt = "SELECT 
                 a.STATUS as attStatus FROM tb_attendance as a
                LEFT JOIN tb_class AS c ON c.CLASS_CODE = a.CLASS_CODE
                LEFT JOIN tb_user AS u ON u.id = a.STUDENT_ID
                WHERE a.STUDENT_ID = $id AND a.CLASS_CODE = ? AND a.TERM = 1 AND a.TYPE = '$options' AND c.TYPE = '$options' AND c.ACADEMIC_YEAR = '$yearHear'
                ORDER BY a.TIME_IN ASC";

    $stmtAtt = $mysqli->prepare($sqlAtt);

    $stmtAtt->bind_param("s", $classCode);
    $stmtAtt->execute();

    if ($stmtAtt === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
        exit;
    }

    $resultAtt = $stmtAtt->get_result();

// Fetch
    $attStatus = array();
    while ($row = $resultAtt->fetch_assoc()) {
        $attStatus[] = $row['attStatus'];
    }

    $totalData = 20;
    if (empty($attStatus)) {
        $html .= '
                <td style="width: 75%; vertical-align: top;">
                                <table border="1" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <th rowspan="3" style="width: 100px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">ATTENDANCE <b style="font-size: 8px">(Prelims to Mid Terms)</b></th>
                                    </tr>
                                    <tr>
        ';

        for ($i = 1; $i <= $totalData; $i++) {
            $html .= ' <th>' . $i . '</th>';
        }
        $html .= '           </tr><tr>';

        for ($i = 1; $i <= $totalData; $i++) {
            $html .= ' <th>0</th>';
        }
        $html .= '       
                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
        ';
    } else {
        $totalAttendance = count($attStatus);
        $remainingTd = $totalData - $totalAttendance;
        $html .= '
                <td style="width: 75%; vertical-align: top;">
                                <table border="1" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <th rowspan="3" style="width: 100px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">ATTENDANCE <b style="font-size: 8px">(Prelims to Mid Terms)</b></th>
                                    </tr>
                                    <tr>
        ';

        for ($i = 1; $i <= $totalData; $i++) {
            $html .= ' <th>' . $i . '</th>';
        }
        $html .= '           </tr><tr>';

        foreach ($attStatus as $status) {
            $html .= ' <th>' . $status . '</th>';
        }
        for ($i = 1; $i <= $remainingTd; $i++) {
            $html .= ' <th>0</th>';
        }
        $html .= '       
                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
        ';
    }

    //term semis-finals

    if($options == 'LABORATORY'){
        $scoreString = "SUM(CASE WHEN s.TYPE = 'EXPERIMENT'  THEN s.SCORE ELSE 0 END) as expActScore";
    }else{
        $scoreString = "SUM(CASE WHEN s.TYPE = 'ACTIVITY'  THEN s.SCORE ELSE 0 END) as expActScore";
    }

    $sqlTotalAtt = "SELECT 
                 COUNT(a.STATUS) as attStatus FROM tb_attendance as a
                LEFT JOIN tb_class AS c ON c.CLASS_CODE = a.CLASS_CODE
                LEFT JOIN tb_user AS u ON u.id = a.STUDENT_ID
                WHERE a.STUDENT_ID = $id AND a.CLASS_CODE = ? AND a.TERM = 2 AND a.TYPE = '$options' AND c.TYPE = '$options' AND c.ACADEMIC_YEAR = '$yearHear'  AND a.STATUS = 'P'";

    $stmtTotalAtt = $mysqli->prepare($sqlTotalAtt);

    $stmtTotalAtt->bind_param("s", $classCode);
    $stmtTotalAtt->execute();

    if ($stmtTotalAtt === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
        exit;
    }

    $resultTotalAtt = $stmtTotalAtt->get_result();

// Fetch

    while ($row = $resultTotalAtt->fetch_assoc()) {
        $totalAttendanceAttend = $row['attStatus'];
    }

    $sqlPE = "SELECT 
                SUM(CASE WHEN s.TYPE = 'PE' THEN s.SCORE ELSE 0 END) as PEscore,
                SUM(CASE WHEN s.TYPE = 'ME' THEN s.SCORE ELSE 0 END) as MEscore,
                SUM(CASE WHEN s.TYPE = 'QUIZ'  THEN s.SCORE ELSE 0 END) as quizScore,
                $scoreString,
                SUM(CASE WHEN s.TYPE = 'OTHERS'  THEN s.SCORE ELSE 0 END) as otherScore,
                c.ATTENDANCE, c.QUIZ, c.ACTEXP, c.OTHERS
            FROM 
                tb_score as s
            LEFT JOIN 
                tb_class AS c ON c.CLASS_CODE = s.CLASS_CODE
            LEFT JOIN 
                tb_user AS u ON u.id = s.STUDENT_ID
            WHERE 
                s.STUDENT_ID = $id AND c.CLASS_CODE = ? 
            AND s.TERM = $term AND c.ACADEMIC_YEAR = '$yearHear' AND c.TYPE = '$options' AND s.CLASS_TYPE = '$options';
        ";

    $stmtPE = $mysqli->prepare($sqlPE);

    $stmtPE->bind_param("s", $classCode);
    $stmtPE->execute();

    if ($stmtPE === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
        exit;
    }

    $resultPE= $stmtPE->get_result();

// Fetch
    while ($row = $resultPE->fetch_assoc()) {
        $peScore = $row['PEscore'];
        $meScore = $row['MEscore'];
        $quizScore = $row['quizScore'];
        $expActScore = $row['expActScore'];
        $otherScore = $row['otherScore'];
        $totalAtt = $row['ATTENDANCE'];
        $totalQuiz = $row['QUIZ'];
        $totalActExp = $row['ACTEXP'];
        $totalOthers = $row['OTHERS'];
    }
    $attendanceConverted = ($totalAttendanceAttend / $totalAtt) * 100;
    $quizConverted = $quizScore / $totalQuiz;
    $expActConverted = $expActScore / $totalActExp;
    $othersConverted = $otherScore / $totalOthers;
    $totalPerformance = ($attendanceConverted + $quizConverted + $expActConverted + $othersConverted) * 0.30;
    $peConverted = $peScore * 0.30;
    $meConverted = $meScore * 0.40;

    $midtermGrade = number_format($totalPerformance + $peConverted + $meConverted, 2, '.', '');

    $html .= ' 
        <div style="text-align: center; margin-top: 10px;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 20%; vertical-align: top;">
                        <table border="1" style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <th rowspan="3" style="width: 100px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">MIDTERM GRADE</th>
                            </tr>
                            <tr>
                                <th rowspan="2">'.$midtermGrade.'</th>
                                <th><b style="font-size: 8px">PARENT&rsquo;S SIGNATURE</b></th>
                            </tr>
                            <tr>
                                <th height="30px"></th>
                            </tr>
                        </table>
                    </td>
                    <td></td>
    ';

    $sqlAtt2 = "SELECT 
                 a.STATUS as attStatus FROM tb_attendance as a
                LEFT JOIN tb_class AS c ON c.CLASS_CODE = a.CLASS_CODE
                LEFT JOIN tb_user AS u ON u.id = a.STUDENT_ID
                WHERE a.STUDENT_ID = $id AND a.CLASS_CODE = ? AND a.TERM = 2 AND a.TYPE = '$options' AND c.TYPE = '$options' AND c.ACADEMIC_YEAR = '$yearHear'";

    $stmtAtt2 = $mysqli->prepare($sqlAtt2);

    $stmtAtt2->bind_param("s", $classCode);
    $stmtAtt2->execute();

    if ($stmtAtt2 === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
        exit;
    }

    $resultAtt2 = $stmtAtt2->get_result();

// Fetch
    $attStatus2 = array();
    while ($row = $resultAtt2->fetch_assoc()) {
        $attStatus2[] = $row['attStatus'];
    }

    $totalData2 = 20;
    if (empty($attStatus2)) {
        $html .= '
                <td style="width: 75%; vertical-align: top;">
                                <table border="1" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <th rowspan="3" style="width: 100px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">ATTENDANCE <b style="font-size: 8px">(Semifinals to Finals)</b></th>
                                    </tr>
                                    <tr>
        ';

        for ($i = 1; $i <= $totalData; $i++) {
            $html .= ' <th>' . $i . '</th>';
        }
        $html .= '           </tr><tr>';

        for ($i = 1; $i <= $totalData; $i++) {
            $html .= ' <th>0</th>';
        }
        $html .= '       
                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
        ';
    }
    else {
        $totalAttendance = count($attStatus2);
        $remainingTd = $totalData2 - $totalAttendance;
        $html .= '
                <td style="width: 75%; vertical-align: top;">
                                <table border="1" style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <th rowspan="3" style="width: 100px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">ATTENDANCE <b style="font-size: 8px">(Semifinals to Finals)</b></th>
                                    </tr>
                                    <tr>
        ';

        for ($i = 1; $i <= $totalData2; $i++) {
            $html .= ' <th>' . $i . '</th>';
        }
        $html .= '           </tr><tr>';

        foreach ($attStatus2 as $status) {
            $html .= ' <th>' . $status . '</th>';
        }
        for ($i = 1; $i <= $remainingTd; $i++) {
            $html .= ' <th>0</th>';
        }
        $html .= '       
                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
           
        ';
    }

    $html .= '<hr/>';

    //quizzes prelim-mid

    $sqlQuiz = "SELECT s.SCORE
                FROM tb_score as s
                LEFT JOIN tb_class AS c ON c.CLASS_CODE = s.CLASS_CODE
                LEFT JOIN tb_user AS u ON u.id = s.STUDENT_ID
                WHERE s.STUDENT_ID = $id AND c.CLASS_CODE = ? AND s.TERM = 1 AND s.TYPE = 'QUIZ' AND c.TYPE = '$options' AND s.CLASS_TYPE = '$options' 
                ORDER BY EXAM_DATE ASC";

    $stmtQuiz = $mysqli->prepare($sqlQuiz);

    $stmtQuiz->bind_param("s", $classCode);
    $stmtQuiz->execute();

    if ($stmtQuiz === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
        exit;
    }

    $resultQuiz= $stmtQuiz->get_result();

// Fetch
    $quizScore = array();
    while ($row = $resultQuiz->fetch_assoc()) {
        $quizScore[] = $row['SCORE'];
    }
    $totalQuizData = 20;
    if(empty($quizScore)){
        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">QUIZZES <br/><b style="font-size: 8px;">(Prelims to Mid Terms)</b></th>
                        </tr>
                        <tr>
            ';

            for($i = 1; $i <= $totalQuizData; $i++){
                $html .= '<th>'.$i.'</th>';
            }

            $html .= '</tr><tr>';

            for($i = 1; $i <= $totalQuizData; $i++){
                $html .= '<th>0</th>';
            }

            $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }
    else{
        $totalExistingQuiz = count($quizScore);
        $remainingTdQuiz = $totalQuizData - $totalExistingQuiz;

        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">QUIZZES <br/><b style="font-size: 8px;">(Prelims to Mid Terms)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalQuizData; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        foreach ($quizScore as $score){
            $html .= '<th>'.$score.'</th>';
        }

        for($i = 1; $i <= $remainingTdQuiz; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }

    //quizzes semis - finals

    $sqlQuiz2 = "SELECT s.SCORE
                FROM tb_score as s
                LEFT JOIN tb_class AS c ON c.CLASS_CODE = s.CLASS_CODE
                LEFT JOIN tb_user AS u ON u.id = s.STUDENT_ID
                WHERE s.STUDENT_ID = $id AND c.CLASS_CODE = ? AND s.TERM = 2 AND s.TYPE = 'QUIZ' AND c.TYPE = '$options' AND s.CLASS_TYPE = '$options'  
                ORDER BY EXAM_DATE ASC";

    $stmtQuiz2 = $mysqli->prepare($sqlQuiz2);

    $stmtQuiz2->bind_param("s", $classCode);
    $stmtQuiz2->execute();

    if ($stmtQuiz2 === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
        exit;
    }

    $resultQuiz2 = $stmtQuiz2->get_result();

// Fetch
    $quizScore2 = array();
    while ($row = $resultQuiz2->fetch_assoc()) {
        $quizScore2[] = $row['SCORE'];
    }
    $totalQuizData2 = 20;
    if(empty($quizScore2)){
        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">QUIZZES <br/><b style="font-size: 8px;">(Semifinals to Finals)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalQuizData2; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        for($i = 1; $i <= $totalQuizData2; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }
    else{
        $totalExistingQuiz = count($quizScore2);
        $remainingTdQuiz = $totalQuizData2 - $totalExistingQuiz;

        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">QUIZZES <br/><b style="font-size: 8px;">(Semifinals to Finals)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalQuizData2; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        foreach ($quizScore2 as $score){
            $html .= '<th>'.$score.'</th>';
        }

        for($i = 1; $i <= $remainingTdQuiz; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }


    //classroom act  prelim - mid

    $sqlClassAct = "SELECT s.SCORE
                FROM tb_score as s
                LEFT JOIN tb_class AS c ON c.CLASS_CODE = s.CLASS_CODE
                LEFT JOIN tb_user AS u ON u.id = s.STUDENT_ID
                WHERE s.STUDENT_ID = $id AND c.CLASS_CODE = ? AND s.TERM = 1 AND s.TYPE = 'ACTIVITY' AND c.TYPE = '$options' AND s.CLASS_TYPE = '$options'  
                ORDER BY EXAM_DATE ASC";

    $stmtClassAct = $mysqli->prepare($sqlClassAct);

    $stmtClassAct->bind_param("s", $classCode);
    $stmtClassAct->execute();

    if ($stmtClassAct === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
        exit;
    }

    $resultClassAct = $stmtClassAct->get_result();

// Fetch
    $classActScore = array();
    while ($row = $resultClassAct->fetch_assoc()) {
        $classActScore[] = $row['SCORE'];
    }
    $totalClassActData = 20;
    if(empty($classActScore)){
        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">CLASSROOM ACTIVITIES <br/><b style="font-size: 8px;">(Prelims to Mid Term)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalClassActData; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        for($i = 1; $i <= $totalClassActData; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }
    else{
        $totalExistingClassAct = count($classActScore);
        $remainingTdClassAct = $totalClassActData - $totalExistingClassAct;

        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                           <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">CLASSROOM ACTIVITIES <br/><b style="font-size: 8px;">(Prelims to Mid Term)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalClassActData; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        foreach ($classActScore as $score){
            $html .= '<th>'.$score.'</th>';
        }

        for($i = 1; $i <= $remainingTdClassAct; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }


  //classroom act  semis - Final

    $sqlClassAct2 = "SELECT s.SCORE
                FROM tb_score as s
                LEFT JOIN tb_class AS c ON c.CLASS_CODE = s.CLASS_CODE
                LEFT JOIN tb_user AS u ON u.id = s.STUDENT_ID
                WHERE s.STUDENT_ID = $id AND c.CLASS_CODE = ? AND s.TERM = 2 AND s.TYPE = 'ACTIVITY' AND c.TYPE = '$options' AND s.CLASS_TYPE = '$options'  
                ORDER BY EXAM_DATE ASC";

    $stmtClassAct2 = $mysqli->prepare($sqlClassAct2);

    $stmtClassAct2->bind_param("s", $classCode);
    $stmtClassAct2->execute();

    if ($stmtClassAct2 === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
        exit;
    }

    $resultClassAct2 = $stmtClassAct2->get_result();

// Fetch
    $classActScore2 = array();
    while ($row = $resultClassAct2->fetch_assoc()) {
        $classActScore2[] = $row['SCORE'];
    }
    $totalClassActData2 = 20;
    if(empty($classActScore2)){
        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">CLASSROOM ACTIVITIES <br/><b style="font-size: 8px;">(Semifinals to Finals)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalClassActData2; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        for($i = 1; $i <= $totalClassActData2; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }
    else{
        $totalExistingClassAct = count($classActScore2);
        $remainingTdClassAct = $totalClassActData2 - $totalExistingClassAct;

        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                           <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">CLASSROOM ACTIVITIES <br/><b style="font-size: 8px;">(Semifinals to Finals)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalClassActData2; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        foreach ($classActScore2 as $score){
            $html .= '<th>'.$score.'</th>';
        }

        for($i = 1; $i <= $remainingTdClassAct; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }


    //experiment  PRElims - mid

    $sqlExp = "SELECT s.SCORE
                FROM tb_score as s
                LEFT JOIN tb_class AS c ON c.CLASS_CODE = s.CLASS_CODE
                LEFT JOIN tb_user AS u ON u.id = s.STUDENT_ID
                WHERE s.STUDENT_ID = $id AND c.CLASS_CODE = ? AND s.TERM = 1 AND s.TYPE = 'EXPERIMENT' AND c.TYPE = '$options' AND s.CLASS_TYPE = '$options' 
                ORDER BY EXAM_DATE ASC";

    $stmtExp = $mysqli->prepare($sqlExp);

    $stmtExp->bind_param("s", $classCode);
    $stmtExp->execute();

    if ($stmtExp === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
        exit;
    }

    $resultExp = $stmtExp->get_result();

// Fetch
    $expScore= array();
    while ($row = $resultExp->fetch_assoc()) {
        $expScore[] = $row['SCORE'];
    }
    $totalExpData = 20;
    if(empty($expScore)){
        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                           <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">EXPERIMENTS <br/><b style="font-size: 8px;">(Prelims to Mid Term)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalExpData; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        for($i = 1; $i <= $totalExpData; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }
    else{
        $totalExistingExp = count($expScore);
        $remainingTdExp = $totalExpData - $totalExistingExp;

        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                           <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">EXPERIMENTS <br/><b style="font-size: 8px;">(Prelims to Mid Term)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalExpData; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        foreach ($expScore as $score){
            $html .= '<th>'.$score.'</th>';
        }

        for($i = 1; $i <= $remainingTdExp; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }


    $html .= '
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 70%">
                            <img src="' . __DIR__ . '/common/images/logo/lpu-logo.png" alt="Logo" width="250" height="250">
                        </td>
                        <td style="width: 30%;text-align: right;">
                            <p>FM-LPU-VPAR-33/D1</p>
                            <p> Office of the VP for Academic & Research </p>
                            <p style="font-size:13px;">Telephone No. (043) 723-0706 loc. 110/109</p>
                        </td>
                    </tr>
                </table>   
                <div style="text-align: center; margin-top: -10px;">
                    <h1 style="text-align: center; margin-top: -50px;">Student Progress Monitoring Sheet</h1>
                </div>
        ';

    //experiment  semis - finals
    $sqlExp2 = "SELECT s.SCORE
                FROM tb_score as s
                LEFT JOIN tb_class AS c ON c.CLASS_CODE = s.CLASS_CODE
                LEFT JOIN tb_user AS u ON u.id = s.STUDENT_ID
                WHERE s.STUDENT_ID = $id AND c.CLASS_CODE = ? AND s.TERM = 2 AND s.TYPE = 'EXPERIMENT' AND c.TYPE = '$options' AND s.CLASS_TYPE = '$options' 
                ORDER BY EXAM_DATE ASC";

    $stmtExp2 = $mysqli->prepare($sqlExp2);

    $stmtExp2->bind_param("s", $classCode);
    $stmtExp2->execute();

    if ($stmtExp2 === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
        exit;
    }

    $resultExp2 = $stmtExp2->get_result();

// Fetch
    $expScore= array();
    while ($row = $resultExp2->fetch_assoc()) {
        $expScore2[] = $row['SCORE'];
    }
    $totalExpData2 = 20;
    if(empty($expScore2)){
        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                           <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">EXPERIMENTS <br/><b style="font-size: 8px;">(Semis to Finals)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalExpData2; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        for($i = 1; $i <= $totalExpData2; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }
    else{
        $totalExistingExp = count($expScore2);
        $remainingTdExp = $totalExpData2 - $totalExistingExp;

        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                           <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">EXPERIMENTS <br/><b style="font-size: 8px;">(Semis to Finals)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalExpData2; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        foreach ($expScore2 as $score){
            $html .= '<th>'.$score.'</th>';
        }

        for($i = 1; $i <= $remainingTdExp; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }

    //others prelim to mid
    $sqlOthers = "SELECT s.SCORE
                FROM tb_score as s
                LEFT JOIN tb_class AS c ON c.CLASS_CODE = s.CLASS_CODE
                LEFT JOIN tb_user AS u ON u.id = s.STUDENT_ID
                WHERE s.STUDENT_ID = $id AND c.CLASS_CODE = ? AND s.TERM = 1 AND s.TYPE = 'OTHERS' AND c.TYPE = '$options' AND s.CLASS_TYPE = '$options' 
                ORDER BY EXAM_DATE ASC";

    $stmtOthers = $mysqli->prepare($sqlOthers);

    $stmtOthers->bind_param("s", $classCode);
    $stmtOthers->execute();

    if ($stmtOthers === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
        exit;
    }

    $resultOthers = $stmtOthers->get_result();

// Fetch
    $othersScore= array();
    while ($row = $resultOthers->fetch_assoc()) {
        $othersScore[] = $row['SCORE'];
    }
    $totalOthersData = 20;
    if(empty($othersScore)){
        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                           <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">OTHERS <br/><b style="font-size: 8px;">(Prelims to Mid Term)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalOthersData; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        for($i = 1; $i <= $totalOthersData; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }
    else{
        $totalExistingOthers = count($othersScore);
        $remainingTdOthers = $totalOthersData - $totalExistingOthers;

        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                           <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">OTHERS <br/><b style="font-size: 8px;">(Prelims to Mid term)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalOthersData; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        foreach ($othersScore as $score){
            $html .= '<th>'.$score.'</th>';
        }

        for($i = 1; $i <= $remainingTdOthers; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }

    //others semis to finals
    $sqlOthers2 = "SELECT s.SCORE
                FROM tb_score as s
                LEFT JOIN tb_class AS c ON c.CLASS_CODE = s.CLASS_CODE
                LEFT JOIN tb_user AS u ON u.id = s.STUDENT_ID
                WHERE s.STUDENT_ID = $id AND c.CLASS_CODE = ? AND s.TERM = 2 AND s.TYPE = 'OTHERS' AND c.TYPE = '$options' AND s.CLASS_TYPE = '$options' 
                ORDER BY EXAM_DATE ASC";

    $stmtOthers2 = $mysqli->prepare($sqlOthers2);

    $stmtOthers2->bind_param("s", $classCode);
    $stmtOthers2->execute();

    if ($stmtOthers2 === false) {
        echo json_encode(['status' => false, 'message' => 'Error in preparing the statement: ' . $mysqli->error]);
        exit;
    }

    $resultOthers2 = $stmtOthers2->get_result();

// Fetch
    $othersScore2= array();
    while ($row = $resultOthers2->fetch_assoc()) {
        $othersScore2[] = $row['SCORE'];
    }
    $totalOthersData2 = 20;
    if(empty($othersScore2)){
        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                           <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">OTHERS <br/><b style="font-size: 8px;">(Semifinals to Finals)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalOthersData2; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        for($i = 1; $i <= $totalOthersData2; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }
    else{
        $totalExistingOthers2 = count($othersScore2);
        $remainingTdOthers2 = $totalOthersData2 - $totalExistingOthers2;

        $html .= '
            <div style="text-align: center; margin-top: 10px;">
                    <table border="1" style="width: 100%;border-collapse: collapse;">
                        <tr>
                           <th rowspan="3" style="width: 300px;text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF">OTHERS <br/><b style="font-size: 8px;">(Semifinals to Finals)</b></th>
                        </tr>
                        <tr>
            ';

        for($i = 1; $i <= $totalOthersData2; $i++){
            $html .= '<th>'.$i.'</th>';
        }

        $html .= '</tr><tr>';

        foreach ($othersScore2 as $score){
            $html .= '<th>'.$score.'</th>';
        }

        for($i = 1; $i <= $remainingTdOthers2; $i++){
            $html .= '<th>0</th>';
        }

        $html .= '                        
                    </tr>
                    </table>
                    </div>
            ';
    }

    $html .= '
          <div style="text-align: center; margin-top: 10px;">
            <table border="1" style="width: 100%;border-collapse: collapse;">
                <tr>
                     <th colspan="2"  style="text-align: center;font-weight: bold;background-color: #800000;color: #FFFFFF;padding: 10px;"><b style="font-size: 12px;">REFLECTIVE ESSAY</b></th>
                </tr>
                <tr>
                    <td style="border-bottom: 0;">
                        <p>MIDTERM GRADING PERIOD</p>
                        <p>1. What is my course evaluation?</p>
                        <p>2. What do I feel?</p>
                        <p>3. What should I do to improve my performance and past this course?</p>
                    </td>
                    <td style="border-bottom: 0;">
                        <p>FINAL GRADING PERIOD</p>
                        <p>1. What is my course evaluation?</p>
                        <p>2. What do I feel?</p>
                        <p>3. What should I do to improve my performance and past this course?</p>
                    </td>
                </tr>
                <tr>
                    <td style="height: 200px; border-top: 0;"></td>
                    <td style="height: 200px; border-top: 0;"></td>
                </tr>
            </table>
          </div>
    ';

}
else {
    $error = errorRequest::getErrorMessage(405); // Get the error message for 405 (Method Not Allowed)
    http_response_code(405); // Set the HTTP response code
    echo json_encode(['status' => false, 'error' => $error]);
    exit;
}

// Create a new MPDF object
$mpdf = new \Mpdf\Mpdf(['format' => 'Legal-L']);
$mpdf->SetMargins(10, 10, 0, 10);
// Your HTML template


// Add the HTML content to the PDF
$mpdf->WriteHTML($html);

// Output the PDF to the browser or save it to a file
$mpdf->Output('output.pdf', 'I');
?>
