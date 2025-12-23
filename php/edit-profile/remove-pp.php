<?php
include '../connection.php';
session_start();
$userId = $_SESSION["userId"];

echo $_POST["projectPicture"];
$foto_profil = $_POST["projectPicture"];


if($foto_profil == "" ){
    header("location:../../after/edit profil/edit_profil_general.php?pesan=already-removed");
}else {
    $sql2 = mysqli_query($conn,"UPDATE user SET profilePicture = '' ");

    $sql = mysqli_query($conn, "SELECT MAX(id) AS last_id FROM logactivity");
    $hasil = mysqli_fetch_assoc($sql);
    echo$last_id = $hasil["last_id"];
    $trigger = mysqli_query($conn,"UPDATE logactivity SET userId = '$userId' WHERE id = '$last_id'");
    
    header("location:../../after/edit profil/edit_profil_general.php?pesan=succes-remove-pp");
}

?>