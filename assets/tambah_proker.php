<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Proker</title>

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


function input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$success = "";
$error = "";

// Buat ID Otomatis
$query = mysqli_query($conn, "SELECT MAX(RIGHT(ID_PROKER, 10)) AS kode FROM proker");
$data = mysqli_fetch_assoc($query);
$kodeBaru = $data['kode'] ? (int)$data['kode'] + 1 : 1;
$generatedId = 'PK' . str_pad($kodeBaru, 10, '0', STR_PAD_LEFT);

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = input($_POST["id_proker"]);
    $nama = input($_POST["nama"]);
    $ukm = input($_POST["id_ukm"]);
    $status = input($_POST["status"]);
    $pj = input($_POST["id_anggota"]);
    $tanggal = $_POST["tanggal_proker"];



    $sql = "INSERT INTO proker (ID_PROKER, ID_UKM, NAMA_PROKER, TAHUN_PROKER, STATUS_PROKER, ID_ANGGOTA)
    VALUES ('$id', '$ukm', '$nama', '$tanggal', '$status', '$pj')";


    if (mysqli_query($conn, $sql)) {
        $success = "Data berhasil disimpan!";
    } else {
        $error = "Data gagal disimpan: " . mysqli_error($conn);
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
<div id="tambahDataProker" class="hidden fixed top-0 left-0 w-full h-full bg-black/50 z-50 flex items-center justify-center  ">

  <!-- Form -->
  <form action="" method="post" class="p-6 rounded-2xl border bg-white space-y-4 max-w-sm w-full shadow-xl">

    <h3 class="text-2xl font-bold text-center">Form Input Proker</h3>

    <!-- ID UKM (disembunyikan) -->
    <input type="" name="id_proker" readonly value="<?= $generatedId ?>">

    <!-- Nama UKM -->
    <div class="form-control">
      <label for="nama" class="label">Nama</label>
      <input required id="nama" name="nama" type="text" class="input rounded-xl input-bordered w-full" />
    </div>
    <div class="form-control" >
        <label for="ukm" class="label">Pilih UKM</label>
        <select id="ukm" required name="id_ukm" class="select     input rounded-xl input-bordered w-full" required>
        <option value="" disabled selected class="text-slate-700 ">Pilih UKM</option>
        <?php
            include("koneksi.php");
            $ukm = mysqli_query($conn, "SELECT * FROM ukm");
            while ($row = mysqli_fetch_assoc($ukm)) {
            echo "<option value='".$row['ID_UKM']."'>".$row['NAMA_UKM']."</option>";
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
            <option value="" disabled selected class="text-slate-700">Pilih Status</option>
            <option value="proses"  class="text-slate-700">Proses</option>
            <option value="sukses"  class="text-slate-700">Sukses</option>
        </select>

    </div>
  
    
    <div class="form-control">
      <label for="tanggal" class="label">Tanggal Proker</label>
      <input required id="tanggal" name="tanggal_proker" type="date" class="input rounded-xl input-bordered w-full" />
    </div>

    <!-- Tombol Aksi -->
    <button type="submit" class="btn btn-primary w-full rounded-xl">Simpan</button>
    <button type="button" onclick="document.getElementById('tambahDataProker').classList.add('hidden')" class="btn btn-neutral w-full rounded-xl">Batal</button>

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

   const ukmSelect = document.querySelector('select[name="id_ukm"]');
    const roleSelect = document.querySelector('select[name="id_anggota"]');

    ukmSelect.addEventListener('change', function () {
        const selectedUKM = this.value;
        roleSelect.innerHTML = '<option disabled selected>Loading...</option>';

        fetch(`get_anggota_by_ukm.php?id_ukm=${selectedUKM}`)
            .then(res => res.json())
            .then(data => {
                roleSelect.innerHTML = '<option disabled selected>Pilih PJ</option>';
                if (data.length === 0) {
                    roleSelect.innerHTML += `<option disabled>Tidak ada PJ</option>`;
                } else {
                    data.forEach(role => {
                        roleSelect.innerHTML += `<option value="${role.id}">${role.nama}</option>`;
                    });
                }
            })
            .catch(err => {
                console.error("Gagal ambil data role:", err);
                roleSelect.innerHTML = '<option disabled selected>Error ambil role</option>';
            });
    });

</script>
</script>

</body>
</html>