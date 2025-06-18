<?php
include("koneksi.php");



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $idPost = mysqli_real_escape_string($conn, ($_POST['id_proker']));
 

    $id = $_POST['id'];
    $delete = mysqli_query($conn, "DELETE FROM proker WHERE ID_PROKER = '$idPost'");

    if ($delete) {
        header("Location: proker.php?status=success");
        exit;

    } else {
        $error = urlencode("Gagal memperbarui data: " . mysqli_error($conn));
        header("Location: proker.php?status=error");
        exit;
    }

} else {
    header("Location: proker.php");
    exit;
}
?>