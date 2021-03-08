<?php
session_start();

if(isset($_SESSION["username"]) && $_SESSION["loggin"] == true){
    session_start();
    session_unset();
    session_destroy();
    header("location: login.php");
}
header("location: login.php");

?>