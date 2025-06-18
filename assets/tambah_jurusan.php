<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jurusan</title>

    <!-- LINK SELESAI-->
     <link rel="stylesheet" href="../css/dist/output.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
     <!-- LINK SELESAI -->
</head>
<body>
<?php

include("koneksi.php");

if (!isset($_SESSION['is_login'])) {
header("Location: login.php");
exit;
};


// include("validasi_login.php");
function input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$success = "";
$error = "";

// Buat ID Otomatis
$query = mysqli_query($conn, "SELECT MAX(RIGHT(id_jurusan, 2)) AS kode FROM jurusan");
$data = mysqli_fetch_assoc($query);
$kodeBaru = $data['kode'] ? (int)$data['kode'] + 1 : 1;
$generatedId = 'J' . str_pad($kodeBaru, 2, '0', STR_PAD_LEFT);

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = input($_POST["id_jurusan"]);
    $nama = input($_POST["nama_jurusan"]);

    // Cek duplikasi nama UKM
    $cek = mysqli_query($conn, "SELECT * FROM jurusan WHERE nama_jurusan = '$nama'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Nama Jurusan <b>$nama</b> sudah ada!";
    } else {
        $sql = "INSERT INTO jurusan (id_jurusan, nama_jurusan) VALUES ('$id', '$nama')";
        if (mysqli_query($conn, $sql)) {
            $success = "Data berhasil disimpan!";
        } else {
            $error = "Data gagal disimpan: " . mysqli_error($conn);
        }
    }
}
?>
<?php if (!empty($success)) : ?>
<div id="alertSuccess" role="alert" class="fixed top-0 left-1/2 transform -translate-x-1/2 -translate-y-full opacity-0 transition-all duration-500 z-50 w-3/4 max-w-xl bg-green-100 text-green-800 p-4 rounded flex gap-2 items-center shadow-lg">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  <span><?= $success ?></span>
</div>
<?php elseif (!empty($error)) : ?>
<div id="alertError" role="alert" class="fixed top-0 left-1/2 transform -translate-x-1/2 -translate-y-full opacity-0 transition-all duration-500 z-50 w-3/4 max-w-xl bg-red-100 text-red-800 p-4 rounded flex gap-2 items-center shadow-lg">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      d="M6 18L18 6M6 6l12 12" />
  </svg>
  <span><?= $error ?></span>
</div>
<?php endif; ?>





<!-- Modal Background -->
<div id="tambahDataJurusan" class="hidden fixed top-0 left-0 w-full h-full bg-black/50 z-50 flex items-center justify-center ">

  <!-- Form -->
  <form action="" method="post" class="p-6 rounded-2xl border bg-white space-y-4 max-w-sm w-full shadow-xl">

    <h3 class="text-2xl font-bold text-center">Form Input Jurusan</h3>

    <!-- ID UKM (disembunyikan) -->
    <input type="" name="id_jurusan" readonly value="<?= $generatedId ?>">

    <!-- Nama UKM -->
    <div class="form-control">
      <label for="nama" class="label">Nama Jurusan</label>
      <input required id="nama" name="nama_jurusan" type="text" class="input rounded-xl input-bordered w-full" />
    </div>

    <!-- Tombol Aksi -->
    <button type="submit" class="btn btn-primary w-full rounded-xl">Simpan</button>
    <button type="button" onclick="document.getElementById('tambahDataJurusan').classList.add('hidden')" class="btn btn-neutral w-full rounded-xl">Batal</button>

  </form>
</div>

<script src="js/main.js"></script>
<script>
window.addEventListener("DOMContentLoaded", () => {
  const alertSuccess = document.getElementById("alertSuccess");
  const alertError = document.getElementById("alertError");
  const closeTambahData = document.getElementById('tambahData')
  if (alertSuccess) {
    setTimeout(() => {
      alertSuccess.classList.remove("-translate-y-full", "opacity-0");
      alertSuccess.classList.add("translate-y-5", "opacity-100");
    }, 100);

    setTimeout(() => {
      alertSuccess.classList.remove("translate-y-5", "opacity-100");
      alertSuccess.classList.add("-translate-y-full", "opacity-0");
    }, 3000);
    // windows ukm php
  }

  if (alertError) {
    setTimeout(() => {
      alertError.classList.remove("-translate-y-full", "opacity-0");
      alertError.classList.add("translate-y-5", "opacity-100");
    }, 100);

    setTimeout(() => {
      alertError.classList.remove("translate-y-5", "opacity-100");
      alertError.classList.add("-translate-y-full", "opacity-0");
    }, 3000);
    closeTambahData.classList.add("hidden")
  }
});



function btnUpdate_ukm() {
    alert('Update Berhasil')
}
</script>

</body>
</html>