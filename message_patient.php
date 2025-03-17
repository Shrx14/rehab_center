<?php
session_start();
include 'connection.php';

// Check if the user is logged in as a Doctor
if ($_SESSION['role'] != 'Doctor') {
    header("Location: index.php");
    exit();
}

// Get the patient ID from the query parameter
$patient_id = $_GET['patient_id'];

// Fetch the patient's details
$patient_query = "SELECT * FROM patients WHERE patient_id='$patient_id'";
$patient_result = mysqli_query($conn, $patient_query);
$patient = mysqli_fetch_assoc($patient_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Patient</title>
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
        <h2>Contact Information for <?php echo htmlspecialchars($patient['name']); ?></h2>
        <p>Email: <?php echo htmlspecialchars($patient['email']); ?></p>
        <p>Phone: <?php echo htmlspecialchars($patient['phone']); ?></p>
    </div>

</body>
</html>
