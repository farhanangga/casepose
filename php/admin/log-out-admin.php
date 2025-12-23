<?php
session_start();

// Menghapus semua data sesi
session_unset();

// Menghancurkan sesi
session_destroy();

// Redirect ke halaman login atau halaman lain yang sesuai
header("Location: ../../admin/index.php?pesan=berhasil-logout");
exit();
?>
