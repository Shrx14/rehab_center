<?php
// Include database connection
include 'connection.php';

// Get the current date and time
$currentDateTime = date('Y-m-d H:i:s');

// Query to select appointments that are due
$query = "SELECT * FROM appointments WHERE appointment_date <= CURDATE() AND appointment_time <= CURTIME() AND status = 'Scheduled';";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointmentId = $row['appointment_id'];
        $doctorId = $row['doctor_id'];

        echo "Updating appointment status...\n"; // Debugging output
        // Update the appointment status to 'Completed'
        $updateQuery = "UPDATE appointments SET status = 'Completed' WHERE appointment_id = $appointmentId";
        $conn->query($updateQuery);

        echo "Counting scheduled appointments for doctor ID: $doctorId...\n"; // Debugging output
        $scheduledCountQuery = "SELECT COUNT(*) as count FROM appointments WHERE doctor_id = $doctorId AND status = 'Scheduled'";
        $countResult = $conn->query($scheduledCountQuery);
        $countRow = $countResult->fetch_assoc();
        $appointmentCount = $countRow['count'];

        echo "Counting canceled appointments for doctor ID: $doctorId...\n"; // Debugging output
        $cancelledCountQuery = "SELECT COUNT(*) as count FROM appointments WHERE doctor_id = $doctorId AND status = 'Cancelled'";
        $cancelledResult = $conn->query($cancelledCountQuery);
        $cancelledRow = $cancelledResult->fetch_assoc();
        $cancelledCount = $cancelledRow['count'];

        // Update the appointment count for the doctor
        $updateCountQuery = "UPDATE doctors SET appointment_count = appointment_count - 1 WHERE doctor_id = $doctorId";
        $conn->query($updateCountQuery);
    }
}

// Close the database connection
$conn->close();
?>
