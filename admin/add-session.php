<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }
    
    
    if($_POST){
        //import database
        include("../connection.php");
        $title=$_POST["title"];
        $maidid=$_POST["maidid"];
        $nop=$_POST["nop"];
        $date=$_POST["date"];
        $time=$_POST["time"];
        $sql="insert into schedule (maidid, title, scheduledate, scheduletime, nop) values ($maidid, '$title', '$date', '$time', $nop);";
        $result= $database->query($sql);
        header("location: schedule.php?action=session-added&title=$title");
        
    }

?>