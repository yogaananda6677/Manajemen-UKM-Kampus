<?php
include("koneksi.php");
include("validasi_login.php");

$nama_admin = $_SESSION['nama_admin'];
$username_admin = $_SESSION['username'];
$id_admin = $_SESSION['id_adm'];
// Cari Jumlah UKM
$success = "";
$error = "";

if(isset($_POST['ubahAkun'])){
    $id = $_POST['id_admin'];
    $nama = $_POST['nama_admin'];
    $username = $_POST['username_admin'];
    $cek = mysqli_query($conn, "SELECT * FROM admin WHERE USERNAME = '$username' AND ID_ADMIN != '$id'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Username ($username) Sudah Ada";
    }

    else{
        
      $query_uppdate = mysqli_query($conn , "UPDATE admin SET NAMA_ADMIN = '$nama',  USERNAME = '$username' WHERE ID_ADMIN = '$id'");

      if($query_uppdate) {
        $success = "Berhaasil Di Update";
      }
      else{
        $error = "Gagal Di Update";
      }
    }



}
// else{
//  header("Location : error.php");
// }





?>




<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DASHBORD ADMIN</title>
    <link rel="stylesheet" href="../css/dist/output.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">

  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


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
          
          <?php 
          $data = mysqli_query($conn,"SELECT * FROM admin where ID_ADMIN = '$id_admin'");
          $row = mysqli_fetch_assoc($data);
          ?>
        <div class="w-full bg-white shadow-xl rounded-xl p-8 mb-8">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="w-32 h-32 md:w-48 md:h-48 flex-shrink-0">
                    <img src="img/admin.png" class="w-full h-full object-cover rounded-full border-4 border-cyan-500 shadow-md" alt="Admin Profile Picture" />
                </div>
                <div class="text-center md:text-left">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2 mt-3"><?php echo $row['NAMA_ADMIN']?></h2>
                    <p class="text-l text-gray-600 mb-4">@<?php echo $row['USERNAME']?></p>
                    <div class="flex flex-wrap justify-center md:justify-start gap-3">
                        <a href="jurusan.php" class="btn btn-info text-white px-6 py-2 rounded-lg shadow-md hover:bg-info-focus transition duration-300 ease-in-out">
                            <i class="fas fa-book-open mr-2"></i> Kelola Jurusan
                        </a>
                        <button onclick="ubahAkun()" class="btn btn-accent text-white px-6 py-2 rounded-lg shadow-md hover:bg-accent-focus transition duration-300 ease-in-out">
                            <i class="fas fa-edit mr-2"></i> Ubah Akun
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php 
      $query_ubah_akun = mysqli_query($conn , "SELECT * FROM admin WHERE ID_ADMIN = '$id_admin'");
      $adm = mysqli_fetch_assoc($query_ubah_akun)
      ?>
      <div id="ubahAkun" class="hidden fixed top-0 left-0 w-full h-full bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl p-6 w-[90%] max-w-sm text-center space-y-4">
          <h3 class="text-lg font-bold text-gray-800">Ganti Akun</h3>
          <form action="profil.php" method="POST" class="space-y-4 text-left">
            <div class="hidden">
              <label class="label text-sm font-medium text-gray-700">ID Lengkap</label>
              <input type="text" name="id_admin" placeholder="Nama baru" required class="input input-bordered w-full" value="<?php echo $adm['ID_ADMIN']?>"/>
            </div>
            <div>
              <label class="label text-sm font-medium text-gray-700">Nama Lengkap</label>
              <input type="text" name="nama_admin" placeholder="Nama baru" required class="input input-bordered w-full" value="<?php echo $adm['NAMA_ADMIN']?>"/>
            </div>
            <div>
              <label class="label text-sm font-medium text-gray-700">Username</label>
              <input type="text" name="username_admin" placeholder="Username baru" required class="input input-bordered w-full" value="<?= $adm['USERNAME']?>"/>
            </div>
            <div class="flex justify-center gap-4 pt-2">
              <button type="submit" name="ubahAkun" class="btn btn-primary px-6">Simpan</button>
              <button type="button" onclick="document.getElementById('ubahAkun').classList.add('hidden')" class="btn btn-ghost border px-6">Batal</button>
            </div>
          </form>
        </div>
      </div>

        </main>

        <footer
          class="footer footer-center p-4 bg-base-300 text-base-content mt-8"
        >
          <aside>
            <p>Copyright © 2025 - All right reserved by yoga and tasya </p>
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
            <a href="dashbord.php" class="active rounded-box group"
              ><i class="fas fa-tachometer-alt mr-3  "></i> Dashboard</a
            >
          </li>
          <li>
            <details open>
              <summary class="rounded-box">
                <i class="fas fa-handshake mr-3"></i> UKM
              </summary>
              <ul>
                <li><a href="ukm.php" class="rounded-box">List UKM</a></li>
                <li><a class="rounded-box" onclick="tambahUkmOut()">Tambah UKM</a></li>
              </ul>
            </details>
          </li>
          <li>
            <details>
              <summary class="rounded-box">
                <i class="fas fa-users mr-3"></i> Anggota
              </summary>
              <ul>
                <li><a href="anggota.php" class="rounded-box">List Anggota</a></li>
                <li><a onclick="tambahAnggotaOut()" class="rounded-box">Tambah Anggota</a></li>
              </ul>
            </details>

            <details>
              <summary class="rounded-box">
                <i class="fas fa-calendar-check mr-3"></i> Proker
              </summary>
              <ul>
                <li><a href="proker.php" class="rounded-box">List Proker</a></li>
                <li><a class="rounded-box" onclick="tambahProkerOut()" >Tambah Proker</a></li>
              </ul>
            </details>

          </li>
          <li>
            <a href="laporan.php" class="rounded-box  "
              ><i class="fas fa-file-alt mr-3 "></i> Laporan</a
            >
          </li>
          <li>
            <a  class="rounded-box bg-slate-800 text-slate-200"
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
  function ubahAkun(){
    const closeChangeAKun = document.getElementById("ubahAkun");
    closeChangeAKun.classList.remove("hidden")
  }


  window.addEventListener("DOMContentLoaded", () => {
    const alertSuccess = document.getElementById("alertSuccess");
    const alertError = document.getElementById("alertError");
    const closeChangeAKun = document.getElementById("ubahAkun");
    if (alertSuccess || alertError) {
      setTimeout(() => {
        if (alertSuccess) {
          alertSuccess.style.transform = "translateY(100px)";
          alertSuccess.style.opacity = "1";
        }
        if (alertError) {
          alertError.style.transform = "translateY(100px)";
          alertError.style.opacity = "1";
        }
      }, 100);

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

      setTimeout(() => {
        const url = new URL(window.location);
        url.searchParams.delete("status");
        window.history.replaceState({}, document.title, url);
      }, 3200);

      setTimeout(() => {
        closeChangeAKun.classList.add("hidden");
      }, 0);
    }
  });

  function confirmLogout() {
      document.getElementById('confirmBox').classList.remove('hidden');
  }
</script>
  <script src="js/main.js"></script>
   <script src="js/script.js"></script>
  </body>
</html>