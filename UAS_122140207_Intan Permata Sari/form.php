<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "db_mahasiswa";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['mahasiswa_nim'];
    $nama = $_POST['mahasiswa_nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $semester = $_POST['mahasiswa_semester'];
    $ipk = $_POST['mahasiswa_ipk'];

    $query = "INSERT INTO mahasiswa (mahasiswa_nim, mahasiswa_nama, jenis_kelamin, mahasiswa_semester, ipk) 
              VALUES ('$nim', '$nama', '$jenis_kelamin', '$semester', '$ipk')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil disimpan!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Information System</title>
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

        .container {
            max-width: 800px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #2d3436;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #2d3436;
            font-weight: 500;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #dfe6e9;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s ease;
            background: white;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #6c5ce7;
            box-shadow: 0 0 10px rgba(108, 92, 231, 0.1);
            outline: none;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }

        .submit-btn {
            background: linear-gradient(45deg, #6c5ce7, #a55eea);
            color: white;
        }

        .view-btn {
            background: linear-gradient(45deg, #00b894, #00cec9);
            color: white;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Information System</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="nim">Student ID:</label>
                <input type="text" id="nim" name="mahasiswa_nim" placeholder="Enter your student ID" required>
            </div>

            <div class="form-group">
                <label for="nama">Full Name:</label>
                <input type="text" id="nama" name="mahasiswa_nama" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="jenis_kelamin" value="Pria" required>
                        Male
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="jenis_kelamin" value="Wanita" required>
                        Female
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="semester">Semester:</label>
                <select id="semester" name="mahasiswa_semester" required>
                    <option value="">Select Semester</option>
                    <?php for($i=1; $i<=8; $i++): ?>
                        <option value="<?php echo $i; ?>">Semester <?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ipk">GPA:</label>
                <input type="number" id="ipk" name="mahasiswa_ipk" min="0" max="4" step="0.01" placeholder="Enter your GPA" required>
            </div>

            <button type="submit" class="submit-btn">Submit Data</button>
        </form>
        <a href="table.php"><button type="button" class="view-btn">View Data</button></a>
    </div>

    <script>
        function validateForm() {
            let nim = document.getElementById("nim").value;
            let nama = document.getElementById("nama").value;
            let ipk = document.getElementById("ipk").value;

            if (isNaN(nim) || nim.trim() === "") {
                alert("Student ID must be numeric and not empty");
                return false;
            }

            if (nama.trim() === "") {
                alert("Name cannot be empty");
                return false;
            }

            if (ipk < 0 || ipk > 4) {
                alert("GPA must be between 0 and 4");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>