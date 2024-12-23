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

// Mulai sesi untuk menyimpan notifikasi
session_start();

// Cek jika ada aksi logout
if (isset($_GET['logout'])) {
    session_destroy();  // Menghancurkan sesi
    header("Location: login.php"); // Redirect ke halaman login setelah logout
    exit();
}

// Definisi kelas MahasiswaManager
class MahasiswaManager
{
    private $conn;

    // Constructor untuk inisialisasi koneksi
    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    // Metode untuk mengambil data mahasiswa
    public function getMahasiswa($search = '')
    {
        $query = "SELECT * FROM mahasiswa WHERE mahasiswa_nim LIKE '%$search%' 
                  OR mahasiswa_nama LIKE '%$search%' 
                  ORDER BY id DESC";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // Metode untuk menghapus data mahasiswa
    public function deleteMahasiswa($id)
    {
        $query = "DELETE FROM mahasiswa WHERE id = $id";
        return mysqli_query($this->conn, $query);
    }
}

// Membuat instance dari MahasiswaManager
$mahasiswaManager = new MahasiswaManager($conn);

// Inisialisasi variabel pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Mengambil data mahasiswa
$mahasiswa = $mahasiswaManager->getMahasiswa($search);

// Fungsi untuk menghapus data mahasiswa
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($mahasiswaManager->deleteMahasiswa($id)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Gagal menghapus data mahasiswa.";
    }
}

// Menutup koneksi
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>
    <style>
        /* CSS tetap sama seperti yang Anda berikan */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f9d5e5, #fcd4e8); /* Pastel pink gradient */
            color: #333; /* Dark gray for general text */
        }

        .table-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #3e3e3e; /* Darker text color for the heading */
        }

        .notification {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
        }

        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .search-bar input[type="text"] {
            width: 80%;
            padding: 10px;
            border: 1px solid #e8a1b2;
            border-radius: 5px;
            font-size: 16px;
            background-color: #fbe1e6; /* Pastel pink */
            color: #333; /* Dark gray text for better contrast */
        }

        .search-bar button {
            padding: 10px 20px;
            background-color: #f46a9b; /* Pastel pink button */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .search-bar button:hover {
            background-color: #f16d87; /* Darker pink for hover */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border-radius: 8px;
            background: white;
        }

        table th, table td {
            text-align: left;
            padding: 16px;
            border-bottom: 1px solid #f3c1d3;
            font-size: 16px;
            color: #3e3e3e; /* Dark gray for table content */
        }

        table th {
            background: #f9c9d2; /* Light pink */
            color: #3e3e3e; /* Dark gray for better readability */
            text-transform: uppercase;
        }

        table tr:nth-child(odd) {
            background: #fce7f0;
        }

        table tr:nth-child(even) {
            background: #f9e1ec;
        }

        table tr:hover {
            background: #f7d0e2;
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        .empty-message {
            text-align: center;
            color: #6c757d; /* Subtle gray for empty state message */
            font-size: 18px;
            margin-top: 20px;
            font-style: italic;
        }

        button {
            display: inline-block;
            padding: 8px 15px; /* Make buttons smaller */
            background: #f46a9b; /* Pastel pink */
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 14px; /* Smaller font size */
            cursor: pointer;
            margin-top: 10px;
            text-transform: uppercase;
            text-align: center;
        }

        button:hover {
            background: #f16d87; /* Darker pink for hover */
        }
    </style>
</head>
<body>

<div class="table-container">
    <h2>Student Data</h2>

    <!-- Notifikasi sukses edit -->
    <?php if (isset($_SESSION['success_edit'])): ?>
        <div class="notification">
            <?= $_SESSION['success_edit']; ?>
        </div>
        <?php unset($_SESSION['success_edit']); ?>
    <?php endif; ?>

    <!-- Form pencarian -->
    <form class="search-bar" method="GET" action="">
        <input type="text" name="search" placeholder="Cari mahasiswa (NIM, Nama, Semester)" value="<?= htmlspecialchars($search); ?>">
        <button type="submit">Cari</button>
    </form>

    <!-- Tabel untuk menampilkan data mahasiswa -->
    <?php if (!empty($mahasiswa)): ?>
        <table>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Semester</th>
                <th>IPK</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($mahasiswa as $key => $row): ?>
            <tr>
                <td><?= $key+1; ?></td>
                <td><?= htmlspecialchars($row['mahasiswa_nim']); ?></td>
                <td><?= htmlspecialchars($row['mahasiswa_nama']); ?></td>
                <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                <td><?= htmlspecialchars($row['mahasiswa_semester']); ?></td>
                <td><?= htmlspecialchars($row['ipk']); ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>"><button>Edit</button></a>
                    <a href="?delete=<?= $row['id']; ?>"><button>Delete</button></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p class="empty-message">Tidak ada data mahasiswa yang ditemukan.</p>
    <?php endif; ?>

    <!-- Tombol Logout -->
    <div style="text-align: center; margin-top: 20px;">
        <a href="?logout=true"><button>Logout</button></a>
    </div>
</div>

</body>
</html>
