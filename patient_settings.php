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
} else {
    echo "Patient not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
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
        }
        .section-title {
            margin-bottom: 20px;
            color: #0056b3;
        }
        .card {
            border: none;
            border-radius: 10px;
            margin-bottom: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 20px;
        }
        .btn-settings {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            text-align: left;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .btn-settings.account {
            background-color: #28a745;
            color: white;
        }
        .btn-settings.account:hover {
            background-color: #218838;
        }
        .btn-settings.view {
            background-color: #17a2b8;
            color: white;
        }
        .btn-settings.view:hover {
            background-color: #138496;
        }
        .btn-settings.delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-settings.delete:hover {
            background-color: #c82333;
        }
        .btn-back {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4><?php echo $patient_name; ?></h4>
        <p><?php echo $email; ?></p>
        <a href="logout.php">Logout</a>
        <hr>
        <a href="patient_dashboard.php">Home</a>
        <a href="my_doctors.php">My Doctors</a>
        <a href="my_sessions.php">Scheduled Sessions</a>
        <a href="my_bookings.php">My Bookings</a>
        <a href="patient_settings.php" class="active">Settings</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <a href="patient_dashboard.php" class="btn btn-primary btn-back">&larr; Back</a>
        <h2 class="section-title">Settings</h2>

        <div class="card">
            <div class="card-body">
                <button class="btn-settings account" onclick="window.location.href='patient_acc_set.php';">Account Settings</button>
                <p>Edit your Account Details & Change Password</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <button class="btn-settings view" onclick="window.location.href='patient_view_acc.php';">View Account Details</button>
                <p>View Personal Information About Your Account</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <button class="btn-settings delete" onclick="window.location.href='patient_del_acc.php';">Delete Account</button>
                <p>Will Permanently Remove your Account</p>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
                window.location.href = 'delete_account.php';
            }
        }
    </script>

</body>
</html>
