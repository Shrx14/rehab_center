<?php
include 'connection.php'; // Database connection file

if (isset($_POST['signup'])) {
    $role = $_POST['role'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    // Validate phone number format
    if (!preg_match('/^\+91\d{10}$/', $phone)) {
        echo "<script>
                alert('Invalid phone number. Please enter a valid Indian phone number with country code +91 followed by 10 digits.');
                window.history.back();
              </script>";
        exit();
    }

    if ($role === "Admin") {
        $query = "INSERT INTO admin (username, password, email) VALUES ('$name', '$password', '$email')";
    } elseif ($role === "Doctor") {
        $speciality = $_POST['speciality'];
        $max_patients = $_POST['max_patients'];
        $visit_days = $_POST['visit_days'];
        $role_id = 2;
        $query = "INSERT INTO doctors (name, speciality, email, password, phone, role_id, max_patients, experience, visit_days) 
                  VALUES ('$name', '$speciality', '$email', '$password', '$phone', $role_id, '$max_patients', '$experience', '$visit_days')";
    } elseif ($role === "Patient") {
        $age = $_POST['age'];
        $address = $_POST['address'];
        $diagnosis_type = $_POST['diagnosis_type'];
        $admitted_date = $_POST['admitted_date'];
        $surgery_status = $_POST['surgery_status'];
        $role_id = 3;
        $query = "INSERT INTO patients (name, email, password, phone, role_id, age, address, diagnosis_type, admitted_date, surgery_status) 
                  VALUES ('$name', '$email', '$password', '$phone', $role_id, '$age', '$address', '$diagnosis_type', '$admitted_date', '$surgery_status')";
    }

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Successfully registered! Please login.');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . mysqli_error($conn) . "');
                window.history.back();
              </script>";
    }
}
?>
