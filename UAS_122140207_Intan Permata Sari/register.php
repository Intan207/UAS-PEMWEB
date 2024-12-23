<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "db_mahasiswa";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Proses Registrasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $accept_terms = isset($_POST['accept_terms']); // Menangkap status checkbox

    // Cek apakah password dan konfirmasi password sama
    if ($password !== $confirm_password) {
        echo "<script>alert('Password dan konfirmasi password tidak cocok!');</script>";
    } elseif (!$accept_terms) {
        echo "<script>alert('Anda harus menyetujui syarat dan ketentuan!');</script>";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk menyimpan data
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registrasi berhasil!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #fbc2eb, #a6c1ee);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: #fefefe;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .card h2 {
            color: #4e4a89;
            margin-bottom: 25px;
            font-size: 28px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            font-size: 14px;
            color: #6c5b7b;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px;
            border: 1px solid #d1c7e0;
            border-radius: 10px;
            font-size: 14px;
            color: #555;
            background-color: #f1f0f7;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #6c5b7b;
            box-shadow: 0 0 5px rgba(108, 91, 123, 0.3);
        }

        button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(45deg, #00b894, #00cec9); /* Updated gradient background */
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
             background: linear-gradient(45deg, #00cec9, #00b894); /* Reverse gradient for hover effect */
            transform: translateY(-2px);
        }

        button:active {
             transform: translateY(0);
        }


        p {
            font-size: 14px;
            color: #6c5b7b;
        }

        p a {
            color: #6c5b7b;
            text-decoration: none;
            font-weight: 600;
        }

        p a:hover {
            text-decoration: underline;
        }

        .terms {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            font-size: 14px;
            margin-bottom: 20px;
            margin-top: 10px; /* Menambahkan jarak antara konfirmasi password dan checkbox */
        }

        .terms input {
            margin-right: 10px;
        }

        @media (max-width: 480px) {
            .card {
                padding: 25px;
                width: 90%;
            }

            .card h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Register</h2>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <!-- Checkbox for terms -->
            <div class="terms">
                <input type="checkbox" id="accept_terms" name="accept_terms">
                <label for="accept_terms">I accept the <a href="#">Terms and Conditions</a></label>
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
