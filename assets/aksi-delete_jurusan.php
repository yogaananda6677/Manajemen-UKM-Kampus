<?php
include("koneksi.php");



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idPost = mysqli_real_escape_string($conn, ($_POST['id_jurusan']));
 

    $id_jurusan = $_POST['id_jurusan'];
    $delete = mysqli_query($conn, "DELETE FROM jurusan WHERE ID_JURUSAN = '$id_jurusan'");


    if ($delete) {
        header("Location: jurusan.php?status=success");
        exit;

    } else {
        $error = urlencode("Gagal memperbarui data: " . mysqli_error($conn));
        header("Location: jurusan.php?status=error&msg=Nama%20UKM%20sudah%20digunakan");
        exit;
    }

} else {
    header("Location: jurusan.php");
    exit;
}
?>