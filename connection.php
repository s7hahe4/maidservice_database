<?php

    $database= new mysqli("localhost","root","","bualagbedatabase");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>