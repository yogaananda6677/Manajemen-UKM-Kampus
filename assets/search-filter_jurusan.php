<?php
include("koneksi.php");
header('Content-Type: application/json');

$search = $_POST['search'] ?? '';
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;
$no = $offset + 1;

$where = "";
if ($search !== '') {
    $search = mysqli_real_escape_string($conn, $search);
    $where = "WHERE nama_jurusan LIKE '%$search%'";
}

$orderBy = "ORDER BY id_jurusan DESC";

$sql = "SELECT * FROM jurusan $where $orderBy LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Hitung total data
$sql_count = "SELECT COUNT(*) AS total FROM jurusan $where";
$count_result = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_assoc($count_result);
$total_row = $row_count['total'];
$total_pages = ceil($total_row / $limit);

// Buat isi tabel
$table = "";
while ($row = mysqli_fetch_assoc($result)) {
    $table .= "<tr>";
    $table .= "<td>" . $no++ . "</td>";
    $table .= "<td>" . htmlspecialchars($row['ID_JURUSAN']) . "</td>";
    $table .= "<td>" . htmlspecialchars($row['NAMA_JURUSAN']) . "</td>";
    $table .= "<td class='flex items-center gap-2'>
        <a href='jurusan_1.php?id_jur=" . htmlspecialchars($row['ID_JURUSAN']) . "' class='btn btn-circle btn-sm bg-yellow-400 text-white hover:bg-yellow-500 tooltip transition duration-200' data-tip='Edit Data'>
            <span class='material-symbols-outlined' style='font-size: 19px;'>edit</span>
        </a>
        <a href='jurusan_2.php?id_jur=" . htmlspecialchars($row['ID_JURUSAN']) . "' class='btn btn-circle btn-sm bg-red-500 text-white hover:bg-red-600 tooltip transition duration-200' data-tip='Hapus Data''>
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
