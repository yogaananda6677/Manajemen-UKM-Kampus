<?php
include("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $idPost = mysqli_real_escape_string($conn, input($_POST['id_ukm']));
    $nama = mysqli_real_escape_string($conn, input($_POST['nama_ukm']));

    $cek = mysqli_query($conn, "SELECT * FROM ukm WHERE NAMA_UKM = '$nama' AND ID_UKM != '$idPost'");
    if (mysqli_num_rows($cek) > 0) {
        header("Location: ukm.php?status=error&msg=Nama%20UKM%20sudah%20digunakan");
        exit;
    }

    $update = mysqli_query($conn, "UPDATE ukm SET NAMA_UKM = '$nama' WHERE ID_UKM = '$idPost'");
$id_ukm = $_POST['id_ukm'];


    if ($update) {
        header("Location: ukm.php?status=success");
        exit;

    } else {
        $error = urlencode("Gagal memperbarui data: " . mysqli_error($conn));
        header("Location: ukm.php?status=error");
        exit;
    }

} else {
    header("Location: ukm.php");
    exit;
}



