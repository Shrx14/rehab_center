<?php
session_start();
include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Get patient ID from URL parameter
if (!isset($_GET['patient_id'])) {
    header("Location: my_patients.php");
    exit();
}

$patient_id = $_GET['patient_id'];

// Fetch patient details
$patient_query = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
$patient_result = mysqli_query($conn, $patient_query);
$patient = mysqli_fetch_assoc($patient_result);

// Fetch patient's appointments
$appointments_query = "SELECT a.*, d.name AS doctor_name 
                      FROM appointments a
                      JOIN doctors d ON a.doctor_id = d.doctor_id
                      WHERE a.patient_id = '$patient_id'
                      ORDER BY a.appointment_date DESC";
$appointments_result = mysqli_query($conn, $appointments_query);

// Fetch patient's therapy sessions
$therapy_query = "SELECT ts.*, d.name AS doctor_name 
                  FROM therapy_sessions ts
                  JOIN doctors d ON ts.doctor_id = d.doctor_id
                  WHERE ts.patient_id = '$patient_id'
                  ORDER BY ts.session_date DESC";
$therapy_result = mysqli_query($conn, $therapy_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #0056b3;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .info-section p {
            margin-bottom: 10px;
        }
        .section-title {
            margin-bottom: 20px;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #e9ecef;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .alert {
            margin-top: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Patient Details</h2>
        
        <!-- Patient Information Section -->
        <div class="info-section">
            <h3 class="section-title">Personal Information</h3>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> <?php echo $patient['name']; ?></p>
                    <p><strong>Email:</strong> <?php echo $patient['email']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $patient['phone']; ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Address:</strong> <?php echo $patient['address']; ?></p>
                    <?php if (isset($patient['dob'])): ?>
                        <p><strong>Date of Birth:</strong> <?php echo $patient['dob']; ?></p>
                    <?php endif; ?>
                    <?php if (isset($patient['gender'])): ?>
                        <p><strong>Gender:</strong> <?php echo $patient['gender']; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Appointments Section -->
        <div class="appointments">
            <h3 class="section-title">Appointments</h3>
            <?php if (mysqli_num_rows($appointments_result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Doctor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($appointment = mysqli_fetch_assoc($appointments_result)): ?>
                            <tr>
                                <td><?php echo $appointment['appointment_date']; ?></td>
                                <td><?php echo $appointment['appointment_time']; ?></td>
                                <td><?php echo $appointment['doctor_name']; ?></td>
                                <td><?php echo $appointment['status']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info">No appointments found.</div>
            <?php endif; ?>
        </div>

        <!-- Therapy Sessions Section -->
        <div class="therapy-sessions">
            <h3 class="section-title">Therapy Sessions</h3>
            <?php if (mysqli_num_rows($therapy_result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Doctor</th>
                            <th>Progress Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($therapy = mysqli_fetch_assoc($therapy_result)): ?>
                            <tr>
                                <td><?php echo $therapy['session_date']; ?></td>
                                <td><?php echo $therapy['doctor_name']; ?></td>
                                <td><?php echo $therapy['progress_notes']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info">No therapy sessions found.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
