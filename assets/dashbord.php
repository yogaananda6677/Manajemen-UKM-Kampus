<?php
include("koneksi.php");
include("validasi_login.php");
$nama_admin = $_SESSION['nama_admin'];
// Cari Jumlah UKM
$sql = "SELECT COUNT(*) as total_ukm FROM ukm";
$result = $conn->query($sql);
if(!$result) {
    die("Query ukm error: " . $conn->error);
}
$data = $result->fetch_assoc();
$total_ukm = $data['total_ukm'];

// Cari Jumlah ANGGOTA
$sql = "SELECT COUNT(*) as total_anggota FROM anggota";
$result = $conn->query($sql);
if(!$result) {
    die("Query anggota error: " . $conn->error);
}
$data = $result->fetch_assoc();
$total_anggota = $data['total_anggota'];


// Cari Jumlah proker sukses
$sql = "SELECT COUNT(*) as total_proker_sukses FROM proker WHERE status_proker = 'sukses'";
$result = $conn->query($sql);
if(!$result) {
    die("Query proker error: " . $conn->error);
}
$data = $result->fetch_assoc();
$total_proker_sukses = $data['total_proker_sukses'];



// Cari Jumlah proker sukses
$sql = "SELECT COUNT(*) as total_proker_proses FROM proker WHERE status_proker = 'proses'";
$result = $conn->query($sql);
if(!$result) {
    die("Query proker proses error: " . $conn->error);
}
$data = $result->fetch_assoc();
$total_proker_proses = $data['total_proker_proses'];


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
                <li><a href="profil.php">Profile</a></li>
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
         
          
        <!-- ISI KONTEN -->
         <h1 class="text-2xl text-slate-900 font-bold text-center">Selamat Datang! <span class="text-cyan-500"><?= $nama_admin ?></span></h1>
         <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 mt-7"
          >
          <!-- CARD 1 -->
          <div class="bg-white shadow-lg rounded-xl p-10 flex items-center space-x-4">
            <div class="bg-amber-100 text-amber-700 w-18 flex items-center justify-center h-18 rounded-full">
            <i class="fas fa-handshake text-3xl"></i>
            </div>

            <div>
                <div class="text-2xl font-bold text-gray-800"><?php echo $total_ukm ?></div>
                <div class="text-sm text-gray-500">UKM</div>
            </div>
            </div>
            
            <!-- CARD 2 -->
            <div class="bg-white shadow-lg rounded-xl p-10 flex items-center space-x-4">
              <div class=" bg-indigo-100 text-indigo-500 w-18 flex items-center justify-center h-18 rounded-full">
              <i class="fas fa-user-group text-3xl"></i>
              </div>
  
              <div>
                  <div class="text-2xl font-bold text-gray-800"><?php echo $total_anggota ?></div>
                  <div class="text-sm text-gray-500">Anggota</div>
              </div>
              </div>
              
              <!-- CARD 3 -->
              <div class="bg-white shadow-lg rounded-xl p-10 flex items-center space-x-4">
                <div class="bg-green-100 text-green-500 w-18 flex items-center justify-center h-18 rounded-full">
                <i class="fas fa-chart-line text-3xl"></i>
                </div>
    
                <div>
                    <div class="text-2xl font-bold text-gray-800"><?php echo $total_proker_sukses ?></div>
                    <div class="text-sm text-gray-500">Proker Sukses</div>
                </div>
                </div>
                
                <!-- CARD 1 -->
                <div class="bg-white shadow-lg rounded-xl p-10 flex items-center space-x-4">
                  <div class="bg-yellow-100 text-amber-600 w-18 flex items-center justify-center h-18 rounded-full">
                  <i class="fas fa-spinner text-3xl"></i>
                  </div>
      
                  <div>
                      <div class="text-2xl font-bold text-gray-800"><?php echo $total_proker_proses?></div>
                      <div class="text-sm text-gray-500">Proker Proses</div>
                  </div>
                  </div>
        </div>

        <!-- 5 Data UKM anggota terbanyak --> 
            <div class="max-w-7xl mx-auto p-4">
  <!-- Judul -->
  <h4 class="text-center text-2xl font-bold my-10 bg-slate-200 text-gray-600 p-5 rounded-2xl w-full sm:w-2/3 lg:w-1/3 mx-auto">
    UKM PALING AKTIF
  </h4>

  <!-- Tabel responsif -->
  <div class="overflow-x-auto">
    <table class="table table-zebra w-full">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama UKM</th>
          <th>Jumlah Anggota</th>
          <th>Jumlah Proker</th>
          <th>Poin Keaktifan</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $hasil = mysqli_query($conn, '
          SELECT 
            ukm.nama_ukm AS Nama,
            COUNT(DISTINCT proker.id_proker) AS Jumlah_Proker,
            COUNT(DISTINCT anggota.id_anggota) AS Jumlah_Anggota,
            (2 * COUNT(DISTINCT proker.id_proker) + 1 * COUNT(DISTINCT anggota.id_anggota)) AS Skor_Aktivitas
          FROM ukm
          LEFT JOIN proker ON ukm.id_ukm = proker.id_ukm
          LEFT JOIN anggota ON ukm.id_ukm = anggota.id_ukm
          GROUP BY ukm.id_ukm, ukm.nama_ukm
          ORDER BY Skor_Aktivitas DESC
          LIMIT 5;
        ');
        $no = 1;
        while ($data = mysqli_fetch_array($hasil)) { ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $data["Nama"]; ?></td>
            <td><?php echo $data["Jumlah_Anggota"]; ?></td>
            <td><?php echo $data["Jumlah_Proker"]; ?></td>
            <td><?php echo $data["Skor_Aktivitas"]; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>



           
         <!-- ISI KONTEN SELESAI -->
<?php include('tambah_ukm.php'); ?>
        </main>

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
            <a href="#" class="active rounded-box group bg-slate-800 text-slate-200"
              ><i class="fas fa-tachometer-alt mr-3 text-slate-200 "></i> Dashboard</a
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
            <details class="dropdown dropdown-end">
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
            <a href="laporan.php" class="rounded-box"
              ><i class="fas fa-file-alt mr-3"></i> Laporan</a
            >
          </li>
          <li>
            <a href="profil.php" class="rounded-box"
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
</script>
  <script src="js/main.js"></script>
   <script src="js/script.js"></script>
  </body>
</html>
