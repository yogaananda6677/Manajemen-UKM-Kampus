<?php
include("koneksi.php");
session_start();

$login_message = "";

if(isset($_SESSION["is_login"])){
    header("Location: dashbord.php");
    exit;
}

if(isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $data = $result->fetch_assoc();

        $_SESSION["id_adm"] = $data["ID_ADMIN"];
        $_SESSION["username"] = $data["USERNAME"];
        $_SESSION["nama_admin"] = $data["NAMA_ADMIN"];
        $_SESSION["is_login"] = true;
        $tets = print_r($_SESSION);

        header("Location: dashbord.php");
        exit;
    }
    else {
        $login_message = "Login gagal";
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
<body class="min-h-screen w-full bg-cover bg-center bg-no-repeat " style="background-image: url('img/bg-login2.jpg');">
    <div class=" bg-cover bg-center  h-screen w-full flex flex-col items-center justify-center px-4" ">
<form action="login.php" method="POST"
      class="rounded-2xl bg-gray-300/55 backdrop-blur-md text-slate-800 w-full max-w-md p-8 space-y-6 shadow-xl mx-2">
  <h2 class="text-center font-bold text-4xl">Login</h2>

  <div>
    <label for="username" class="block mb-1 font-semibold">Username</label>
    <input type="text" id="username" name="username" placeholder="Masukkan Username"
           class="w-full px-4 py-2 rounded-md bg-white/30 text-slate-800 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-emerald-500" required />
  </div>

  <div>
    <label for="password" class="block mb-1 font-medium">Password</label>
    <input type="password" id="password" name="password" placeholder="Masukkan Password"
           class="w-full px-4 py-2 rounded-md bg-white/30 text-slate-800 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-emerald-500" required />
  </div>

  <p class="text-red-500 text-sm font-medium mt-10 text-center"><?php echo $login_message ?></p>
  <button type="submit" name="login"
  class="w-full py-2 rounded-md  bg-emerald-500 hover:bg-emerald-700 transition-colors font-semibold text-white">
  Login
</button>
<a href="l_register.php" class="flex justify-center text-sm w-full text-slate-800">Belum Punya Akun?</a>

</form>

    

    </div>
</body>
</html>
