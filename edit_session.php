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
$query = "SELECT * FROM appointments WHERE appointment_id = '$appointment_id'";
$result = mysqli_query($conn, $query);
$session = mysqli_fetch_assoc($result);

if (!$session) {
    header("Location: all_sess.php?error=Session not found");
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
    $appointment_time = mysqli_real_escape_string($conn, $_POST['appointment_time']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $update_query = "
        UPDATE appointments 
        SET 
            appointment_date = '$appointment_date', 
            appointment_time = '$appointment_time', 
            status = '$status' 
        WHERE appointment_id = '$appointment_id'";

    if (mysqli_query($conn, $update_query)) {
        $success = "Session details updated successfully.";
        header("Refresh: 2; url=all_sess.php");
    } else {
        $error = "Failed to update session: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Session</title>
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
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.4s forwards;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #0056b3;
        }
        .form-group label {
            font-weight: bold;
            color: #2c3e50;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #e9ecef;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
        }
        .btn-primary {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 500;
            transition: all 0.3s ease;
            transform: scale(1);
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.02);
        }
        .alert {
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .error {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Session Details</h2>
        
        <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST">
            <div class="form-group">
                <label>Appointment Date</label>
                <input type="date" name="appointment_date" class="form-control" value="<?php echo htmlspecialchars($session['appointment_date']); ?>" required>
            </div>
            <div class="form-group">
                <label>Appointment Time</label>
                <input type="time" name="appointment_time" class="form-control" value="<?php echo htmlspecialchars($session['appointment_time']); ?>" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="Scheduled" <?php echo ($session['status'] == 'Scheduled') ? 'selected' : ''; ?>>Scheduled</option>
                    <option value="Completed" <?php echo ($session['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                    <option value="Cancelled" <?php echo ($session['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Session</button>
        </form>
    </div>
</body>
</html>