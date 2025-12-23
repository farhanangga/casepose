<?php
include '../php/connection.php';
$userId = $_SESSION["userId"];

$sqlp_1 = mysqli_query($conn," SELECT p.userId AS id_user,p.projectId AS id_project
,p.projectPicture AS foto_project,p.projectName AS nama_project, 
CONCAT(u.firstName,' ',u.lastName) AS nama_lengkap_2 FROM project p 
JOIN user u ON p.userId = u.userId WHERE p.userId = '$userId'");

$sqlp_2 = mysqli_query($conn,"SELECT u.userId AS id_user,u.profilePicture AS foto_profil
,p.userId AS id_user, p.projectId AS id_project, p.projectPicture AS foto_project
,p.projectName AS nama_project, CONCAT(u.firstName,' ',u.lastName) AS nama_lengkap_2 
FROM project p JOIN user u ON p.userId = u.userId ORDER BY RAND() LIMIT 9;");

// untuk menampilkan project yang dipromosikan agar tampil di div rekomendasi project
$rekomendasi_project = mysqli_query($conn,"SELECT u.userId AS id_user,u.profilePicture AS foto_profil
,p.userId AS id_user, p.projectId AS id_project, p.projectPicture AS foto_project
,p.projectName AS nama_project, CONCAT(u.firstName,' ',u.lastName) AS nama_lengkap_2 
FROM project p JOIN user u  ON p.userId = u.userId JOIN pricing pr ON p.projectId = pr.projectId 
ORDER BY RAND() LIMIT 3;");

$today = date('Y-m-d');

$top_3 = mysqli_query($conn,"SELECT 
        pr.dateExpired AS kadaluarsa, 
        u.userId AS id_user, 
        u.profilePicture AS foto_profil,
        p.projectId AS id_project, 
        p.projectPicture AS foto_project,
        p.projectName AS nama_project, 
        CONCAT(u.firstName, ' ', u.lastName) AS nama_lengkap_2 
    FROM 
        project p 
    JOIN 
        user u ON p.userId = u.userId 
    JOIN 
        pricing pr ON p.projectId = pr.projectId 
    WHERE 
        pr.pricingPackage != 1 
    ORDER BY 
        RAND() 
    LIMIT 3;;");

$sql_pricing = mysqli_query($conn,"SELECT p.projectId, p.projectName
FROM project p
JOIN user u ON p.userId = u.userId WHERE p.userId = '$userId'
");

$sql_pricing_2 = mysqli_query($conn, "SELECT p.projectId, p.projectName,pr.payment, pr.pricingPackage, pr.dateExpired 
    FROM project p 
    JOIN pricing pr ON p.projectId = pr.projectId 
    WHERE p.userId = '$userId'
");

$sql_pricing_limit = mysqli_query($conn, "SELECT p.projectId, p.projectName, pr.pricingPackage, pr.dateExpired , u.profilePicture
    FROM project p 
    JOIN pricing pr JOIN user u ON p.projectId = pr.projectId AND p.userId = u.userId
    WHERE p.userId = '$userId'
    ORDER BY RAND()
    LIMIT 3
");

?>