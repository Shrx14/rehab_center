<?php
session_start();
include 'connection.php';

if ($_SESSION['role'] != 'Doctor') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'];
    $delete_query = "DELETE FROM doctors WHERE email = '$email'";

    if (mysqli_query($conn, $delete_query)) {
        echo "<h2 style='padding: 8px 12px; font-size:15px; border-radius:6px; border:none; background-color: #85C1E9;color: black;' >Your account has been deleted successfully.</h3>";
        echo "<a href='welcome.php' class='btn btn-view btn-sm' style='padding: 8px 12px; font-size:15px; border-radius:6px; border:none; background-color: #85C1E9;color: black;'>Go to Welcome Page</a>";

        exit();


    } else {
        $error = "Failed to delete account.";
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
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #dc3545;
        }
        p {
            font-size: 18px;
            margin-bottom: 30px;
            text-align: center;
        }
        .btn-danger {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            font-weight: 500;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .alert {
            margin-bottom: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delete Account</h2>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <p>Are you sure you want to delete your account? This action cannot be undone.</p>
        <form method="POST">
            <button type="submit" class="btn btn-danger">Delete Account</button>
        </form>
    </div>
</body>
</html>
