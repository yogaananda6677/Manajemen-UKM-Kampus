<?php
include("koneksi.php");

header('Content-Type: application/json');

if (isset($_GET['id_ukm'])) {
    $id_ukm = $_GET['id_ukm'];
    $query = "SELECT ID_ANGGOTA AS id, NAMA AS nama FROM anggota WHERE ID_UKM = '$id_ukm'";
    $result = mysqli_query($conn, $query);

    $roles = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $roles[] = $row;
    }

    echo json_encode($roles);
} else {
    echo json_encode([]);
}
?>
