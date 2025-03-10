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
    min-height: 100vh;  /* Add this line to ensure vertical centering */
}
        .container {
            width: 100%;
            max-width: 800px;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h3 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
            font-size: 30px;
        }
        .form-label {
            font-weight: bold;
            font-size: 1.1rem;
        }
        .btn-primary, .btn-secondary {
            width: 100%;
            padding: 15px;
            font-size: 1.1rem;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px;
            font-size: 1.1rem;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
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

            <button type="submit" class="btn btn-primary">Add Patient</button>
            <a href="all_patients.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
