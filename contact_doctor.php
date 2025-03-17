<?php
session_start();
include 'connection.php';

// Check if the user is logged in as a Patient
if ($_SESSION['role'] != 'Patient') {
    header("Location: index.php");
    exit();
}

// Get the doctor ID from the query parameter
$doctor_id = $_GET['doctor_id'];

// Fetch the doctor's details
$doctor_query = "SELECT * FROM doctors WHERE doctor_id='$doctor_id'";
$doctor_result = mysqli_query($conn, $doctor_query);
$doctor = mysqli_fetch_assoc($doctor_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Doctor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .main-content {
            margin: 20px;
        }
    </style>
</head>
<body>

    <div class="main-content">
        <h2>Contact Information for Dr. <?php echo $doctor['name']; ?></h2>
        <p>Email: <?php echo $doctor['email']; ?></p>
        <p>Phone: <?php echo $doctor['phone']; ?></p>
    </div>

</body>
</html>
