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
    header("Location: all_patients.php");
    exit();
}

$email = urldecode($_GET['email']);
$query = "SELECT * FROM patients WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$patient = mysqli_fetch_assoc($result);

if (!$patient) {
    header("Location: all_patients.php?error=Patient not found");
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $diagnosis_type = mysqli_real_escape_string($conn, $_POST['diagnosis_type']);
    $admitted_date = mysqli_real_escape_string($conn, $_POST['admitted_date']);
    $surgery_status = mysqli_real_escape_string($conn, $_POST['surgery_status']);

    // Validate phone number format
    if (!preg_match('/^\+91\d{10}$/', $phone)) {
        $error = "Invalid phone number. Please enter a valid Indian phone number with country code +91 followed by 10 digits.";
    }

    if (empty($error)) {
        $update_query = "
            UPDATE patients 
            SET 
                name = '$name', 
                phone = '$phone', 
                address = '$address', 
                age = '$age', 
                diagnosis_type = '$diagnosis_type', 
                admitted_date = '$admitted_date', 
                Surgery_status = '$surgery_status' 
            WHERE email = '$email'";

        if (mysqli_query($conn, $update_query)) {
            $success = "Patient details updated successfully.";
            header("Refresh: 2; url=all_patients.php");
        } else {
            $error = "Failed to update patient: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
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
<body>
    <div class="container">
        <h2>Edit Patient Details</h2>
        
        <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST" onsubmit="return validatePhone()">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($patient['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($patient['email']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number (with country code +91)</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($patient['phone']); ?>" required>
                <div id="phoneError" class="error"></div>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" class="form-control" value="<?php echo htmlspecialchars($patient['address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" class="form-control" value="<?php echo htmlspecialchars($patient['age']); ?>" required>
            </div>
            <div class="form-group">
                <label for="diagnosis_type">Diagnosis Type</label>
                <input type="text" id="diagnosis_type" name="diagnosis_type" class="form-control" value="<?php echo htmlspecialchars($patient['diagnosis_type']); ?>" required>
            </div>
            <div class="form-group">
                <label for="admitted_date">Admission Date</label>
                <input type="date" id="admitted_date" name="admitted_date" class="form-control" value="<?php echo htmlspecialchars($patient['admitted_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="surgery_status">Surgery Status</label>
                <input type="text" id="surgery_status" name="surgery_status" class="form-control" value="<?php echo htmlspecialchars($patient['Surgery_status']); ?>" >
            </div>
            <button type="submit" class="btn btn-primary">Update Patient</button>
        </form>
    </div>
</body>
</html>