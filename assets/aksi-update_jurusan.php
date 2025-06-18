<?php
include("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $idPost = mysqli_real_escape_string($conn, input($_POST['id_jurusan']));
    $nama = mysqli_real_escape_string($conn, input($_POST['nama_jurusan']));

    $cek = mysqli_query($conn, "SELECT * FROM jurusan WHERE NAMA_JURUSAN = '$nama' AND ID_JURUSAN != '$idPost'");
    if (mysqli_num_rows($cek) > 0) {
        header("Location: jurusan.php?status=error&msg=Nama%20UKM%20sudah%20digunakan");
        exit;
    }

    $update = mysqli_query($conn, "UPDATE jurusan SET NAMA_JURUSAN = '$nama' WHERE ID_JURUSAN = '$idPost'");
$id_ukm = $_POST['id_jurusan'];

// Jika update sukses
    if ($update) {
        header("Location: jurusan.php?status=success");
        exit;

    } else {
        $error = urlencode("Gagal memperbarui data: " . mysqli_error($conn));
        header("Location: jurusan.php?status=error");
        exit;
    }

} else {
    header("Location: jurusan.php");
    exit;
}



