<?php
session_start();
include 'connection.php'; // Database connection file

// Check if the user is logged in as Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: index.php"); // Redirect to login page if not an admin
    exit();
}

// Fetch the session details for editing
if (isset($_GET['id'])) {
    $session_id = $_GET['id'];
    $query = "SELECT * FROM therapy_sessions WHERE session_id = $session_id";
    $result = mysqli_query($conn, $query);
    $session = mysqli_fetch_assoc($result);
} else {
    header("Location: all_therapy_sessions.php"); // Redirect if no ID is provided
    exit();
}

// Update session details
if (isset($_POST['update'])) {
    $session_date = $_POST['session_date'];
    $progress_notes = $_POST['progress_notes'];

    $update_query = "UPDATE therapy_sessions SET session_date='$session_date', progress_notes='$progress_notes' WHERE session_id=$session_id";
    mysqli_query($conn, $update_query);
    header("Location: all_therapy_sessions.php"); // Redirect after update
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Therapy Session</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
            padding: 12px;
            font-size: 16px;
            margin-top: 15px;
        
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
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
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
        <h1>Edit Therapy Session</h1>

        <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST">
            <div class="form-group">
                <label>Session Date:</label>
                <input type="date" name="session_date" class="form-control" value="<?php echo $session['session_date']; ?>" required>
            </div>
            <div class="form-group">
                <label>Progress Notes:</label>
                <textarea name="progress_notes" class="form-control" rows="4" required><?php echo $session['progress_notes']; ?></textarea>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Session</button>
        </form>
    </div>
</body>
</html>
