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
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #0056b3;
        }
        .table {
            width: 100%;
            margin-top: 20px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
        }
        .table th, .table td {
            padding: 15px;
            border: 1px solid #e9ecef;
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
<body>
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
                <th>Visit Days</th>
                <td><?php echo $user['visit_days']; ?></td>
            </tr>
            <tr>
                <th>Experience</th>
                <td><?php echo $user['experience']; ?></td>
            </tr>
            <tr>
                <th>Maximum Number of Patients (Patient Intake)</th>
                <td><?php echo $user['max_patients']; ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
