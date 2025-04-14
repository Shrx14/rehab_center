<button?php
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
    $max_patients = mysqli_real_escape_string($conn, $_POST['max_patients']);
    $appointment_count = 0; // Initialize appointment_count to 0

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = 2;

    $query = "INSERT INTO doctors (name, email, speciality, phone, experience, visit_days, max_patients, appointment_count, password, role_id) 
              VALUES ('$name', '$email', '$specialty', '$phone', '$experience', '$visit_days', '$max_patients', '$appointment_count', '$password', '$role_id')";

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
    </style>
</head>
<body style="position: relative; background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg'); background-size: cover; background-position: center; background-attachment: local; height: 100vh; display: flex; flex-direction: column; animation: fadeIn 1.5s ease-in-out;">

    <div class="container mt-5">
        <h3>Add New Doctor</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name" class="form-label">Doctor Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
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
                <label for="experience" class="form-label">Experience</label>
                <input type="number" id="experience" name="experience" class="form-control" placeholder="In Years" required>
            </div>

            <div class="form-group">
                <label for="max_patients" class="form-label">Max Patients</label>
                <input type="number" id="max_patients" name="max_patients" class="form-control" placeholder="(Patient Intake)" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Add Doctor</button>
                <button type="button" onclick="window.location.href='all_doc.php'" class="btn btn-secondary">Cancel</button>
            </div>
            <style>
                .button-group {
                    display: flex;
                    flex-direction: column;
                    gap: 12px;
                }
                .button-group .btn {
                    width: 100%;
                }
            </style>
        </form>
    </div>
</body>
</html>
