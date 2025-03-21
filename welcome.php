<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Rehab Center</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .header {
            position: relative;
            text-align: center;
            color: white;
            background-image: url('Home.jpg');
            background-size: cover; /* Ensures the image covers the header */
            background-position: center; /* Centers the image */
            height: 100vh; /* Sets the height of the header */
        }
        .header-content {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            width: 100%;
            color: black; /* Changed to black for better visibility */
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.7); /* Added text shadow */
        }
        .header-content h1 {
            font-size: 4.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .header-content p {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .btn-custom {
            margin: 10px;
            padding: 14px 30px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 25px;
            transition: all 0.3s ease-in-out;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .btn-success {
            background-color: #28a745;
            border: none;
            color: #fff;
        }
        .btn-success:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        .why-choose-us {
            position: absolute;
            bottom: 20%;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            color: white;
            width: 90%;
        }
        .why-choose-us h2 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .why-choose-us .points {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        .why-choose-us .point {
            background: rgba(255, 255, 255, 0.2);
            padding: 40px;
            border-radius: 50%;
            text-align: center;
            width: 220px;
            height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            margin: 20px;
            color: black; /* Changed to black for better visibility */
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.7); /* Added text shadow */
        }
        .why-choose-us .point h3 {
            font-size: 1.5rem;
            color:rgb(0, 0, 0);
            margin-bottom: 10px;
        }
        .why-choose-us .point p {
            font-size: 1rem;
            color: rgb(0, 0, 0);
            text-align: center;
        }
        .extra-section {
            position: absolute;
            bottom: 5%;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            color: white;
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }
        .extra-section h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        .extra-section p {
            font-size: 1.2rem;
        }
        footer {
            margin-top: 30px;
            text-align: center;
            padding: 15px;
            background: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Welcome to Rehab Center</h1>
            <p>Your journey to recovery starts here</p>
            <a href="index.php" class="btn btn-custom btn-primary">Login</a>
            <a href="signup.php" class="btn btn-custom btn-success">Sign Up</a>
        </div>
        <div class="why-choose-us">
            <h2>Why Choose Us</h2>
            <div class="points">
                <div class="point">
                    <h3>Expert Team</h3>
                    <p>Highly trained specialists for personalized care.</p>
                </div>
                <div class="point">
                    <h3>Modern Facilities</h3>
                    <p>State-of-the-art equipment for recovery.</p>
                </div>
                <div class="point">
                    <h3>Holistic Approach</h3>
                    <p>Comprehensive plans tailored to your needs.</p>
                </div>
            </div>
        </div>
        <div class="extra-section">
            <h3>Our Mission</h3>
            <p>Empowering individuals with the care and support they need to lead a healthier life.</p>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Rehab Center. All Rights Reserved.</p>
    </footer>
</body>
</html>
