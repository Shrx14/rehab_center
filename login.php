<?php
session_start();
include 'connection.php'; // Database connection file

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user is in the admin table
    $query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['role'] = 'Admin';
        $_SESSION['email'] = $email;
        header("Location: admin_dashboard.php");
        exit();
    }

    // Check if the user is in the doctors table
    $query = "SELECT * FROM doctors WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $doctor = mysqli_fetch_assoc($result);
        $_SESSION['doctor_id'] = $doctor['doctor_id']; // Set doctor_id in session
        $_SESSION['role'] = 'Doctor';
        $_SESSION['email'] = $email;
        header("Location: doctor_dashboard.php");
        exit();
    }

    // Check if the user is in the patients table
    $query = "SELECT * FROM patients WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['role'] = 'Patient';
        $_SESSION['email'] = $email;
        header("Location: patient_dashboard.php");
        exit();
    }

    // If no match is found
    echo "<script>alert('Invalid email or password'); window.location.href = 'index.php';</script>";
}
?>
