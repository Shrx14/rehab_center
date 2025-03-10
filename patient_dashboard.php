<?php
session_start();

// Check if the user is logged in as a Patient
if ($_SESSION['role'] != 'Patient') {
    header("Location: index.php");  // Redirect to login page if not a patient
    exit();
}

// Include the database connection file
include 'connection.php';

// Get the logged-in patient's email
$email = $_SESSION['email'];

// Fetch the patient's details from the database
$query = "SELECT * FROM patients WHERE email='$email'";
$result = mysqli_query($conn, $query);

// Check if the patient exists in the database
if (mysqli_num_rows($result) > 0) {
    $patient = mysqli_fetch_assoc($result);
    $patient_name = $patient['name'];
    $patient_id = $patient['patient_id'];
} else {
    echo "Patient not found!";
    exit();
}

// Fetch the number of assigned doctors
$doctor_count_query = "SELECT COUNT(DISTINCT doctor_id) AS doctor_count FROM appointments WHERE patient_id = '$patient_id'";
$doctor_count_result = mysqli_query($conn, $doctor_count_query);
$doctor_count = mysqli_fetch_assoc($doctor_count_result)['doctor_count'];

// Fetch upcoming sessions
$upcoming_sessions_query = "SELECT * FROM appointments WHERE patient_id = '$patient_id' AND appointment_date >= CURDATE() ORDER BY appointment_date ASC";
$upcoming_sessions_result = mysqli_query($conn, $upcoming_sessions_query);

// Get current page from the URL, default to 'home' if not set
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Include different pages based on the 'page' parameter
switch ($page) {
    case 'my_bookings':
        include 'my_bookings.php';
        break;
    case 'home':
    default:
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Patient Dashboard</title>
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
                .sidebar .active {
                    background-color: #007bff;
                }
                .main-content {
                    margin-left: 250px;
                    padding: 20px;
                }
                .welcome-section {
                    margin-bottom: 30px;
                    padding: 20px;
                    background-color: #007bff;
                    color: white;
                    border-radius: 10px;
                }
                .dashboard-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                    gap: 20px;
                }
                .card {
                    border: none;
                    border-radius: 10px;
                    padding: 20px;
                    background-color: #ffffff;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }
                .card h5 {
                    margin-bottom: 15px;
                    font-weight: bold;
                    color: #0056b3;
                }
                .daily-motivation {
                    margin-top: 50px;
                    text-align: center;
                    font-style: italic;
                    color: #555;
                    font-size: 18px;
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
                <a href="patient_dashboard.php?page=home" class="<?php echo ($page == 'home') ? 'active' : ''; ?>">Home</a>
                <a href="my_doctors.php" class="<?php echo ($page == 'my_doctors') ? 'active' : ''; ?>">My Doctors</a>
                <a href="my_sessions.php" class="<?php echo ($page == 'my_sessions') ? 'active' : ''; ?>">Scheduled Sessions</a>
                <a href="my_bookings.php" class="<?php echo ($page == 'my_bookings') ? 'active' : ''; ?>">My Bookings</a>
                <a href="patient_settings.php" class="<?php echo ($page == 'settings') ? 'active' : ''; ?>">Settings</a>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Welcome Section -->
                <div class="welcome-section">
                    <h3>Welcome, <?php echo $patient_name; ?>!</h3>
                    <p>Your care and recovery are our priority.</p>
                </div>

                <!-- Dashboard Grid -->
                <div class="dashboard-grid">
                    <!-- Upcoming Sessions -->
                    <div class="card">
                        <h5>Upcoming Sessions</h5>
                        <?php
                        if (mysqli_num_rows($upcoming_sessions_result) > 0) {
                            echo "<ul>";
                            while ($session = mysqli_fetch_assoc($upcoming_sessions_result)) {
                                echo "<li>";
                                echo "Date: " . $session['appointment_date'] . " | Time: " . $session['appointment_time'];
                                echo "</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "<p>No upcoming sessions.</p>";
                        }
                        ?>
                    </div>

                    <!-- Assigned Doctors -->
                    <div class="card">
                        <h5>Assigned Doctors</h5>
                        <p>You have <?php echo $doctor_count; ?> assigned doctors.</p>
                    </div>
                </div>

                <!-- Daily Motivation -->
                <div class="daily-motivation">
                    "The journey of a thousand miles begins with a single step."
                </div>
            </div>

        </body>
        </html>
        <?php
        break;
}
?>
