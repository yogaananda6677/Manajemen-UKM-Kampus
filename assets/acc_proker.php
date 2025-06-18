<?php
include("koneksi.php");


if (!isset($_GET['id'])) {
    header('Location: error.php');
    exit;
}


$id = $_GET['id'];

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: error.php');
    exit;
}


$sql = "SELECT * FROM proker WHERE ID_PROKER = '$id'";
$query = mysqli_query($conn, $sql);
$proker_data = mysqli_fetch_assoc($query);

if (!$proker_data) {
    die("Data tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ACC PROKER</title>
    <link rel="stylesheet" href="../css/dist/output.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
  </head>
  <body>
    <div
      class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center px-4"
    >
      <form
        action="aksi-acc_proker.php"
        method="post"
        class="w-full max-w-md bg-white p-6 rounded-2xl shadow-xl space-y-5 border border-gray-200"
      >
        <h3 class="text-2xl font-bold text-center text-green-700">
          Konfirmasi Proker Sukses
        </h3>
        <p class="text-center text-gray-700">
          Apakah Anda yakin ingin menyetujui Proker berikut?
        </p>

        <input
          type="hidden"
          name="id_proker"
          value="<?= htmlspecialchars($proker_data['ID_PROKER']); ?>"
        />

        <div
          class="bg-gray-100 rounded-xl p-4 text-center text-gray-800 font-medium"
        >
          <span class="text-lg"
            ><?= htmlspecialchars($proker_data['NAMA_PROKER']); ?>
            (<?= htmlspecialchars($proker_data['ID_PROKER']); ?>)</span
          >
        </div>

        <div class="flex justify-between gap-3 pt-2">
          <button
            type="submit"
            class="w-1/2 bg-green-600 hover:bg-green-700 text-white py-2 rounded-xl font-semibold transition-all"
          >
            Setuju
          </button>
          <a
            href="proker.php"
            class="w-1/2 bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 rounded-xl text-center font-semibold transition-all"
          >
            Batal
          </a>
        </div>
      </form>
    </div>
  </body>
</html>
