<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Rehab Center</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            scroll-behavior: smooth;
        }
        .header {
            position: relative;
            text-align: center;
            color: white;
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('H1.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 120vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: fadeIn 1.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .header-content {
            text-align: center;
            width: 100%;
            color: white;
            padding: 0 20px;
        }
        .header-content h1 {
            font-size: clamp(2.5rem, 5vw, 4.5rem);
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            animation: slideInDown 1s ease-out;
        }
        .header-content p {
            font-size: clamp(1rem, 2vw, 1.5rem);
            margin-bottom: 30px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            animation: slideInUp 1s ease-out;
        }
        @keyframes slideInDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        @keyframes slideInUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .btn-custom {
            margin: 15px;
            padding: 15px 35px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 30px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
            z-index: 1;
            transform: scale(1);
        }
        .btn-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
            z-index: -1;
        }
        .btn-custom:hover::before {
            transform: translateX(100%);
        }
        .btn-primary {
            background-color: #007bff;
            border: 2px solid #007bff;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: transparent;
            color: #007bff;
            transform: translateY(-3px) scale(1.05);
        }
        .btn-success {
            background-color: #28a745;
            border: 2px solid #28a745;
            color: #fff;
        }
        .btn-success:hover {
            background-color: transparent;
            color: #28a745;
            transform: translateY(-3px) scale(1.05);
        }
        .why-choose-us {
            text-align: center;
            color: white;
            width: 90%;
            max-width: 1200px;
            margin: 80px auto;
            padding: 20px;
        }
        .why-choose-us h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            margin-bottom: 50px;
            position: relative;
            display: inline-block;
        }
        .why-choose-us h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: #007bff;
        }
        .why-choose-us .points {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            justify-content: center;
        }
        .why-choose-us .point {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            color: #333;
        }
        .why-choose-us .point:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        .why-choose-us .point h3 {
            font-size: 1.5rem;
            color: #007bff;
            margin-bottom: 15px;
        }
        .why-choose-us .point p {
            font-size: 1rem;
            color: #555;
            line-height: 1.6;
        }
        .extra-section {
            text-align: center;
            color: white;
            background: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 15px;
            max-width: 800px;
            margin: 50px auto;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.1);
        }
        .extra-section h3 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: #007bff;
        }
        .extra-section p {
            font-size: 1.2rem;
            line-height: 1.6;
        }
        footer {
            text-align: center;
            padding: 25px;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            font-size: 1rem;
        }
        @media (max-width: 768px) {
            .header-content h1 {
                font-size: 2.5rem;
            }
            .why-choose-us .points {
                grid-template-columns: 1fr;
            }
            .btn-custom {
                padding: 12px 25px;
                font-size: 1rem;
            }
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
