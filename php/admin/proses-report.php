<?php
include '../connection.php';

echo$projectId = $_POST["projectId"];
echo$reportStatus = $_POST["status"];

$sql = mysqli_query($conn,"UPDATE report SET reportStatus = '$reportStatus'WHERE projectId = '$projectId'");

header("Location:../../admin/report.php")
?>