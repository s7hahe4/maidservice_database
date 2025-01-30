<?php

session_start();

if(!isset($_SESSION["user"]) || $_SESSION["user"]=="" || $_SESSION['usertype']!='c'){
    header("location: ../login.php");
    exit;
}

if($_GET){
    //import database
    include("../connection.php");
    $id = $_GET["id"];
    $sql = "DELETE FROM appointment WHERE appoid=?";
    $stmt = $database->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("location: appointment.php");
    exit;
}

?>