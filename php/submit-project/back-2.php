<?php

$projectName = $_POST["projectName"];
$projectDescription = $_POST["projectDescription"];
$projectType = $_POST["projectType"];
$name_file = $_POST["projectPicture"];

$filename = '../../asset/users/project/halaman/' . $name_file;

unlink($filename);

header("Location: ../../after/submit-project/submit-project-2.php?".
"projectName=$projectName&projectDescription=$projectDescription&projectType=$projectType");

?>