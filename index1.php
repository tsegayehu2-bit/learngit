<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - Mekdela Amba University</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #0033cc; margin-bottom: 30px; }
        label { display: block; margin: 10px 0 5px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; }
        .course-section { background: #f9f9f9; padding: 15px; border-radius: 5px; margin: 10px 0; }
        button { background: #0033cc; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; width: 100%; }
        button:hover { background: #002299; }
        .required { color: red; }
        .form-row { display: flex; gap: 20px; }
        .form-row > div { flex: 1; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Registration Form</h1>
        <form action="register1.php" method="POST" id="registrationForm">
            
            <div class="form-row">
                <div>
                    <label for="student_id">Student ID <span class="required">*</span></label>
                    <input type="text" name="student_id" id="student_id" placeholder="Enter Student ID" required>
                </div>
                <div>
                    <label for="full_ame">Full Name <span class="required">*</span></label>
                    <input type="text" name="full_ame" id="full_ame" placeholder="Enter Full Name" required>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" name="password" id="password" placeholder="Enter Password" required>
                </div>
                <div>
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" name="email" id="email" placeholder="Enter Email" required>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="phone">Phone <span class="required">*</span></label>
                    <input type="text" name="phone" id="phone" placeholder="Enter Phone Number" required>
                </div>
                <div>
                    <label for="age">Age <span class="required">*</span></label>
                    <input type="number" name="age" id="age" placeholder="Enter Age" min="15" max="60" required>
                </div>
            </div>

            <label for="address">Address <span class="required">*</span></label>
            <input type="text" name="address" id="address" placeholder="Enter Address" required>

            <div class="form-row">
                <div>
                    <label for="birthdate">Birth Date <span class="required">*</span></label>
                    <input type="date" name="birthdate" id="birthdate" required>
                </div>
                <div>
                    <label for="registration_date">Registration Date <span class="required">*</span></label>
                    <input type="date" name="registration_date" id="registration_date" required>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="department">Department <span class="required">*</span></label>
                    <select name="department" id="department" required>
                        <option value="">-- Select Department --</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Information Technology">Information Technology</option>
                        <option value="Software Engineering">Software Engineering</option>
                        <option value="Mechanical Engineering">Mechanical Engineering</option>
                        <option value="Electrical Engineering">Electrical Engineering</option>
                        <option value="Biology">Biology</option>
                        <option value="Mathematics">Mathematics</option>
                        <option value="Physics">Physics</option>
                        <option value="Chemistry">Chemistry</option>
                    </select>
                </div>
                <div>
                    <label for="year_of_study">Year of Study <span class="required">*</span></label>
                    <select name="year_of_study" id="year_of_study" required>
                        <option value="">-- Select Year --</option>
                        <option value="1">Year 1</option>
                        <option value="2">Year 2</option>
                        <option value="3">Year 3</option>
                        <option value="4">Year 4</option>
                    </select>
                </div>
            </div>

            <label for="semester">Select Semester <span class="required">*</span></label>
            <select name="semester" id="semester" onchange="toggleCourses()" required>
                <option value="">-- Select Semester --</option>
                <option value="sem1">Semester 1</option>
                <option value="sem2">Semester 2</option>
            </select>

            <div id="sem1Courses" class="course-section" style="display:none;">
                <h3>Semester 1 Courses</h3>
                <label><input type="checkbox" name="courses[]" value="Java"> Java</label><br>
                <label><input type="checkbox" name="courses[]" value="Multimedia"> Multimedia</label><br>
                <label><input type="checkbox" name="courses[]" value="System Analysis"> System Analysis</label><br>
                <label><input type="checkbox" name="courses[]" value="Maintenance"> Maintenance</label><br>
                <label><input type="checkbox" name="courses[]" value="Advanced DB"> Advanced DB</label><br>
                <label><input type="checkbox" name="courses[]" value="Internet Programming II"> Internet Programming II</label>
            </div>

            <div id="sem2Courses" class="course-section" style="display:none;">
                <h3>Semester 2 Courses</h3>
                <label><input type="checkbox" name="courses[]" value="Math"> Math</label><br>
                <label><input type="checkbox" name="courses[]" value="C++"> C++</label><br>
                <label><input type="checkbox" name="courses[]" value="Java"> Java</label><br>
                <label><input type="checkbox" name="courses[]" value="Database"> Database</label><br>
                <label><input type="checkbox" name="courses[]" value="Internet Programming I"> Internet Programming I</label>
            </div>

            <h3>Grades</h3>
            <div class="form-row">
                <div>
                    <label for="quize">Quiz (10%) <span class="required">*</span></label>
                    <input type="number" name="quize" id="quize" placeholder="0-10" min="0" max="10" step="0.1" required>
                </div>
                <div>
                    <label for="assignment">Assignment (20%) <span class="required">*</span></label>
                    <input type="number" name="assignment" id="assignment" placeholder="0-20" min="0" max="20" step="0.1" required>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="mid">Mid Exam (20%) <span class="required">*</span></label>
                    <input type="number" name="mid" id="mid" placeholder="0-20" min="0" max="20" step="0.1" required>
                </div>
                <div>
                    <label for="final">Final Exam (50%) <span class="required">*</span></label>
                    <input type="number" name="final" id="final" placeholder="0-50" min="0" max="50" step="0.1" required>
                </div>
            </div>

            <button type="submit">Register Student</button>
        </form>
    </div>

    <script>

        // Add this to ensure course checkboxes submit properly
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    var semester = document.getElementById('semester').value;
    var courseCheckboxes = document.querySelectorAll('input[name="courses[]"]:checked');
    
    // Show warning if semester selected but no courses chosen
    if (semester && courseCheckboxes.length === 0) {
        if (!confirm('You have selected a semester but no courses. Continue without selecting courses?')) {
            e.preventDefault();
            return false;
        }
    }
    
    // Enable all checkboxes (even hidden ones) before submit
    var allCheckboxes = document.querySelectorAll('input[name="courses[]"]');
    allCheckboxes.forEach(function(checkbox) {
        checkbox.disabled = false;
    });
});
    function toggleCourses() {
        var semesterSelect = document.getElementById('semester');
        var sem1Div = document.getElementById('sem1Courses');
        var sem2Div = document.getElementById('sem2Courses');
        
        // Hide both course sections first
        sem1Div.style.display = 'none';
        sem2Div.style.display = 'none';
        
        // Uncheck all checkboxes when switching semesters
        var checkboxes = document.querySelectorAll('input[name="courses[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
        
        // Show the appropriate course section based on selection
        if (semesterSelect.value === 'sem1') {
            sem1Div.style.display = 'block';
        } else if (semesterSelect.value === 'sem2') {
            sem2Div.style.display = 'block';
        }
    }
    
    // Set today's date as default for registration date
    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('registration_date').value = today;
        
        // Set max date for birthdate (minimum age 15 years)
        var maxBirthDate = new Date();
        maxBirthDate.setFullYear(maxBirthDate.getFullYear() - 15);
        document.getElementById('birthdate').max = maxBirthDate.toISOString().split('T')[0];
    });
    </script>
</body>
</html>