<?php
session_start();

// Check if the user is logged in as Admin
if ($_SESSION['role'] != 'Admin') {
    header("Location: index.php");
    exit();
}

include 'connection.php';

if (isset($_GET['id'])) {
    $doctor_id = $_GET['id'];
    $sql = "SELECT * FROM doctors WHERE doctor_id='$doctor_id'";
    $result = mysqli_query($conn, $sql);
    $doctor = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $speciality = $_POST['speciality'];
    $phone = $_POST['phone'];
    $experience = $_POST['experience'];
    $max_patients = $_POST['max_patients'];

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE doctors SET name='$name', email='$email', password='$hashed_password', speciality='$speciality', phone='$phone', experience='$experience', max_patients='$max_patients' WHERE doctor_id='$doctor_id'";

    } else {
        $sql = "UPDATE doctors SET name='$name', email='$email', speciality='$speciality', phone='$phone', experience='$experience', max_patients='$max_patients' WHERE doctor_id='$doctor_id'";
    }
    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Doctor updated successfully!');
                window.location.href = 'all_doc.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . mysqli_error($conn) . "');
                window.history.back();
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
    <link rel="stylesheet" href="styles.css"> <!-- Keep the existing CSS file -->
</head>
<body>
    <div class="container">
        <h1>Edit Doctor</h1>
        <form method="POST" action="">
            <input type="hidden" name="doctor_id" value="<?php echo $doctor['doctor_id']; ?>">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $doctor['name']; ?>" required>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $doctor['email']; ?>" required>
            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Speciality:</label>
            <input type="text" name="speciality" value="<?php echo $doctor['speciality']; ?>" required>
            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo $doctor['phone']; ?>" required>
            <label>Experience:</label>
            <input type="text" name="experience" value="<?php echo $doctor['experience']; ?>" required>
            <label>Max Patients:</label>
            <input type="number" name="max_patients" value="<?php echo $doctor['max_patients']; ?>" required>
            <button type="submit" name="update">Update Doctor</button>
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
                <label>Maximum Patients</label>
                <input type="number" name="max_patients" class="form-control" value="<?php echo htmlspecialchars($doctor['max_patients']); ?>" required>
            </div>
            <div class="form-group">
                <label>Current Scheduled Appointments</label>
                <input type="number" name="appointment_count" class="form-control" value="<?php echo htmlspecialchars($doctor['appointment_count']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Doctor</button>
        </form>
    </div>
</body>
</html>
