<?php
session_start();

// Check if the user is logged in as a Patient
if ($_SESSION['role'] != 'Patient') {
    header("Location: index.php"); // Redirect to login page if not a patient
    exit();
}

// Include the database connection file
include 'connection.php';

// Get the logged-in patient's email
$email = $_SESSION['email'];

// Fetch the patient's details
$query = "SELECT * FROM patients WHERE email='$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $patient = mysqli_fetch_assoc($result);
    $patient_name = $patient['name'];
    $patient_id = $patient['patient_id'];
} else {
    echo "Patient not found!";
    exit();
}

// Fetch all doctors assigned to the patient
$doctors_query = "
    SELECT DISTINCT d.doctor_id, d.name AS doctor_name, d.email AS doctor_email 
    FROM doctors d
    JOIN appointments a ON d.doctor_id = a.doctor_id
    WHERE a.patient_id = '$patient_id'
";
$doctors_result = mysqli_query($conn, $doctors_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Doctors</title>
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
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            color: white;
        }
        .sidebar h4, .sidebar p {
            text-align: center;
        }
        .sidebar a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            animation: slideInUp 0.5s ease-out;
        }
        .section-title {
            margin-bottom: 20px;
            color: #0056b3;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.2s forwards;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.3s forwards;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #e9ecef;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .table tr:hover {
            background-color: #f1f1f1;
        }
        .message-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
        }
        .header-section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #007bff;
            color: white;
            border-radius: 10px;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.2s forwards;
        }
        .message-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body style="position: relative; background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg'); background-size: cover; background-position: center; background-attachment: local; height: 100vh; display: flex; flex-direction: column; animation: fadeIn 1.5s ease-in-out;">

    <!-- Sidebar -->
    <div class="sidebar">
        <h4><?php echo $patient_name; ?></h4>
        <p><?php echo $email; ?></p>
        <a href="logout.php">Logout</a>
        <hr>
        <a href="patient_dashboard.php">Home</a>
        <a href="my_doctors.php" class="active">My Doctors</a>
        <a href="my_sessions.php">Scheduled Sessions</a>
        <a href="my_bookings.php">My Bookings</a>
        <a href="patient_settings.php">Settings</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header-section">
            <h3>My Doctors</h3>
            <!-- Total Number of Doctors -->
            <div>
                <h5>Total Doctors: <?php echo mysqli_num_rows($doctors_result); ?></h5>
            </div>
        </div>
        <!-- Doctors Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Doctor Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($doctors_result) > 0): ?>
                    <?php while ($doctor = mysqli_fetch_assoc($doctors_result)): ?>
                        <tr>
                            <td><?php echo $doctor['doctor_name']; ?></td>
                            <td><?php echo $doctor['doctor_email']; ?></td>
                            <td>
                                <a href="contact_doctor.php?doctor_id=<?php echo $doctor['doctor_id']; ?>" class="message-btn">Message</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No doctors assigned.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
