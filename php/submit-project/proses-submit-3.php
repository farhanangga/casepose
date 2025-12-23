<?php

$projectName = $_POST["projectName"];
$projectDescription = $_POST["projectDescription"];
$projectType = $_POST["projectType"];
$projectLink = $_POST["projectLink"];
$name_file = $_POST["projectPicture"];
$projectTag = $_POST["projectTag"];
$projectStatus = $_POST["projectStatus"];

if(empty($projectTag) || empty($projectStatus)){

    header("Location: ../../after/submit-project/submit-project-3.php?".
    "projectName=$projectName&projectDescription=$projectDescription&projectType=$projectType".
    "&projectLink=$projectLink&projectPicture=$name_file&pesan=kosong");
}else {
    if(strlen($projectTag) > 255){
        header("Location: ../../after/submit-project/submit-project-3.php?".
        "projectName=$projectName&projectDescription=$projectDescription&projectType=$projectType".
        "&projectLink=$projectLink&projectPicture=$name_file&pesan=project-tag-length-255");
    }else{

        header("Location: ../../after/submit-project/submit-project-4.php?".
        "projectName=$projectName&projectDescription=$projectDescription&projectType=$projectType".
        "&projectLink=$projectLink&projectPicture=$name_file".
        "&projectTag=$projectTag&projectStatus=$projectStatus");
        exit();
    }
}

?>