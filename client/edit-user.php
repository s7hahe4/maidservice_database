<?php

//import database
include("../connection.php");

if($_POST){
    //print_r($_POST);
    $result= $database->query("select * from webuser");
    $name=$_POST['name'];
    $nic=$_POST['nic'];
    $oldemail=$_POST["oldemail"];
    $address=$_POST['address'];
    $email=$_POST['email'];
    $tele=$_POST['Tele'];
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
    $id=$_POST['id00'];
    
    if ($password==$cpassword){
        $error='3';

        $sqlmain= "select client.clientid from client inner join webuser on client.clientemail=webuser.email where webuser.email=?;";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();
        //$resultqq= $database->query("select * from maid where maidid='$id';");
        if($result->num_rows==1){
            $id2=$result->fetch_assoc()["clientid"];
        }else{
            $id2=$id;
        }
        

        if($id2!=$id){
            $error='1';
            //$resultqq1= $database->query("select * from maid where maidemail='$email';");
            //$did= $resultqq1->fetch_assoc()["maidid"];
            //if($resultqq1->num_rows==1){
                
        }else{

            //$sql1="insert into maid(maidemail,maidname,maidpassword,maidnic,maidtel,specialties) values('$email','$name','$password','$nic','$tele',$spec);";
            $sql1="update client 
                   set clientemail='$email',clientname='$name',clientpassword='$password',clientnic='$nic',clienttel='$tele',clientaddress='$address' 
                   where clientid=$id ;";
            $database->query($sql1);
            echo $sql1;
            $sql1="update webuser 
                   set email='$email' 
                   where email='$oldemail' ;";
            $database->query($sql1);
            echo $sql1;
            
            $error= '4';
            
        }
        
    }else{
        $error='2';
    }

} else {
    //header('location: signup.php');
    $error='3';
}

header("location: settings.php?action=edit&error=".$error."&id=".$id);
?>
</body>
</html>