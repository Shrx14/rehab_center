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
    $specialty = mysqli_real_escape_string($conn, $_POST['speciality']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $visit_days = mysqli_real_escape_string($conn, $_POST['visit_days']);
    $max_patients = mysqli_real_escape_string($conn, $_POST['max_patients']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = 2;

    $query = "INSERT INTO doctors (name, email, speciality, phone, experience, visit_days, max_patients, password, role_id) 
              VALUES ('$name', '$email', '$specialty', '$phone', '$experience', '$visit_days', '$max_patients', '$password', '$role_id')";

    if (mysqli_query($conn, $query)) {
        header("Location: all_doc.php?success=Doctor added successfully");
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
    <title>Add New Doctor</title>
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
        <h3>Add New Doctor</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name" class="form-label">Doctor Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Doctor Name" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>

            <div class="form-group">
                <label for="speciality" class="form-label">Specialty</label>
                <input type="text" id="speciality" name="speciality" class="form-control" placeholder="Specialty" required>
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone" required>
            </div>

            <div class="form-group">
                <label for="experience" class="form-label">Years of Experience</label>
                <input type="number" id="experience" name="experience" class="form-control" placeholder="Years of Experience" required>
            </div>

            <div class="form-group">
                <label for="visit_days" class="form-label">Visit Days (e.g., Mon-Fri)</label>
                <input type="text" id="visit_days" name="visit_days" class="form-control" placeholder="Visit Days" required>
            </div>

            <div class="form-group">
                <label for="max_patients" class="form-label">Max Patients</label>
                <input type="number" id="max_patients" name="max_patients" class="form-control" placeholder="Max Patients (Patient Intake)" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Doctor</button>
            <a href="all_doc.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
