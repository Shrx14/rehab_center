<?php
session_start();
include 'connection.php';

// Check if the user is logged in
if ($_SESSION['role'] != 'Patient') {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM patients WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

$success = ''; // Initialize success message variable
$error = '';   // Initialize error message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $diagnosis_type = $_POST['diagnosis_type'];
    $admitted_date = $_POST['admitted_date'];
    $surgery_status = $_POST['surgery_status'];
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
        // Update query to reflect all columns
        $update_query = "
            UPDATE patients 
            SET 
                name = '$name', 
                phone = '$phone', 
                address = '$address', 
                age = '$age', 
                diagnosis_type = '$diagnosis_type', 
                admitted_date = '$admitted_date', 
                Surgery_status = '$surgery_status', 
                password = '" . password_hash($new_password, PASSWORD_DEFAULT) . "' 

            WHERE email = '$email'";

        if (mysqli_query($conn, $update_query)) {
            // Set a success message and redirect after 2 seconds
            $success = "Your account details have been updated successfully.";
            header("Refresh: 2; url=patient_acc_set.php"); // Redirect to the same page
            exit();
        } else {
            $error = "Failed to update account: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
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
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.2s forwards;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        .btn-primary {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.3s forwards;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert {
            margin-top: 20px;
            border-radius: 8px;
            transform: translateY(20px);
            opacity: 0;
            animation: fadeIn 0.5s ease-out 0.3s forwards;
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
        <h2>Account Settings</h2>
        
        <!-- Display success or error messages -->
        <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <!-- Form for updating user details -->
        <form method="POST" onsubmit="return validatePhone()">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number (with country code +91)</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                <div id="phoneError" class="error"></div>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" class="form-control" value="<?php echo htmlspecialchars($user['address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" class="form-control" value="<?php echo htmlspecialchars($user['age']); ?>" required>
            </div>
            <div class="form-group">
                <label for="diagnosis_type">Diagnosis Type</label>
                <input type="text" id="diagnosis_type" name="diagnosis_type" class="form-control" value="<?php echo htmlspecialchars($user['diagnosis_type']); ?>" required>
            </div>
            <div class="form-group">
                <label for="admitted_date">Admission Date</label>
                <input type="date" id="admitted_date" name="admitted_date" class="form-control" value="<?php echo htmlspecialchars($user['admitted_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="surgery_status">Surgery Status</label>
                <select id="surgery_status" name="surgery_status" class="form-control" required>
                    <option value="Not Required" <?php echo (empty($user['Surgery_status']) || $user['Surgery_status'] == 'Not Required') ? 'selected' : ''; ?>>Not Required</option>
                    <option value="Completed" <?php echo ($user['Surgery_status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                    <option value="Pending" <?php echo ($user['Surgery_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                </select>
            </div>
            <div class="form-group">
                <label for="old_password">Old Password (Required for password change)</label>
                <input type="password" id="old_password" name="old_password" class="form-control">
            </div>
            <div class="form-group">
                <label for="new_password">New Password (Optional)</label>
                <input type="password" id="new_password" name="new_password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update Account</button>
        </form>
    </div>
</body>
</html>
