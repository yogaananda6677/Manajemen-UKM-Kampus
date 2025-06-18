<?php
require '../vendor/autoload.php';
include 'koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Judul utama
$sheet->mergeCells('A1:E1');
$sheet->setCellValue('A1', 'LAPORAN UKM POLINEMA PSDKU KEDIRI');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Tanggal laporan
$tanggal = date('d F Y');
$sheet->mergeCells('A2:E2');
$sheet->setCellValue('A2', 'Tanggal Laporan: ' . $tanggal);
$sheet->getStyle('A2')->getFont()->setItalic(true);
$sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Header kolom
$headers = ['No', 'Nama UKM', 'Ketua', 'Jumlah Anggota', 'Jumlah Proker'];
$sheet->fromArray($headers, NULL, 'A4');
$sheet->getStyle('A4:E4')->getFont()->setBold(true);

// Ambil data dari database
$query = mysqli_query($conn, "
SELECT 
    u.nama_ukm,
    (SELECT a.nama 
     FROM anggota a 
     JOIN role_ukm r ON a.id_role = r.id_role 
     WHERE a.id_ukm = u.id_ukm AND LOWER(r.nama_role) = 'ketua' LIMIT 1) AS ketua,
    (SELECT COUNT(*) FROM anggota a2 WHERE a2.id_ukm = u.id_ukm) AS jumlah_anggota,
    (SELECT COUNT(*) FROM proker p WHERE p.id_ukm = u.id_ukm) AS jumlah_proker
FROM ukm u
");

$row = 5;
$no = 1;
while ($data = mysqli_fetch_assoc($query)) {
    $sheet->setCellValue("A$row", $no++);
    $sheet->setCellValue("B$row", $data['nama_ukm']);
    $sheet->setCellValue("C$row", $data['ketua']);
    $sheet->setCellValue("D$row", $data['jumlah_anggota']);
    $sheet->setCellValue("E$row", $data['jumlah_proker']);
    $row++;
}

// Tambahkan border ke semua sel yang digunakan
$lastRow = $row - 1;
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
];
$sheet->getStyle("A4:E$lastRow")->applyFromArray($styleArray);

// Auto-size kolom
foreach (range('A', 'E') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Output ke browser
$filename = 'laporan_ukm.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
