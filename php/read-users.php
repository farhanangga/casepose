<?php
$userId = $_SESSION["userId"];
$sql = mysqli_query($conn,"SELECT * FROM user WHERE userId ='$userId'");
$rows = mysqli_fetch_assoc($sql);

$sql_2 = mysqli_query($conn,"SELECT CONCAT(firstName,' ',lastName)AS nama_lengkap FROM user WHERE userId = '$userId'");
$nama_lengkap = mysqli_fetch_assoc($sql_2);

// potong link
$sql_3_1 = mysqli_query($conn,"SELECT CONCAT('...',RIGHT(personalWeb, 15) ) AS link_web FROM user WHERE userId = '$userId'");
$link_web = mysqli_fetch_assoc($sql_3_1);
$sql_3_2 = mysqli_query($conn,"SELECT CONCAT('...',RIGHT(instagram, 15) ) AS link_ig FROM user WHERE userId = '$userId'");
$link_ig = mysqli_fetch_assoc($sql_3_2);
$sql_3_3 = mysqli_query($conn,"SELECT CONCAT('...',RIGHT(linkedin, 15) ) AS link_linkedin FROM user WHERE userId = '$userId'");
$link_linkin = mysqli_fetch_assoc($sql_3_3);
$sql_3_4 = mysqli_query($conn,"SELECT CONCAT('...',RIGHT(github, 15) ) AS link_gh FROM user WHERE userId = '$userId'");
$link_gh= mysqli_fetch_assoc($sql_3_4);
$sql_3_5 = mysqli_query($conn,"SELECT CONCAT('...',RIGHT(medium, 15) ) AS link_mdm FROM user WHERE userId = '$userId'");
$link_mdm= mysqli_fetch_assoc($sql_3_5);
$sql_3_6 = mysqli_query($conn,"SELECT CONCAT('...',RIGHT(x, 15) ) AS link_x FROM user WHERE userId = '$userId'");
$link_x= mysqli_fetch_assoc($sql_3_6);

?>