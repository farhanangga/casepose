<?php
$projectName = $_POST["projectName"];
$projectDescription = $_POST["projectDescription"];
$projectType = $_POST["projectType"];
$projectLink = $_POST["projectLink"];

$folder_p_picture = "../../asset/users/project/halaman/";

$name_file = $_FILES['projectPicture']['name'];
$path = $_FILES['projectPicture']['tmp_name'];
$file_size = $_FILES['projectPicture']['size'];

        // Cek apakah projectPicture tidak kosong
        if (empty($name_file)) {
            header('Location: ../../after/submit-project/submit-project-2.php?'
            ."projectName=$projectName&projectDescription=$projectDescription&projectType=$projectType&pesan=kosong");
        }else{
            // Cek ukuran file (5MB = 5 * 1024 * 1024 bytes)
            if ($file_size > 5 * 1024 * 1024) {
                header('Location: ../../after/submit-project/submit-project-2.php?'
                ."projectName=$projectName&projectDescription=$projectDescription&projectType=$projectType&pesan=5mb");
            }else{
                // Cek apakah nama file diakhiri dengan .jpg atau .png
                if (!preg_match('/\.(jpg|jpeg|png)$/i', $name_file)) {
                    header('Location: ../../after/submit-project/submit-project-2.php?'
                    ."projectName=$projectName&projectDescription=$projectDescription&projectType=$projectType&pesan=tipe");
                }else{
                    // Cek apakah projectLink diawali dengan https://
                    if (substr($projectLink, 0, 8) !== "https://" ) {
                        header('Location: ../../after/submit-project/submit-project-2.php?'
                        ."projectName=$projectName&projectDescription=$projectDescription&projectType=$projectType&pesan=https");
                    }else{
                        // Jika validasi lolos, pindahkan file ke folder tujuan
                        if (move_uploaded_file($path, $folder_p_picture.$name_file)) {
                            // Redirect ke halaman berikutnya jika berhasil
                            header("Location: ../../after/submit-project/submit-project-3.php?".
                            "projectName=$projectName&projectDescription=$projectDescription&projectType=$projectType".
                            "&projectLink=$projectLink&projectPicture=$name_file");
                            exit();
                        } else {
                            // Redirect jika gagal mengupload file
                            header('Location: ../../after/submit-project/submit-project-2.php?'.
                            "projectName=$projectName&projectDescription=$projectDescription&projectType=$projectType&pesan=upload");
                        }
                    }
                }
            }
        }

?>
