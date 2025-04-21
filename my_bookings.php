<?php
session_start();

// Check if the user is logged in as a Patient
if ($_SESSION['role'] != 'Patient') {
    header("Location: index.php"); // Redirect to login page if not a patient
    exit();
}

// Include the database connection file
include 'connection.php';

// Get the logged-in patient's email
$email = $_SESSION['email'];

// Fetch the patient's details
$query = "SELECT * FROM patients WHERE email='$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $patient = mysqli_fetch_assoc($result);
    $patient_name = $patient['name'];
    $patient_id = $patient['patient_id'];
} else {
    echo "Patient not found!";
    exit();
}

// Fetch all doctors with their availability status
$doctors_query = "SELECT d.doctor_id, d.name, d.email, d.speciality, d.appointment_count, d.max_patients 
                  FROM doctors d";
$doctors_result = mysqli_query($conn, $doctors_query);

// Check if form is submitted
$success_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $message = $_POST['message'] ?? '';

    // Check if the selected doctor is available
    $availability_query = "SELECT appointment_count, max_patients, name FROM doctors WHERE doctor_id='$doctor_id'";
    $availability_result = mysqli_query($conn, $availability_query);
    $doctor_info = mysqli_fetch_assoc($availability_result);

    if ($doctor_info['appointment_count'] >= $doctor_info['max_patients']) {
        $success_message = $doctor_info['name'] . " is not available for booking. Please choose another doctor.";
    } else {
        // Insert the appointment into the appointments table
        $insert_query = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, status)
                         VALUES ('$patient_id', '$doctor_id', '$appointment_date', '$appointment_time', 'Scheduled')";

        if (mysqli_query($conn, $insert_query)) {
            // Update the appointment count in the doctors table
            $update_count_query = "UPDATE doctors 
                                   SET appointment_count = appointment_count + 1 
                                   WHERE doctor_id = '$doctor_id'";
            mysqli_query($conn, $update_count_query);

            $success_message = "Your appointment with " . $doctor_info['name'] . " has been booked successfully!";
        } else {
            $success_message = "Error booking appointment: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
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
            animation: slideInUp 0.5s ease-out;
        }
        .form-section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.3s forwards;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .header-section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #007bff;
            color: white;
            border-radius: 10px;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.2s forwards;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
        .alert {
            margin-top: 20px;
            border-radius: 8px;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.4s forwards;
        }
    </style>
</head>
<body style="position: relative; background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg'); background-size: cover; background-position: center; background-attachment: local; height: 100vh; display: flex; flex-direction: column; animation: fadeIn 1.5s ease-in-out;">

<!-- Sidebar -->
<div class="sidebar">
        <h4><?php echo $patient_name; ?></h4>
        <p><?php echo $email; ?></p>
        <a href="logout.php">Logout</a>
        <hr>
        <a href="patient_dashboard.php">Home</a>
        <a href="my_doctors.php">My Doctors</a>
        <a href="my_sessions.php">My Sessions</a>
        <a href="my_bookings.php" class="active">My Bookings</a>
        <a href="patient_settings.php">Settings</a>
    </div>

    <div class="main-content">
        <div class="header-section">
        <h2>Book an Appointment</h2>

        <!-- Success/Failure Message -->
        <?php if ($success_message): ?>
            <div class="alert alert-info">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        </div>
        <!-- Appointment Booking Form -->
        <form action="my_bookings.php" method="POST">

            <!-- Select Doctor -->
            <div class="form-group">
                <label for="doctor_id">Select Doctor</label>
                <select name="doctor_id" class="form-control" required>
                    <option value="">--Select Doctor--</option>
                    <?php while ($doctor = mysqli_fetch_assoc($doctors_result)): ?>
                        <?php
                        $availability = ($doctor['appointment_count'] >= $doctor['max_patients']) ? " (Not Available)" : "";
                        ?>
                        <option value="<?php echo $doctor['doctor_id']; ?>" 
                                <?php echo ($availability) ? "disabled" : ""; ?>>
                             <?php echo $doctor['name']; ?> - <?php echo $doctor['speciality']; ?> <?php echo $availability; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Select Appointment Date -->
            <div class="form-group">
                <label for="appointment_date">Select Appointment Date</label>
                <input type="date" name="appointment_date" class="form-control" required>
            </div>

            <!-- Select Appointment Time -->
            <div class="form-group">
                <label for="appointment_time">Select Appointment Time</label>
                <input type="time" name="appointment_time" class="form-control" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary submit-btn">Book Appointment</button>
        </form>
    </div>

</body>
</html>
