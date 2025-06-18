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



          <?php
          if (!isset($_GET['id_ukm'])) {
                      header('Location: error.php');
                      
                  }
          $id = $_GET['id_ukm'];


          $batas = 5;
          $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
          $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

          $previous = $halaman - 1;
          $next = $halaman + 1;

          $sql = mysqli_query($conn, "SELECT 
              u.id_ukm ,
              u.nama_ukm 'Nama UKM',
              a.nama AS nama_anggota,
              a.tanggal_daftar Tanggal,
              r.nama_role AS role_kepengurusan
          FROM anggota a
          LEFT JOIN role_ukm r ON a.id_role = r.id_role AND a.id_ukm = r.id_ukm
          JOIN ukm u ON a.id_ukm = u.id_ukm
          WHERE a.id_ukm = '$id'
          ");
          $jumlah_data = mysqli_num_rows($sql);
          $total_halaman = ceil($jumlah_data / $batas);

          $hasil = mysqli_query($conn, "SELECT 
              u.id_ukm,
              a.nim 'NIM',
              u.nama_ukm 'Nama UKM',
              a.nama AS nama_anggota,
              a.tanggal_daftar Tanggal,
              r.nama_role AS role_kepengurusan
          FROM anggota a
          LEFT JOIN role_ukm r ON a.id_role = r.id_role AND a.id_ukm = r.id_ukm
          JOIN ukm u ON a.id_ukm = u.id_ukm
          WHERE a.id_ukm = '$id'
          LIMIT $halaman_awal, $batas
          ");

          $ukm_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_ukm FROM ukm WHERE id_ukm = '$id'"));
          $jumlah_row = mysqli_fetch_assoc(mysqli_query($conn, "select count(*) jumlah from ukm,anggota where ukm.id_ukm = anggota.id_ukm and ukm.id_ukm = '$id'"));
          ?>
<div class="flex items-center justify-between">
  <div class="">
      <h2 class="lg:text-xl text-sm my-4 font-semibold ">Nama UKM : <?php echo $ukm_row['nama_ukm'] ?></h2>
      <h2 class="lg:text-xl text-sm my-4 font-semibold ">Jumlah Anggota : <?php echo $jumlah_row['jumlah'] ?></h2>
      </div>
      <a href="tambah_role.php?id=<?= $id ?>" class="btn btn-primary">Tambah Role</a>
      </div>
          <div class="overflow-x-auto">
          <table class="table table-zebra w-full">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>NIM</th>
                          <th>Nama Anggota</th>
                          <th>Tanggal Daftar</th>
                          <th>Role</th>
                      </tr>
                  </thead>
      <?php
      $no = $halaman_awal + 1;
      while ($data = mysqli_fetch_array($hasil)) { ?>
                  <tbody>
                      <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $data["NIM"]; ?></td>
                          <td><?php echo $data["nama_anggota"]; ?></td>
                          <td><?php echo $data["Tanggal"]; ?></td>
                          <td><?php echo $data["role_kepengurusan"]; ?></td>
                          
                      </tr>
                  </tbody>
                  <?php } ?>
                  </table>
                </div>

          <?php
      $pagination = "<div class='join mt-4 flex justify-center'>";

// Tombol Previous
if ($halaman > 1) {
    $pagination .= "<button class='join-item btn btn-sm btn-outline' onclick='loadData(" . ($halaman - 1) . ")'>«</button>";
} else {
    $pagination .= "<button class='join-item btn btn-sm btn-disabled'>«</button>";
}

// Tombol Angka Halaman
for ($i = 1; $i <= $total_halaman; $i++) {
    $activeClass = $i === $halaman ? 'btn-active' : 'btn-outline';
    $pagination .= "<button class='join-item btn btn-sm $activeClass' onclick='loadData($i)'>$i</button>";
}

// Tombol Next
if ($halaman < $total_halaman) {
    $pagination .= "<button class='join-item btn btn-sm btn-outline' onclick='loadData(" . ($halaman + 1) . ")'>»</button>";
} else {
    $pagination .= "<button class='join-item btn btn-sm btn-disabled'>»</button>";
}

$pagination .= "</div>";
echo $pagination;
?>

<a class="btn btn-neutral" href="ukm.php">Kembali</a>



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
                <li><a href="ukm.php" class="rounded-box  bg-slate-800 text-slate-200">List UKM</a></li>
                <li><a onclick="tambahUkmOut()" class="rounded-box">Tambah UKM</a></li>
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
                <li><a onclick="tambahProkerOut()" class="rounded-box">Tambah Proker</a></li>
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


  <?php



function input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$success = "";
$error = "";

// Buat ID Otomatis
$query = mysqli_query($conn, "SELECT MAX(RIGHT(ID_ROLE, 5)) AS kode FROM role_ukm");
$data = mysqli_fetch_assoc($query);
$kodeBaru = $data['kode'] ? (int)$data['kode'] + 1 : 1;
$generatedId = 'RL' . str_pad($kodeBaru, 5, '0', STR_PAD_LEFT);

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = input($_POST["id_role"]);
    $nama = input($_POST["nama"]);
    $ukm = input($_POST["id_ukm"]);



    $sql = "INSERT INTO role_ukm (ID_ROLE, ID_UKM, NAMA_ROLE)
    VALUES ('$id', '$ukm', '$nama')";


    if (mysqli_query($conn, $sql)) {
        $success = "Data $nama berhasil disimpan!";
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







<script>
function loadData(page) {
    const urlParams = new URLSearchParams(window.location.search);
    const id_ukm = urlParams.get('id_ukm');
    window.location.href = `?id_ukm=${id_ukm}&halaman=${page}`;
}
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



      


    <script src="js/script.js"></script>
  </body>
</html>
