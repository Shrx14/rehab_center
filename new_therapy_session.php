<?php
session_start();
include 'connection.php'; // Database connection file

// Check if the user is logged in as Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: index.php"); // Redirect to login page if not an admin
    exit();
}

// Insert new session details
if (isset($_POST['add'])) {
    $session_date = $_POST['session_date'];
    $progress_notes = $_POST['progress_notes'];

    $insert_query = "INSERT INTO therapy_sessions (session_date, progress_notes) VALUES ('$session_date', '$progress_notes')";
    mysqli_query($conn, $insert_query);
    header("Location: all_therapy_sessions.php"); // Redirect after adding
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Therapy Session</title>
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
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.2s forwards;
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
            transition: background-color 0.3s ease;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.3s forwards;
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
    <div class="container mt-5">
        <h3 class="mb-4" style="color: #007bff; transform: translateY(20px); opacity: 0; animation: slideInUp 0.5s ease-out 0.1s forwards;">Add Therapy Session</h3>
                
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="new_therapy_session.php">
            <div class="form-group">
                <label for="name" class="form-label">Session Date:</label>
                <input type="date" name="session_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Progress Notes:</label>
                <textarea name="progress_notes" class="form-control" rows="7" required></textarea>
            </div>
            <button type="submit" name="add" class="btn btn-primary submit-btn">Add Session</button>
        </form>
    </div>
</body>
</html>
