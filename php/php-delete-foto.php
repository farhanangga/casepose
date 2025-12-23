<?php

$halaman = $_POST["halaman"];

if (isset($_POST["hapus-img"])) {
    // Ambil nama file dari input POST
    if (isset($_POST['name_file'])) {
        $name_file = $_POST['name_file'];
        $filename = '../asset/users/project/halaman/' . $name_file;

        // Debugging: Cek path file
        echo "Path file: $filename<br>";

        // Periksa apakah file ada
        if (file_exists($filename)) {
            // Debugging: File ditemukan
            echo "File ditemukan.<br>";

            // Periksa izin baca dan tulis
            if (is_readable($filename) && is_writable($filename)) {
                // Debugging: Izin cukup
                echo "Izin cukup untuk menghapus file.<br>";

                // Hapus file
                if (unlink($filename)) {

                    echo "File berhasil dihapus.<br>";

                    header("Location: $halaman");
                    exit; // Hentikan eksekusi skrip lebih lanjut
                } else {
                    // Debugging: Terjadi kesalahan saat menghapus file
                    echo "Terjadi kesalahan saat menghapus file '$filename'.<br>";
                }
            } else {
                // Debugging: Izin tidak mencukupi
                echo "File '$filename' tidak memiliki izin yang diperlukan untuk dihapus.<br>";
            }
        } else {
            // Debugging: File tidak ditemukan
            echo "File '$filename' tidak ditemukan.<br>";
            header("Location: $halaman");
        }
    } else {
        // Debugging: name_file tidak ada dalam POST
        echo "Tidak ada 'name_file' dalam POST.<br>";
    }
} else {
    // Debugging: hapus-img tidak di-set
    echo "Tidak ada 'hapus-img' dalam POST.<br>";
}
?>
