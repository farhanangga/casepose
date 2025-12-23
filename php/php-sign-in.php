<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        header("Location: ../sign-in.php?pesan=kosong");
        exit();
    }

    $sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["userId"] = $row["userId"];
        $_SESSION["status"] = "login";
        header("Location: ../after/index.php");
        exit();
    } else {
        header("Location: ../sign-in.php?pesan=gagal");
        exit();
    }

    mysqli_close($conn);
}
?>
