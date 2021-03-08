<?php
    session_start();
    require("conn.php");
    if(!isset($_SESSION["loggin"])){
        header("location: index.php");
    }
    

    $id = htmlentities(mysqli_real_escape_string($conn,$_POST["id"]));
    $title = htmlentities(mysqli_real_escape_string($conn,$_POST["title"]));
    $desc = htmlentities(mysqli_real_escape_string($conn,$_POST["desc"]));

    $query = "UPDATE `question` SET `question_title`='$title',`question_description`='$desc',`question_time` = CURRENT_TIMESTAMP WHERE question_id = $id";

    mysqli_query($conn,$query);

    header("location: /quora/my_questions.php");
?>