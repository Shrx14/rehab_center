<?php
session_start();
include 'connection.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Get user role
$role = $_SESSION['role'];

// Get appointment ID from URL parameter
if (!isset($_GET['appointment_id'])) {
    header("Location: doc_sessions.php");
    exit();
}

$appointment_id = $_GET['appointment_id'];

// Fetch detailed appointment information
$query = "SELECT a.appointment_id, a.appointment_date, a.appointment_time, 
                 d.name AS doctor_name, d.email AS doctor_email,
                 p.name AS patient_name, p.email AS patient_email,
                 a.status, ts.progress_notes AS therapy_notes
          FROM appointments a
          LEFT JOIN therapy_sessions ts ON a.appointment_id = ts.appointment_id
          JOIN doctors d ON a.doctor_id = d.doctor_id
          JOIN patients p ON a.patient_id = p.patient_id
          WHERE a.appointment_id = '$appointment_id'";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Session Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
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
    </style>
</head>
<body style="position: relative;  background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg'); background-size: cover; background-position: center; background-attachment: local; height: 100vh; display: flex; flex-direction: column; animation: fadeIn 1.5s ease-in-out;">
    <div class="container" style="transform: translateY(20px); opacity: 0; animation: slideInUp 0.5s ease-out 0.4s forwards;">
        <h2>Session Details</h2>
        
<?php
$therapy_notes_exist = false;
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if (!empty($row['therapy_notes'])) {
        $therapy_notes_exist = true;
    }
    mysqli_data_seek($result, 0);
}
?>

<?php if (mysqli_num_rows($result) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Doctor</th>
                <th>Patient</th>
                <th>Status</th>
                <?php if ($therapy_notes_exist): ?>
                    <th>Therapy Notes</th>
                <?php endif; ?>
                <?php if ($role == 'Admin'): ?>
                    <th>Doctor Email</th>
                    <th>Patient Email</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['appointment_date']; ?></td>
                    <td><?php echo $row['appointment_time']; ?></td>
                    <td><?php echo $row['doctor_name']; ?></td>
                    <td><?php echo $row['patient_name']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <?php if ($therapy_notes_exist): ?>
                        <td><?php echo $row['therapy_notes'] ?? 'No notes available'; ?></td>
                    <?php endif; ?>
                    <?php if ($role == 'Admin'): ?>
                        <td><?php echo $row['doctor_email']; ?></td>
                        <td><?php echo $row['patient_email']; ?></td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">No sessions found.</div>
<?php endif; ?>
    </div>
</body>
</html>
