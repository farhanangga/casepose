<?php
include '../connection.php';

echo$projectId = $_POST["projectId"];

$sql = mysqli_query($conn,"DELETE FROM report WHERE projectId = '$projectId'");

header("Location:../../admin/report.php")
?>