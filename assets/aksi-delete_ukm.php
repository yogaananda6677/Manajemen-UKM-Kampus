<?php
include("koneksi.php");



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idPost = mysqli_real_escape_string($conn, ($_POST['id_ukm']));
 

    $id_ukm = $_POST['id_ukm'];
    $delete = mysqli_query($conn, "DELETE FROM ukm WHERE ID_UKM = '$id_ukm'");

// Jika update sukses
    if ($delete) {
        header("Location: ukm.php?status=success");
        exit;

    } else {
        $error = urlencode("Gagal memperbarui data: " . mysqli_error($conn));
        header("Location: ukm.php?status=error&msg=Nama%20UKM%20sudah%20digunakan");
        exit;
    }

} else {
    header("Location: ukm.php");
    exit;
}
?>