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

// Fetch today's sessions count from 'therapy_sessions' table
$session_count_query = "SELECT COUNT(*) AS session_count FROM therapy_sessions WHERE session_date = CURDATE()";
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
            background-color: #ffffff;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
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
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .search-bar {
    background-color: #ffffff;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: right;
    align-items: center;
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
    transition: background 0.3s;
}

.search-bar button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
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
    </div>

    <!-- Search Bar -->
<div class="search-bar mb-4 d-flex justify-content-between align-items-center">
    <form class="d-flex" action="search.php" method="GET">
        <input class="form-control me-2" type="search" name="query" placeholder="Search..." aria-label="Search">
        <button class="btn btn-outline-primary" type="submit">Search</button>
    </form>
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
                <h5>New Bookings</h5>
                <p>Total: <?php echo $booking_count; ?></p>
            </div>
            <div class="card">
                <h5>Today's Sessions</h5>
                <p>Total: <?php echo $session_count; ?></p>
            </div>
        </div>
        <div class="card mt-4">
            <h5>This Week's Sessions</h5>
            <button class="btn btn-primary">Show This Week's Sessions</button>
        </div>
    </div>
</body>
</html>
