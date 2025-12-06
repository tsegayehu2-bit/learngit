<?php
require_once "db.php";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    // Get all POST data
    $student_id  = trim($_POST['student_id']);
    $full_ame    = trim($_POST['full_ame']);
    $password    = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email       = trim($_POST['email']);
    $phone       = trim($_POST['phone']);
    $address     = trim($_POST['address']);
    $birthdate   = $_POST['birthdate'];
    $department  = trim($_POST['department']);
    $year_of_study = (int)$_POST['year_of_study'];
    $semester    = trim($_POST['semester']);
    
    // DEBUG: Check courses data
    echo "<!-- DEBUG: POST courses data -->\n";
    echo "<!-- courses POST exists: " . (isset($_POST['courses']) ? 'YES' : 'NO') . " -->\n";
    if (isset($_POST['courses'])) {
        echo "<!-- courses type: " . gettype($_POST['courses']) . " -->\n";
        echo "<!-- courses value: " . print_r($_POST['courses'], true) . " -->\n";
    }
    
    // FIXED: Handle courses array properly
    $courses = "No courses selected";
    if (isset($_POST['courses'])) {
        if (is_array($_POST['courses'])) {
            // Remove empty values from array
            $courses_array = array_filter($_POST['courses']);
            if (!empty($courses_array)) {
                $courses = implode(", ", $courses_array);
            }
        } elseif (!empty(trim($_POST['courses']))) {
            $courses = trim($_POST['courses']);
        }
    }
    
    echo "<!-- DEBUG: Final courses value: " . $courses . " -->\n";
    
    $quize       = (float)$_POST['quize'];
    $assignment  = (float)$_POST['assignment'];
    $mid         = (float)$_POST['mid'];
    $final       = (float)$_POST['final'];
    $age         = (int)$_POST['age'];
    $registration_date = date('Y-m-d', strtotime($_POST['registration_date']));

    // Calculate total grade and status
    $total_grade = $quize + $assignment + $mid + $final;
    $grade_status = ($total_grade >= 50) ? 'Pass' : 'Fail';

    // Debug SQL before execution
    echo "<!-- DEBUG: SQL will insert courses as: " . htmlspecialchars($courses) . " -->\n";

    // Prepare SQL statement
    $stmt = $conn->prepare("
        INSERT INTO studentss 
        (student_id, full_ame, password, email, phone, address, 
         birthdate, department, year_of_study, semester, courses, 
         quize, assignment, mid, final, age, registration_date,
         total_grade, grade_status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error . "<br>SQL Error: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param(
        "ssssssssisdddddisds",
        $student_id,
        $full_ame,
        $password,
        $email,
        $phone,
        $address,
        $birthdate,
        $department,
        $year_of_study,
        $semester,
        $courses,        // This should now have course names
        $quize,
        $assignment,
        $mid,
        $final,
        $age,
        $registration_date,
        $total_grade,
        $grade_status
    );

    if ($stmt->execute()) {
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Registration Successful</title>
            <style>
                body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f4f4f4; }
                .success { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto; }
                h2 { color: #28a745; margin-bottom: 20px; }
                .student-info { text-align: left; background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0; }
                .student-info p { margin: 8px 0; padding: 5px 0; border-bottom: 1px solid #eee; }
                .student-info p:last-child { border-bottom: none; }
                .links { margin-top: 30px; }
                .links a { display: inline-block; margin: 10px; padding: 12px 24px; background: #0033cc; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
                .links a:hover { background: #002299; }
                .grade-pass { color: #28a745; font-weight: bold; }
                .grade-fail { color: #dc3545; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='success'>
                <h2>✅ Student Registered Successfully!</h2>
                
                <div class='student-info'>
                    <p><strong>Student Details:</strong></p>
                    <p><strong>Student ID:</strong> " . htmlspecialchars($student_id) . "</p>
                    <p><strong>Full Name:</strong> " . htmlspecialchars($full_ame) . "</p>
                    <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
                    <p><strong>Phone:</strong> " . htmlspecialchars($phone) . "</p>
                    <p><strong>Department:</strong> " . htmlspecialchars($department) . "</p>
                    <p><strong>Year:</strong> " . htmlspecialchars($year_of_study) . "</p>
                    <p><strong>Semester:</strong> " . htmlspecialchars($semester) . "</p>
                    <p><strong>Courses:</strong> " . htmlspecialchars($courses) . "</p>
                    <p><strong>Quiz:</strong> " . number_format($quize, 2) . "/10</p>
                    <p><strong>Assignment:</strong> " . number_format($assignment, 2) . "/20</p>
                    <p><strong>Mid Exam:</strong> " . number_format($mid, 2) . "/20</p>
                    <p><strong>Final Exam:</strong> " . number_format($final, 2) . "/50</p>
                    <p><strong>Total Grade:</strong> " . number_format($total_grade, 2) . "/100</p>
                    <p><strong>Status:</strong> <span class='" . ($grade_status == 'Pass' ? 'grade-pass' : 'grade-fail') . "'>" . $grade_status . "</span></p>
                    <p><strong>Age:</strong> " . htmlspecialchars($age) . "</p>
                    <p><strong>Registration Date:</strong> " . htmlspecialchars($registration_date) . "</p>
                </div>
                
                <div class='links'>
                    <a href='index1.php'>➕ Add Another Student</a>
                    <a href='view.php'>👥 View All Students</a>
                </div>
            </div>
        </body>
        </html>";
    } else {
        echo "<div style='text-align:center; padding:50px;'>
                <h2 style='color:red;'>❌ Error: " . htmlspecialchars($stmt->error) . "</h2>
                <p style='margin-top:20px;'><a href='index1.php' style='padding:10px 20px; background:#0033cc; color:white; text-decoration:none; border-radius:5px;'>← Go Back to Registration</a></p>
              </div>";
    }

    $stmt->close();
} else {
    // If not POST request, redirect to registration form
    header("Location: index1.php");
    exit();
}

$conn->close();
?>