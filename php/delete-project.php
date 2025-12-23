<?php
include 'connection.php';
session_start();
$userId = $_SESSION["userId"];

$projectId = $_POST["projectId"];

// Periksa apakah ada entri di tabel pricing yang menggunakan projectId yang akan dihapus
$sql_check_pricing = "SELECT COUNT(*) as count FROM pricing WHERE projectId = '$projectId'";
$result_check_pricing = mysqli_query($conn, $sql_check_pricing);

if ($result_check_pricing) {
    $row = mysqli_fetch_assoc($result_check_pricing);
    $pricing_count = $row['count'];

    // Jika ada entri di tabel pricing, hapus entri-entri tersebut terlebih dahulu
    if ($pricing_count > 0) {
        $sql_delete_pricing = "DELETE FROM pricing WHERE projectId = '$projectId'";
        $result_delete_pricing = mysqli_query($conn, $sql_delete_pricing);

        $sql2 = mysqli_query($conn, "SELECT MAX(id) AS last_id FROM logactivity");
        $hasil = mysqli_fetch_assoc($sql2);
        echo$last_id = $hasil["last_id"];
        $trigger = mysqli_query($conn,"UPDATE logactivity SET userId = '$userId' WHERE id = '$last_id'");

        if (!$result_delete_pricing) {
            // Handle error if deletion from pricing table fails
            echo "Error deleting entries from pricing table: " . mysqli_error($conn);
            exit();
        }
    }

    // Setelah menghapus entri-entri pricing yang berkaitan, hapus proyek dari tabel project
    $sql_delete_project = "DELETE FROM project WHERE projectId = '$projectId'";
    $result_delete_project = mysqli_query($conn, $sql_delete_project);

    $sql2 = mysqli_query($conn, "SELECT MAX(id) AS last_id FROM logactivity");
        $hasil = mysqli_fetch_assoc($sql2);
        echo$last_id = $hasil["last_id"];
        $trigger = mysqli_query($conn,"UPDATE logactivity SET userId = '$userId' WHERE id = '$last_id'");

    if (!$result_delete_project) {
        // Handle error if deletion from project table fails
        echo "Error deleting project from project table: " . mysqli_error($conn);
        exit();
    }

    // Redirect to the desired page after successful deletion
    header("Location:../after/profil.php");
} else {
    // Handle error if checking pricing table fails
    echo "Error checking pricing table: " . mysqli_error($conn);
    exit();
}
?>
