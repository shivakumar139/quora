<?php
$server = "localhost";
$user_name = "root";
$password = "";
$db = "quora";

$conn = mysqli_connect($server,$user_name,$password,$db);
if(!$conn){
    die("false");
}

?>