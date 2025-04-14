<?php
session_start();

// Check if the user is logged in as a Doctor
if ($_SESSION['role'] != 'Doctor') {
    header("Location: index.php"); // Redirect to login page if not a doctor
    exit();
}

// Include the database connection file
include 'connection.php';

// Get the logged-in doctor's email
$email = $_SESSION['email'];

// Fetch the doctor's details from the database
$query = "SELECT * FROM doctors WHERE email='$email'";
$result = mysqli_query($conn, $query);

// Check if the doctor exists in the database
if (mysqli_num_rows($result) > 0) {
    $doctor = mysqli_fetch_assoc($result);
    $doctor_name = $doctor['name'];
    $doctor_id = $doctor['doctor_id'];
} else {
    echo "Doctor not found!";
    exit();
}

// Fetch the number of patients
$patient_count_query = "SELECT COUNT(DISTINCT patient_id) AS patient_count FROM appointments WHERE doctor_id = '$doctor_id'";
$patient_count_result = mysqli_query($conn, $patient_count_query);
$patient_count = mysqli_fetch_assoc($patient_count_result)['patient_count'];

// Fetch the number of bookings
$booking_count_query = "SELECT COUNT(*) AS booking_count FROM appointments WHERE doctor_id = '$doctor_id'";
$booking_count_result = mysqli_query($conn, $booking_count_query);
$booking_count = mysqli_fetch_assoc($booking_count_result)['booking_count'];

// Fetch today's sessions
$todays_sessions_query = "SELECT COUNT(*) AS session_count FROM appointments WHERE doctor_id = '$doctor_id' AND appointment_date = CURDATE()";
$todays_sessions_result = mysqli_query($conn, $todays_sessions_query);
$session_count = mysqli_fetch_assoc($todays_sessions_result)['session_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
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
        .welcome-section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #007bff;
            color: white;
            border-radius: 10px;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.2s forwards;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out forwards;
        }
        .card:nth-child(1) { animation-delay: 0.3s; }
        .card:nth-child(2) { animation-delay: 0.4s; }
        .card:nth-child(3) { animation-delay: 0.5s; }
        .card h5 {
            margin-bottom: 15px;
            font-weight: bold;
            color: #0056b3;
        }
        .search-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .search-bar input {
            width: 300px;
            padding: 10px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
        .current-date {
            font-size: 16px;
            color: #666;
        }
    </style>
</head>
<body style="position: relative; background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg'); background-size: cover; background-position: center; background-attachment: local; height: 100vh; display: flex; flex-direction: column; animation: fadeIn 1.5s ease-in-out;">

    <!-- Sidebar -->
    <div class="sidebar">
        <h4><?php echo $doctor_name; ?></h4>
        <p><?php echo $email; ?></p>
        <a href="logout.php">Logout</a>
        <hr>
        <a href="doctor_dashboard.php?page=dashboard" class="active">Dashboard</a>
        <a href="my_patients.php">My Patients</a>
        <a href="doc_sessions.php">Sessions</a>
        <a href="doc_settings.php">Settings</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h3>Welcome, <?php echo $doctor_name; ?>!</h3>
            <p>"Your dedication to care and recovery inspires us every day."</p>
        </div>

        <!-- Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Number of Patients -->
            <div class="card">
                <h5>Total Patients</h5>
                <p>You are assigned to <?php echo $patient_count; ?> patients.</p>
            </div>

            <!-- Number of Bookings -->
            <div class="card">
                <h5>Total Appointments</h5>
                <p>You have <?php echo $booking_count; ?> appointments.</p>
            </div>

            <!-- Today's Sessions -->
            <div class="card">
                <h5>Today's Sessions</h5>
                <p>You have <?php echo $session_count; ?> sessions scheduled today.</p>
            </div>
        </div>
    </div>

</body>
</html>
