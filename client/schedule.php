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
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    if (isset($_SESSION["user"])) {
        if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'c') {
            header("location: ../login.php");
        } else {
            $useremail = $_SESSION["user"];
        }
    } else {
        header("location: ../login.php");
    }

    // Import database
    include("../connection.php");

    $sqlmain = "SELECT * FROM client WHERE clientemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $result = $stmt->get_result();
    $userfetch = $result->fetch_assoc();
    $userid = $userfetch["clientid"];
    $username = $userfetch["clientname"];

    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d');

    // Define filter variables
    $fees_filter = "";
    $search = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fees_filter = $_POST['fees_filter'] ?? "";
        // Capture the maid name posted from maid.php
        $search = $_POST['search'] ?? "";
    }

    $filter_condition = "";

    // If user selected any fees filter
    if (!empty($fees_filter)) {
        switch ($fees_filter) {
            case "low":
                $filter_condition .= " AND schedule.`fees/hr` <= 100";
                break;
            case "medium":
                $filter_condition .= " AND schedule.`fees/hr` > 100 AND schedule.`fees/hr` <= 1000";
                break;
            case "high":
                $filter_condition .= " AND schedule.`fees/hr` > 200";
                break;
        }
    }

    // Apply maid name if provided
    if (!empty($search)) {
        $search = $database->real_escape_string($search);
        $filter_condition .= " AND maid.maidname LIKE '%$search%'";
    }

    $sqlmain = "SELECT maid.maidid, maid.maidname, maid.maidemail, specialties.sname, schedule.scheduleid, 
                       schedule.title, schedule.scheduledate, schedule.scheduletime, schedule.`fees/hr`, schedule.`cost/delay`
                FROM schedule
                INNER JOIN maid ON schedule.maidid = maid.maidid
                LEFT JOIN specialties ON maid.specialties = specialties.id
                WHERE 1=1 $filter_condition
                ORDER BY schedule.scheduledate ASC";

    $result = $database->query($sqlmain);
    ?>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo htmlspecialchars(substr($username, 0, 13)) ?>..</p>
                                    <p class="profile-subtitle"><?php echo htmlspecialchars(substr($useremail, 0, 22)) ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php"><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-home">
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Home</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="maid.php" class="non-style-link-menu"><div><p class="menu-text">All Maids</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0; margin:0; padding:0; margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="index.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <form action="" method="post" class="header-search">
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Maid name or Email or Date (YYYY-MM-DD)" list="maids">&nbsp;&nbsp;
                            <select name="fees_filter" class="input-text header-searchbar">
                                <option value="">Select Fees/Hour</option>
                                <option value="low" <?php if ($fees_filter == "low") echo "selected"; ?>>Low (<= 100)</option>
                                <option value="medium" <?php if ($fees_filter == "medium") echo "selected"; ?>>Medium (100 - 200)</option>
                                <option value="high" <?php if ($fees_filter == "high") echo "selected"; ?>>High (> 200)</option>
                            </select>&nbsp;&nbsp;
                            <input type="submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">Today's Date</p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;"><?php echo $today; ?></p>
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
    echo '<tr><td colspan="5">No sessions found.</td></tr>';
} else {
    $counter = 0;
    while ($row = $result->fetch_assoc()) {
        $startTime = new DateTime($row['scheduletime']);
        $endTime = clone $startTime;
        $endTime->modify('+2 hours');

        if ($counter % 3 == 0) echo '<tr>';

        echo '<td style="width: 25%;">
            <div class="dashboard-items search-items">
                <div>
                    <div class="h1-search">' . htmlspecialchars($row['title'] ?? 'N/A') . '</div>
                    <div class="h3-search">Maid: ' . htmlspecialchars($row['maidname'] ?? 'N/A') . '</div>
                    <div class="h4-search">Date: ' . htmlspecialchars($row['scheduledate'] ?? 'N/A') . '<br>Time: <b>@' . htmlspecialchars($startTime->format('H:i:s')) . ' to ' . htmlspecialchars($endTime->format('H:i:s')) . '</b></div>
                    <div class="h4-search">Fees/Hour: ৳' . htmlspecialchars($row['fees/hr'] ?? '0') . '</div>
                    <div class="h4-search">Cost/Delay: ৳' . htmlspecialchars($row['cost/delay'] ?? '0') . '</div>
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
</body>
</html>
