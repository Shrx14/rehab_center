<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
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
        @keyframes slideInLeft {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .header {
            position: relative;
            text-align: center;
            color: white;
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: local;
            height: 150vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: fadeIn 1.5s ease-in-out;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(199, 223, 221, 0.7);
            backdrop-filter: blur(8px);
            border-radius: 10px;
            border: 3px solid cyan;
            box-shadow: 0px 0px 5px cyan,
                0px 0px 5px cyan inset;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out forwards;
            transition: all 0.3s ease;
        }

        .container:hover {
            transform: translateY(20px) scale(1.02);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        .container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #0056b3;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.2s forwards;
        }
        .form-group {
            color: #0056b3;
            font-size: 1rem;
            margin-bottom: 20px;
        }
        .form-control {
            width: 100%;
            padding: 7px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
        .btn-success {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out 0.3s forwards;
        }
        .text-center {
            text-align: center;
        }
        .mt-3 {
            margin-top: 15px;
        }
        .error {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="header" style="height: 120vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Sign Up</h2>
                <form action="signup_handler.php" method="POST" onsubmit="return validatePhone()">
                    <div class="form-group">
                        <label for="role">Select Role</label>
                        <select name="role" class="form-control" required style="border-radius: 8px;">
                            <option value="">-- Select Role --</option>
                            <option value="Admin">Admin</option>
                            <option value="Doctor">Doctor</option>
                            <option value="Patient">Patient</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <div class="form-group" id="doctor_fields" style="display: none;">
                        <label for="speciality">Speciality</label>
                        <input type="text" name="speciality" style="margin-bottom: 20px;" class="form-control" placeholder="Enter your specialty">
                        <label for="max_patients">Patient Intake</label>
                        <input type="text" name="max_patients" class="form-control" placeholder="Enter the maximum patients intake">
                    </div>
                    <div class="form-group" id="patient_fields" style="display: none;">
                        <label for="age">Age</label>
                        <input type="number" name="age" style="margin-bottom: 20px;" class="form-control" placeholder="Enter your age">
                        <label for="address">Address</label>
                        <input type="text" name="address" style="margin-bottom: 20px;" class="form-control" placeholder="Enter your address">
                        <label for="diagnosis_type">Diagnosis</label>
                        <input type="text" name="diagnosis_type" style="margin-bottom: 20px;" class="form-control" placeholder="Enter your diagnosis result">
                        <label for="admitted_date">Date of Patient Admission</label>
                        <input type="date" name="admitted_date" style="margin-bottom: 20px;" class="form-control" placeholder="Enter your admission date">
                        <label for="surgery_status">Surgery Status</label>
                        <select name="surgery_status" class="form-control">
                        <option value="Not Required" <?php echo (empty($patient['Surgery_status']) || $patient['Surgery_status'] == 'Not Required') ? 'selected' : ''; ?>>Not Required</option>
                            <option value="Completed">Completed</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number (with country code +91)</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="+91XXXXXXXXXX" required>
                        <div id="phoneError" class="error"></div>
                    </div>
                    <button type="submit" name="signup" class="btn btn-success">Sign Up</button>
                </form>
                <p class="text-center mt-3" style="color: #0056b3; font-size: 0.9rem;">Already have an account? <a href="index.php">Login here</a></p>
            </div>
        </div>
    </div>
</div>
    <script>
        // Phone number validation
        function validatePhone() {
            const phoneInput = document.getElementById('phone');
            const phoneError = document.getElementById('phoneError');
            const phonePattern = /^\+91\d{10}$/;

            if (!phonePattern.test(phoneInput.value)) {
                phoneError.textContent = 'Please enter a valid phone number with country code +91 followed by 10 digits';
                return false;
            }
            phoneError.textContent = '';
            return true;
        }

        // Show fields based on selected role
        document.querySelector('select[name="role"]').addEventListener('change', function() {
            var role = this.value;
            if (role === "Doctor") {
                document.getElementById('doctor_fields').style.display = 'block';
                document.getElementById('patient_fields').style.display = 'none';
            } else if (role === "Patient") {
                document.getElementById('doctor_fields').style.display = 'none';
                document.getElementById('patient_fields').style.display = 'block';
            } else {
                document.getElementById('doctor_fields').style.display = 'none';
                document.getElementById('patient_fields').style.display = 'none';
            }
        });
    </script>
</body>
</html>
