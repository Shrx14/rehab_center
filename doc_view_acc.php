<?php
session_start();
include 'connection.php';

if ($_SESSION['role'] != 'Doctor') {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM doctors WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Account Details</title>
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
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out forwards;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.2s forwards;
        }
        .table {
            width: 100%;
            margin-top: 20px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
            animation: fadeIn 0.8s ease-out 0.3s forwards;
            opacity: 0;
        }
        .table th, .table td {
            padding: 15px;
            border: 1px solid #e9ecef;
            transition: background-color 0.3s ease;
        }
        .table tr:hover td {
            background-color: #f1f8ff;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }
        .table td {
            background-color: #ffffff;
        }
    </style>
</head>
<body style="position: relative; background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg'); background-size: cover; background-position: center; background-attachment: local; height: 100vh; display: flex; flex-direction: column; animation: fadeIn 1.5s ease-in-out;">
    <div class="container">
        <h2>View Account Details</h2>
        <table class="table">
            <tr>
                <th>Name</th>
                <td><?php echo $user['name']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $user['email']; ?></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><?php echo $user['phone']; ?></td>
            </tr>
            <tr>
                <th>Specialization</th>
                <td><?php echo $user['speciality']; ?></td>
            </tr>
            <tr>
                <th>Experience</th>
                <td><?php echo $user['experience']; ?></td>
            </tr>
            <tr>
                <th>Maximum Number of Patients (Patient Intake)</th>
                <td><?php echo $user['max_patients']; ?></td>
            </tr>
            <tr>
                <th>Current Scheduled Appointments</th>
                <td><?php echo $user['appointment_count']; ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
