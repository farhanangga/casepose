<?php
require_once 'vendor/autoload.php';

// Konfigurasi API Google
$clientID = '622703433714-k4aa149lv5o9n5j1ftoed7tva6l05019.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/casepose/casePose/sign-in.php';

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

        // Periksa apakah email ada di database
        $query = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            // Email ditemukan, set sesi login
            $user = $result->fetch_assoc();
            $_SESSION['status'] = "login";
            $_SESSION['userId'] = $user['userId'];

            // Redirect ke halaman setelah login
            header('Location: after/index.php');
            exit();
        } else {
            // Email tidak ditemukan, redirect ke halaman login dengan pesan error
            header('Location: sign-in.php?pesan=email');
            exit();
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
    <title>casePose | Sign In</title>
    <link rel="stylesheet" href="style/global.css">
    <link rel="stylesheet" href="style/style-sign-in.css">
</head>

<body>
    <div class="container_login">
        <div class="container_login_1">
            <label class="label-cp roboto bold">WELCOME to</label><br>
            <label class="label-cp roboto bold">casePose</label>
        </div>
        <div class="container_login_2">
            <a href="index.php" class="back-button-click">
                <svg xmlns="http://www.w3.org/2000/svg" class="back-button">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                </svg>
            </a>
            <div class="head-login-rps">
                <div class="logo-case-pose"></div>
                <div class="head-login-rps-label">
                    <label for="">casePose</label>
                </div>
            </div>
            <div class="label-sign-in">
                <h1>Sign in</h1>
            </div>
            <div class="label-welcome">
                <label class="roboto grey">Welcome back! Please login to your account.</label>
            </div>
            <form method="post" action="php/php-sign-in.php">
                <div class="label-input">
                    <label for="email" class="roboto bold">Email</label>
                </div>
                <input type="text" id="email" name="email" class="input_1" placeholder="Click here.....">
                <div class="label-input">
                    <label for="password" class="roboto bold">Password</label><br>
                </div>
                <input type="password" id="password" name="password" class="input_1" placeholder="Click here.....">
                <div class="massage">
                    <label class="roboto bold red">
                        <?php 
                        if(isset($_GET['pesan'])){
                            if($_GET['pesan'] == "gagal"){
                                echo "Invalid email or password";
                            }else if($_GET['pesan'] == "kosong"){
                                echo "Make sure the input data is filled in completely";
                            }else if($_GET['pesan'] == "belum_login"){
                                echo "You should Login first";
                            }else if($_GET['pesan'] == "email"){
                                echo "The account has not been registered yet";
                            }
                        }?>
                    </label><br>
                </div>
                <button type="submit" id="signInButton" class="button_1">Sign in</button>
                <a href="<?= htmlspecialchars($client->createAuthUrl()) ?>" class="button_g">
                    <img src="asset/logo/google.png" alt="Google Logo" style="width:20px; height:20px; margin-right:10px;">
                    Sign in with Google
                </a>
                <div class="to-sign-in">
                    <p class="grey" style="text-align: center;">New user? <a href="sign-up.php" class="roboto bold"
                            style="color: rgb(39, 115, 255)">Sign up</a></p>
                </div>
            </form>
            <!-- Tombol Google Sign-In -->
            
        </div>
    </div>
</body>

</html>
