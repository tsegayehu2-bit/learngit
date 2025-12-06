<?php
$servername = "localhost";
$username = "tsega";
$password = "12345";
$dbname = "mekdela amba";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
echo "database connection is successfull";
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");
?>