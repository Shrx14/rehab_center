<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $diagnosis_type = mysqli_real_escape_string($conn, $_POST['diagnosis']);
    $Surgery_status = mysqli_real_escape_string($conn, $_POST['Surgery_status']);
    $admitted_date = mysqli_real_escape_string($conn, $_POST['admitted_date']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = 3; // Assuming 3 represents the patient role

    $query = "INSERT INTO patients (name, email, phone, age, address, diagnosis_type, surgery_status, admitted_date, password, role_id) 
              VALUES ('$name', '$email', '$phone', '$age', '$address', '$diagnosis_type', '$Surgery_status', '$admitted_date', '$password', '$role_id')";

    if (mysqli_query($conn, $query)) {
        header("Location: all_patients.php?success=Patient added successfully");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Patient</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
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
            width: 100%;
            max-width: 800px;
            padding: 40px;
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out forwards;
            border: 1px solid rgba(0,0,0,0.05);
        }
        h3 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
            font-size: 28px;
            font-weight: 500;
            letter-spacing: -0.5px;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.2s forwards;
        }
        .form-label {
            font-weight: bold;
            font-size: 1.1rem;
        }
        .btn-primary, .btn-secondary {
            width: 100%;
            padding: 14px;
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.3s forwards;
            border-radius: 8px;
        }
        .btn-primary:hover, .btn-secondary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-secondary {
            margin-top: 12px;
            background-color: #f8f9fa;
            color: #495057;
            border: 1px solid #e0e0e0;
        }
        .form-control {
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
            background-color: #fcfcfc;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.1rem rgba(0,123,255,.15);
            background-color: white;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .alert {
            margin-bottom: 20px;
            transform: translateY(20px);
            opacity: 0;
            animation: fadeIn 0.5s ease-out 0.3s forwards;
        }
        .button-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .button-group .btn {
            width: 100%;
        }
    </style>
</head>
<body style="position: relative; background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg'); background-size: cover; background-position: center; background-attachment: local; height: 100vh; display: flex; flex-direction: column; animation: fadeIn 1.5s ease-in-out;">

    <div class="container mt-5">
        <h3>Add New Patient</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name" class="form-label">Patient Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Patient Name" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone" required>
            </div>

            <div class="form-group">
                <label for="age" class="form-label">Age</label>
                <input type="number" id="age" name="age" class="form-control" placeholder="Age" required>
            </div>

            <div class="form-group">
                <label for="address" class="form-label">Address</label>
                <input type="text" id="address" name="address" class="form-control" placeholder="Address" required>
            </div>

            <div class="form-group">
                <label for="diagnosis" class="form-label">Diagnosis Type</label>
                <input type="text" id="diagnosis" name="diagnosis" class="form-control" placeholder="Diagnosis Type" required>
            </div>

            <div class="form-group">
                <label for="Surgery_status" class="form-label">Surgery Status</label>
                <input type="text" id="Surgery_status" name="Surgery_status" class="form-control" placeholder="Surgery Status (e.g., Pending, Completed)" required>
            </div>

            <div class="form-group">
                <label for="admitted_date" class="form-label">Admission Date</label>
                <input type="date" id="admitted_date" name="admitted_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Add Patient</button>
                <button type="button" onclick="window.location.href='all_patients.php'" class="btn btn-secondary">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>
