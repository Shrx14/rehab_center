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
        echo "<div class='container' style='text-align: center;'>";
        echo "<h2 style='color: #28a745; margin-bottom: 20px;'>Your account has been deleted successfully</h2>";
        echo "<a href='welcome.php' class='btn btn-success' style='padding: 10px 20px;'>Go to Welcome Page</a>";
        echo "</div>";

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
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out forwards;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #dc3545;
            padding-bottom: 15px;
            border-bottom: 2px solid #f8d7da;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.2s forwards;
        }
        p {
            font-size: 18px;
            margin-bottom: 30px;
            text-align: center;
            color: #dc3545;
            font-weight: bold;
            animation: fadeIn 0.8s ease-out 0.3s forwards;
            opacity: 0;
        }
        .btn-danger {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.3s forwards;
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
