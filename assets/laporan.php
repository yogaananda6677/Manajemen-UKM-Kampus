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
              <a href="profil.php"><i class="fas fa-user"></i> Profile</a>
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
         
        <h4 class="text-center text-2xl font-bold  text-gray-600 rounded-2xl   
        ">Laporan</h4>
        <div class="flex justify-center lg:justify-end gap-4 py-5 ">
            <a href="export_excel.php" class="btn btn-accent">Download Excel</a>
            <form action="download_pdf.php" method="post">
                  <button class="btn btn-secondary">Download Pdf</button>
          </form>
        </div>
            <div class="overflow-x-auto  w-full">
            <table class="table table-zebra w-full table-fixed">

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
                <?php
            $result = mysqli_query($conn,
              "SELECT 
                        u.nama_ukm,
                        (SELECT a.nama 
                        FROM anggota a 
                        JOIN role_ukm r ON a.id_role = r.id_role 
                        WHERE a.id_ukm = u.id_ukm AND r.nama_role = 'ketua' LIMIT 1) AS ketua,
                        (SELECT COUNT(*) FROM anggota a2 WHERE a2.id_ukm = u.id_ukm) AS jumlah_anggota,
                        (SELECT COUNT(*) FROM proker p WHERE p.id_ukm = u.id_ukm) AS jumlah_proker
                    FROM ukm u
");

            $no = 1;
            while ($row = mysqli_fetch_array($result)) {
            ?>
            <tr>
              <td><?php echo $no++; ?></td>
              <td><?php echo $row['nama_ukm']; ?></td>
              <td><?php echo $row['jumlah_anggota']; ?></td>
              <td><?php echo $row['jumlah_proker']; ?></td>
              <td><?php echo $row['ketua']; ?></td>
            </tr>
            <?php } ?>
              </tbody>
            </table>
          </div>

         <!-- ISI KONTEN SELESAI -->

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
            <a class="rounded-box  bg-slate-800 text-slate-200"
              ><i class="fas fa-file-alt mr-3 "></i> Laporan</a
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
