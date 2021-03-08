<?php
    session_start();
    if(!isset($_SESSION["loggin"])){
        header("location: index.php");
    }

    require("partials/conn.php");



    $question_id = $_GET["question_id"];
     

    //deleting the question
    $query = "DELETE FROM `question` WHERE question_id = $question_id";
    mysqli_query($conn,$query);


    //deleteing the comments on this question
    $cquery = "DELETE FROM `comment` WHERE question_id = $question_id";
    mysqli_query($conn,$cquery);

    header("location: my_questions.php");

?>