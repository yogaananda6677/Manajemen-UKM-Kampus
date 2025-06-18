<?php
include("koneksi.php");

header('Content-Type: application/json');

$search = $_POST['search'] ?? '';
$filter = $_POST['filter'] ?? '';
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;
$no = $offset + 1;

$where = "";
if ($search !== '') {
    $search = mysqli_real_escape_string($conn, $search);
    $where = "WHERE ukm.nama_ukm LIKE '%$search%' OR pj.nama LIKE '%$search%'";
}

$orderBy = "ORDER BY id_ukm DESC";
if ($filter === 'proker_terbanyak') {
    $orderBy = "ORDER BY Jumlah_Proker DESC";
} else if ($filter === 'anggota_terbanyak') {
    $orderBy = "ORDER BY Jumlah_Anggota DESC";
}

$sql = "SELECT 
        ukm.id_ukm,
        ukm.nama_ukm AS Nama_UKM,
        COUNT(DISTINCT proker.id_proker) AS Jumlah_Proker,
        COUNT(DISTINCT anggota.id_anggota) AS Jumlah_Anggota,
        pj.nama AS Penanggung_Jawab
    FROM ukm
    LEFT JOIN proker ON ukm.id_ukm = proker.id_ukm
    LEFT JOIN anggota ON ukm.id_ukm = anggota.id_ukm
    LEFT JOIN role_ukm ON ukm.id_ukm = role_ukm.id_ukm AND role_ukm.nama_role = 'Ketua'
    LEFT JOIN anggota AS pj ON pj.id_role = role_ukm.id_role
    $where
    GROUP BY ukm.id_ukm, ukm.nama_ukm, pj.nama
    $orderBy
    LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $sql);

// Hitung total data
$sql_count = "SELECT COUNT(*) as total FROM (
    SELECT ukm.id_ukm
    FROM ukm
    LEFT JOIN proker ON ukm.id_ukm = proker.id_ukm
    LEFT JOIN anggota ON ukm.id_ukm = anggota.id_ukm
    LEFT JOIN role_ukm ON ukm.id_ukm = role_ukm.id_ukm AND role_ukm.nama_role = 'Ketua'
    LEFT JOIN anggota AS pj ON pj.id_role = role_ukm.id_role
    $where
    GROUP BY ukm.id_ukm
) AS subquery";

$count_result = mysqli_query($conn, $sql_count);
$total_row = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_row / $limit);

// Buat isi tabel
$table = "";
while ($row = mysqli_fetch_assoc($result)) {
    $table .= "<tr>";
    $table .= "<td>" . $no++ . "</td>";
    $table .= "<td>" . htmlspecialchars($row['id_ukm']) . "</td>";
    $table .= "<td>" . htmlspecialchars($row['Nama_UKM']) . "</td>";
    $table .= "<td>" . $row['Jumlah_Proker'] . "</td>";
    $table .= "<td>" . $row['Jumlah_Anggota'] . "</td>";
    $table .= "<td>" . htmlspecialchars($row['Penanggung_Jawab'] ?? 'Belum Ada') . "</td>";
    $table .= "<td class='flex items-center gap-2'>
        <a href='detail_ukm.php?id_ukm=" . htmlspecialchars($row['id_ukm']) . "' class='btn btn-circle btn-sm bg-indigo-500 text-white hover:bg-indigo-600 tooltip transition duration-200' data-tip='Lihat Detail'>
            <span class='material-symbols-outlined' style='font-size: 17px;'>visibility</span>
        </a>
        <a href='ukm_1.php?id_ukm=" . htmlspecialchars($row['id_ukm']) . "' class='btn btn-circle btn-sm bg-yellow-400 text-white hover:bg-yellow-500 tooltip transition duration-200' data-tip='Edit Data'>
            <span class='material-symbols-outlined' style='font-size: 19px;'>edit</span>
        </a>
        <a href='ukm_2.php?id_ukm=" . htmlspecialchars($row['id_ukm']) . "'onclick='btnUpdate()'"."' class='btn btn-circle btn-sm bg-red-500 text-white hover:bg-red-600 tooltip transition duration-200' data-tip='Hapus Data' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>
            <span class='material-symbols-outlined' style='font-size: 18px;'>delete</span>
        </a>
    </td>";
    $table .= "</tr>";
}

// Buat tombol pagination
$pagination = "<div class='btn-group'>";
if ($page > 1) {
    $pagination .= "<button class='btn btn-sm btn-outline' onclick='loadData(" . ($page - 1) . ")'>Previous</button>";
}
for ($i = 1; $i <= $total_pages; $i++) {
    $active = $i === $page ? 'btn-primary' : 'btn-outline';
    $pagination .= "<button class='btn btn-sm $active' onclick='loadData($i)'>$i</button>";
}
if ($page < $total_pages) {
    $pagination .= "<button class='btn btn-sm opacity-80 btn-neutral' onclick='loadData(" . ($page + 1) . ")'>Next</button>";
}
$pagination .= "</div>";

echo json_encode([
    'table' => $table,
    'pagination' => $pagination
]);
?>
