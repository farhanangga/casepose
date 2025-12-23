<?php
session_start();
include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    echo$username = $_POST["username"];
    echo$password = $_POST["password"];

    if (empty($username) || empty($password)) {
        header("Location: ../../admin/index.php?pesan=kosong");
        exit();
    }

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["userId"] = $row["userId"];
        $_SESSION["status"] = "loginadmin";
        header("Location: ../../admin/home.php");
        exit();
    } else {
        header("Location: ../../admin/index.php?pesan=gagal");
        exit();
    }

    mysqli_close($conn);
}
?>
