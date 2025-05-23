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

// Fetch available doctors
$doctors_query = "SELECT doctor_id, name, email FROM doctors";
$doctors_result = mysqli_query($conn, $doctors_query);

// Check if form is submitted
$success_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $message = $_POST['message'];

    // Insert the appointment into the appointments table
    $insert_query = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, status)
                     VALUES ('$patient_id', '$doctor_id', '$appointment_date', '$appointment_time', 'Pending')";

    if (mysqli_query($conn, $insert_query)) {
        $success_message = "Your appointment has been booked successfully!";
    } else {
        $success_message = "Error booking appointment: " . mysqli_error($conn);
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
        .form-section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
        .submit-btn:hover {
            background-color: #0056b3;
        }
        .alert {
            margin-top: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4><?php echo $patient_name; ?></h4>
        <p><?php echo $email; ?></p>
        <a href="logout.php">Logout</a>
        <hr>
        <a href="patient_dashboard.php">Home</a>
        <a href="my_doctors.php">My Doctors</a>
        <a href="my_sessions.php">Scheduled Sessions</a>
        <a href="my_bookings.php" class="active">My Bookings</a>
        <a href="patient_settings.php">Settings</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Book an Appointment</h2>

        <!-- Success Message -->
        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <!-- Appointment Booking Form -->
        <div class="form-section">
            <h3>Select Doctor and Appointment Details</h3>
            <form action="my_bookings.php" method="POST">

                <!-- Select Doctor -->
                <div class="form-group">
                    <label for="doctor_id">Select Doctor</label>
                    <select name="doctor_id" class="form-control" required>
                        <option value="">--Select Doctor--</option>
                        <?php while ($doctor = mysqli_fetch_assoc($doctors_result)): ?>
                            <option value="<?php echo $doctor['doctor_id']; ?>">
                                <?php echo $doctor['name']; ?> (<?php echo $doctor['email']; ?>)
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

                <!-- Optional Message to Doctor -->
                <div class="form-group">
                    <label for="message">Additional Details (Optional)</label>
                    <textarea name="message" class="form-control" rows="4"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">Book Appointment</button>
            </form>
        </div>
    </div>

</body>
</html>