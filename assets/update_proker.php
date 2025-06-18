<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Proker</title>

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

if (!isset($_GET['id'])) {
    header('Location: error.php'); // Atau redirect ke halaman daftar anggota
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM proker WHERE ID_PROKER = '$id'";
$query = mysqli_query($conn, $sql);
$proker_data = mysqli_fetch_assoc($query);

// Jika data anggota tidak ditemukan, redirect atau tampilkan error
if (!$proker_data) {
    header('Location: error.php'); // Anggota tidak ditemukan
    exit;
}


$id_ukm_terpilih = $proker_data["ID_UKM"]; // Ambil ID UKM dari data anggota
$id_anggota_terpilih = $proker_data["ID_ANGGOTA"];
$id_status_terpilih = $proker_data["STATUS_PROKER"];

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
<div id="tambahDataProker" class="fixed top-0 left-0 w-full h-full bg-black/50 z-50 flex items-center justify-center  ">

  <!-- Form -->
  <form action="aksi-update_proker.php" method="post" class="p-6 rounded-2xl border bg-white space-y-4 max-w-sm w-full shadow-xl">

    <h3 class="text-2xl font-bold text-center">Form Update Proker</h3>

    <!-- ID UKM (disembunyikan) -->
    <input type="text" name="id_proker" class="text-slate-900" readonly value="<?php echo $id ?>">

    <!-- Nama UKM -->
    <div class="form-control">
      <label for="nama" class="label">Nama</label>
      <input required id="nama" name="nama" type="text" class="input rounded-xl input-bordered w-full" value="<?php echo $proker_data['NAMA_PROKER'] ?>"/>
    </div>
    <div class="form-control" >
        <label for="ukm" class="label">Pilih UKM</label>
        <select id="ukm" required name="id_ukm" class="select     input rounded-xl input-bordered w-full" required>
        <option value="" disabled <?php echo ($id_ukm_terpilih == "") ? "selected" : ""; ?> class="text-slate-700 ">Pilih UKM</option>
        <?php
            include("koneksi.php");
            $ukm = mysqli_query($conn, "SELECT * FROM ukm");
                  while ($row = mysqli_fetch_assoc($ukm)) {
                      $selected = ($row['ID_UKM'] == $id_ukm_terpilih) ? "selected" : "";
                      echo "<option value='".htmlspecialchars($row['ID_UKM'])."' ".$selected.">".htmlspecialchars($row['NAMA_UKM'])."</option>";
            }
        ?>
        </select>
    </div>



    <div class="form-control">
        <label for="anggota" class="label">Pilih Penanggung Jawab</label>
        <select required id="anggota" name="id_anggota" class="select input rounded-xl input-bordered w-full">
            <option value="" disabled selected class="text-slate-700">Pilih PJ</option>
        </select>

      </div>

  <div class="form-control">
      <label for="status" class="label">Pilih Status Proker</label>
      <select required id="status" name="status" class="select input rounded-xl input-bordered w-full">
          <option value="" disabled <?= ($id_status_terpilih == "") ? "selected" : "" ?> class="text-slate-700">Pilih Status</option>
          <option value="proses" <?= ($id_status_terpilih == "proses") ? "selected" : "" ?> class="text-slate-700">Proses</option>
          <option value="sukses" <?= ($id_status_terpilih == "sukses") ? "selected" : "" ?> class="text-slate-700">Sukses</option>
      </select>
  </div>
  
    
    <div class="form-control">
      <label for="tanggal" class="label">Tanggal Proker</label>
      <input required id="tanggal" name="tanggal_proker" type="date" class="input rounded-xl input-bordered w-full" value="<?php echo $proker_data['TAHUN_PROKER'] ?>"/>
    </div>

    <!-- Tombol Aksi -->
    <button type="submit" class="btn btn-primary w-full rounded-xl">Simpan</button>
    <a href="proker.php" type="button"  class="btn btn-neutral w-full rounded-xl">Batal</a>

  </form>
</div>

<script>
window.addEventListener("DOMContentLoaded", () => {
  const alertSuccess = document.getElementById("alertSuccess");
  const alertError = document.getElementById("alertError");
    const closeTambahData = document.getElementById('tambahDataAnggota')
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
    setTimeout(() => {
    // Ambil nama file dari path URL saat ini
    const currentPage = window.location.pathname.split("/").pop();

    // Cek apakah bukan di ukm.php
    if (currentPage !== "proker.php") {
        window.location.href = "proker.php";
    }
    }, 3230);
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

 window.addEventListener("DOMContentLoaded", () => {
    const ukmSelect = document.querySelector('select[name="id_ukm"]');
    const roleSelect = document.querySelector('select[name="id_anggota"]'); // ✅ sudah diperbaiki
    const idRoleTerpilih = "<?= $id_anggota_terpilih ?>";

    function loadAnggota(idUKM, selectedId = null) {
      roleSelect.innerHTML = '<option disabled selected>Loading...</option>';
      fetch(`get_anggota_by_ukm.php?id_ukm=${idUKM}`) // pastikan endpoint ini sesuai
        .then(res => res.json())
        .then(data => {
          roleSelect.innerHTML = '<option disabled>Pilih Anggota</option>';
          if (data.length === 0) {
            roleSelect.innerHTML += `<option disabled selected>Tidak ada Role</option>`;
          } else {
            data.forEach(role => {
              const selected = role.id === selectedId ? 'selected' : '';
              roleSelect.innerHTML += `<option value="${role.id}" ${selected}>${role.nama}</option>`;
            });
          }
        })
        .catch(err => {
          console.error("Gagal ambil data role:", err);
          roleSelect.innerHTML = '<option disabled selected>Error ambil role</option>';
        });
    }

    // Load saat awal jika ada UKM terpilih
    if (ukmSelect.value !== "") {
      loadAnggota(ukmSelect.value, idRoleTerpilih);
    }

    // Load ulang saat UKM berubah
    ukmSelect.addEventListener('change', function () {
      loadAnggota(this.value);
    });
});


</script>
</script>

</body>
</html>