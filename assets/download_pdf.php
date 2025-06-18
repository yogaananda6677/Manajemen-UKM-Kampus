<?php
require_once __DIR__ . '/../vendor/autoload.php';
include("koneksi.php");

$mpdf = new \Mpdf\Mpdf();


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

$tanggal = date('d F Y');

$html = '
<style>
    body { font-family: sans-serif; }
    .kop { text-align: center; margin-bottom: 10px; }
    .kop h2 { margin: 0; }
    .kop p { margin: 0; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { border: 1px solid black; padding: 6px; text-align: center; font-size: 12px; }
    .ttd { margin-top: 50px; width: 100%; font-size: 12px; }
</style>

<div class="kop">
    <h2>LAPORAN UKM POLINEMA PSDKU KEDIRI</h2>
    <p>Tanggal Laporan: ' . $tanggal . '</p>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama UKM</th>
            <th>Jumlah Anggota</th>
            <th>Jumlah Proker</th>
            <th>Nama Ketua</th>
        </tr>
    </thead>
    <tbody>
';

$no = 1;
while ($row = mysqli_fetch_assoc($query)) {
    $html .= '<tr>
        <td>' . $no++ . '</td>
        <td>' . $row['nama_ukm'] . '</td>
        <td>' . $row['jumlah_anggota'] . '</td>
        <td>' . $row['jumlah_proker'] . '</td>
        <td>' . $row['ketua'] . '</td>
    </tr>';
}

$html .= '
    </tbody>
</table>

<div class="ttd">
    <table style="border: none;">
        <tr>
            <td style="border: none; width: 70%;"></td>
            <td style="border: none; text-align: center;">
                Kediri, ' . $tanggal . '<br>
                Pembina UKM / Kepala Unit,<br><br><br><br>
                <u><b>Nama Pejabat</b></u><br>
                NIP. 123456789
            </td>
        </tr>
    </table>
</div>
';

$mpdf->WriteHTML($html);
$mpdf->Output("laporan_ukm.pdf", "D"); // Download otomatis
?>
