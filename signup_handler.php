<?php
include 'connection.php'; // Database connection file

if (isset($_POST['signup'])) {
    $role = $_POST['role'];
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

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
        $role_id = 2;
        $query = "INSERT INTO doctors (name, speciality, email, password, phone, role_id, max_patients) 
                  VALUES ('$name', '$speciality', '$email', '$password', '$phone', $role_id, '$max_patients')";
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
        // Get the last inserted doctor_id if the role is Doctor
        if ($role === "Doctor") {
            $doctor_id = mysqli_insert_id($conn);
            session_start();
            $_SESSION['doctor_id'] = $doctor_id; // Set doctor_id in session
        }
        
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
