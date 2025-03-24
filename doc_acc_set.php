<?php
session_start();
include 'connection.php';

// Check if user is logged in as Doctor
if ($_SESSION['role'] != 'Doctor') {
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM doctors WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

$success = ''; // Initialize success message variable
$error = '';   // Initialize error message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $speciality = $_POST['speciality'];
    $experience = $_POST['experience'];
    $max_patients = $_POST['max_patients'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    // Validate phone number format
    if (!preg_match('/^\+91\d{10}$/', $phone)) {
        $error = "Invalid phone number. Please enter a valid Indian phone number with country code +91 followed by 10 digits.";
    }

    // Verify old password if new password is provided
    if (!empty($new_password) && empty($error)) {
        if (!password_verify($old_password, $user['password'])) {

            $error = "Old password is incorrect";
        } else {
            $password = $new_password;
        }
    } else {
        $password = $user['password'];
    }

    if (empty($error)) {
        $update_query = "UPDATE doctors SET 
            name = '$name', 
            phone = '$phone', 
            speciality = '$speciality', 
            experience = '$experience', 
            max_patients = '$max_patients'";
            
        // Only update password if a new one was provided
        if (!empty($new_password)) {
            $update_query .= ", password = '" . password_hash($new_password, PASSWORD_DEFAULT) . "'";

        }
        
        $update_query .= " WHERE email = '$email'";

        if (mysqli_query($conn, $update_query)) {
            $success = "Account updated successfully.";
        } else {
            $error = "Failed to update account.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Account Settings</title>
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
        <h2>Doctor Account Settings</h2>
        <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST" onsubmit="return validatePhone()">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $user['name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Email Id</label>
                <input type="text" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
            </div>
            <div class="form-group">
                <label>Phone Number (with country code +91)</label>
                <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $user['phone']; ?>" required>
                <div id="phoneError" class="error"></div>
            </div>
            <div class="form-group">
                <label>Specialization</label>
                <input type="text" name="speciality" class="form-control" value="<?php echo $user['speciality']; ?>" required>
            </div>
            <div class="form-group">
                <label>Experience</label>
                <input type="text" name="experience" class="form-control" value="<?php echo $user['experience']; ?>" required>
            </div>
            <div class="form-group">
                <label>Maximum Patients (Patient Intake)</label>
                <input type="text" name="max_patients" class="form-control" value="<?php echo $user['max_patients']; ?>" required>
            </div>
            <div class="form-group">
                <label>Old Password (Required for password change)</label>
                <input type="password" name="old_password" class="form-control">
            </div>
            <div class="form-group">
                <label>New Password (Optional)</label>
                <input type="password" name="new_password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update Account</button>
        </form>
    </div>
</body>
</html>
