<?php
session_start();

// Check if the user is logged in as Admin
if ($_SESSION['role'] != 'Admin') {
    header("Location: index.php");
    exit();
}

include 'connection.php';

// Fetch all doctors from the database
$doctors_query = "SELECT doctor_id, name, speciality, email, phone, experience, max_patients, appointment_count FROM doctors";

$doctors_result = mysqli_query($conn, $doctors_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors</title>
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
        .btn {
            padding: 8px 12px;
            font-size: 15px;
            border-radius: 6px;
            border: none;
        }
        .btn-view {
            background-color: #85C1E9; /* Pastel Blue */
            color: black;
        }
        .btn-edit {
            background-color: #F9E79F; /* Pastel Yellow */
            color: black;
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
        .add-doctor-box {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 250px;
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
        <a href="all_doc.php">Doctors</a>
        <a href="all_patients.php">Patients</a>
        <a href="all_sess.php">Sessions</a>
        <a href="all_therapy_sessions.php">Therapy Sessions</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
            <h3 style="font-size: 30px;">Manage Doctors</h3>
        <div class="add-doctor-box" style="margin-top: 40px;"> <!-- Adjusted margin to lower the box -->
            <div class="card" style="background-color: #FAD7A0;"> <!-- Pastel color -->
                <div class="card-body text-center">
                    <a href="new_doc.php" class="btn btn-light" style="font-size: 18px; font-weight: bold;">+ Add New Doctor</a>
                </div>
            </div>
        </div>

        <!-- Doctors List -->
        <div class="table-container">
            <div class="card-header">All Doctors</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Doctor Name</th>
                        <th>Specialty</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Experience</th>
                        <th>Max Patients</th>
                        <th>Appointment Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($doctors_result) > 0): ?>
                        <?php $count = 1; while ($doctor = mysqli_fetch_assoc($doctors_result)): ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $doctor['name']; ?></td>
                                <td><?php echo $doctor['speciality']; ?></td>
                                <td><?php echo $doctor['email']; ?></td>
                                <td><?php echo $doctor['phone']; ?></td>
                                <td><?php echo $doctor['experience']; ?></td>
                                <td><?php echo $doctor['max_patients']; ?></td>
                                <td><?php echo $doctor['appointment_count']; ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="view_doctor.php?email=<?php echo urlencode($doctor['email']); ?>" class="btn btn-view btn-sm">View</a>
                                        <a href="edit_doctor.php?email=<?php echo urlencode($doctor['email']); ?>" class="btn btn-edit btn-sm">Edit</a>

                                        <a href="delete_doctor.php?id=<?php echo $doctor['doctor_id']; ?>" class="btn btn-remove btn-sm" onclick="return confirm('Are you sure?');">Remove</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No doctors found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
