<div class="modal" id="addClassModal">
    <div class="modal-content">
        <div class="modal-title">
            <p>Create Class</p>
        </div>
        <div class="modal-body">
            <form id="createClassForm">
                <div class="create-class">
                    <div class="create-class-item">
                        <div class="create-class-item-content">
                            <div class="create-class-item--content">
                                <span class="custom-select-class">
                                    <select  class="college-select" id="create-type" name="create-type">
                                        <option value="">Type</option>
                                        <option value="LECTURE">Lecture</option>
                                        <option value="BOTH">Lecture & Laboratory</option>
                                    </select>
                                </span>
                                <small class="message message-type"></small>
                            </div>
                            <div class="create-class-item--content">
                                <input type="text" class="create-class-input" id="class-academic-year" name="class-academic-year" placeholder="Academic Year">
                                <small class="message message-class-academic-year"></small>
                            </div>
                        </div>
                    </div>
                    <div class="create-class-item">
                        <div class="create-class-item-content">
                            <div class="create-class-item--content">
                                <input type="text" class="create-class-input" id="className" name="className" placeholder="Class Name">
                                <small class="message message-className"></small>
                            </div>
                            <div class="create-class-item--content">
                             <span class="custom-select-class">
                                    <select  class="college-select" id="create-program" name="create-program">
                                        <option value="">Program</option>
                                        <option value="BSCS">BSCS</option>
                                        <option value="BSIT">BSIT</option>
                                    </select>
                                </span>
                                <small class="message message-program"></small>
                            </div>
                        </div>
                    </div>
                    <div class="create-class-item">
                        <div class="create-class-item-content">
                            <div class="create-class-item--content">
                               <span class="custom-select-class">
                                    <select  class="college-select" id="create-sem" name="create-sem">
                                        <option value="">Semester</option>
                                        <option value="1">1st</option>
                                        <option value="2">2nd</option>
                                        <option value="3">Summer</option>
                                    </select>
                                </span>
                                <small class="message message-semester"></small>
                            </div>
                            <div class="create-class-item--content">
                                <span class="custom-select-class">
                                    <select  class="college-select" id="create-year" name="create-year">
                                        <option value="">Year</option>
                                        <option value="I">I</option>
                                        <option value="II">II</option>
                                        <option value="III">III</option>
                                        <option value="III">III</option>
                                        <option value="IV">IV</option>
                                    </select>
                                </span>
                                <small class="message message-year"></small>
                            </div>
                        </div>
                    </div>
                    <div class="create-class-item">
                        <div class="create-class-item-content">
                            <div class="create-class-item--content">
                                <span class="custom-select-class">
                                    <select  class="college-select" id="create-course" name="create-course">
                                        <option value="">Course</option>
                                        <?php foreach ($courseData as $course) {?>
                                            <option value="<?php echo $course['COURSE_CODE'] ?>"><?php echo $course['COURSE_CODE'] ?></option>
                                        <?php }?>
                                    </select>
                                </span>
                                <small class="message message-course"></small>
                            </div>
                            <div class="create-class-item--content">
                               <span class="custom-select-class">
                                    <select  class="college-select" id="create-section" name="create-section">
                                        <option value="">Section</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                    </select>
                                </span>
                                <small class="message message-section"></small>
                            </div>
                        </div>
                    </div>
                    <div class="create-class-item">
                        <div class="create-schedule">
                            <h3>Schedule</h3>
                        </div>
                    </div>
                    <div class="create-class-item">
                        <label for="monday">Monday </label>
                        <input type="checkbox" class="checkBoxes" id="monday" name="monday" value="on">
                        <label for="tuesday">Tuesday</label>
                        <input type="checkbox" class="checkBoxes" id="tuesday" name="tuesday" value="on">
                        <label for="wednesday">Wednesday </label>
                        <input type="checkbox" class="checkBoxes" id="wednesday" name="wednesday" value="on">
                        <label for="thursday">Thursday</label>
                        <input type="checkbox" class="checkBoxes" id="thursday" name="thursday" value="on">
                        <label for="friday">Friday </label>
                        <input type="checkbox" class="checkBoxes" id="friday" name="friday" value="on">
                        <label for="saturday">Saturday</label>
                        <input type="checkbox" class="checkBoxes" id="saturday" name="saturday" value="on">
                        <small class="message message-schedule"></small>
                    </div>
                    <div class="create-class-item">
                        <div class="create-schedule">
                            <h3>Time</h3>
                            <div class="time-item">
                                <input type="time" id="am">
                                <span>To</span>
                                <input type="time" id="pm">
                            </div>

                        </div>
                        <small class="message message-time"></small>

                    </div>
                </div>
                <div class="class-save-container">
                    <button type="button" class="btn-save" onclick="createClass('add','createClassForm')">Save</button>
                    <button type="button" class="closeModalBtn btn-cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="classEdit">
    <div class="modal-content">
        <div class="modal-title">
            <p>Edit Class</p>
        </div>
        <div class="modal-body">
            <form id="updateClassForm">
                <div class="create-class">
                    <input type="text" id="classId" name="classId" readonly hidden >
                    <div class="create-class-item">
                        <div class="create-class-item-content">
                            <div class="create-class-item--content">
<!--                                <span class="custom-select-class">-->
<!--                                    <select  class="college-select" id="update-create-type" name="update-create-type">-->
<!--                                        <option value="">Type</option>-->
<!--                                        <option value="LABORATORY">Laboratory</option>-->
<!--                                        <option value="LECTURE">Lecture</option>-->
<!--                                    </select>-->
<!--                                </span>-->
<!--                                <small class="message message-update-type"></small>-->
                                <input type="text" class="creat-class-input" id="update-create-type" name="update-create-type" placeholder="" READONLY>
                            </div>
                            <div class="create-class-item--content">
                                <input type="text" class="creat-class-input" id="update-class-academic-year" name="update-class-academic-year" placeholder="Academic Year">
                                <small class="message message-update-class-academic-year"></small>
                            </div>
                        </div>
                    </div>
                    <div class="create-class-item">
                        <div class="create-class-item-content">
                            <div class="create-class-item--content">
                                <input type="text" class="creat-class-input" id="update-className" name="update-className" placeholder="Class Name">
                                <small class="message message-update-className"></small>
                            </div>
                            <div class="create-class-item--content">
                             <span class="custom-select-class">
                                    <select  class="college-select" id="update-create-program" name="update-create-program">
                                        <option value="">Program</option>
                                        <option value="BSCS">BSCS</option>
                                        <option value="BSIT">BSIT</option>
                                    </select>
                                </span>
                                <small class="message message-update-program"></small>
                            </div>
                        </div>
                    </div>
                    <div class="create-class-item">
                        <div class="create-class-item-content">
                            <div class="create-class-item--content">
                               <span class="custom-select-class">
                                    <select  class="college-select" id="update-create-sem" name="create-sem">
                                        <option value="">Semester</option>
                                        <option value="1">1st</option>
                                        <option value="2">2nd</option>
                                        <option value="3">Summer</option>
                                    </select>
                                </span>
                                <small class="message message-update-semester"></small>
                            </div>
                            <div class="create-class-item--content">
                                <span class="custom-select-class">
                                    <select  class="college-select" id="update-create-year" name="update-create-year">
                                        <option value="">Year</option>
                                        <option value="I">I</option>
                                        <option value="II">II</option>
                                        <option value="III">III</option>
                                        <option value="III">III</option>
                                        <option value="IV">IV</option>
                                    </select>
                                </span>
                                <small class="message message-update-year"></small>
                            </div>
                        </div>
                    </div>
                    <div class="create-class-item">
                        <div class="create-class-item-content">
                            <div class="create-class-item--content">
                                <span class="custom-select-class">
                                    <select  class="college-select" id="update-create-course" name="update-create-course">
                                        <option value="">Course</option>
                                        <?php foreach ($courseData as $course) {?>
                                            <option value="<?php echo $course['COURSE_CODE'] ?>"><?php echo $course['COURSE_DESC'] ?></option>
                                        <?php }?>
                                    </select>
                                </span>
                                <small class="message message-update-course"></small>
                            </div>
                            <div class="create-class-item--content">
                               <span class="custom-select-class">
                                    <select  class="college-select" id="update-create-section" name="update-create-section">
                                        <option value="">Section</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                    </select>
                                </span>
                                <small class="message message-update-section"></small>
                            </div>
                        </div>
                    </div>
                    <div class="create-class-item">
                        <div class="create-class-item-content">
                            <div class="create-class-item--content">
                                <label><b>Total Attendance</b></label>
                                <input type="text" class="creat-class-input" id="update-class-att" name="update-class-att" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="2" placeholder="Total Attendance">
                                <small class="message message-update-class-att"></small>
                            </div>
                            <div class="create-class-item--content">
                                <label><b>Total Quizzes</b></label>
                                <input type="text" class="creat-class-input" id="update-class-quiz" name="update-class-quiz" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="2" placeholder="Total Quizzes">
                                <small class="message message-update-class-quiz"></small>
                            </div>
                        </div>
                    </div>
                    <div class="create-class-item">
                        <div class="create-class-item-content" id="lecOrLab">

                        </div>
                    </div>
                    <div class="create-class-item">
                        <div class="create-schedule">
                            <h3>Schedule</h3>
                        </div>
                    </div>
                    <div class="create-class-item">
                        <label for="update-monday">Monday </label>
                        <input type="checkbox" class="checkBoxes-update" id="update-monday" name="update-monday">
                        <label for="update-tuesday">Tuesday</label>
                        <input type="checkbox" class="checkBoxes-update" id="update-tuesday" name="update-tuesday">
                        <label for="update-wednesday">Wednesday </label>
                        <input type="checkbox" class="checkBoxes-update" id="update-wednesday" name="update-wednesday">
                        <label for="update-thursday">Thursday</label>
                        <input type="checkbox" class="checkBoxes-update" id="update-thursday" name="update-thursday">
                        <label for="update-friday">Friday </label>
                        <input type="checkbox" class="checkBoxes-update" id="update-friday" name="update-friday">
                        <label for="update-saturday">Saturday</label>
                        <input type="checkbox" class="checkBoxes-update" id="update-saturday" name="update-saturday">
                        <small class="message message-update-schedule"></small>
                    </div>
                    <div class="create-class-item">
                        <div class="create-schedule">
                            <h3>Time</h3>
                            <div class="time-item">
                                <input type="time" id="update-am">
                                <span>To</span>
                                <input type="time" id="update-pm">
                            </div>

                        </div>
                        <small class="message message-update-time"></small>

                    </div>
                </div>
                <div class="class-save-container">
                    <button type="button" class="btn-save" onclick="createClass('edit','updateClassForm')">Save</button>
                    <button type="button" class="closeModalBtn btn-cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="classView">
    <div class="modal-content">
        <div class="modal-title">
           <div class="class-title">
               <div class="class-title-content">
                    <div class="class-title-item">
                        <span id="class_name"></span>
                        <span id="secyear">1st Year - IT 1-a</span>
                        <span id="sem"></span>
                        <span id="ayear">2023-2024</span>
                    </div>
               </div>
               <div class="class-title-code" onclick="copy()">
                    <span id="classcode" ></span>
                   <i class="fa-regular fa-copy fa-xl" style="margin-left: 10px"></i>
                   <div id="notification" style="display: none; background-color: transparent; color: #000000;"></div>
               </div>
           </div>
        </div>
        <div class="modal-body">
            <div class="table-container-modal">
                <table class="class-student-list-table" >
                    <thead>
                    <tr>
                        <th>Student</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>