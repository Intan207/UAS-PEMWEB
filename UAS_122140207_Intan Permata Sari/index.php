<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #fbc2eb, #a6c1ee);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .welcome-container {
            max-width: 500px;
            width: 100%;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            text-align: center;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .welcome-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        h1 {
            color: #2d3436;
            font-size: 2.5em;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .welcome-text {
            color: #636e72;
            font-size: 1.1em;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .buttons-container {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .button {
            padding: 15px 40px;
            border: none;
            border-radius: 30px;
            font-size: 1em;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
        }

        .login-btn {
            background: linear-gradient(45deg, #6c5ce7, #a55eea);
        }

        .register-btn {
            background: linear-gradient(45deg, #00b894, #00cec9);
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 480px) {
            .buttons-container {
                flex-direction: column;
            }
            
            .welcome-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Student Portal</h1>
        <p class="welcome-text">Welcome Informatics Engineering Students of Sumatra Institute of Technology</p>
        <div class="buttons-container">
            <a href="login.php" class="button login-btn">Login</a>
            <a href="register.php" class="button register-btn">Register</a>
        </div>
    </div>
</body>
</html>