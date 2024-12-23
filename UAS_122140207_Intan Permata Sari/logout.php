<?php
// Mulai sesi
session_start();

// Hancurkan sesi dan hapus data pengguna yang tersimpan di sesi
session_destroy();

// Arahkan pengguna kembali ke halaman login
header("Location: index.php");
exit();
?>
