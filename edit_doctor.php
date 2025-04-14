<?php
session_start();
include 'connection.php';

// Check if the user is logged in as Admin
if ($_SESSION['role'] != 'Admin') {
    header("Location: index.php");
    exit();
}

// Check if email parameter is set
if (!isset($_GET['email'])) {
    header("Location: all_doc.php");
    exit();
}

$email = urldecode($_GET['email']);
$query = "SELECT * FROM doctors WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$doctor = mysqli_fetch_assoc($result);

if (!$doctor) {
    header("Location: all_doc.php?error=Doctor not found");
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $speciality = mysqli_real_escape_string($conn, $_POST['speciality']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $max_patients = (int)$_POST['max_patients'];

    // Validate phone number format
    if (!preg_match('/^\+91\d{10}$/', $phone)) {
        $error = "Invalid phone number. Please enter a valid Indian phone number with country code +91 followed by 10 digits.";
    }

    if (empty($error)) {
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_query = "
            UPDATE doctors 
            SET 
                    name = '$name', 
                    email = '$email', 
                    password = '$hashed_password', 
                    speciality = '$speciality', 
                    phone = '$phone', 
                    experience = '$experience', 
                    max_patients = $max_patients 
                WHERE email = '$email'";
        } else {
            $update_query = "
                UPDATE doctors 
                SET 
                    name = '$name', 
                    email = '$email', 
                    speciality = '$speciality', 
                    phone = '$phone', 
                    experience = '$experience', 
                    max_patients = $max_patients 
                WHERE email = '$email'";
        }

        if (mysqli_query($conn, $update_query)) {
            $success = "Doctor details updated successfully.";
            header("Refresh: 2; url=all_doc.php");
        } else {
            $error = "Failed to update doctor: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
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
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
        .btn-primary {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert {
            margin-top: 20px;
            border-radius: 8px;
        }
        .error {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
    <script>
        function validatePhone() {
            const phoneInput = document.getElementById('phone');
            const phonePattern = /^\+91\d{10}$/;
            
            if (!phonePattern.test(phoneInput.value)) {
                document.getElementById('phoneError').textContent = 'Please enter a valid Indian phone number with country code +91 followed by 10 digits';
                return false;
            }
            document.getElementById('phoneError').textContent = '';
            return true;
        }
    </script>
</head>
<body style="position: relative; background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg'); background-size: cover; background-position: center; background-attachment: local; height: 100vh; display: flex; flex-direction: column; animation: fadeIn 1.5s ease-in-out;">
    <div class="container">
        <h2>Edit Doctor Details</h2>
        
        <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST" onsubmit="return validatePhone()">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($doctor['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($doctor['email']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number (with country code +91)</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($doctor['phone']); ?>" required>
                <div id="phoneError" class="error"></div>
            </div>
            <div class="form-group">
                <label for="speciality">Specialty</label>
                <input type="text" id="speciality" name="speciality" class="form-control" value="<?php echo htmlspecialchars($doctor['speciality']); ?>" required>
            </div>
            <div class="form-group">
                <label for="experience">Experience (years)</label>
                <input type="text" id="experience" name="experience" class="form-control" value="<?php echo htmlspecialchars($doctor['experience']); ?>" required>
            </div>
            <div class="form-group">
                <label for="max_patients">Maximum Patients</label>
                <input type="number" id="max_patients" name="max_patients" class="form-control" value="<?php echo htmlspecialchars($doctor['max_patients']); ?>" required>
            </div>
            <div class="form-group">
                <label for="appointment_count">Current Scheduled Appointments</label>
                <input type="number" id="appointment_count" name="appointment_count" class="form-control" value="<?php echo htmlspecialchars($doctor['appointment_count']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">New Password (leave blank to keep current)</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update Doctor</button>
        </form>
    </div>
</body>
</html>
