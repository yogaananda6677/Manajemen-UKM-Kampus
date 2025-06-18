<?php
include("koneksi.php");

include("validasi_login.php");
$nama_admin = $_SESSION['nama_admin'];
// Cek status di awal
$errorMessage = '';
$successMessage = "";
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    $successMessage = "Data berhasil diperbarui!";
}  elseif (isset($_GET['status']) && $_GET['status'] === 'error'){
        $errorMessage = "Terjadi kesalahan saat memperbarui data (NIM sudah digunakan).";
}




?>




<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DASHBORD ADMIN</title>


    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>



    <link rel="stylesheet" href="../css/dist/output.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">

  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" rel="stylesheet" />

<style>
  .material-symbols-outlined {
    font-variation-settings: 'FILL' 0, 'wght' 100, 'GRAD' 0, 'opsz' 24;
  }
</style>


    <!-- Font Awesome 6.5.0 – CDN resmi dari cdnjs -->
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>

    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Petrona:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" / >
  </head>
  <body class="bg-base-200 font-heading">
    <div class="navbar bg-base-100 shadow-md p-4 w-full sticky top-0 z-20">
      <div class="flex-none lg:hidden">
        <label for="my-drawer-2" class="btn btn-square btn-ghost">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            class="inline-block w-6 h-6 stroke-current"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            ></path>
          </svg>
        </label>
      </div>
      <img
        src="img/logo-ukm.jpg"
        class="w-[40px] h-[40px] rounded-b-full ml-2  "
        alt="logo-ukm"
      />
      <div class="flex-1 px-2  text-xl font-bold">
        UKM-<span class="text-cyan-500">PRO</span>
      </div>
      <div class="flex-none hidden lg:block">
        <ul class="menu menu-horizontal px-1">
          <li>
            <details>
              <summary class="btn btn-ghost">
                <div class="avatar online">
                  <div class="w-8 rounded-full">
                    <img
                      src="./img/admin.png"
                      alt="User Avatar"
                    />
                  </div>
                </div>
                <!-- RELASI DENGAN TABEL ADMIN -->
                <?php echo $nama_admin ?>
              </summary>
              <ul class="p-2 bg-base-100 rounded-t-none z-10">
                <li><a>Profile</a></li>
                <li><a  onclick="confirmLogout()">Logout</a></li>
              </ul>
            </details>
          </li>
        </ul>
      </div>

      <div class="flex-none lg:hidden">
        <div class="dropdown dropdown-end">
          <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
            <i class="fas fa-ellipsis-v"></i>
          </div>
          <ul
            tabindex="0"
            class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52"
          >
            <li>
              <a><i class="fas fa-user"></i> Profile</a>
            </li>
            <li>
              <a onclick="confirmLogout()"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="drawer lg:drawer-open">
      <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
      <div class="drawer-content flex flex-col items-start justify-start">
        <main class="flex-1 p-6 md:p-10 w-full">
         
        <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        </div>
                <!-- ISI KONTEN -->
                 
            <label class="relative block w-full max-w-md mx-auto">
            <!-- Icon -->
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <g
                    stroke-linejoin="round"
                    stroke-linecap="round"
                    stroke-width="2.5"
                    fill="none"
                    stroke="currentColor"
                >
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </g>
                </svg>
            </span>

            <!-- Input -->
            <input
                id="searchInput"
                type="search"
                placeholder="Search"
                name="search"
                required
                class="w-full pl-12 pr-4 py-3 bg-slate/80 rounded-xl shadow-md border border-gray-300 
                    focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-gray-500
                    transition-transform duration-200 ease-in-out transform focus:scale-105"
            />
          </label>
        <div class="flex flex-col lg:flex-row justify-between items-center mb-8">
          <div class="flex flex-row  w-ful bg-amber my-5">
            <select  id="filterSelectUkm" required name="filter_ukm" class="select select-bordered mt-2" required>
            <option value=""  class="text-slate-700">Pilih UKM</option>
                <?php
            include("koneksi.php");
            $ukm_fil = mysqli_query($conn, "SELECT * FROM ukm");
            while ($row = mysqli_fetch_assoc($ukm_fil)) {
            echo "<option value='".$row['ID_UKM']."'>".$row['NAMA_UKM']."</option>";
        }
            ?>
            </select>   

        <select id="filterSelectTahun" name="filter_tahun" class="select select-bordered mt-2">
            <option value="">Pilih Tahun</option>
                            <?php
            $tahun = mysqli_query($conn, "SELECT DISTINCT YEAR(tahun_proker) AS tahun FROM proker ORDER BY tahun DESC;");
            while ($row = mysqli_fetch_assoc($tahun)) {
            echo "<option value='".$row['tahun']."'>".$row['tahun']."</option>";
        }
            ?>
        </select>
            
            <select id="filterSelectStatus" class="btn btn-dash btn-accent mt-2" name="filter_jurusan">
                <option value=""  class="text-slate-700">Pilih Status</option>
                <option value="sukses"  class="text-slate-700">Sukses</option>
                <option value="proses"  class="text-slate-700">Proses</option>

            </select>


            
        </div>
        <button class="btn btn-primary" value="Submit" name="tambah_data" onclick="tambahProker()">Tambah Data</button>
        </div>


<div class="overflow-x-auto rounded-box border border-base-content/5 bg-slate-100">
  <table class="table w-full">
    <thead>
      <tr>
        <th>No</th>
        <th>ID</th>
        <th>Nama</th>
        <th>UKM</th>
        <th>Tahun</th>
        <th>Penanggung Jawab</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="tampil">
      
    </tbody>
  </table>
</div>
<!-- Semua pagination dalam satu baris -->
<div id="pagination" class="join mt-4 flex justify-center flex-wrap gap-1"></div>


            <!-- TABEL ENDD -->





           
          </main>
         <!-- ISI KONTEN SELESAI -->


        <footer
          class="footer footer-center p-4 bg-base-300 text-base-content mt-8"
        >
          <aside>
            <p>Copyright © 2025 - All right reserved by yoga and tasya</p>
          </aside>
        </footer>
      </div>

      <div class="drawer-side">
        <label
          for="my-drawer-2"
          aria-label="close sidebar"
          class="drawer-overlay"
        ></label>
        <ul
          class="menu p-4 w-80 min-h-full pt-20 lg:pt-5 bg-neutral-100 text-base-content font-heading text-[15px] gap-2"
        >
          <li>
            <a href="dashbord.php   " class="active rounded-box group "
              ><i class="fas fa-tachometer-alt mr-3 "></i> Dashboard</a
            >
          </li>
          <li>
            <details open>
              <summary class="rounded-box">
                <i class="fas fa-handshake mr-3"></i> UKM
              </summary>
              <ul>
                <li><a href="ukm.php" class="rounded-box  ">List UKM</a></li>
                <li><a  class="rounded-box" onclick="tambahUkmOut()">Tambah UKM</a></li>
              </ul>
            </details>
          </li>
          <li>
            <details> 
              <summary class="rounded-box">
                <i class="fas fa-users mr-3"></i> Anggota
              </summary>
              <ul>
                <li><a class="rounded-box ">List Anggota</a></li>
                <li><a class="rounded-box" onclick="tambahAnggotaOut()">Tambah Anggota</a></li>
              </ul>
            </details>

            <details open>
              <summary class="rounded-box">
                <i class="fas fa-calendar-check mr-3"></i> Proker
              </summary>
              <ul>
                <li><a class="rounded-box bg-slate-800 text-slate-200">List Proker</a></li>
                <li><a class="rounded-box" onclick="tambahProker()">Tambah Proker</a></li>
              </ul>
            </details>

          </li>
          <li>
            <a class="rounded-box"
              ><i class="fas fa-file-alt mr-3"></i> Laporan</a
            >
          </li>
          <li>
            <a class="rounded-box"
              ><i class="fas fa-cogs mr-3"></i> Pengaturan</a
            >
          </li>
          <li class="mt-[50px]">
            <a
              onclick="confirmLogout()" 
              class="rounded-box group"
            >
              <i class="fas fa-sign-out-alt mr-3"></i> Logout
            </a>

            

          </li>
        </ul>
      </div>
    </div>

<?php include_once('acc_proker.php'); ?>

<?php if (!empty($successMessage)) : ?>
  <div id="alertSuccess" role="alert" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-3/4 max-w-xl bg-green-100 text-green-800 p-4 rounded flex gap-2 items-center shadow-lg transition-all duration-500">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span><?= $successMessage ?></span>
  </div>

<?php elseif (!empty($errorMessage)) : ?>
  <div id="alertError" role="alert" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 w-3/4 max-w-xl bg-red-100 text-red-800 p-4 rounded flex gap-2 items-center shadow-lg transition-all duration-500">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
    <span><?= $errorMessage ?></span>
  </div>
<?php endif; ?>
<script src="js/main.js"></script>
<script src="js/script.js"></script>
<script>



  document.addEventListener('DOMContentLoaded', function () {
    const ukmSelect = document.getElementById('filterSelectUkm');
    const roleSelect = document.getElementById('filterSelectRole');

    ukmSelect.addEventListener('change', function () {
        const selectedUKM = this.value;
        if (!selectedUKM) return;

        roleSelect.innerHTML = '<option disabled selected>Loading...</option>';

        fetch(`get_role_by_ukm_filter.php?id_ukm=${selectedUKM}`)
            .then(res => {
                if (!res.ok) throw new Error("HTTP error " + res.status);
                return res.json();
            })
            .then(data => {
                roleSelect.innerHTML = '<option value="">Pilih Role</option>';
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
});

// COPY
window.addEventListener("DOMContentLoaded", () => {
  const urlParams = new URLSearchParams(window.location.search);
  const isTambah = urlParams.get("tambah") === "1";

  const formTambah = document.getElementById("tambahDataProker");
  const alertSuccess = document.getElementById("alertSuccess");
  const alertError = document.getElementById("alertError");

  if (isTambah && formTambah) {
    formTambah.classList.remove("hidden");
  }

  if (alertSuccess || alertError) {
    // Tampilkan alert
    setTimeout(() => {
      if (alertSuccess) {
        alertSuccess.style.transform = "translateY(20px)";
        alertSuccess.style.opacity = "1";
      }
      if (alertError) {
        alertError.style.transform = "translateY(20px)";
        alertError.style.opacity = "1";
      }
    }, 100);

    // Sembunyikan alert setelah 3 detik
    setTimeout(() => {
      if (alertSuccess) {
        alertSuccess.style.transform = "translateY(-100%)";
        alertSuccess.style.opacity = "0";
      }
      if (alertError) {
        alertError.style.transform = "translateY(-100%)";
        alertError.style.opacity = "0";
      }
    }, 3000);

    // Sembunyikan form setelah alert selesai
    setTimeout(() => {
      if (formTambah) {
        formTambah.classList.add("hidden");
      }

      // Hapus parameter dari URL agar tidak buka form lagi saat reload
      // const newUrl = new URL(window.location);
      // newUrl.searchParams.delete("tambah");
      // window.history.replaceState({}, document.title, newUrl);
    }, 0);
    setTimeout(() => {
      if (formTambah) {
        // Hapus parameter dari URL agar tidak buka form lagi saat reload
        const newUrl = new URL(window.location);
        newUrl.searchParams.delete("tambah");
        newUrl.searchParams.delete("status");
        window.history.replaceState({}, document.title, newUrl);
      }

    }, 3200);
  }
});
</script>


    

  <!-- Kotak Konfirmasi Logout -->
  <div id="confirmBox" class="hidden fixed top-0 left-0 w-full h-full bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl p-6 w-[90%] max-w-sm text-center space-y-4">
      <h3 class="text-lg font-bold text-gray-800">Konfirmasi Logout</h3>
      <p class="text-sm text-gray-600">Apakah Anda yakin ingin keluar dari sistem?</p>
      <div class="flex justify-center gap-4 pt-2">
        <a href="logout.php" class="btn btn-error text-white px-6">Ya</a>
        <button onclick="document.getElementById('confirmBox').classList.add('hidden')" 
        class="btn btn-ghost border px-6">
        Batal
      </button>
    </div>
    </div>
  </div>
  

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- <script src="js/script.js"></script> -->
<script>


  

function loadData(page = 1) {
    $.ajax({
        url: 'search-filter_proker.php',
        type: 'POST',
        dataType: 'json',
        data: {
            search: $('#searchInput').val(),
            filter_ukm: $('#filterSelectUkm').val(),
            filter_tahun: $('#filterSelectTahun').val(),
            filter_status: $('#filterSelectStatus').val(),
            page: page
        },
        success: function(response) {
            $('#tampil').html(response.table);
            $('#pagination').html(response.pagination);
        },
        error: function(xhr, status, error) {
            alert("Gagal mengambil data: " + error);
        }
    });
}

$('#searchInput').on('keyup', function () {
    loadData(1);
});

$('#filterSelectUkm').on('change', function () {
    loadData(1);
});

$('#filterSelectTahun').on('change', function () {
    loadData(1);
});

$('#filterSelectStatus').on('change', function () {
    loadData(1);
});


$(document).ready(function () {
    loadData();
});








</script>


      


  </body>
</html>
