<?php
// Start session
session_start();

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "db_mahasiswa";

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize search variable
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Query to get student data with search filter (excluding mahasiswa_prodi)
$query = "SELECT * FROM mahasiswa WHERE mahasiswa_nim LIKE ? 
          OR mahasiswa_nama LIKE ? 
          ORDER BY id DESC";

// Prepare statement
$stmt = mysqli_prepare($conn, $query);

// Bind parameters
$searchPattern = "%" . $search . "%";
mysqli_stmt_bind_param($stmt, "ss", $searchPattern, $searchPattern);

// Execute query
mysqli_stmt_execute($stmt);

// Get results
$result = mysqli_stmt_get_result($stmt);
$students = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>

    <style>
    /* CSS */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f8c9d4, #f1a7b1); /* Pastel pink gradient */
        color: #333;
        display: flex;
        justify-content: center;
        align-items: flex-start; /* Aligning card to the top */
        min-height: 100vh;
        padding-top: 30px; /* Adding space on top */
    }

    .table-container {
        max-width: 1000px;
        width: 90%;
        margin: 30px auto;
        background: #fff;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        overflow: hidden;
        text-align: center;
        transition: all 0.3s ease;
    }

    .table-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    /* Header */
    h2 {
        font-size: 32px;
        color: #4e4b5e; /* Neutral color for elegant contrast */
        margin-bottom: 20px;
        font-weight: 600;
        letter-spacing: 1px;
    }

    /* Search Bar */
    .search-bar {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .search-bar input[type="text"] {
        width: 80%;
        padding: 14px 20px;
        font-size: 16px;
        border: 1px solid #dcdbe1; /* Light gray border */
        border-radius: 8px;
        background-color: #f1f3f5; /* Input background color */
        color: #4e4b5e;
        transition: all 0.3s ease;
    }

    .search-bar input[type="text"]:focus {
        border-color: #f8c9d4; /* Highlight border with pastel pink */
        background-color: #fff;
    }

    .search-bar button {
        padding: 14px 22px;
        background-color: #f8c9d4; /* Pastel pink */
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .search-bar button:hover {
        background-color: #f1a7b1; /* Darker pink on hover */
        transform: translateY(-2px);
    }

    /* Table Styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th, table td {
        padding: 14px;
        text-align: left;
        border-bottom: 1px solid #eaeaea; /* Soft separator line */
    }

    table th {
        background-color: #f8c9d4; /* Pink pastel header */
        color: white;
        text-transform: uppercase;
        font-size: 14px;
    }

    table tr:nth-child(odd) {
        background-color: #f7f7f7; /* Odd row background */
    }

    table tr:nth-child(even) {
        background-color: #fafafa; /* Even row background */
    }

    table tr:hover {
        background-color: #f8e1e6; /* Row highlight on hover */
        transform: scale(1.02);
        transition: all 0.3s ease;
    }

    /* Empty Message */
    .empty-message {
        font-size: 18px;
        color: #888;
        font-style: italic;
        margin-top: 20px;
    }

    /* Buttons */
    button {
        padding: 12px 30px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 25px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        border: none;
    }

    .logout-button {
        background-color: #f7a6b5; /* Pastel pink logout button */
        color: white;
        margin-top: 30px;
    }

    .logout-button:hover {
        background-color: #f48291; /* Darker pink on hover */
        transform: translateY(-2px);
    }

    .logout-button:active {
        background-color: #f2576e; /* Stronger pink on click */
        transform: translateY(0);
    }

    .back-button {
        background-color: #f1a7b1; /* Pastel pink back button */
        color: white;
        margin-top: 20px;
    }

    .back-button:hover {
        background-color: #f8c9d4; /* Darker pink on hover */
        transform: translateY(-2px);
    }

    .back-button:active {
        background-color: #f1a7b1; /* Darker pink on click */
        transform: translateY(0);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .table-container {
            padding: 15px;
        }

        h2 {
            font-size: 28px;
        }

        .search-bar input[type="text"] {
            width: 70%;
            font-size: 14px;
        }

        .search-bar button {
            padding: 10px 15px;
            font-size: 14px;
        }

        table th, table td {
            padding: 10px;
        }
    }

    @media (max-width: 480px) {
        .search-bar input[type="text"] {
            width: 60%;
        }

        .search-bar button {
            padding: 8px 12px;
        }

        table th, table td {
            padding: 8px;
        }

        button {
            padding: 10px 20px;
        }
    }
    </style>
</head>
<body>

    <div class="table-container">
        <h2>Student Data</h2>

        <!-- Search form -->
        <form class="search-bar" method="GET" action="">
            <input type="text" name="search" placeholder="Search student (NIM, Name)" value="<?= htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Student data table -->
        <?php if (!empty($students)): ?>
            <table>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>GPA</th>
                </tr>
                <?php foreach ($students as $key => $row): ?>
                <tr>
                    <td><?= $key+1; ?></td>
                    <td><?= htmlspecialchars($row['mahasiswa_nim']); ?></td>
                    <td><?= htmlspecialchars($row['mahasiswa_nama']); ?></td>
                    <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                    <td><?= htmlspecialchars($row['ipk']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p class="empty-message">No student data found.</p>
        <?php endif; ?>

        <!-- Button to go back to form.php -->
        <button class="back-button" onclick="window.location.href='form.php'">Back to Form</button>

        <!-- Logout button -->
        <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
    </div>

</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>
