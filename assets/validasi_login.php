<?php

    session_start();
    // Wajib Dicantumkan setiap page
    if (!isset($_SESSION['is_login'])) {
    header("Location: login.php");
    exit;

    


    // Cegah cache halaman ini
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
    header("Pragma: no-cache"); // HTTP 1.0
    header("Expires: 0"); // Proxies
}

?>