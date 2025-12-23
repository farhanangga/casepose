<?php 
include 'connection.php';

echo$pricingPackage = $_POST["pricingPackage"];
echo$payment = $_POST["payment"];
echo$projectId = $_POST["projectId"];

$date = date('Y-m-d');
$dateObject = new DateTime($date);
$dateObject->modify('+30 days');
$newDate = $dateObject->format('Y-m-d');
echo $newDate;

if (empty($payment)){
    header("location:../after/pricing-2.php?pesan=kosong&paket=$pricingPackage");
}else {
    $sql = mysqli_query($conn,"INSERT INTO pricing (pricingPackage,dateExpired,payment,projectId) 
    VALUES ('$pricingPackage','$newDate','$payment','$projectId')");

    header("location:../after/pricing-2.php?pesan=sukses&paket=$pricingPackage");
}


?>