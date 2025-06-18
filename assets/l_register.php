<?php
include("koneksi.php");
session_start();

$login_message = "";
$login_succes = "";
function generateRoleId($conn) {
    $query = mysqli_query($conn, "SELECT MAX(RIGHT(ID_ADMIN, 3)) AS kode FROM admin");
    $data = mysqli_fetch_assoc($query);
    $kodeBaru = $data['kode'] ? (int)$data['kode'] + 1 : 1;
    $generatedId = 'A' . str_pad($kodeBaru, 3, '0', STR_PAD_LEFT);


    $cek = mysqli_query($conn, "SELECT 1 FROM admin WHERE ID_ADMIN = '$generatedId'");
    if (mysqli_num_rows($cek) > 0) {
        return generateRoleId($conn); 
    }

    return $generatedId;
}


$generatedId = generateRoleId($conn);

if (isset($_POST['register'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id_admin']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $nama = mysqli_real_escape_string($conn, $_POST['name']);


    $check_username = "SELECT username FROM admin WHERE username = '$username'";
    $hasil_check = $conn->query($check_username);

    if ($hasil_check->num_rows > 0) {

        $login_message = "Username sudah digunakan!";

    } else {


        $sql = "INSERT INTO admin (ID_ADMIN, USERNAME, PASSWORD, NAMA_ADMIN) 
                VALUES ('$id', '$username', '$password', '$nama')";
        $result = $conn->query($sql);

        if ($result) {
            $login_succes = "Register Sukses";
        } else {
            $login_message = "Register gagal: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
        <link rel="stylesheet" href="../css/dist/output.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">

  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    <!-- Font Awesome 6.5.0 – CDN resmi dari cdnjs -->
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>

</head>
<body class="h-screen w-full bg-cover bg-center" style="background-image: url('img/bg-regis2.jpg')">
    <div class=" bg-cover bg-center  h-screen w-full flex flex-col items-center justify-center px-4" ">
<form action="l_register.php" method="POST"
      class="rounded-2xl bg-black/20 backdrop-blur-md text-white w-full max-w-md p-8 space-y-6 shadow-xl">
  <h2 class="text-center font-bold text-4xl">Register</h2>

  <div class="hidden">
    <label for="id_admin" class="block mb-1 font-medium">ID ADMIN</label>
    <input type="text" id="id_admin" name="id_admin" placeholder="Masukkan Username"
           class="w-full px-4 py-2 rounded-md bg-white/30 text-white placeholder-white/90 focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo $generatedId ?>" required />
  </div>
  
  <div>
    <label for="name" class="block mb-1 font-medium">Name</label>
    <input type="text" id="name" name="name" placeholder="Masukkan Nama"
           class="w-full px-4 py-2 rounded-md bg-white/30 text-white placeholder-white/90 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
  </div>

  <div>
    <label for="username" class="block mb-1 font-medium">Username</label>
    <input type="text" id="username" name="username" placeholder="Masukkan Username"
           class="w-full px-4 py-2 rounded-md bg-white/30 text-white placeholder-white/90 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
  </div>


  <div>
    <label for="password" class="block mb-1 font-medium">Password</label>
    <input type="password" id="password" name="password" placeholder="Masukkan Password"
           class="w-full px-4 py-2 rounded-md bg-white/30 text-white placeholder-white/90 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
  </div>

  <p class="text-red-500 text-sm font-semibold mt-10 text-center"><?php echo $login_message;?></p>
  <p class="text-green-400 text-sm font-semibold mt-10 text-center"><?php echo $login_succes; ?></p>
  <button type="submit" name="register"
  class="w-full py-2 rounded-md  bg-blue-600 hover:bg-blue-700 transition-colors font-semibold">
  Register
</button>
<a href="login.php" class="flex justify-center text-sm w-full text-slate-300">Sudah Punya Akun?</a>
</form>

    

    </div>
</body>
</html>
