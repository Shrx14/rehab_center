<?php
session_start();
include 'connection.php';

// Check if the user is logged in as Admin
if ($_SESSION['role'] != 'Admin') {
    header("Location: index.php");
    exit();
}

// Check if appointment ID parameter is set
if (!isset($_GET['id'])) {
    header("Location: all_sess.php");
    exit();
}

$appointment_id = intval($_GET['id']);

// Fetch the doctor ID related to the appointment before deletion
$doctor_query = "SELECT doctor_id FROM appointments WHERE appointment_id = '$appointment_id'";
$doctor_result = mysqli_query($conn, $doctor_query);

if ($doctor_result && mysqli_num_rows($doctor_result) > 0) {
    $doctor = mysqli_fetch_assoc($doctor_result);
    $doctor_id = $doctor['doctor_id'];

    // Delete the appointment
    $delete_query = "DELETE FROM appointments WHERE appointment_id = '$appointment_id'";
    if (mysqli_query($conn, $delete_query)) {
        // Reduce the appointment count in the doctors table
        $update_count_query = "UPDATE doctors SET appointment_count = appointment_count - 1 WHERE doctor_id = '$doctor_id'";
        mysqli_query($conn, $update_count_query);

        header("Location: all_sess.php?success=Appointment deleted successfully.");
    } else {
        header("Location: all_sess.php?error=Failed to delete appointment: " . mysqli_error($conn));
    }
} else {
    header("Location: all_sess.php?error=Appointment not found.");
}
?>
