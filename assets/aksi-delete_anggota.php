<?php
include("koneksi.php");



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idPost = mysqli_real_escape_string($conn, ($_POST['id_anggota']));
 

    $id = $_POST['id'];
    $delete = mysqli_query($conn, "DELETE FROM anggota WHERE ID_ANGGOTA = '$idPost'");

    if ($delete) {
        header("Location: anggota.php?status=success");
        exit;

    } else {
        $error = urlencode("Gagal memperbarui data: " . mysqli_error($conn));
        header("Location: anggota.php?status=error&msg=NIM%20sudah%20digunakan");
        exit;
    }

} else {
    header("Location: anggota.php");
    exit;
}
?>