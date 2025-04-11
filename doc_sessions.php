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

// Fetch the total number of sessions
$session_count_query = "SELECT COUNT(*) AS session_count FROM appointments WHERE doctor_id = '$doctor_id'";
$session_count_result = mysqli_query($conn, $session_count_query);
$total_sessions = mysqli_fetch_assoc($session_count_result)['session_count'];

// Fetch session details
$sessions_query = "
    SELECT a.appointment_id, a.appointment_date, a.appointment_time, p.name AS patient_name, p.email AS patient_email, a.status
    FROM appointments a
    JOIN patients p ON a.patient_id = p.patient_id
    WHERE a.doctor_id = '$doctor_id'
    ORDER BY a.appointment_date, a.appointment_time";
$sessions_result = mysqli_query($conn, $sessions_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Sessions</title>
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
        .table-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.3s forwards;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-view-details {
            background-color: #17a2b8;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            text-decoration: none;
        }
        .btn-view-details:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4><?php echo $doctor_name; ?></h4>
        <p><?php echo $email; ?></p>
        <a href="logout.php">Logout</a>
        <hr>
        <a href="doctor_dashboard.php?page=dashboard">Dashboard</a>
        <a href="my_patients.php">My Patients</a>
        <a href="doc_sessions.php" class="active">Sessions</a>
        <a href="doc_settings.php">Settings</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Section -->
        <div class="header-section">
            <h3>Your Sessions</h3>
            <p>Total Sessions: <?php echo $total_sessions; ?></p>
        </div>

        <!-- Table Section -->
        <div class="table-container">
            <h5>Session Details</h5>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($sessions_result) > 0) {
                        $count = 1;
                        while ($session = mysqli_fetch_assoc($sessions_result)) {
                            echo "<tr>";
                            echo "<td>" . $count++ . "</td>";
                            echo "<td>" . $session['patient_name'] . "</td>";
                            echo "<td>" . $session['patient_email'] . "</td>";
                            echo "<td>" . $session['appointment_date'] . "</td>";
                            echo "<td>" . $session['appointment_time'] . "</td>";
                            echo "<td>" . $session['status'] . "</td>";
                            echo "<td>
                                    <a href='view_session_details.php?appointment_id=" . $session['appointment_id'] . "' class='btn btn-view-details'>View Details</a>";
                            if ($session['status'] == 'Scheduled') {
                                echo "<a href='add_therapy_notes.php?appointment_id=" . $session['appointment_id'] . "' class='btn btn-primary'>Add Therapy Notes</a>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No sessions available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
