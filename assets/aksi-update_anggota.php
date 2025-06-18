<?php
include("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $idPost = mysqli_real_escape_string($conn, input($_POST['id_anggota']));
    $nama = mysqli_real_escape_string($conn, input($_POST['nama']));
    $nim = mysqli_real_escape_string($conn, input($_POST['nim']));
    $jurusan_input = mysqli_real_escape_string($conn, input($_POST['id_jurusan']));
    $ukm = mysqli_real_escape_string($conn, input($_POST['id_ukm']));
    $role = mysqli_real_escape_string($conn, input($_POST['id_role']));
    $tanggal = mysqli_real_escape_string($conn, input($_POST['tanggal_daftar']));

    $cek = mysqli_query($conn, "SELECT * FROM anggota WHERE NIM = '$nim' AND ID_ANGGOTA != '$idPost'");
    if (mysqli_num_rows($cek) > 0) {
        header("Location: anggota.php?status=error&msg=NIM%20sudah%20digunakan");
        exit;
    }

    $qRole = mysqli_query($conn, "SELECT nama_role, id_ukm FROM role_ukm WHERE id_role = '$role'");
    if ($qRole && mysqli_num_rows($qRole) > 0) {
        $dRole = mysqli_fetch_assoc($qRole);
        $nama_role = strtolower($dRole['nama_role']);
        $id_ukm = $dRole['id_ukm'];

        if ($nama_role === 'ketua') {
            $cek_ketua = mysqli_query($conn, "SELECT * FROM anggota a
                                              JOIN role_ukm r ON a.id_role = r.id_role
                                              WHERE r.id_ukm = '$id_ukm' 
                                                AND r.nama_role = 'ketua' 
                                                AND a.id_anggota != '$idPost'");
            if (mysqli_num_rows($cek_ketua) >= 1) {
                header("Location: anggota.php?status=error&msg=Jumlah%20Ketua%20untuk%20UKM%20ini%20sudah%20maksimal");
                exit;
            }
        }
    } else {
        header("Location: anggota.php?status=error&msg=Role%20tidak%20valid");
        exit;
    }

    $update = mysqli_query($conn, "UPDATE anggota SET
                                        ID_ROLE = '$role',
                                        ID_JURUSAN = '$jurusan_input',
                                        ID_UKM = '$ukm',
                                        NIM = '$nim',
                                        NAMA = '$nama',
                                        TANGGAL_DAFTAR = '$tanggal'
                                    WHERE ID_ANGGOTA = '$idPost'");

    if ($update) {
        header("Location: anggota.php?status=success");
        exit;
    } else {
        $error = urlencode("Gagal memperbarui data: " . mysqli_error($conn));
        header("Location: anggota.php?status=error&msg=$error");
        exit;
    }

} else {
    header("Location: anggota.php");
    exit;
}
