<?php
include("koneksi.php");

include("validasi_login.php");
$nama_admin = $_SESSION['nama_admin'];




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

          <div class="flex justify-between w-ful bg-amber my-5">
            
            
            <select id="filterSelect" class="btn btn-dash btn-accent" name="filter">
              <option class="" value="">Filter</option>
              <option value="proker_terbanyak">Proker Terbanyak</option>
              <option value="anggota_terbanyak">Anggota Terbanyak</option>
            </select>
            
            <button class="btn btn-primary" value="Submit" name="tambah_data" onclick="btnOpen()">Tambah Data</button>
            </div>



<div class="overflow-x-auto rounded-box border border-base-content/5 bg-slate-100">
  <table class="table w-full">
    <thead>
      <tr>
        <th>No</th>
        <th>ID</th>
        <th>Nama UKM</th>
        <th>Proker</th>
        <th>Anggota</th>
        <th>Penanggung Jawab</th>
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
                <li><a class="rounded-box  bg-slate-800 text-slate-200">List UKM</a></li>
                <li><a class="rounded-box" onclick="btnOpen()">Tambah UKM</a></li>
              </ul>
            </details>
          </li>
          <li>
            <details>
              <summary class="rounded-box">
                <i class="fas fa-users mr-3"></i> Anggota
              </summary>
              <ul>
                <li><a class="rounded-box">List Anggota</a></li>
                <li><a class="rounded-box">Tambah Anggota</a></li>
              </ul>
            </details>

            <details>
              <summary class="rounded-box">
                <i class="fas fa-calendar-check mr-3"></i> Proker
              </summary>
              <ul>
                <li><a class="rounded-box">List Anggota</a></li>
                <li><a class="rounded-box">Tambah Anggota</a></li>
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

      <?php include_once('delete_ukm.php') ?>
    </div>

    
    

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
  

<script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function loadData(page = 1) {
    $.ajax({
        url: 'search-filter_ukm.php',
        type: 'POST',
        dataType: 'json',
        data: {
            search: $('#searchInput').val(),
            filter: $('#filterSelect').val(),
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

$('#filterSelect').on('change', function () {
    loadData(1);
});

$(document).ready(function () {
    loadData();
});




function openUpdateForm(id) {
  fetch(`get_ukm.php?id_ukm=${id}`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        // isi value input form modal update
        document.getElementById('form_update_id').value = data.ukm.id_ukm;
        document.getElementById('form_update_nama').value = data.ukm.nama_ukm;
        
        // tampilkan modal
        document.getElementById('modalUpdate').classList.remove('hidden');
      } else {
        alert("Gagal mengambil data UKM.");
      }
    });
}

function btnUpdate() {

}


</script>


      


    <script src="js/script.js"></script>
  </body>
</html>
