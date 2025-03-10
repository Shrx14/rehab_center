<?php
session_start();
include 'connection.php';

// Check if the user is logged in as Admin
if ($_SESSION['role'] != 'Admin') {
    header("Location: index.php");
    exit();
}

// Check if email parameter is set
if (!isset($_GET['email'])) {
    header("Location: all_doc.php");
    exit();
}

$email = urldecode($_GET['email']);
$query = "SELECT * FROM doctors WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$doctor = mysqli_fetch_assoc($result);

if (!$doctor) {
    header("Location: all_doc.php?error=Doctor not found");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Doctor Details</title>
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
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #0056b3;
        }
        .doctor-details {
            margin-bottom: 20px;
        }
        .doctor-details label {
            font-weight: bold;
            color: #2c3e50;
        }
        .doctor-details p {
            margin-bottom: 15px;
            font-size: 16px;
        }
        .btn-back {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background-color: #6c757d;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 500;
            transition: background-color 0.3s ease;
            color: white;
            text-align: center;
            text-decoration: none;
            display: block;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Doctor Details</h2>
        <div class="doctor-details">
            <label>Name:</label>
            <p><?php echo htmlspecialchars($doctor['name']); ?></p>

            <label>Email:</label>
            <p><?php echo htmlspecialchars($doctor['email']); ?></p>

            <label>Phone:</label>
            <p><?php echo htmlspecialchars($doctor['phone']); ?></p>

            <label>Specialty:</label>
            <p><?php echo htmlspecialchars($doctor['speciality']); ?></p>

            <label>Experience:</label>
            <p><?php echo htmlspecialchars($doctor['experience']); ?></p>

            <label>Visit Days:</label>
            <p><?php echo htmlspecialchars($doctor['visit_days']); ?></p>

            <label>Maximum Patients:</label>
            <p><?php echo htmlspecialchars($doctor['max_patients']); ?></p>
        </div>
        <a href="all_doc.php" class="btn-back">Back to Doctors List</a>
    </div>
</body>
</html>