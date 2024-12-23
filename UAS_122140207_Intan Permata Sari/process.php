<?php
// Konfigurasi koneksi database
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

// Cek jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nim = $_POST['mahasiswa_nim'];
    $nama = $_POST['mahasiswa_nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $prodi = $_POST['mahasiswa_prodi'];
    
    // Handle checkbox minat (jika ada)
    $minat = isset($_POST['minat']) ? implode(", ", $_POST['minat']) : "";

    // Query untuk insert data
    $sql = "INSERT INTO mahasiswa (mahasiswa_nim, mahasiswa_nama, jenis_kelamin, mahasiswa_prodi, minat) 
            VALUES ('$nim', '$nama', '$jenis_kelamin', '$prodi', '$minat')";

    // Eksekusi query
    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Data berhasil disimpan!');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Tutup koneksi
    mysqli_close($conn);
}
?>