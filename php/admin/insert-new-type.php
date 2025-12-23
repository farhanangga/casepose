<?php 
include '../connection.php';
echo $new_type = $_POST["type"];

if (empty($new_type)){
    header("location:../../admin/tambah-type.php?pesan=kosong");
}else {
    $sql = mysqli_query($conn, "INSERT INTO project_type(nama) VALUES ('$new_type')");
    header("location:../../admin/tambah-type.php?pesan=sukses");
}

?>