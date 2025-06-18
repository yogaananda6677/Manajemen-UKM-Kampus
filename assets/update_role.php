<?php
include("koneksi.php");

// Pastikan ada id_ukm di URL
if (!isset($_GET['id_ukm'])) {
    header('Location: error.php');
    exit;
}


$id = $_GET['id_ukm'];

if (!isset($_GET['id_ukm']) || empty($_GET['id_ukm'])) {
    header('Location: error.php');
    exit;
}

// Ambil status dari URL jika ada
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $success = "Data berhasil diperbarui!";
    } elseif ($_GET['status'] == 'error') {
        $error = "Terjadi kesalahan saat memperbarui data!";
    }
}

$success = "";
$error = "";

// Fungsi sanitasi input


// Ambil data UKM untuk form
$sql = "SELECT * FROM ukm WHERE ID_UKM = '$id'";
$query = mysqli_query($conn, $sql);
$ukm_data = mysqli_fetch_assoc($query);

if (!$ukm_data) {
    die("Data tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Update UKM</title>
    <link rel="stylesheet" href="../css/dist/output.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
</head>
<body>

<?php if (!empty($success)) : ?>
<div id="alertSuccess" role="alert" class="fixed top-0 left-1/2 transform -translate-x-1/2 translate-y-5 opacity-100 z-50 w-3/4 max-w-xl bg-green-100 text-green-800 p-4 rounded flex gap-2 items-center shadow-lg transition-all duration-500">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  <span><?= $success ?></span>
</div>
<?php elseif (!empty($error)) : ?>
<div id="alertError" role="alert" class="fixed top-0 left-1/2 transform -translate-x-1/2 translate-y-5 opacity-100 z-50 w-3/4 max-w-xl bg-red-100 text-red-800 p-4 rounded flex gap-2 items-center shadow-lg transition-all duration-500">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      d="M6 18L18 6M6 6l12 12" />
  </svg>
  <span><?= $error ?></span>
</div>
<?php endif; ?>

<!-- Form Center -->
<div  class=" fixed top-0 left-0 w-full h-full bg-black/50 z-50 flex items-center justify-center" >
  <form action="aksi-update_ukm.php" method="post" class="p-6 rounded-2xl border bg-white space-y-4 max-w-sm w-full shadow-xl">
    <h3 class="text-2xl font-bold text-center">Form Update UKM</h3>

    <input type="hidden" name="id_ukm" value="<?= htmlspecialchars($ukm_data['ID_UKM']); ?>">

    <div class="form-control">
      <label for="nama" class="label">Nama UKM</label>
      <input required id="nama" name="nama_ukm" type="text" class="input rounded-xl input-bordered w-full" value="<?= htmlspecialchars($ukm_data['NAMA_UKM']); ?>" />
    </div>

    <button type="submit" class="btn btn-primary w-full rounded-xl">Simpan</button>
    <a href="tambah_role.php?id=<?php echo $id?>" class="btn btn-neutral w-full rounded-xl text-center">Kembali</a>
  </form>
</div>



</body>
</html>
