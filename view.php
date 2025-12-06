<?php
require_once "db.php";

// Get all students
$sql = "SELECT * FROM studentss ORDER BY id DESC";
$result = $conn->query($sql);

$students = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students - Mekdela Amba University</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; }
        h1 { text-align: center; color: #0033cc; margin-bottom: 30px; padding: 20px; background: white; border-radius: 10px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: center; font-size: 14px; }
        th { background: #0033cc; color: white; position: sticky; top: 0; }
        tr:nth-child(even) { background: #f9f9f9; }
        tr:hover { background: #f1f7ff; }
        .actions { text-align: center; margin: 30px 0; }
        .actions a { display: inline-block; margin: 0 10px; padding: 12px 24px; background: #0033cc; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .actions a:hover { background: #002299; }
        .no-data { text-align: center; padding: 40px; background: white; border-radius: 10px; }
        .grade-pass { color: #28a745; font-weight: bold; }
        .grade-fail { color: #dc3545; font-weight: bold; }
        .status-pass { background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 3px; }
        .status-fail { background: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 3px; }
        .courses { max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .courses:hover { white-space: normal; overflow: visible; position: relative; z-index: 100; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.2); }
        .stats { background: white; padding: 20px; border-radius: 10px; margin: 20px 0; text-align: center; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 20px; }
        .stat-box { background: #f8f9fa; padding: 15px; border-radius: 5px; border-left: 4px solid #0033cc; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 Registered Students - Mekdela Amba University</h1>
        
        <?php if(!empty($students)): 
            // Calculate statistics
            $total_students = count($students);
            $pass_count = 0;
            $fail_count = 0;
            $total_grade_sum = 0;
            
            foreach($students as $student) {
                $total_grade = $student['total_grade'] ?? 0;
                $total_grade_sum += $total_grade;
                if (($student['grade_status'] ?? 'Fail') == 'Pass') {
                    $pass_count++;
                } else {
                    $fail_count++;
                }
            }
            
            $average_grade = $total_students > 0 ? $total_grade_sum / $total_students : 0;
        ?>
        
        <div class="stats">
            <h3>📊 Statistics</h3>
            <div class="stats-grid">
                <div class="stat-box">
                    <h4>Total Students</h4>
                    <p style="font-size: 24px; font-weight: bold; color: #0033cc;"><?= $total_students ?></p>
                </div>
                <div class="stat-box">
                    <h4>Passed</h4>
                    <p style="font-size: 24px; font-weight: bold; color: #28a745;"><?= $pass_count ?></p>
                </div>
                <div class="stat-box">
                    <h4>Failed</h4>
                    <p style="font-size: 24px; font-weight: bold; color: #dc3545;"><?= $fail_count ?></p>
                </div>
                <div class="stat-box">
                    <h4>Average Grade</h4>
                    <p style="font-size: 24px; font-weight: bold; color: #6c757d;"><?= number_format($average_grade, 2) ?></p>
                </div>
            </div>
        </div>
        
        <div style="overflow-x: auto;">
            <table>
                <td class="courses" title="<?= htmlspecialchars($student['courses'] ?? '') ?>">
    <?= !empty($student['courses']) && $student['courses'] !== '0' ? 
         htmlspecialchars($student['courses']) : 
         'No courses selected' ?>
</td>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Department</th>
                        <th>Year</th>
                        <th>Semester</th>
                        <th>Courses</th>
                        <th>Quiz</th>
                        <th>Assignment</th>
                        <th>Mid</th>
                        <th>Final</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Age</th>
                        <th>Reg. Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($students as $student): 
                        $total = $student['total_grade'] ?? 0;
                        $grade_status = $student['grade_status'] ?? 'Fail';
                        $status_class = $grade_status == 'Pass' ? 'status-pass' : 'status-fail';
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($student['id'] ?? '') ?></td>
                        <td><strong><?= htmlspecialchars($student['student_id'] ?? '') ?></strong></td>
                        <td><?= htmlspecialchars($student['full_ame'] ?? '') ?></td>
                        <td><?= htmlspecialchars($student['email'] ?? '') ?></td>
                        <td><?= htmlspecialchars($student['phone'] ?? '') ?></td>
                        <td><?= htmlspecialchars($student['department'] ?? '') ?></td>
                        <td>Year <?= htmlspecialchars($student['year_of_study'] ?? '') ?></td>
                        <td><?= htmlspecialchars($student['semester'] ?? '') ?></td>
                        <td class="courses" title="<?= htmlspecialchars($student['courses'] ?? '') ?>">
                            <?= htmlspecialchars($student['courses'] ?? 'No courses') ?>
                        </td>
                        <td><?= number_format($student['quize'] ?? 0, 2) ?></td>
                        <td><?= number_format($student['assignment'] ?? 0, 2) ?></td>
                        <td><?= number_format($student['mid'] ?? 0, 2) ?></td>
                        <td><?= number_format($student['final'] ?? 0, 2) ?></td>
                        <td class="<?= $grade_status == 'Pass' ? 'grade-pass' : 'grade-fail' ?>">
                            <?= number_format($total, 2) ?>
                        </td>
                        <td><span class="<?= $status_class ?>"><?= htmlspecialchars($grade_status) ?></span></td>
                        <td><?= htmlspecialchars($student['age'] ?? '') ?></td>
                        <td><?= htmlspecialchars($student['registration_date'] ?? '') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="actions">
            <a href="index1.php">➕ Add New Student</a>
            <a href="#" onclick="window.print()">🖨️ Print List</a>
            <a href="export.php">📥 Export Data</a>
        </div>
        
        <?php else: ?>
            <div class="no-data">
                <h2>📭 No Students Registered Yet</h2>
                <p>No student records found in the database.</p>
                <div class="actions">
                    <a href="index1.php">📝 Register First Student</a>
                </div>
            </div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 30px; color: #666; font-size: 14px;">
            <p>Database: mekdela amba | Table: studentss | Total Records: <?= $total_students ?? 0 ?></p>
            <p>Generated on: <?= date('Y-m-d H:i:s') ?></p>
        </div>
    </div>
    
    <script>
    // Make courses column expand on click
    document.addEventListener('DOMContentLoaded', function() {
        var courseCells = document.querySelectorAll('.courses');
        courseCells.forEach(function(cell) {
            cell.addEventListener('click', function() {
                this.classList.toggle('expanded');
            });
        });
        
        // Add keyboard shortcut for printing
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
    });
    </script>
</body>
</html>

<?php
$conn->close();
?>