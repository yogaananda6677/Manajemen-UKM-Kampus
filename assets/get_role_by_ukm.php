<?php
include("koneksi.php");

if (isset($_GET['id_ukm'])) {
    $id_ukm = $_GET['id_ukm'];

    $query = mysqli_query($conn, "SELECT ID_ROLE, NAMA_ROLE FROM role_ukm WHERE ID_UKM = '$id_ukm'");
    $roles = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $roles[] = [
            "id" => $row['ID_ROLE'],
            "nama" => $row['NAMA_ROLE']
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($roles);
} else {
    echo json_encode(["error" => "ID UKM tidak ditemukan"]);
}
