<?php
session_start();
include 'connection.php';

// Check if the user is a 'Patient'
if ($_SESSION['role'] != 'Patient') {
    header("Location: index.php");  // Redirect to index if not a patient
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'];  // Get the patient's email from the session
    
    // Ensure the email is valid before attempting to delete
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } else {
        // Delete query to completely remove the patient record from the 'patients' table
        $delete_query = "DELETE FROM patients WHERE email = '$email'"; 
        
        if (mysqli_query($conn, $delete_query)) {
            // Successfully deleted the account
            echo "<h2 style='padding: 8px 12px; font-size:15px; border-radius:6px; border:none; background-color: #85C1E9;color: black;' >Your account has been deleted successfully.</h3>";
            echo "<a href='welcome.php' class='btn btn-view btn-sm' style='padding: 8px 12px; font-size:15px; border-radius:6px; border:none; background-color: #85C1E9;color: black;'>Go to Welcome Page</a>";

            exit();



        } else {
            // Error with the query
            $error = "Failed to delete account. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #0056b3;
        }
        .alert {
            margin-top: 20px;
            border-radius: 8px;
        }
        .btn-danger {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delete Account</h2>
        <!-- Display any error message -->
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <p>Are you sure you want to delete your account? This action cannot be undone.</p>
            <button type="submit" class="btn btn-danger">Delete Account</button>
        </form>
    </div>
</body>
</html>
