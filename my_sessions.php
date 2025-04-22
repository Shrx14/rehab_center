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

// Fetch session details for the patient including status and all sessions
$sessions_query = "SELECT a.appointment_id, d.name AS doctor_name, a.appointment_date, a.appointment_time, a.status 
                   FROM appointments a
                   JOIN doctors d ON a.doctor_id = d.doctor_id
                   WHERE a.patient_id = '$patient_id'
                   ORDER BY a.appointment_date, a.appointment_time";
$sessions_result = mysqli_query($conn, $sessions_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Sessions</title>
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
        <a href="my_doctors.php">My Doctors</a>
        <a href="my_sessions.php" class="active">My Sessions</a>
        <a href="my_bookings.php">My Bookings</a>
        <a href="patient_settings.php">Settings</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header-section">
        <h3>My Sessions</h3>
        </div>
        <!-- Session Details Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Doctor Name</th>
                    <th>Session Date</th>
                    <th>Session Time</th>
                    <th>Session Status</th>
                    <th>Therapy Details</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($sessions_result) > 0): ?>
                    <?php while ($session = mysqli_fetch_assoc($sessions_result)): ?>
                        <tr>
                            <td><?php echo $session['doctor_name']; ?></td>
                            <td><?php echo $session['appointment_date']; ?></td>
                            <td><?php echo $session['appointment_time']; ?></td>
                            <td><?php echo ucfirst($session['status']); ?></td>
                            <td><a href="my_sessions.php?appointment_id=<?php echo $session['appointment_id']; ?>" class="btn btn-primary btn-sm">View Details</a></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No session details available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php
        if (isset($_GET['appointment_id'])) {
            $appointment_id = $_GET['appointment_id'];

            // Fetch therapy notes for the appointment
            $notes_query = "SELECT progress_notes, session_date FROM therapy_sessions WHERE appointment_id = '$appointment_id' ORDER BY session_date DESC";
            $notes_result = mysqli_query($conn, $notes_query);

            if (mysqli_num_rows($notes_result) > 0) {
                echo '<div class="therapy-notes-section" style="margin-top: 30px; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">';
                echo '<h4>Therapy Notes</h4>';
                while ($note = mysqli_fetch_assoc($notes_result)) {
                    echo '<div style="margin-bottom: 15px;">';
                    echo '<strong>Date: ' . htmlspecialchars($note['session_date']) . '</strong><br>';
                    echo '<p>' . nl2br(htmlspecialchars($note['progress_notes'])) . '</p>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<div class="therapy-notes-section" style="margin-top: 30px; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">';
                echo '<h4>Therapy Notes</h4>';
                echo '<p>No therapy notes available for this appointment.</p>';
                echo '</div>';
            }
        }
        ?>
    </div>

</body>
</html>
