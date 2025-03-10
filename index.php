<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Rehab Center</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url('Home.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            font-family: 'Arial', sans-serif;
            margin: 0;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.85);
            z-index: -1;
        }
        .header {
            background: rgba(30, 136, 229, 0.9);
            color: #fff;
            padding: 50px 20px;
            text-align: center;
            border-bottom: 4px solid #1565c0;
        }
        .header h1 {
            font-size: 4.5rem;
            margin: 0;
        }
        .header p {
            font-size: 1.8rem;
            margin: 10px 0 0;
        }
        .btn-container {
            margin-top: 20px;
            text-align: center;
        }
        .btn-custom {
            padding: 12px 25px;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 25px;
            transition: all 0.3s ease-in-out;
        }
        .btn-custom-primary {
            background-color: #1976d2;
            border: none;
            color: #fff;
        }
        .btn-custom-primary:hover {
            background-color: #0d47a1;
        }
        footer {
            margin-top: 30px;
            text-align: center;
            padding: 15px;
            background: rgba(30, 136, 229, 0.9);
            color: #fff;
            border-top: 4px solid #1565c0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to Rehab Center</h1>
        <p>Your Path to Recovery and Wellness</p>
    </div>
    <div class="btn-container">
        <button class="btn btn-custom btn-custom-primary" data-toggle="modal" data-target="#loginModal">Login</button>
    </div>
    <footer>
        <p>&copy; 2024 Rehab Center. All Rights Reserved.</p>
    </footer>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="login.php">
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                        <div class="text-center mt-3">
                            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
