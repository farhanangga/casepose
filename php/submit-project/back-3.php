<?php

$projectName = $_POST["projectName"];
$projectDescription = $_POST["projectDescription"];
$projectType = $_POST["projectType"];
$projectLink = $_POST["projectLink"];
$name_file = $_POST["projectPicture"];

header("Location: ../../after/submit-project/submit-project-3.php?".
"projectName=$projectName&projectDescription=$projectDescription&projectType=$projectType".
"&projectLink=$projectLink&projectPicture=$name_file");

?>