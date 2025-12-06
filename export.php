<?php
require_once "db.php";

// Check if download is requested
if (isset($_GET['download']) && $_GET['download'] == 'csv') {
    // Set headers for file download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=students_' . date('Y-m-d_H-i-s') . '.csv');
    
    // Create output stream
    $output = fopen('php://output', 'w');
    
    // Add UTF-8 BOM for Excel compatibility
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // CSV headers
    $headers = array(
        'ID',
        'Student ID', 
        'Full Name',
        'Email',
        'Phone',
        'Address',
        'Birth Date',
        'Department',
        'Year of Study',
        'Semester',
        'Courses',
        'Quiz (10%)',
        'Assignment (20%)',
        'Mid Exam (20%)',
        'Final Exam (50%)',
        'Total Grade',
        'Grade Status',
        'Age',
        'Registration Date',
        'Created At'
    );
    
    // Write headers
    fputcsv($output, $headers);
    
    // Get student data
    $sql = "SELECT * FROM studentss ORDER BY id DESC";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Prepare data for CSV
            $data = array(
                $row['id'] ?? '',
                $row['student_id'] ?? '',
                $row['full_ame'] ?? '',
                $row['email'] ?? '',
                $row['phone'] ?? '',
                $row['address'] ?? '',
                $row['birthdate'] ?? '',
                $row['department'] ?? '',
                $row['year_of_study'] ?? '',
                $row['semester'] ?? '',
                $row['courses'] ?? '',
                number_format($row['quize'] ?? 0, 2),
                number_format($row['assignment'] ?? 0, 2),
                number_format($row['mid'] ?? 0, 2),
                number_format($row['final'] ?? 0, 2),
                number_format($row['total_grade'] ?? 0, 2),
                $row['grade_status'] ?? '',
                $row['age'] ?? '',
                $row['registration_date'] ?? '',
                $row['created_at'] ?? ''
            );
            
            fputcsv($output, $data);
        }
    } else {
        fputcsv($output, array('No student data available'));
    }
    
    fclose($output);
    exit();
}

// HTML Interface for Export
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Student Data - Mekdela Amba University</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #0033cc; margin-bottom: 30px; }
        .export-options { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 30px 0; }
        .option-card { background: #f8f9fa; padding: 25px; border-radius: 8px; border-left: 4px solid #0033cc; text-align: center; }
        .option-card h3 { color: #0033cc; margin-bottom: 15px; }
        .option-card p { color: #666; margin-bottom: 20px; }
        .btn { display: inline-block; padding: 12px 30px; background: #0033cc; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; border: none; cursor: pointer; }
        .btn:hover { background: #002299; }
        .btn-excel { background: #217346; }
        .btn-excel:hover { background: #1a5c38; }
        .btn-pdf { background: #dc3545; }
        .btn-pdf:hover { background: #c82333; }
        .btn-print { background: #6c757d; }
        .btn-print:hover { background: #5a6268; }
        .back-link { text-align: center; margin-top: 30px; }
        .back-link a { color: #0033cc; text-decoration: none; }
        .back-link a:hover { text-decoration: underline; }
        .stats { background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
        .stat-box { text-align: center; padding: 15px; }
        .stat-value { font-size: 24px; font-weight: bold; color: #0033cc; }
        .stat-label { color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📥 Export Student Data</h1>
        
        <?php
        // Get statistics
        $sql_stats = "SELECT 
            COUNT(*) as total_students,
            SUM(CASE WHEN grade_status = 'Pass' THEN 1 ELSE 0 END) as passed,
            SUM(CASE WHEN grade_status = 'Fail' THEN 1 ELSE 0 END) as failed,
            AVG(total_grade) as avg_grade
            FROM studentss";
        
        $result_stats = $conn->query($sql_stats);
        $stats = $result_stats->fetch_assoc();
        ?>
        
        <div class="stats">
            <h3>📊 Current Database Statistics</h3>
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-value"><?= $stats['total_students'] ?? 0 ?></div>
                    <div class="stat-label">Total Students</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?= $stats['passed'] ?? 0 ?></div>
                    <div class="stat-label">Passed</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?= $stats['failed'] ?? 0 ?></div>
                    <div class="stat-label">Failed</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value"><?= number_format($stats['avg_grade'] ?? 0, 2) ?></div>
                    <div class="stat-label">Avg Grade</div>
                </div>
            </div>
        </div>
        
        <p style="text-align: center; color: #666; margin: 20px 0;">
            Export student data in various formats. CSV format is recommended for Excel.
        </p>
        
        <div class="export-options">
            <div class="option-card">
                <h3>📄 CSV Format</h3>
                <p>Export data as CSV file (Comma Separated Values). Best for Microsoft Excel and Google Sheets.</p>
                <a href="export.php?download=csv" class="btn btn-excel">⬇️ Download CSV</a>
            </div>
            
            <div class="option-card">
                <h3>🖨️ Print Report</h3>
                <p>Generate a printer-friendly version of the student list for physical records.</p>
                <button onclick="window.print()" class="btn btn-print">🖨️ Print Report</button>
            </div>
        </div>
        
        <div style="background: #fff3cd; padding: 20px; border-radius: 8px; margin: 30px 0; border-left: 4px solid #ffc107;">
            <h3 style="color: #856404; margin-bottom: 10px;">⚠️ Export Information</h3>
            <ul style="color: #856404; padding-left: 20px;">
                <li>CSV files can be opened in Microsoft Excel, Google Sheets, or any spreadsheet software</li>
                <li>Total records to export: <strong><?= $stats['total_students'] ?? 0 ?></strong> students</li>
                <li>File will be named: <code>students_<?= date('Y-m-d_H-i-s') ?>.csv</code></li>
                <li>Data includes all student information from the database</li>
            </ul>
        </div>
        
        <div class="back-link">
            <a href="view.php">← Back to Student List</a> | 
            <a href="index1.php">Go to Registration Form</a>
        </div>
    </div>
    
    <script>
    // Auto-download CSV after 2 seconds if coming from view.php
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('auto') === 'csv') {
            setTimeout(function() {
                window.location.href = 'export.php?download=csv';
            }, 2000);
        }
    });
    </script>
</body>
</html>

<?php
$conn->close();
?>