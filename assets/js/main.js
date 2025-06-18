function tambahAnggotaOut() {
  window.location.href = "anggota.php?tambah=1";
  // masuk ke angggota.php
  const tambahAnggota = document.getElementById("tambahDataAnggota");
  tambahAnggota.classList.remove("hidden");
}

function tambahAnggota() {
  // masuk ke angggota.php
  const tambahAnggota = document.getElementById("tambahDataAnggota");
  tambahAnggota.classList.remove("hidden");
}

function tambahData() {
  const tambahUkm = document.getElementById("tambahData");
  tambahUkm.classList.remove("hidden");
}

function tambahUkmOut() {
  window.location.href = "ukm.php?tambah=1";
}

function tambahProker() {
  const tambahProker = document.getElementById("tambahDataProker");
  tambahProker.classList.remove("hidden");
}
function tambahProkerOut() {
  window.location.href = "proker.php?tambah=1";
}

function tambahRole() {
  alert("anjai");
  const tambahProker = document.getElementById("tambahDataRole");
  tambahProker.classList.remove("hidden");
}
