// Script sederhana untuk menutup sidebar di mobile saat item diklik (opsional)
document
  .querySelectorAll(".drawer-side .menu li a, .drawer-side .menu summary")
  .forEach((item) => {
    item.addEventListener("click", (e) => {
      const isDropdown = e.target.closest("details") !== null;
      if (isDropdown) {
        // Klik dalam dropdown, jangan tutup drawer
        return;
      }

      const drawerToggle = document.getElementById("my-drawer-2");
      if (drawerToggle && drawerToggle.checked && window.innerWidth < 1024) {
        drawerToggle.checked = false;
      }
    });
  });

function confirmLogout() {
  const box = document.getElementById("confirmBox");
  box.classList.remove("hidden");
}

// Tambah Data
function btnOpen() {
  const tambahData = document.getElementById("tambahData");

  tambahData.classList.remove("hidden");
}

// Cek apakah bukan di ukm.php

// function tambahAnggota() {
//   const tambahDataAnggota = document.getElementById("tambahDataAnggota");
//   tambahDataAnggota.classList.remove("hidden");
// }
