<?php 
include '../connection.php';
session_start();
$userId = $_SESSION["userId"];

$personal_web = $_POST["pw"];
$instagram = $_POST["ig"];
$github = $_POST["gh"];
$medium = $_POST["md"];
$x = $_POST["x"];
$linkedin = $_POST["ln"];


    function validateUrl($url) {
        return $url === "" || preg_match('/^https:\/\//', $url);
    }

    if (
        validateUrl($personal_web) &&
        validateUrl($instagram) &&
        validateUrl($github) &&
        validateUrl($medium) &&
        validateUrl($x) &&
        validateUrl($linkedin)
    ) {
        echo "Semua inputan valid.";

        $sql2 = mysqli_query($conn,"UPDATE user SET personalWeb = '$personal_web',
        instagram = '$instagram', linkedin = '$linkedin', github ='$github', medium = '$medium', x = '$x' 
        WHERE userId = '$userId'");

        $sql = mysqli_query($conn, "SELECT MAX(id) AS last_id FROM logactivity");
        $hasil = mysqli_fetch_assoc($sql);
        echo$last_id = $hasil["last_id"];
        $trigger = mysqli_query($conn,"UPDATE logactivity SET userId = '$userId' WHERE id = '$last_id'");

        header("Location: ../../after/edit profil/edit_profil_social.php?pesan=sukses");
        
    } else {
        header("Location: ../../after/edit profil/edit_profil_social.php?pesan=https");
    }

?>
