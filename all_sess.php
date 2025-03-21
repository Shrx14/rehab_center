<?php
session_start();

// Check if the user is logged in as Admin
if ($_SESSION['role'] != 'Admin') {
    header("Location: index.php");
    exit();
}

include 'connection.php';

// Fetch session details from the appointments table
$sessions_query = "
    SELECT 
        appointments.appointment_id, 
        appointments.appointment_date, 
        appointments.appointment_time, 
        appointments.status,
        doctors.name AS doctor_name, 
        patients.name AS patient_name
    FROM appointments
    INNER JOIN doctors ON appointments.doctor_id = doctors.doctor_id
    INNER JOIN patients ON appointments.patient_id = patients.patient_id
    ORDER BY appointments.appointment_date DESC, appointments.appointment_time DESC";

$sessions_result = mysqli_query($conn, $sessions_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Appointments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            font-size: 18px;
            padding: 20px;
        }

        /* Sidebar Styling */
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

        /* Main Content Styling */
        .main-content {
            margin-left: 280px;
            padding: 20px;
        }

        /* Table Styling */
        .table-container {
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            padding: 14px;
            font-size: 16px;
            border: 1px solid #ddd;
        }
        .table thead {
            background-color: #007bff;
            color: white;
            font-size: 17px;
        }

        /* Buttons */
        .btn {
            font-size: 16px;
            padding: 10px 14px;
            border-radius: 8px;
            border: none;
            transition: 0.3s;
        }

        .btn-edit {
    background-color: #F9E79F; /* Pastel Yellow */
    color: black;
    margin-right: 10px; /* Adds space between buttons */
}

.btn-remove {
    background-color: #F5B7B1; /* Pastel Red */
    color: black;
}

        .btn:hover {
            filter: brightness(90%);
        }
        .action-buttons {
            display: flex;
            gap: 6px;
            justify-content: center;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            font-size: 20px;
            padding: 18px;
            border-radius: 8px 8px 0 0;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 15px;
        }
        .card-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }
        .card-text {
            font-size: 15px;
            color: #666;
            margin-bottom: 12px;
        }
        .btn-primary {
            padding: 10px 16px;
            font-size: 16px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Admin Dashboard</h4>
        <p><?php echo $_SESSION['email']; ?></p>
        <a href="logout.php">Logout</a>
        <hr>
        <a href="admin_dashboard.php?page=dashboard">Dashboard</a>
        <a href="all_doc.php" class="<?php echo ($page == 'all_doc') ? 'active' : ''; ?>">Doctors</a>
        <a href="all_patients.php" class="<?php echo ($page == 'all_patients') ? 'active': ''; ?>">Patients</a>
        <a href="all_sess.php" class="<?php echo ($page == 'all_sess') ? 'active' : ''; ?>">Sessions</a>
        <a href="all_therapy_sessions.php">Therapy Sessions</a> <!-- New link added -->

    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <h3 style="font-size: 30px;">All Appointments</h3>
        </div>

        <!-- Appointment Table -->
        <div class="table-container">
            <div class="card-header">Appointment Details</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Doctor Name</th>
                            <th>Patient Name</th>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($sessions_result) > 0): ?>
                            <?php $count = 1; while ($session = mysqli_fetch_assoc($sessions_result)): ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $session['doctor_name']; ?></td>
                                    <td><?php echo $session['patient_name']; ?></td>
                                    <td><?php echo date("d M Y", strtotime($session['appointment_date'])); ?></td>
                                    <td><?php echo date("h:i A", strtotime($session['appointment_time'])); ?></td>
                                    <td>
                                        <span class="badge 
                                            <?php echo ($session['status'] == 'Confirmed') ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo $session['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Edit Session -->
                                            <a href="edit_session.php?id=<?php echo $session['appointment_id']; ?>" 
                                               class="btn btn-edit">
                                               Edit
                                            </a>

                                            <!-- Cancel Session -->
                                            <a href="cancel_session.php?id=<?php echo $session['appointment_id']; ?>" 
                                               class="btn btn-remove" 
                                               onclick="return confirm('Are you sure you want to cancel this appointment?');">
                                               Cancel
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">No appointments found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

</body>
</html>
