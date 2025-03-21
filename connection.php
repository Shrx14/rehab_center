<?php
// Database credentials
$servername = "localhost"; // Server name (default for XAMPP is localhost)
$username = "root";        // MySQL username (default is root)
$password = "";            // MySQL password (default is empty)
$dbname = "rehab_center";  // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
