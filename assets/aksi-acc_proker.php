<?php
include("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idPost = mysqli_real_escape_string($conn, ($_POST['id_proker']));
    

    $id = $_POST['id'];
    $delete = mysqli_query($conn, "UPDATE proker SET STATUS_PROKER = 'sukses' WHERE ID_PROKER = '$idPost'");


    if ($delete) {
        header("Location: proker.php?status=success");
        exit;

    } else {
        $error = urlencode("Gagal memperbarui data: " . mysqli_error($conn));
        header("Location: proker.php?status=error&msg=NIM%20sudah%20digunakan");
        exit;
    }

} else {
    header("Location: proker.php");
    exit;
}
?>