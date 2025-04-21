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

// Fetch upcoming sessions as JSON for the calendar
$appointments = [];
$upcoming_sessions_query = "SELECT appointment_id, appointment_date, appointment_time FROM appointments 
                            WHERE patient_id = '$patient_id' AND appointment_date >= CURDATE() ORDER BY appointment_date ASC";
$upcoming_sessions_result = mysqli_query($conn, $upcoming_sessions_query);

while ($session = mysqli_fetch_assoc($upcoming_sessions_result)) {
    $appointments[] = [
        'start' => $session['appointment_date'] . 'T' . $session['appointment_time']
    ];
}

// Convert PHP array to JSON
$appointments_json = json_encode($appointments);

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
            <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.css" rel="stylesheet">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
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
                .sidebar .active {
                    background-color: #007bff;
                }
                .main-content {
                    margin-left: 250px;
                    padding: 20px;
                    animation: slideInUp 0.5s ease-out;
                }
                .welcome-section {
                    margin-bottom: 30px;
                    padding: 20px;
                    background-color: #007bff;
                    color: white;
                    border-radius: 10px;
                    transform: translateY(20px);
                    opacity: 0;
                    animation: slideInUp 0.5s ease-out 0.2s forwards;
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
                    transform: translateY(20px);
                    opacity: 0;
                    animation: slideInUp 0.5s ease-out forwards;
                }
                .card:nth-child(1) { animation-delay: 0.3s; }
                .card:nth-child(2) { animation-delay: 0.4s; }
                .card h5 {
                    margin-bottom: 15px;
                    font-weight: bold;
                    color: #0056b3;
                }
                .daily-motivation {
                    margin-top: 50px;
                    text-align: center;
                    font-style: italic;
                    color:rgb(8, 12, 69);
                    font-size: 18px;
                    animation: slideInLeft 0.5s ease-out 0.5s forwards;
                    opacity: 0;
                }
                #calendar {
                    max-width: 900px;
                    margin: auto;
                    background: white;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
                }
                /* Reduce height of calendar date cells and inner content */
                .fc .fc-daygrid-day {
                    height: 40px !important;
                    padding: 2px !important;
                }
                .fc .fc-daygrid-day-frame {
                    height: 40px !important;
                    padding: 0 !important;
                }
                .fc .fc-daygrid-day-top {
                    padding: 2px 4px !important;
                }
                /* Remove event dot from dayGrid events */
                .fc .fc-daygrid-event-dot {
                    display: none !important;
                }
                /* Remove bullet point from event start time */
                .fc .fc-event-time,
                .fc .fc-event-time::before {
                    list-style-type: none !important;
                    padding-left: 0 !important;
                    content: none !important;
                    margin: 0 !important;
                    color: red !important;
                }
            </style>
        </head>
        <body style="position: relative;  background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg'); background-size: cover; background-position: center; background-attachment: local; height: 100vh; display: flex; flex-direction: column; animation: fadeIn 1.5s ease-in-out;">

            <!-- Sidebar -->
            <div class="sidebar">
                <h4><?php echo $patient_name; ?></h4>
                <p><?php echo $email; ?></p>
                <a href="logout.php">Logout</a>
                <hr>
                <a href="patient_dashboard.php?page=home" class="<?php echo ($page == 'home') ? 'active' : ''; ?>">Home</a>
                <a href="my_doctors.php" class="<?php echo ($page == 'my_doctors') ? 'active' : ''; ?>">My Doctors</a>
                <a href="my_sessions.php" class="<?php echo ($page == 'my_sessions') ? 'active' : ''; ?>">My Sessions</a>
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
                        <div id="calendar"></div>
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

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        events: <?php echo $appointments_json; ?>,
                        displayEventTime: true,
                        displayEventEnd: false,
                        eventTimeFormat: { // 24-hour format
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        },
                        eventDidMount: function(info) {
                            console.log('Event rendered:', info.event);
                            // Ensure event title is fully visible and not clipped
                            info.el.style.whiteSpace = 'normal';
                            info.el.style.overflow = 'visible';
                            info.el.style.textOverflow = 'unset';
                            info.el.style.height = 'auto';
                        },
                        eventClick: function(info) {
                            // Redirect to my_sessions page on appointment click
                            window.location.href = 'my_sessions.php';
                        }
                    });
                    calendar.render();
                });
            </script>

        </body>
        </html>
        <?php
        break;
}
?>
