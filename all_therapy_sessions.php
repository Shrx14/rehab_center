<?php
session_start();
include 'connection.php'; // Database connection file

// Check if the user is logged in as Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: index.php"); // Redirect to login page if not an admin
    exit();
}

// Fetch therapy sessions from the database
$query = "SELECT ts.session_id, p.name AS patient_name, d.name AS doctor_name, ts.session_date, ts.progress_notes 
          FROM therapy_sessions ts 
          JOIN patients p ON ts.patient_id = p.patient_id 
          JOIN doctors d ON ts.doctor_id = d.doctor_id"; 
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapy Sessions</title>
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
        .sidebar a:nth-child(1) { animation-delay: 0.2s; }
        .sidebar a:nth-child(2) { animation-delay: 0.3s; }
        .sidebar a:nth-child(3) { animation-delay: 0.4s; }
        .sidebar a:nth-child(4) { animation-delay: 0.5s; }
        .sidebar a:nth-child(5) { animation-delay: 0.6s; }

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
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.4s forwards;
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
            transition: all 0.3s ease;
            transform: scale(1);
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
            transform: scale(1.05);
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

    <!-- Main Content -->
    <div class="sidebar">
        <h4>Admin Dashboard</h4>
        <p><?php echo $_SESSION['email']; ?></p>
        <a href="logout.php">Logout</a>
        <hr>
        <a href="admin_dashboard.php?page=dashboard">Dashboard</a>
        <a href="all_doc.php">Doctors</a>
        <a href="all_patients.php">Patients</a>
        <a href="all_sess.php">Sessions</a>
        <a href="all_therapy_sessions.php">Therapy Sessions</a>
    </div>

    <div class="main-content">

        <div class="top-bar">


            <h3 style="font-size: 30px;">Manage Therapy Sessions</h3>
        </div>

<div class="add-doctor-box" style="animation: slideInRight 0.8s ease-out 0.6s; animation-fill-mode: both;"> <!-- Adjusted margin to lower the box -->
    <div class="card" style="background-color: #FAD7A0;"> <!-- Pastel color -->
        <div class="card-body text-center">
            <a href="new_therapy_session.php" class="btn btn-light" style="font-size: 18px; font-weight: bold;">+ Add New Therapy Session</a>
        </div>
    </div>
</div>
        <!-- Therapy Sessions List -->
        <div class="table-container">
            <div class="card-header">Therapy Sessions</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Session ID</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Session Date</th>
                        <th>Progress Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($session = mysqli_fetch_assoc($result)): ?>

                            <tr>
                                <td><?php echo $session['session_id']; ?></td>
                                <td><?php echo $session['patient_name']; ?></td>
                                <td><?php echo $session['doctor_name']; ?></td>
                                <td><?php echo $session['session_date']; ?></td>
                                <td><?php echo $session['progress_notes']; ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="edit_therapy_session.php?id=<?php echo $session['session_id']; ?>" class="btn btn-edit btn-sm">Edit</a>
                                        <a href="delete_therapy_session.php?id=<?php echo $session['session_id']; ?>" class="btn btn-remove btn-sm" onclick="return confirm('Are you sure you want to delete this session?');">Delete</a>
                                    </div>
                                </td>
                            </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No therapy sessions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
