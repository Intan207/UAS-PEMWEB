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

// Proses Login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $remember = isset($_POST['remember']) ? $_POST['remember'] : '';

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Jika "Remember Me" dicentang
            if ($remember) {
                // Set cookie untuk username
                setcookie("username", $username, time() + (86400 * 30), "/"); // Cookie valid selama 30 hari
            }

            // Cek role user, jika admin, arahkan ke crud.php, jika bukan admin, arahkan ke form.php
            if ($user['role'] == 'admin') {
                // Login berhasil untuk admin, arahkan ke crud.php
                header("Location: crud.php");
            } else {
                // Login berhasil untuk user biasa, arahkan ke form.php
                header("Location: form.php");
            }
            exit(); // Pastikan script berhenti setelah redirect
        } else {
            // Password salah
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        // Username tidak ditemukan
        echo "<script>alert('Username tidak ditemukan!');</script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Background dan font body */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #fbc2eb, #a6c1ee);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Styling untuk card */
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

        /* Styling untuk judul */
        .card h2 {
            color: #555;
            margin-bottom: 25px;
            font-size: 28px;
            font-weight: bold;
            color: #4e4a89;
        }

        /* Styling form-group */
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        /* Styling label */
        label {
            font-size: 14px;
            color: #6c5b7b;
            display: block;
            margin-bottom: 8px;
        }

        /* Styling input fields */
        input[type="text"],
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
        input[type="password"]:focus {
            border-color: #6c5b7b;
            box-shadow: 0 0 5px rgba(108, 91, 123, 0.3);
        }

        /* Styling tombol submit */
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

        /* Styling untuk link pendaftaran */
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

        /* Responsif untuk layar kecil */
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
        <h2>Login</h2>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember" value="1"> Remember Me
                </label>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</body>
</html>
