<?php
include("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $idPost = mysqli_real_escape_string($conn, input($_POST['id_proker']));
    $nama = mysqli_real_escape_string($conn, input($_POST['nama']));
    $ukm = mysqli_real_escape_string($conn, input($_POST['id_ukm']));
    $status = mysqli_real_escape_string($conn, input($_POST['status']));
    $pj = mysqli_real_escape_string($conn, input($_POST['id_anggota']));
    $tanggal = mysqli_real_escape_string($conn, input($_POST['tanggal_proker']));


    $update = mysqli_query($conn, "UPDATE proker
                                                    SET
                                                        STATUS_PROKER = '$status',
                                                        ID_UKM = '$ukm',
                                                        ID_ANGGOTA = '$pj',
                                                        NAMA_PROKER = '$nama',
                                                        TAHUN_PROKER = '$tanggal'
                                                    WHERE
                                                        ID_PROKER = '$idPost';");
$id_proker = $_POST['id_proker'];

    if ($update) {
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



