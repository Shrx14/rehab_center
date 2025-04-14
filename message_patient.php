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
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            animation: slideInUp 0.5s ease-out;
        }
        h2 {
            color: #007bff;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.2s forwards;
        }
        .contact-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .contact-info p {
            font-size: 18px;
            margin-bottom: 10px;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out forwards;
        }
        .contact-info p:nth-child(1) { animation-delay: 0.3s; }
        .contact-info p:nth-child(2) { animation-delay: 0.4s; }
        .btn-back {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body style="position: relative; background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg'); background-size: cover; background-position: center; background-attachment: local; height: 100vh; display: flex; flex-direction: column; animation: fadeIn 1.5s ease-in-out;">

    <div class="main-content">
        <h2>Contact Information for <?php echo htmlspecialchars($patient['name']); ?></h2>
        <div class="contact-info">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($patient['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($patient['phone']); ?></p>
        </div>
        <button class="btn-back" onclick="window.history.back()">← Back</button>
    </div>

</body>
</html>
