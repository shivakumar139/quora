<?php
$server = "freedb.tech";
$user_name = "freedbtech_shiva";
$password = "shiva0525";
$db = "freedbtech_quora";

$conn = mysqli_connect($server,$user_name,$password,$db);
if(!$conn){
    die("false");
}

?>