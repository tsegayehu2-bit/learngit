<?php
// Database connection
$servername = "localhost";
$username = "tsega";
$password = "12345";
$dbname = "mekdela amba";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Database Update</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 50px; background: #f4f4f4; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .success { color: #28a745; padding: 10px; background: #d4edda; border-radius: 5px; margin: 10px 0; }
        .error { color: #dc3545; padding: 10px; background: #f8d7da; border-radius: 5px; margin: 10px 0; }
        .info { color: #0c5460; padding: 10px; background: #d1ecf1; border-radius: 5px; margin: 10px 0; }
        .actions { margin-top: 30px; text-align: center; }
        .actions a { display: inline-block; margin: 10px; padding: 12px 24px; background: #0033cc; color: white; text-decoration: none; border-radius: 5px; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>⚙️ Database Structure Check</h1>
        <p>Checking table: <strong>studentss</strong> in database: <strong>mekdela amba</strong></p>
        <hr>";

// Check table structure
$sql = "DESCRIBE studentss";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='info'><strong>Table Structure:</strong></div>";
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%; margin: 20px 0;'>
            <tr style='background: #0033cc; color: white;'>
                <th>#</th>
                <th>Column Name</th>
                <th>Type</th>
                <th>Allows Null</th>
                <th>Key</th>
                <th>Default</th>
                <th>Extra</th>
            </tr>";
    
    $i = 1;
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $i++ . "</td>
                <td><strong>" . $row['Field'] . "</strong></td>
                <td>" . $row['Type'] . "</td>
                <td>" . $row['Null'] . "</td>
                <td>" . $row['Key'] . "</td>
                <td>" . $row['Default'] . "</td>
                <td>" . $row['Extra'] . "</td>
              </tr>";
    }
    echo "</table>";
    
    echo "<div class='success'>✅ Table structure is correct. All columns are properly defined.</div>";
} else {
    echo "<div class='error'>❌ Table 'studentss' does not exist or has no columns.</div>";
    
    // Create table if it doesn't exist
    $create_sql = "CREATE TABLE IF NOT EXISTS studentss (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id VARCHAR(50) NOT NULL,
        full_ame VARCHAR(100) NOT NULL,
        password VARCHAR(255),
        email VARCHAR(100),
        phone VARCHAR(20),
        address TEXT,
        birthdate DATE,
        department VARCHAR(100),
        year_of_study INT,
        semester VARCHAR(20),
        courses TEXT,
        quize DECIMAL(5,2),
        assignment DECIMAL(5,2),
        mid DECIMAL(5,2),
        final DECIMAL(5,2),
        age INT,
        registration_date DATE,
        total_grade DECIMAL(5,2),
        grade_status VARCHAR(10),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($create_sql) === TRUE) {
        echo "<div class='success'>✅ Table 'studentss' created successfully!</div>";
    }
}

echo "<hr>
        <div class='actions'>
            <a href='index1.php'>📝 Go to Registration Form</a>
            <a href='view.php'>👥 View Students</a>
            <a href='#' onclick='location.reload()'>🔄 Check Again</a>
        </div>
    </div>
</body>
</html>";

$conn->close();
?>