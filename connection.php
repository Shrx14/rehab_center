<?php
// Database credentials
$servername = "localhost"; // Server name (default for XAMPP is localhost)
$username = "root";        // MySQL username (default is root)
$password = "";            // MySQL password (leave blank if using XAMPP default)
$database = "rehab_center"; // Database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Uncomment the line below to confirm successful connection during testing
// echo "Database connected successfully!";
?>
