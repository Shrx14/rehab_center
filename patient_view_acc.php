<?php
session_start();
include 'connection.php';

// Check if the user is logged in and has the 'Patient' role
if ($_SESSION['role'] != 'Patient') {
    header("Location: index.php");
    exit();
}

// Retrieve the logged-in patient's email from the session
$email = $_SESSION['email'];

// Fetch the patient's details from the database
$query = "SELECT * FROM patients WHERE email = '$email'";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "Error fetching user details.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Account Details</title>
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
            color: #007bff;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.2s forwards;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            animation: fadeIn 0.8s ease-out 0.3s forwards;
            opacity: 0;
        }
        .table th, .table td {
            padding: 15px;
            text-align: left;
            border: 1px solid #e9ecef;
            transition: background-color 0.3s ease;
        }
        .table tr:hover td {
            background-color: #f1f8ff;
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Account Details</h2>
        <table class="table">
            <tr>
                <th>Name</th>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><?php echo htmlspecialchars($user['phone']); ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?php echo htmlspecialchars($user['address']); ?></td>
            </tr>
            <tr>
                <th>Age</th>
                <td><?php echo htmlspecialchars($user['age']); ?></td>
            </tr>
            <tr>
                <th>Diagnosis Type</th>
                <td><?php echo htmlspecialchars($user['diagnosis_type']); ?></td>
            </tr>
            <tr>
                <th>Admission Date</th>
                <td><?php echo htmlspecialchars($user['admitted_date']); ?></td>
            </tr>
            <tr>
                <th>Surgery Status</th>
                <td><?php echo htmlspecialchars($user['Surgery_status']); ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
