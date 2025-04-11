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
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed']));
}

// Check if the user is logged in as Admin
if ($_SESSION['role'] != 'Admin') {
    header("Location: index.php");
    exit();
}

// Check if email parameter is set
if (!isset($_GET['email'])) {
    header("Location: all_patients.php?error=Invalid request");
    exit();}

$email = mysqli_real_escape_string($conn, $_GET['email']);

// Verify patient exists
$check_query = "SELECT * FROM patients WHERE email = '$email'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) == 0) {
    header("Location: all_patients.php?error=Doctor not found");
    exit();
}

// Start transaction
mysqli_begin_transaction($conn);

    // Get and store patient data
    $patient_data = mysqli_fetch_assoc($check_result);
    error_log("Attempting to delete patient: " . print_r($patient_data, true));

    try {
        error_log("Attempting to delete patient with email: $email");
        
        // Verify we have valid patient data
        if (!$patient_data || !isset($patient_data['patient_id'])) {
            throw new Exception("Invalid patient data");
        }
        $patient_id = $patient_data['patient_id'];

    // Delete related appointments
    $delete_appointments = "DELETE FROM appointments WHERE patient_id = $patient_id";
    error_log("Executing: $delete_appointments");
    
    if (!mysqli_query($conn, $delete_appointments)) {
        $error = "Failed to delete related appointments: " . mysqli_error($conn);
        error_log($error);
        throw new Exception($error);
    }

    // Delete the patient
    $delete_patient = "DELETE FROM patients WHERE email = '$email'";
    error_log("Executing: $delete_patient");
    
    $delete_result = mysqli_query($conn, $delete_patient);

    if (!$delete_result) {
        $error = "Failed to delete patient: " . mysqli_error($conn);
        error_log($error);
        throw new Exception($error);
    }

    // Verify deletion
    $verify_query = "SELECT * FROM patients WHERE email = '$email'";
    $verify_result = mysqli_query($conn, $verify_query);
    
    if (mysqli_num_rows($verify_result) > 0) {
        $error = "Patient still exists after deletion attempt";
        error_log($error);
        throw new Exception($error);
    }

    // Commit transaction
    mysqli_commit($conn);
    
    ob_end_clean();
    header("Location: all_patients.php?success=Patient%20and%20related%20appointments%20deleted%20successfully");
    exit();

} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);
    error_log("Deletion failed: " . $e->getMessage());
    
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
    exit();
}
?>
