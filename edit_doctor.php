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
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $speciality = mysqli_real_escape_string($conn, $_POST['speciality']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $visit_days = mysqli_real_escape_string($conn, $_POST['visit_days']);
    $max_patients = mysqli_real_escape_string($conn, $_POST['max_patients']);

    // Validate phone number format
    if (!preg_match('/^\+91\d{10}$/', $phone)) {
        $error = "Invalid phone number. Please enter a valid Indian phone number with country code +91 followed by 10 digits.";
    }

    if (empty($error)) {
        $update_query = "
            UPDATE doctors 
            SET 
                name = '$name', 
                phone = '$phone', 
                speciality = '$speciality', 
                experience = '$experience', 
                visit_days = '$visit_days', 
                max_patients = '$max_patients' 
            WHERE email = '$email'";

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
            margin-bottom: 15px;
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
<body>
    <div class="container">
        <h2>Edit Doctor Details</h2>
        
        <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST" onsubmit="return validatePhone()">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($doctor['name']); ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($doctor['email']); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Phone Number (with country code +91)</label>
                <input type="text" name="phone" id="phone" class="form-control" value="<?php echo htmlspecialchars($doctor['phone']); ?>" required>
                <div id="phoneError" class="error"></div>
            </div>
            <div class="form-group">
                <label>Specialty</label>
                <input type="text" name="speciality" class="form-control" value="<?php echo htmlspecialchars($doctor['speciality']); ?>" required>
            </div>
            <div class="form-group">
                <label>Experience</label>
                <input type="text" name="experience" class="form-control" value="<?php echo htmlspecialchars($doctor['experience']); ?>" required>
            </div>
            <div class="form-group">
                <label>Visit Days</label>
                <input type="text" name="visit_days" class="form-control" value="<?php echo htmlspecialchars($doctor['visit_days']); ?>" required>
            </div>
            <div class="form-group">
                <label>Maximum Patients</label>
                <input type="number" name="max_patients" class="form-control" value="<?php echo htmlspecialchars($doctor['max_patients']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Doctor</button>
        </form>
    </div>
</body>
</html>