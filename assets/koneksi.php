<?php


$server = 'localhost';
$user = 'root';
$pass = '';
$database = 'project_akhir_dpw';

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Aktifkan exception
    $conn = mysqli_connect($server, $user, $pass, $database);
} catch (mysqli_sql_exception $e) {
    $_SESSION['error'] = "Koneksi Gagal: " . $e->getMessage();
    header("Location: error.php");
    exit;
}
?>