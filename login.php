<?php
session_start();
include 'connection.php'; // Database connection file

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user is in the admin table
    $query = "SELECT * FROM admin WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        if (password_verify($password, $admin['password'])) {
            $_SESSION['role'] = 'Admin';
            $_SESSION['email'] = $email;
            header("Location: admin_dashboard.php"); // Redirect to admin dashboard
            exit();
        }
    }

    // Check if the user is in the doctors table
    $query = "SELECT * FROM doctors WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $doctor = mysqli_fetch_assoc($result);
        if (password_verify($password, $doctor['password'])) {
            $_SESSION['doctor_id'] = $doctor['doctor_id']; // Set doctor_id in session
            $_SESSION['role'] = 'Doctor';
            $_SESSION['email'] = $email;
            header("Location: doctor_dashboard.php"); // Redirect to doctor dashboard
            exit();
        }
    }

    // Check if the user is in the patients table
    $query = "SELECT * FROM patients WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $patient = mysqli_fetch_assoc($result);
        if (password_verify($password, $patient['password'])) {
            $_SESSION['role'] = 'Patient';
            $_SESSION['email'] = $email;
            header("Location: patient_dashboard.php"); // Redirect to patient dashboard
            exit();
        }
    }

    // If no match is found
    echo "<script>alert('Invalid email or password'); window.location.href = 'index.php';</script>";
}
?>
