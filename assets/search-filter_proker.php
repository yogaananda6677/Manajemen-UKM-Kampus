<?php
include("koneksi.php");
header('Content-Type: application/json');

// Ambil data dari POST
$search = $_POST['search'] ?? '';
$filter_ukm = $_POST['filter_ukm'] ?? '';
$filter_tahun = $_POST['filter_tahun'] ?? '';
$filter_status = $_POST['filter_status'] ?? '';
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;
$no = $offset + 1;

// WHERE dinamis
$whereClause = [];
if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $whereClause[] = "(P.NAMA_PROKER LIKE '%$search%' OR P.ID_PROKER LIKE '%$search%' OR U.NAMA_UKM LIKE '%$search%' OR A.NAMA LIKE '%$search%' OR P.TAHUN_PROKER LIKE '%$search%')";
}
if (!empty($filter_ukm)) {
    $id_ukm = mysqli_real_escape_string($conn, $filter_ukm);
    $whereClause[] = "P.ID_UKM = '$id_ukm'";
}
if (!empty($filter_tahun)) {
    $tahun = mysqli_real_escape_string($conn, $filter_tahun);
    $whereClause[] = "YEAR(P.TAHUN_PROKER) = '$tahun'";
}
if (!empty($filter_status)) {
    $status = mysqli_real_escape_string($conn, $filter_status);
    $whereClause[] = "P.STATUS_PROKER = '$status'";
}

$whereSQL = count($whereClause) ? 'WHERE ' . implode(' AND ', $whereClause) : '';
$orderBy = "ORDER BY P.ID_PROKER DESC";

// Query utama
$sql = "
SELECT 
    P.ID_PROKER AS id,
    P.NAMA_PROKER AS nama_p,
    U.NAMA_UKM AS nama_u,
    P.TAHUN_PROKER AS tahun,
    P.STATUS_PROKER AS status,
    A.NAMA AS penanggung_jawab
FROM 
    PROKER P
LEFT JOIN 
    UKM U ON P.ID_UKM = U.ID_UKM
LEFT JOIN 
    ANGGOTA A ON P.ID_ANGGOTA = A.ID_ANGGOTA
$whereSQL
$orderBy
LIMIT $limit OFFSET $offset
";

$result = mysqli_query($conn, $sql);

// Hitung total data untuk pagination
$sql_count = "
SELECT COUNT(*) AS total 
FROM PROKER P
LEFT JOIN UKM U ON P.ID_UKM = U.ID_UKM
LEFT JOIN ANGGOTA A ON P.ID_ANGGOTA = A.ID_ANGGOTA
$whereSQL
";
$count_result = mysqli_query($conn, $sql_count);
$total_row = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_row / $limit);

// Tampilkan isi tabel
$table = "";
while ($row = mysqli_fetch_assoc($result)) {
    $status = strtolower($row['status'] ?? 'proses'); // Pastikan lowercase untuk konsistensi

    // Tentukan badge status dari database
    if ($status === 'sukses') {
        $statusBadge = "<span class='badge badge-success'>Sukses</span>";
        $btnSelesai = "
            <button class='btn btn-circle btn-sm bg-gray-400 text-white tooltip cursor-not-allowed' data-tip='Sudah Sukses' disabled>
                <span class='material-symbols-outlined' style='font-size: 18px;'>done_all</span>
            </button>
        ";
    } else {
        $statusBadge = "<span class='badge badge-warning'>Proses</span>";
        $btnSelesai = "
            <a href='proker_3.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-circle btn-sm bg-green-600 text-white hover:bg-green-700 tooltip' data-tip='Tandai Sukses'>
                <span class='material-symbols-outlined' style='font-size: 18px;'>check_circle</span>
            </a>
        ";
    }

    $table .= "<tr>";
    $table .= "<td>" . $no++ . "</td>";
    $table .= "<td>" . htmlspecialchars($row['id']) . "</td>";
    $table .= "<td>" . htmlspecialchars($row['nama_p']) . "</td>";
    $table .= "<td>" . htmlspecialchars($row['nama_u'] ?? '-') . "</td>";
    $table .= "<td>" . htmlspecialchars(date('Y', strtotime($row['tahun']))) . "</td>";
    $table .= "<td>" . htmlspecialchars($row['penanggung_jawab'] ?? '-') . "</td>";
    $table .= "<td>" . $statusBadge . "</td>";
    $table .= "<td>
        <div class='flex gap-2'>
            <a href='proker_1.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-circle btn-sm bg-yellow-400 text-white hover:bg-yellow-500 tooltip' data-tip='Edit Data'>
                <span class='material-symbols-outlined' style='font-size: 19px;'>edit</span>
            </a>
            <a href='proker_2.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-circle btn-sm bg-red-500 text-white hover:bg-red-600 tooltip' data-tip='Hapus Data' >
                <span class='material-symbols-outlined' style='font-size: 18px;'>delete</span>
            </a>
            $btnSelesai
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
