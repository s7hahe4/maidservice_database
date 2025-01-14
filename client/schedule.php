<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Sessions</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
    <?php

    //learn from w3schools.com

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='c'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }


    //import database
    include("../connection.php");
    $sqlmain= "select * from client where clientemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $result = $stmt->get_result();
    $userfetch=$result->fetch_assoc();
    $userid= $userfetch["clientid"];
    $username=$userfetch["clientname"];

    //echo $userid;
    //echo $username;

    date_default_timezone_set('Asia/Kolkata');

    $today = date('Y-m-d');

    //echo $userid;
    ?>
 <div class="container">
     <div class="menu">
     <table class="menu-container" border="0">
             <tr>
                 <td style="padding:10px" colspan="2">
                     <table border="0" class="profile-container">
                         <tr>
                             <td width="30%" style="padding-left:20px" >
                                 <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                             </td>
                             <td style="padding:0px;margin:0px;">
                                 <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                 <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                             </td>
                         </tr>
                         <tr>
                             <td colspan="2">
                                 <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                             </td>
                         </tr>
                 </table>
                 </td>
             </tr>
             <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home " >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="maid.php" class="non-style-link-menu"><div><p class="menu-text">All Maids</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        <?php

$sqlmain= "SELECT maid.maidid, maid.maidname, schedule.scheduleid, schedule.title, schedule.scheduledate, schedule.scheduletime 
           FROM schedule 
           INNER JOIN maid ON schedule.maidid = maid.maidid 
           WHERE schedule.scheduledate >= '$today' 
           ORDER BY schedule.scheduledate ASC";


        $sqlpt1="";
        $insertkey="";
        $q='';
        $searchtype="All";
        if($_POST){
            //print_r($_POST);
            
            if(!empty($_POST["search"])){
                /*TODO: make and understand */
                $keyword=$_POST["search"];
                $sqlmain= "select * 
                           from schedule inner join maid 
                           on schedule.maidid=maid.maidid 
                           where schedule.scheduledate>='$today' and (maid.maidname='$keyword' 
                           or maid.maidname like '$keyword%' 
                           or maid.maidname like '%$keyword' 
                           or maid.maidname like '%$keyword%' 
                           or schedule.title='$keyword' 
                           or schedule.title like '$keyword%' 
                           or schedule.title like '%$keyword' 
                           or schedule.title like '%$keyword%' 
                           or schedule.scheduledate like '$keyword%' 
                           or schedule.scheduledate like '%$keyword' 
                           or schedule.scheduledate like '%$keyword%' 
                           or schedule.scheduledate='$keyword' ) 
                           order by schedule.scheduledate asc";
                //echo $sqlmain;
                $insertkey=$keyword;
                $searchtype="Search Result : ";
                $q='"';
            }

        }

        $result= $database->query($sqlmain)

        ?>
                  
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%" >
                    <a href="schedule.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td >
                            <form action="" method="post" class="header-search">

                                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Maid name or Email or Date (YYYY-MM-DD)" list="maids" value="<?php  echo $insertkey ?>">&nbsp;&nbsp;
                                        
                                        <?php
                                        echo '<datalist id="maids">';
                                        $list11 = $database->query("SELECT DISTINCT maidname FROM maid;");

                                        $list12 = $database->query("select DISTINCT * 
                                                                    from schedule 
                                                                    GROUP BY title;");

                                        for ($y=0; $y<$list11->num_rows; $y++){
                                            $row00 = $list11->fetch_assoc();
                                            $d = $row00["maidname"];
                                        
                                            echo "<option value='$d'><br/>";
                                        
                                        };

                                        for ($y=0; $y<$list12->num_rows; $y++){
                                            $row00 = $list12->fetch_assoc();
                                            $d = $row00["title"];
                                        
                                            echo "<option value='$d'><br/>";
                                        };

                                        echo ' </datalist>';
                                        ?>
                                        
                                
                                        <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 

                                
                                echo $today;

                                

                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>
                
                
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo $searchtype." Sessions"."(".$result->num_rows.")"; ?> </p>
                        <p class="heading-main12" style="margin-left: 45px;font-size:22px;color:rgb(49, 49, 49)"><?php echo $q.$insertkey.$q ; ?> </p>
                    </td>
                    
                </tr>
                
                
                
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="100%" class="sub-table scrolldown" border="0" style="padding: 50px;border:none">
                            
                        <tbody>
<?php
if ($result->num_rows == 0) {
    echo '<tr><td colspan="4">No sessions found.</td></tr>';
} else {
    $counter = 0;
    while ($row = $result->fetch_assoc()) {
        if ($counter % 3 == 0) echo '<tr>';

        echo '<td style="width: 25%;">
            <div class="dashboard-items search-items">
                <div>
                    <div class="h1-search">' . htmlspecialchars($row['title']) . '</div>
                    <div class="h3-search">Maid: ' . htmlspecialchars($row['maidname']) . '</div>
                    <div class="h4-search">Date: ' . htmlspecialchars($row['scheduledate']) . '<br>Starts: <b>@' . htmlspecialchars($row['scheduletime']) . '</b></div>
                    <a href="booking.php?id=' . htmlspecialchars($row['scheduleid']) . '">
                        <button class="login-btn btn-primary-soft btn">Book Now</button>
                    </a>
                </div>
            </div>
        </td>';

        if ($counter % 3 == 2) echo '</tr>';
        $counter++;
    }
    if ($counter % 3 != 0) echo '</tr>';
}

?>
</tbody>



                        </table>
                        </div>
                        </center>
                   </td> 
                </tr>
                       
                        
                        
            </table>
        </div>
    </div>

    </div>

</body>
</html>
