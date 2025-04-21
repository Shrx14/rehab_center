<?php
session_start();

// Check if the user is logged in as an Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: index.php"); // Redirect to login page if not an admin
    exit();
}

// Include the database connection file
include 'connection.php';

// Get the logged-in admin's email
$email = $_SESSION['email'];

// Fetch admin details (optional for displaying admin name)
$query = "SELECT * FROM admin WHERE email='$email'";
$result = mysqli_query($conn, $query);

// Check if the admin exists in the database
if ($result && mysqli_num_rows($result) > 0) {
    $admin = mysqli_fetch_assoc($result);
    $admin_name = $admin['username'];
} else {
    echo "Admin not found!";
    exit();
}

// Fetch counts for dashboard stats
$doctor_count_query = "SELECT COUNT(*) AS doctor_count FROM doctors";
$doctor_count_result = mysqli_query($conn, $doctor_count_query);
$doctor_count = mysqli_fetch_assoc($doctor_count_result)['doctor_count'];

$patient_count_query = "SELECT COUNT(*) AS patient_count FROM patients";
$patient_count_result = mysqli_query($conn, $patient_count_query);
$patient_count = mysqli_fetch_assoc($patient_count_result)['patient_count'];

$booking_count_query = "SELECT COUNT(*) AS booking_count FROM appointments";
$booking_count_result = mysqli_query($conn, $booking_count_query);
$booking_count = mysqli_fetch_assoc($booking_count_result)['booking_count'];

$session_count_query = "SELECT COUNT(*) AS session_count FROM therapy_sessions";
$session_count_result = mysqli_query($conn, $session_count_query);
$session_count = mysqli_fetch_assoc($session_count_result)['session_count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            font-size: 18px;
            padding: 20px;
            scroll-behavior: smooth;
        }
        .sidebar {
            height: 100%;
            width: 240px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding: 25px;
            color: white;
            animation: fadeIn 0.8s ease-out;
        }
        .sidebar h4 {
            text-align: center;
            font-size: 22px;
        }
        .sidebar p {
            text-align: center;
            font-size: 20px;
        }
        .sidebar a {
            color: white;
            padding: 14px;
            text-decoration: none;
            font-size: 19px;
            display: block;
            border-radius: 6px;
            margin-bottom: 12px;
            transform: translateX(-20px);
            opacity: 0;
            animation: slideInLeft 0.5s ease-out forwards;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 280px;
            padding: 20px;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }
        .card {
            border: none;
            border-radius: 12px;
            padding: 25px;
            background-color:rgb(150, 227, 199);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out forwards;
        }
        .card h5 {
            margin-bottom: 12px;
            font-weight: bold;
            font-size: 22px; /* Increased font size */
        }
        .card p {
            font-size: 20px; /* Increased font size */
            font-weight: 700;
            color: #007bff;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 10px;
            padding: 15px;
            font-size: 20px;
            transition: all 0.3s ease;
            transform: scale(1);
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .search-bar {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: right;
            align-items: center;
            animation: slideInRight 0.8s ease-out 0.6s;
            animation-fill-mode: both;
        }

.search-bar form {
    width: 80%;
    display: flex;
}

.search-bar input {
    flex-grow: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
}

.search-bar button {
    margin-left: 10px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    transform: scale(1);
}

.search-bar button:hover {
    background-color: #0056b3;
    transform: scale(1.05);
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
    </style>
</head>
<body style="position: relative;  background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg'); background-size: cover; background-position: center; background-attachment: local; height: 100vh; display: flex; flex-direction: column;  animation: fadeIn 1.5s ease-in-out;">
    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Admin Dashboard</h4>
        <p><?php echo htmlspecialchars($email); ?></p>
        <a href="logout.php">Logout</a>
        <hr>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="all_doc.php">Doctors</a>
        <a href="all_patients.php">Patients</a>
        <a href="all_sess.php">Sessions</a>
        <a href="all_therapy_sessions.php">Therapy Sessions</a> <!-- New link added -->
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-grid">
            <div class="card">
                <h5>Doctors</h5>
                <p>Total: <?php echo $doctor_count; ?></p>
            </div>
            <div class="card">
                <h5>Patients</h5>
                <p>Total: <?php echo $patient_count; ?></p>
            </div>
            <div class="card">
                <h5>Total Appointments</h5>
                <p>Total: <?php echo $booking_count; ?></p>
            </div>
            <div class="card">
                <h5>Completed Sessions</h5>
                <p>Total: <?php echo $session_count; ?></p>
            </div>
        </div>
    </div>
</body>
</html>
