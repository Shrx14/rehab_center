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
            scroll-behavior: smooth;
        }
        @keyframes slideInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        @keyframes slideInLeft {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .main-content {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.4s forwards;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #0056b3;
        }
        p {
            margin-bottom: 15px;
            font-size: 16px;
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
