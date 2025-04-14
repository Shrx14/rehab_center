<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Rehab Center</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
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
        .header h1 {
            font-size: 4.5rem;
            margin: 0;
            animation: slideInDown 0.8s ease-out;
        }
        .header p {
            font-size: 1.8rem;
            margin: 10px 0 0;
            animation: slideInDown 0.8s ease-out 0.2s;
            animation-fill-mode: both;
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
    <div class="header" style="height: 100vh;">
        <div class="container d-flex flex-column justify-content-center align-items-center" style="
            max-width: 500px;
            padding: 40px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(8px);
            border-radius: 10px;
            border: 3px solid cyan;
            box-shadow: 0px 0px 5px cyan, 0px 0px 5px cyan inset;
            transform: translateY(20px);
            opacity: 0;
            animation: slideInUp 0.5s ease-out forwards;
        ">
            <h2 style="text-align: center; margin-bottom: 30px; color: #0056b3; font-size: 2rem; font-weight: 600;">Login</h2>
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="email" style="color: #0056b3; font-size: 1rem;">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required style="border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label for="password" style="color: #0056b3; font-size: 1rem;">Password</label>
                    <div class="password-input" style="position: relative;">
                        <input type="password" class="form-control" id="password" name="password" required style="border-radius: 8px;">
                        <i class="fas fa-eye password-toggle" style="position: absolute; right: 15px; top: 38px; cursor: pointer; color: #0056b3;"></i>
                    </div>
                </div>
                <script>
                    document.querySelector('.password-toggle').addEventListener('click', function() {
                        this.style.transition = 'transform 0.3s ease';
                        this.style.transform = 'scale(1.1)';
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                        }, 300);
                        const passwordInput = document.getElementById('password');
                        const icon = this;
                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            icon.classList.replace('fa-eye', 'fa-eye-slash');
                        } else {
                            passwordInput.type = 'password';
                            icon.classList.replace('fa-eye-slash', 'fa-eye');
                        }
                    });
                </script>
                <button type="submit" name="login" class="btn btn-primary btn-block" style="
                    background: linear-gradient(135deg, rgb(106, 205, 169) 0%, rgb(187, 150, 199) 100%);
                    border: none;
                    border-radius: 8px;
                    padding: 12px;
                    margin-top: 20px;
                    font-size: 1.1rem;
                ">Login</button>
                <div class="text-center mt-3">
                    <p style="color: #0056b3; font-size: 0.9rem;">Don't have an account? <a href="signup.php" style="color: #0056b3; font-size: 0.9rem;">Sign Up</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
