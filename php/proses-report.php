<?php 
include 'connection.php';
session_start();
echo$report = $_POST["report"];
echo$desc = $_POST["description"];
echo$projectId = $_POST["projectId"];
echo$userId = $_SESSION["userId"];

$sql = mysqli_query($conn,"INSERT  INTO report(reportType,reportDescription,reportStatus,projectId,userId) 
VALUES ('$report','$desc','ON RIVIEW','$projectId','$userId')");

header("location:../after/detail_project_viewer.php?idproject=$projectId&notif=sukses");

?>