<?php
include("koneksi.php");
header('Content-Type: application/json');

// Ambil data dari POST
$search = $_POST['search'] ?? '';
$filter_ukm = $_POST['filter_ukm'] ?? '';
$filter_jurusan = $_POST['filter_jurusan'] ?? '';
$filter_role = $_POST['filter_role'] ?? '';
$page   = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit  = 5;
$offset = ($page - 1) * $limit;
$no     = $offset + 1;

// WHERE dinamis
$whereClause = [];
if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $whereClause[] = "(A.nama LIKE '%$search%' OR A.id_anggota LIKE '%$search%' OR U.nama_ukm LIKE '%$search%' OR J.nama_jurusan LIKE '%$search%' OR R.nama_role LIKE '%$search%' OR A.nim LIKE '%$search%')";
}
if (!empty($filter_ukm)) {
    $id_ukm = mysqli_real_escape_string($conn, $filter_ukm);
    $whereClause[] = "A.id_ukm = '$id_ukm'";
}
if (!empty($filter_jurusan)) {
    $id_jurusan = mysqli_real_escape_string($conn, $filter_jurusan);
    $whereClause[] = "A.id_jurusan = '$id_jurusan'";
}
if (!empty($filter_role)) {
    $id_role = mysqli_real_escape_string($conn, $filter_role);
    $whereClause[] = "A.id_role = '$id_role'";
}

$whereSQL = count($whereClause) ? 'WHERE ' . implode(' AND ', $whereClause) : '';


// ORDER BY dinamis (tambahan opsional, bisa pakai ID_ANGGOTA atau NAMA)
$orderBy = "ORDER BY A.id_anggota DESC";

// Query utama (Data anggota)
$sql = "
SELECT 
    A.id_anggota,
    A.nim,
    A.nama AS nama_anggota,
    R.nama_role,
    U.nama_ukm,
    A.tanggal_daftar,
    J.nama_jurusan
FROM 
    anggota A
LEFT JOIN 
    role_ukm R ON A.id_role = R.id_role
LEFT JOIN 
    ukm U ON A.id_ukm = U.id_ukm
LEFT JOIN 
    jurusan J ON A.id_jurusan = J.id_jurusan
$whereSQL
$orderBy
LIMIT $limit OFFSET $offset
";

$result = mysqli_query($conn, $sql);

// Hitung total data
$sql_count = "SELECT COUNT(*) AS total FROM anggota A 
LEFT JOIN ukm U ON A.id_ukm = U.id_ukm
LEFT JOIN jurusan J ON A.id_jurusan = J.id_jurusan
LEFT JOIN role_ukm R ON A.id_role = R.id_role
$whereSQL";

$count_result = mysqli_query($conn, $sql_count);
$total_row = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_row / $limit);

// Buat isi tabel
$table = "";
while ($row = mysqli_fetch_assoc($result)) {
    $table .= "<tr>";
    $table .= "<td>" . $no++ . "</td>";
    $table .= "<td>" . htmlspecialchars($row['id_anggota']) . "</td>";
    $table .= "<td>" . htmlspecialchars($row['nim']) . "</td>";
    $table .= "<td>" . htmlspecialchars($row['nama_anggota']) . "</td>";
    $table .= "<td>" . htmlspecialchars($row['nama_jurusan'] ?? '-') . "</td>";
    $table .= "<td>" . htmlspecialchars($row['nama_ukm'] ?? '-') . "</td>";
    $table .= "<td>" . htmlspecialchars($row['nama_role'] ?? '-') . "</td>";
    $table .= "<td>" . htmlspecialchars(date('d-m-Y', strtotime($row['tanggal_daftar']))) . "</td>";
    $table .= "<td>
        <div class='flex gap-2'>

            <a href='anggota_1.php?id=" . urlencode($row['id_anggota']) . "' 
               class='btn btn-circle btn-sm bg-yellow-400 text-white hover:bg-yellow-500 tooltip transition duration-200' 
               data-tip='Edit Data'>
                <span class='material-symbols-outlined' style='font-size: 19px;'>edit</span>
            </a>
            <a href='anggota_2.php?id=" . urlencode($row['id_anggota']) . "'  
               class='btn btn-circle btn-sm bg-red-500 text-white hover:bg-red-600 tooltip transition duration-200' 
               data-tip='Hapus Data'>
                <span class='material-symbols-outlined' style='font-size: 18px;'>delete</span>
            </a>
        </div>
    </td>";
    $table .= "</tr>";
}

// Pagination
$pagination = "<div class='btn-group'>";
if ($page > 1) {
    $pagination .= "<button class='btn btn-sm btn-outline' onclick='loadData(" . ($page - 1) . ")'>Previous</button>";
}
for ($i = 1; $i <= $total_pages; $i++) {
    $active = ($i === $page) ? 'btn-primary' : 'btn-outline';
    $pagination .= "<button class='btn btn-sm $active' onclick='loadData($i)'>$i</button>";
}
if ($page < $total_pages) {
    $pagination .= "<button class='btn btn-sm btn-neutral opacity-80' onclick='loadData(" . ($page + 1) . ")'>Next</button>";
}
$pagination .= "</div>";

// Output JSON
echo json_encode([
    'table' => $table,
    'pagination' => $pagination
]);
?>
