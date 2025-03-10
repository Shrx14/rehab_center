<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Ensure no output before headers
ob_start();

// Include database connection
include 'connection.php';

// Verify database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if the user is logged in as Admin
if ($_SESSION['role'] != 'Admin') {
    header("Location: index.php");
    exit();
}

// Check if doctor_id parameter is set
if (!isset($_GET['id'])) {
    header("Location: all_doc.php?error=Invalid request");
    exit();
}

$doctor_id = intval($_GET['id']);

// Verify doctor exists
$check_query = "SELECT * FROM doctors WHERE doctor_id = $doctor_id";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) == 0) {
    header("Location: all_doc.php?error=Doctor not found");
    exit();
}

// Start transaction
mysqli_begin_transaction($conn);

// Debug: Show current doctor data
$doctor_data = mysqli_fetch_assoc($check_result);
error_log("Attempting to delete doctor: " . print_r($doctor_data, true));


try {
    // Debug: Log deletion attempt
    error_log("Attempting to delete doctor ID: $doctor_id");

    // First delete related appointments
    $delete_appointments = "DELETE FROM appointments WHERE doctor_id = $doctor_id";
    error_log("Executing query: $delete_appointments");
    
    if (!mysqli_query($conn, $delete_appointments)) {
        $error = "Failed to delete related appointments: " . mysqli_error($conn);
        error_log($error);
        throw new Exception($error);
    }

    // Then delete the doctor
    $delete_doctor = "DELETE FROM doctors WHERE doctor_id = $doctor_id";
    error_log("Executing query: $delete_doctor");
    
    $delete_result = mysqli_query($conn, $delete_doctor);
    
    if (!$delete_result) {
        $error = "Failed to delete doctor: " . mysqli_error($conn);
        error_log($error);
        throw new Exception($error);
    }
    
    // Verify deletion
    $verify_query = "SELECT * FROM doctors WHERE doctor_id = $doctor_id";
    $verify_result = mysqli_query($conn, $verify_query);
    
    if (mysqli_num_rows($verify_result) > 0) {
        $error = "Doctor still exists after deletion attempt";
        error_log($error);
        throw new Exception($error);
    }


    // Commit transaction if both operations succeed
    mysqli_commit($conn);
    // Clear output buffer and redirect
    ob_end_clean();
    header("Location: all_doc.php?success=Doctor and related appointments deleted successfully");
    exit();
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);
    // Clear output buffer and redirect
    ob_end_clean();
    header("Location: all_doc.php?error=" . urlencode($e->getMessage()));
    exit();
}

?>
