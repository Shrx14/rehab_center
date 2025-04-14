<?php
session_start();

// Check if the user is logged in as Admin
if ($_SESSION['role'] != 'Admin') {
    header("Location: index.php");
    exit();
}

include 'connection.php';

// Fetch all patients from the database
$patients_query = "SELECT patient_id, name, email, phone, address, diagnosis_type FROM patients";
$patients_result = mysqli_query($conn, $patients_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Patients</title>
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
        .sidebar a:nth-child(1) { animation-delay: 0.2s; }
        .sidebar a:nth-child(2) { animation-delay: 0.3s; }
        .sidebar a:nth-child(3) { animation-delay: 0.4s; }
        .sidebar a:nth-child(4) { animation-delay: 0.5s; }
        .sidebar a:nth-child(5) { animation-delay: 0.6s; }
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
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.4s forwards;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            padding: 18px;
            font-size: 17px;
            border: 1px solid #ccc; /* Light solid border for each cell */
        }
        .table thead {
            background-color: #007bff;
            color: white;
            font-size: 18px;
        }
        .btn {
            padding: 10px 14px;
            font-size: 16px;
            border-radius: 6px;
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
        .btn-view {
            background-color: #85C1E9; /* Pastel Blue */
            color: #000;
        }
        .btn-edit {
            background-color: #F9E79F; /* Pastel Yellow */
            color: #000;
        }
        .btn-remove {
            background-color: #F5B7B1; /* Pastel Red */
            color: #000;
        }
        .btn:hover {
            filter: brightness(90%);
            transform: scale(1.05);
        }
        .action-buttons {
            display: flex;
            gap: 6px; /* Reduced space between buttons */
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
        .add-patient-box {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 250px;
            animation: slideInRight 0.8s ease-out 0.6s;
            animation-fill-mode: both;
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
<body style="position: relative; background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg'); background-size: cover; background-position: center; background-attachment: local; height: 100vh; display: flex; flex-direction: column; animation: fadeIn 1.5s ease-in-out;">

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
        <a href="all_therapy_sessions.php">Therapy Sessions</a> <!-- New link added -->
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <?php if (isset($_GET['alert']) && isset($_GET['message'])): ?>
            <div class="alert alert-<?php echo $_GET['alert'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                <?php echo urldecode($_GET['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="top-bar">


            <h3 style="font-size: 30px;">Manage Patients</h3>
        </div>

        <!-- Box for Add New Patient -->
<div class="add-patient-box" style="margin-top: 40px;"> <!-- Adjusted margin to lower the box -->
    <div class="card" style="background-color: #FAD7A0;"> <!-- Pastel color -->
        <div class="card-body text-center">
            <a href="new_patient.php" class="btn btn-light" style="font-size: 18px; font-weight: bold;">+ Add New Patient</a>
        </div>
    </div>
</div>



        <!-- Patients List -->
        <div class="table-container">
            <div class="card-header">All Patients</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>Diagnosis Type</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($patients_result) > 0): ?>
                        <?php $count = 1; while ($patient = mysqli_fetch_assoc($patients_result)): ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $patient['name']; ?></td>
                                <td><?php echo $patient['diagnosis_type']; ?></td>
                                <td><?php echo $patient['email']; ?></td>
                                <td><?php echo $patient['phone']; ?></td>
                                <td><?php echo $patient['address']; ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="view_patient_details.php?patient_id=<?php echo $patient['patient_id']; ?>" 
                                           class="btn btn-view btn-sm">View</a>
                                        <a href="edit_patient.php?email=<?php echo urlencode($patient['email']); ?>" 
                                           class="btn btn-edit btn-sm">Edit</a>
                                        <a href="delete_patient.php?email=<?php echo urlencode($patient['email']); ?>" 
                                           class="btn btn-remove btn-sm" 
                                           onclick="return confirm('Are you sure you want to remove this patient?');">
                                           Remove
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No patients found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
