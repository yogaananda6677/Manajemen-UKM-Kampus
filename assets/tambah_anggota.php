<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota</title>

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
$query = mysqli_query($conn, "SELECT MAX(RIGHT(id_anggota, 7)) AS kode FROM anggota");
$data = mysqli_fetch_assoc($query);
$kodeBaru = $data['kode'] ? (int)$data['kode'] + 1 : 1;
$generatedId = 'AGA' . str_pad($kodeBaru, 7, '0', STR_PAD_LEFT);

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = input($_POST["id_anggota"]);
    $nama = input($_POST["nama"]);
    $nim = input($_POST["nim"]);
    $jurusan_input = input($_POST["id_jurusan"]);
    $ukm = input($_POST["id_ukm"]);
    $role = input($_POST["id_role"]);
    $tanggal = $_POST["tanggal_daftar"];

// 1. Cek apakah sudah ada Ketua di UKM ini
$cek_ketua = mysqli_query($conn, "
    SELECT a.id_anggota 
    FROM anggota a 
    JOIN role_ukm r ON a.id_role = r.id_role AND a.id_ukm = r.id_ukm
    WHERE a.id_ukm = '$ukm' AND LOWER(r.nama_role) = 'ketua'
    LIMIT 1
");

// 2. Cek apakah NIM sudah terdaftar dalam UKM yang sama
$cek_nim_di_ukm = mysqli_query($conn, "
    SELECT id_anggota 
    FROM anggota 
    WHERE nim = '$nim' AND id_ukm = '$ukm'
    LIMIT 1
");

// 3. Validasi
if (mysqli_num_rows($cek_ketua) > 0 && strtolower($role_name) === 'ketua') {
    $error = "Role Ketua sudah ada di UKM ini, tidak boleh input lagi!";
} elseif (mysqli_num_rows($cek_nim_di_ukm) > 0) {
    $error = "Mahasiswa dengan NIM ini sudah terdaftar di UKM ini!";
} else {
    // INSERT query
    $sql = "INSERT INTO anggota (ID_ANGGOTA, ID_ROLE, ID_JURUSAN, ID_UKM, NIM, NAMA, TANGGAL_DAFTAR)
            VALUES ('$id', '$role', '$jurusan_input', '$ukm', '$nim', '$nama', '$tanggal')";
    
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
<div id="tambahDataAnggota" class="fixed top-0 left-0 w-full h-full bg-black/50 z-50 flex items-center justify-center <?= $_SERVER["REQUEST_METHOD"] == "POST" && $error ? '' : 'hidden' ?>">

  <!-- Form -->
  <form action="" method="post" class="p-6 rounded-2xl border bg-white space-y-4 max-w-sm w-full shadow-xl">

    <h3 class="text-2xl font-bold text-center">Form Input Anggota</h3>

    <!-- ID UKM (disembunyikan) -->
    <input type="" name="id_anggota" readonly value="<?= $generatedId ?>">

    <!-- Nama UKM -->
    <div class="form-control">
      <label for="nama" class="label">Nama</label>
      <input required id="nama" name="nama" type="text" class="input rounded-xl input-bordered w-full" />
    </div>
    <div class="form-control">
      <label for="nim" class="label" >Nim</label>
      <input required id="nim" name="nim" type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="input rounded-xl input-bordered w-full" />
    </div>

    <div class="form-control">
        <label for="jurusan" class="label">Pilih Jurusan</label>
        <select id="jurusan" required name="id_jurusan" class="select     input rounded-xl input-bordered w-full" required>
        <option value="" disabled selected class="text-slate-700 ">Pilih Jurusan</option>
        <?php
            include("koneksi.php");
            $jurusan = mysqli_query($conn, "SELECT * FROM jurusan");
            while ($row = mysqli_fetch_assoc($jurusan)) {
            echo "<option value='".$row['ID_JURUSAN']."'>".$row['NAMA_JURUSAN']."</option>";
            }
        ?>
        </select>
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
        <label for="role" class="label">Pilih Role</label>
        <select required id="role" name="id_role" class="select input rounded-xl input-bordered w-full">
            <option value="" disabled selected class="text-slate-700">Pilih Role</option>
        </select>

    </div>
    <div class="form-control">
      <label for="tanggal" class="label">Tanggal Daftar</label>
      <input required id="tanggal" name="tanggal_daftar" type="date" class="input rounded-xl input-bordered w-full" />
    </div>

    <!-- Tombol Aksi -->
    <button type="submit" class="btn btn-primary w-full rounded-xl">Simpan</button>
    <button type="button" onclick="document.getElementById('tambahDataAnggota').classList.add('hidden')" class="btn btn-neutral w-full rounded-xl">Batal</button>

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
    if (currentPage !== "annggota.php") {
        window.location.href = "anggota.php";
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
    const roleSelect = document.querySelector('select[name="id_role"]');

    ukmSelect.addEventListener('change', function () {
        const selectedUKM = this.value;
        roleSelect.innerHTML = '<option disabled selected>Loading...</option>';

        fetch(`get_role_by_ukm.php?id_ukm=${selectedUKM}`)
            .then(res => res.json())
            .then(data => {
                roleSelect.innerHTML = '<option disabled selected>Pilih Role</option>';
                if (data.length === 0) {
                    roleSelect.innerHTML += `<option disabled>Tidak ada role</option>`;
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