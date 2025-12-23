<?php
session_start();
include 'connection.php';

// Periksa apakah formulir telah dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['sbpw'];

    // Periksa apakah ada kolom yang kosong
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm_password)) {
        // Redirect dengan pesan kesalahan jika ada kolom yang kosong
        header("Location: ../sign-up.php?pesan=kosong");
        exit(); // Pastikan untuk keluar setelah melakukan redireksi
    }

    // Periksa apakah kata sandi cocok
    if ($password !== $confirm_password) {
        // Redirect dengan pesan kesalahan jika kata sandi tidak cocok
        header("Location: ../sign-up.php?pesan=sinkron");
        exit();
    }

    // Panggil fungsi insert_user
    $sql = "SELECT insert_user(?, ?, ?, ?) AS result";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $firstname, $lastname, $email, $password);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result['result']) {
        $sql2 = "SELECT * FROM user WHERE email=?";
        $stmt = $conn->prepare($sql2);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION["userId"] = $row["userId"];
            $_SESSION["status"] = "login";
            // Redirect ke halaman sign-in setelah pendaftaran berhasil
            header("Location: ../after/index.php");
            exit();
        } else {
            header("Location: ../sign-up.php?pesan=error");
            exit();
        }
    } else {
        // Redirect dengan pesan kesalahan jika gagal menyimpan data
        header("Location: ../sign-up.php?pesan=error");
        exit();
    }
}
?>
