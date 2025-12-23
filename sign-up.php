<?php
require_once 'vendor/autoload.php';

// Konfigurasi API Google
$clientID = '622703433714-k4aa149lv5o9n5j1ftoed7tva6l05019.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/casepose/casePose/sign-up.php';

// Inisialisasi Google Client
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Koneksi ke database
include 'php/connection.php';

// Proses autentikasi jika ada parameter "code" di URL
if (isset($_GET['code'])) {
    session_start();
    try {
        // Ambil token autentikasi
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token['access_token']);

        // Dapatkan informasi user
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $email = $google_account_info->email;
        $name = $google_account_info->name;
        $userId = $google_account_info->id;

        // Pisahkan nama depan dan nama belakang
        $firstName = explode(' ', $name)[0];
        $lastName = explode(' ', $name)[1] ?? '';

        // Periksa apakah email sudah ada di database
        $query = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            // Jika email sudah terdaftar, kembali ke halaman sign-up dengan pesan error
            header('Location: sign-up.php?pesan=email');
            exit();
        } else {
            // Jika email belum terdaftar, tambahkan ke database
            $insertQuery = $conn->prepare("INSERT INTO user (userId, firstname, lastname, email) VALUES (?, ?, ?, ?)");
            $insertQuery->bind_param("ssss", $userId, $firstName, $lastName, $email);

            if ($insertQuery->execute()) {
                $_SESSION['status'] = "login";
                $_SESSION['userId'] = $userId;
                // Redirect ke halaman setelah berhasil mendaftar
                header('Location: after/index.php');
                exit();
            } else {
                throw new Exception("Gagal menambahkan data pengguna: " . $conn->error);
            }
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="asset/logo/logo_1.png">
    <title>casePose | Sign Up</title>
    <link rel="stylesheet" href="style/global.css">
    <link rel="stylesheet" href="style/style-sign-in.css">
</head>

<body>
    <div class="container_login">
        <div class="container_login_1">
            <label class="label-cp-2 roboto bold">CREATE your</label><br>
            <label class="label-cp-2 roboto bold">casePose account</label>
        </div>
        <div class="container_login_3">
            <div class="head-login-rps">
                <div class="logo-case-pose"></div>
                <div class="head-login-rps-label">
                    <label for="">casePose</label>
                </div>
            </div>
            <div class="label-sign-in">
                <h1>Sign Up</h1>
            </div>
            <div class="label-welcome">
                <p class="roboto grey">Create your account now!</p>
            </div>
            <form method="POST" action="php/php-sign-up.php">
                <div class="container_reg_1">
                    <div class="container_reg_1_1">
                        <div class="label-input-2">
                            <label for="firstname" class="roboto bold label-input">First name</label>
                        </div>
                        <input
                            name="firstname"
                            type="text"
                            class="input_4"
                            placeholder="Click here....."
                            id="firstname">
                    </div>
                    <div class="container_reg_1_2">
                        <div class="label-input-2">
                            <label for="lastname" class="roboto bold ">Last name</label>
                        </div>
                        <input
                            name="lastname"
                            type="text"
                            class="input_4"
                            placeholder="Click here....."
                            id="lastname">
                    </div>
                </div>
                <div class="label-input-2">
                    <label for="email" class="roboto bold label-input">Email</label>
                </div>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="input_3"
                    placeholder="Click here.....">
                <div class="label-input-2">
                    <label for="password" class="roboto bold ">Password</label>
                </div>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="input_3"
                    placeholder="Click here.....">
                <div class="label-input-2">
                    <label for="sbpw" class="roboto bold ">Confirm password</label>
                </div>
                <input
                    type="password"
                    id="sbpw"
                    name="sbpw"
                    class="input_3"
                    placeholder="Click here.....">
                    <div class="massage">
                        <label class="roboto bold red">
                            <?php 
                            if (isset($_GET['pesan'])) {
                                if ($_GET['pesan'] === 'email') {
                                    echo "email is registered.";
                                }else if($_GET['pesan'] == "kosong"){
                                    echo "Make sure the input data is filled in completely";
                                } else if($_GET['pesan'] == "sinkron"){
                                    echo "Your password is not in sync";
                                } else {
                                    echo htmlspecialchars($_GET['pesan']);
                                }
                            }
                            ?>
                        </label><br>
                    </div>
                <button type="submit" id="SignUpbutton" class="button_1">Sign Up</button>
            </form>
            <!-- Tombol Google Sign-Up -->
            <a href="<?= htmlspecialchars($client->createAuthUrl()) ?>" class="button_g">
                    <img src="asset/logo/google.png" alt="Google Logo" style="width:20px; height:20px; margin-right:10px;">
                    Sign in with Google
                </a>
            <div class="to-sign-in">
                <p class="roboto grey" style="text-align: center;">Have an account?
                    <a href="sign-in.php" class="roboto bold" style="color: rgb(39, 115, 255);">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
