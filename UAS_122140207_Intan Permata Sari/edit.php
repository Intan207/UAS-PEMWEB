<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "db_mahasiswa";

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$id = $_GET['id']; // Mendapatkan id dari URL

// Query untuk mengambil data mahasiswa berdasarkan id
$query = "SELECT * FROM mahasiswa WHERE id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['mahasiswa_nim'];
    $nama = $_POST['mahasiswa_nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $semester = $_POST['mahasiswa_semester'];
    $ipk = $_POST['mahasiswa_ipk'];

    // Query untuk update data mahasiswa
    $updateQuery = "UPDATE mahasiswa SET mahasiswa_nim = '$nim', mahasiswa_nama = '$nama', jenis_kelamin = '$jenis_kelamin', mahasiswa_semester = '$semester', ipk = '$ipk' WHERE id = $id";

    if (mysqli_query($conn, $updateQuery)) {
        header("Location: crud.php"); // Mengarahkan kembali ke halaman crud.php setelah update
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
    <style>
        /* Reset margin dan padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Latar belakang dan font body */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #fbc2eb, #a6c1ee); /* Gradasi pastel cerah */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Card dengan bayangan dan padding */
        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            transition: transform 0.3s, box-shadow 0.3s ease;
        }

        /* Efek hover pada card */
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        /* Styling untuk judul */
        h2 {
            text-align: center;
            color: #4e4a89;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
        }

        /* Form-group styling */
        .form-group {
            margin-bottom: 20px;
        }

        /* Styling untuk label */
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #6c5b7b;
        }

        /* Styling input field */
        input[type="text"],
        select,
        input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #d1c7e0;
            border-radius: 8px;
            font-size: 14px;
            background-color: #f9f9f9;
            transition: border-color 0.3s, box-shadow 0.3s ease;
        }

        /* Fokus pada input */
        input[type="text"]:focus,
        select:focus,
        input[type="number"]:focus {
            border-color: #ffafcc; /* Warna fokus yang lembut */
            outline: none;
            box-shadow: 0 0 8px rgba(255, 175, 204, 0.3);
        }

        /* Styling tombol */
        button {
            width: 100%;
            background: linear-gradient(to right, #ffafcc, #6c5b7b); /* Gradasi pastel untuk tombol */
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s, transform 0.2s;
            margin-bottom: 8px;
        }

        /* Efek hover pada tombol */
        button:hover {
            background: linear-gradient(to right, #6c5b7b, #ffafcc);
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        /* Responsif untuk layar kecil */
        @media (max-width: 768px) {
            .card {
                padding: 30px;
            }

            h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Edit Student Data</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" id="nim" name="mahasiswa_nim" value="<?= htmlspecialchars($row['mahasiswa_nim']); ?>" required>
            </div>

            <div class="form-group">
                <label for="nama">Nama Lengkap:</label>
                <input type="text" id="nama" name="mahasiswa_nama" value="<?= htmlspecialchars($row['mahasiswa_nama']); ?>" required>
            </div>

            <div class="form-group">
                <label>Jenis Kelamin:</label>
                <label for="pria">
                    <input type="radio" id="pria" name="jenis_kelamin" value="Pria" <?= ($row['jenis_kelamin'] == 'Pria') ? 'checked' : ''; ?>> Pria
                </label>
                <label for="wanita">
                    <input type="radio" id="wanita" name="jenis_kelamin" value="Wanita" <?= ($row['jenis_kelamin'] == 'Wanita') ? 'checked' : ''; ?>> Wanita
                </label>
            </div>

            <div class="form-group">
                <label for="semester">Semester:</label>
                <select id="semester" name="mahasiswa_semester" required>
                    <option value="<?= $row['mahasiswa_semester']; ?>"><?= $row['mahasiswa_semester']; ?></option>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                    <option value="4">Semester 4</option>
                    <option value="5">Semester 5</option>
                    <option value="6">Semester 6</option>
                    <option value="7">Semester 7</option>
                    <option value="8">Semester 8</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ipk">IPK:</label>
                <input type="number" id="ipk" name="mahasiswa_ipk" min="0" max="4" step="0.01" value="<?= $row['ipk']; ?>" required>
            </div>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>

<?php
// Tutup koneksi
mysqli_close($conn);
?>
