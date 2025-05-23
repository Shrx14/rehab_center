<?php
session_start();

// Check if the user is logged in as a Doctor
if ($_SESSION['role'] != 'Doctor') {
    header("Location: index.php"); // Redirect to login page if not a doctor
    exit();
}

// Include the database connection file
include 'connection.php';

if (isset($_GET['appointment_id'])) {
    $appointment_id = $_GET['appointment_id'];

    // Fetch the patient_id associated with the appointment_id
    $patient_query = "SELECT patient_id FROM appointments WHERE appointment_id='$appointment_id'";
    $patient_result = mysqli_query($conn, $patient_query);
    $patient = mysqli_fetch_assoc($patient_result);
    $patient_id = $patient['patient_id'];
}

// Check if doctor_id is set in the session
if (!isset($_SESSION['doctor_id'])) {
    echo "<script>alert('Doctor ID is not set in the session. Please log in again.'); window.location.href = 'index.php';</script>";
    exit();
}

if (isset($_POST['submit'])) {
    $notes = $_POST['notes'];
    $session_date = date('Y-m-d'); // Current date for the session

    $sql = "INSERT INTO therapy_sessions (patient_id, doctor_id, appointment_id, session_date, progress_notes) 
            VALUES ('$patient_id', '{$_SESSION['doctor_id']}', '$appointment_id', '$session_date', '$notes')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Therapy notes added successfully!'); window.location.href = 'doc_sessions.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
} elseif (isset($_POST['complete'])) {
    // Update appointment status to completed
    $update_sql = "UPDATE appointments SET status = 'completed' WHERE appointment_id = '$appointment_id'";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Appointment marked as completed!'); window.location.href = 'doc_sessions.php';</script>";
    } else {
        echo "<script>alert('Error updating appointment status: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Therapy Notes</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Use the existing styles.css -->
    <style>
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            scroll-behavior: smooth;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.4s forwards;
        }
        h1 {
            text-align: center;
            color: #007bff;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        textarea {
            width: 80%;
            height: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            resize: vertical;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            transform: scale(1);
        }
        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body style="position: relative;  background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg'); background-size: cover; background-position: center; background-attachment: local; height: 100vh; display: flex; flex-direction: column; animation: fadeIn 1.5s ease-in-out;">
    <div class="container">
        <h1>Add Therapy Notes</h1>
        <form method="POST" action="">
            <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
            <label>Notes:</label>
            <textarea name="notes" required></textarea>
            <button type="submit" name="submit">Submit Notes</button>
            <button type="submit" name="complete" style="background-color: #28a745; margin-top: 10px;">Mark Session as Completed</button>
        </form>
    </div>
</body>
</html>
