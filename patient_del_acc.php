<?php
session_start();
include 'connection.php';

// Check if the user is a 'Patient'
if ($_SESSION['role'] != 'Patient') {
    header("Location: index.php");  // Redirect to index if not a patient
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'];  // Get the patient's email from the session
    
    // Ensure the email is valid before attempting to delete
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } else {
        // Start transaction
        mysqli_begin_transaction($conn);
        
        try {
            // First get patient_id for the email
            $stmt = $conn->prepare("SELECT patient_id FROM patients WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $patient = $result->fetch_assoc();
            $patient_id = $patient['patient_id'];
            $stmt->close();
            
            if (!$patient_id) {
                throw new Exception("Patient not found");
            }
            
            // Delete all appointments for this patient
            $stmt = $conn->prepare("DELETE FROM appointments WHERE patient_id = ?");
            $stmt->bind_param("i", $patient_id);
            $stmt->execute();
            $stmt->close();
            
            // Now delete the patient record
            $stmt = $conn->prepare("DELETE FROM patients WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                // Commit transaction if all operations succeeded
                mysqli_commit($conn);
                
                // Successfully deleted the account
                echo "<div class='container' style='text-align: center;'>";
                echo "<h2 style='color: #28a745; margin-bottom: 20px;'>Your account has been deleted successfully</h2>";
                echo "<a href='welcome.php' class='btn btn-success' style='padding: 10px 20px;'>Go to Welcome Page</a>";
                echo "</div>";
                exit();
            } else {
                throw new Exception("Failed to delete patient record");
            }
        } catch (Exception $e) {
            // Rollback transaction on error
            mysqli_rollback($conn);
            $error = "Failed to delete account: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
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
            color: #dc3545;
            padding-bottom: 15px;
            border-bottom: 2px solid #f8d7da;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.2s forwards;
        }
        .alert {
            margin-top: 20px;
            border-radius: 8px;
        }
        .btn-danger {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.3s forwards;
        }
        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }
        .warning-message {
            color: #dc3545;
            margin-bottom: 20px;
            font-weight: bold;
            animation: fadeIn 0.8s ease-out 0.3s forwards;
            opacity: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delete Account</h2>
        <!-- Display any error message -->
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <p class="warning-message">⚠️ Are you sure you want to delete your account? This action cannot be undone and all your data will be permanently lost.</p>
            <button type="submit" class="btn btn-danger">Delete Account</button>
        </form>
    </div>
</body>
</html>
