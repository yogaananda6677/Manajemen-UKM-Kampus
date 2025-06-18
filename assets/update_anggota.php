<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Anggota</title>

    <link rel="stylesheet" href="../css/dist/output.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    </head>
<body>
<?php
include("koneksi.php");

// Pastikan ada id_anggota di URL
if (!isset($_GET['id'])) {
    header('Location: error.php'); // Atau redirect ke halaman daftar anggota
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM anggota WHERE ID_ANGGOTA = '$id'";
$query = mysqli_query($conn, $sql);
$anggota_data = mysqli_fetch_assoc($query);


if (!$anggota_data) {
    header('Location: error.php');
    exit;
}

$id_jurusan_terpilih = $anggota_data["ID_JURUSAN"];
$id_ukm_terpilih = $anggota_data["ID_UKM"]; 
$id_role_terpilih = $anggota_data["ID_ROLE"];
?>

<div id="updatehDataAnggota" class="fixed top-0 left-0 w-full h-full bg-black/50 z-50 flex items-center justify-center">

    <form action="aksi-update_anggota.php" method="post" class="p-6 rounded-2xl border bg-white space-y-4 max-w-sm w-full shadow-xl">

        <h3 class="text-2xl font-bold text-center">Form Update Anggota</h3>

        <input type="hidden" name="id_anggota" value="<?php echo htmlspecialchars($anggota_data['ID_ANGGOTA']); ?>">

        <div class="form-control">
            <label for="nama" class="label">Nama</label>
            <input required id="nama" name="nama" type="text" class="input rounded-xl input-bordered w-full" value="<?php echo htmlspecialchars($anggota_data['NAMA']); ?>" />
        </div>
        <div class="form-control">
            <label for="nim" class="label">Nim</label>
            <input required id="nim" name="nim" type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');" class="input rounded-xl input-bordered w-full" value="<?php echo htmlspecialchars($anggota_data['NIM']); ?>"/>
        </div>

        <div class="form-control">
            <label for="jurusan" class="label">Pilih Jurusan</label>
            <select id="jurusan" required name="id_jurusan" class="select rounded-xl input-bordered w-full">
                <option value="" disabled <?php echo ($id_jurusan_terpilih == "") ? "selected" : ""; ?>>Pilih Jurusan</option>
                <?php
                    // Pastikan koneksi.php sudah include di awal
                    $jurusan_q = mysqli_query($conn, "SELECT * FROM jurusan");
                    while ($row = mysqli_fetch_assoc($jurusan_q)) {
                        $selected = ($row['ID_JURUSAN'] == $id_jurusan_terpilih) ? "selected" : "";
                        echo "<option value='".htmlspecialchars($row['ID_JURUSAN'])."' ".$selected.">".htmlspecialchars($row['NAMA_JURUSAN'])."</option>";
                    }
                ?>
            </select>
        </div>

        <div class="form-control">
            <label for="ukm" class="label">Pilih UKM</label>
            <select id="ukm" required name="id_ukm" class="select rounded-xl input-bordered w-full">
                <option value="" disabled <?php echo ($id_ukm_terpilih == "") ? "selected" : ""; ?>>Pilih UKM</option>
                <?php
                    // Pastikan koneksi.php sudah include di awal
                    $ukm_q = mysqli_query($conn, "SELECT * FROM ukm");
                    while ($row = mysqli_fetch_assoc($ukm_q)) {
                        $selected = ($row['ID_UKM'] == $id_ukm_terpilih) ? "selected" : "";
                        echo "<option value='".htmlspecialchars($row['ID_UKM'])."' ".$selected.">".htmlspecialchars($row['NAMA_UKM'])."</option>";
                    }
                ?>
            </select>
        </div>
        
        <div class="form-control">
            <label for="role" class="label">Pilih Role</label>
            <select required id="role" name="id_role" class="select rounded-xl input-bordered w-full">
                <option value="" disabled selected class="text-slate-700">Pilih Role</option>
                </select>
        </div>

        <div class="form-control">
            <label for="tanggal" class="label">Tanggal Daftar</label>
            <input required id="tanggal" name="tanggal_daftar" type="date" class="input rounded-xl input-bordered w-full" value="<?php echo htmlspecialchars($anggota_data['TANGGAL_DAFTAR']); ?>" />
        </div>

        <button type="submit" class="btn btn-primary w-full rounded-xl">Simpan</button>
        <a href="anggota.php" type="button" class="btn btn-neutral w-full rounded-xl">Batal</a>

    </form>
</div>

<script>
    const ukmSelect = document.querySelector('select[name="id_ukm"]');
    const roleSelect = document.querySelector('select[name="id_role"]');
    const selectedUKMFromDB = "<?php echo htmlspecialchars($id_ukm_terpilih); ?>";
    const selectedRoleFromDB = "<?php echo htmlspecialchars($id_role_terpilih); ?>";

    // Fungsi untuk memuat role berdasarkan UKM
    function loadRoles(ukmId, selectedRoleId = null) {
        roleSelect.innerHTML = '<option disabled selected>Loading...</option>';

        fetch(`get_role_by_ukm.php?id_ukm=${ukmId}`)
            .then(res => res.json())
            .then(data => {
                roleSelect.innerHTML = '<option value="" disabled>Pilih Role</option>'; // Opsi default

                if (data.length === 0) {
                    roleSelect.innerHTML += `<option disabled>Tidak ada role</option>`;
                    roleSelect.value = ""; // Pastikan pilihan default terpilih
                } else {
                    let hasSelected = false;
                    data.forEach(role => {
                        const option = document.createElement('option');
                        option.value = role.id;
                        option.textContent = role.nama;
                        if (selectedRoleId && role.id == selectedRoleId) { // Gunakan == untuk perbandingan tipe data
                            option.selected = true;
                            hasSelected = true;
                        }
                        roleSelect.appendChild(option);
                    });
                    // Jika tidak ada role yang cocok dari DB, set kembali ke "Pilih Role"
                    if (!hasSelected && selectedRoleId) {
                        roleSelect.value = ""; 
                        roleSelect.querySelector('option[value=""]').selected = true; // Select the "Pilih Role" option
                    } else if (hasSelected) {
                        // Jika ada yang terpilih, pastikan nilainya sesuai
                        roleSelect.value = selectedRoleId;
                    } else {
                        // Jika tidak ada role dari DB dan tidak ada yang terpilih, default ke "Pilih Role"
                         roleSelect.value = ""; 
                         roleSelect.querySelector('option[value=""]').selected = true;
                    }
                }
            })
            .catch(err => {
                console.error("Gagal ambil data role:", err);
                roleSelect.innerHTML = '<option disabled selected>Error ambil role</option>';
                roleSelect.value = ""; // Reset jika error
            });
    }

    // Event listener saat UKM berubah
    ukmSelect.addEventListener('change', function () {
        const selectedUKM = this.value;
        loadRoles(selectedUKM); // Panggil tanpa selectedRoleId, karena user memilih baru
    });

    // Panggil fungsi loadRoles saat halaman pertama kali dimuat
    // Ini akan mengisi dropdown role dengan role yang sudah tersimpan di database
    if (selectedUKMFromDB) {
        loadRoles(selectedUKMFromDB, selectedRoleFromDB);
    } else {
        // Jika ID UKM dari DB kosong (misalnya data baru), pastikan role select kosong
        roleSelect.innerHTML = '<option value="" disabled selected class="text-slate-700">Pilih Role</option>';
    }

</script>

</body>
</html>