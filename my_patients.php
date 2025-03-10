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

// Fetch the total number of unique patients for this doctor
$patient_count_query = "SELECT COUNT(DISTINCT patient_id) AS patient_count FROM appointments WHERE doctor_id = '$doctor_id'";
$patient_count_result = mysqli_query($conn, $patient_count_query);
$patient_count = mysqli_fetch_assoc($patient_count_result)['patient_count'];

// Fetch patient details
$patients_query = "
    SELECT DISTINCT p.patient_id, p.name AS patient_name, p.email AS patient_email
    FROM patients p
    JOIN appointments a ON p.patient_id = a.patient_id
    WHERE a.doctor_id = '$doctor_id'
";
$patients_result = mysqli_query($conn, $patients_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Patients</title>
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
        .header-section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #007bff;
            color: white;
            border-radius: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #e9ecef;
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
        .btn-contact {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-contact:hover {
            background-color: #218838;
        }
        .btn-view-details {
            background-color: #17a2b8;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
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
        <a href="doctor_dashboard.php">Dashboard</a>
        <a href="my_patients.php" class="active">My Patients</a>
        <a href="doc_sessions.php">Sessions</a>
        <a href="doc_settings.php">Settings</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header Section -->
        <div class="header-section">
            <h3>My Patients</h3>
            <p>Total Patients: <strong><?php echo $patient_count; ?></strong></p>
        </div>

        <!-- Patient Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient Name</th>
                    <th>Email</th>
                    <th>Action</th>
                    <th>Medical Details</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($patients_result) > 0) {
                    $index = 1;
                    while ($patient = mysqli_fetch_assoc($patients_result)) {
                        echo "<tr>";
                        echo "<td>" . $index++ . "</td>";
                        echo "<td>" . htmlspecialchars($patient['patient_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($patient['patient_email']) . "</td>";
                        echo "<td><a href='message_patient.php?patient_id=" . $patient['patient_id'] . "' class='btn-contact'>Contact Patient</a></td>";
                        echo "<td><a href='view_patient_details.php?patient_id=" . $patient['patient_id'] . "' class='btn-view-details'>View Details</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No patients found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
