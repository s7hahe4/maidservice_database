<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Availability Manager</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .form-container {
            margin: 20px 45px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container input, .form-container button {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .schedule-table {
            margin: 20px 45px;
            width: calc(100% - 90px);
            border-collapse: collapse;
        }
        .schedule-table th, .schedule-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .schedule-table th {
            background-color: #f2f2f2;
        }
        .message {
            margin: 20px 45px;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }
        .success-msg {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error-msg {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Back Button Styling */
        .back-btn {
            display: inline-block;
            margin: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    // Check if the user is logged in and has the correct user type
    if (isset($_SESSION["user"])) {
        if ($_SESSION["user"] == "" || $_SESSION['usertype'] != 'm') {
            header("location: ../login.php");
        } else {
            $useremail = $_SESSION["user"];
        }
    } else {
        header("location: ../login.php");
    }

    // Connect to the database
    include("../connection.php");

    // Fetch the maid's details from the database
    $userrow = $database->query("SELECT * FROM maid WHERE maidemail='$useremail'");
    $userfetch = $userrow->fetch_assoc();
    $username = $userfetch["maidname"];

    $message = ""; // Initialize the message variable

    // Handle form submission to add availability
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $maidid = $_POST['maidid']; // Manually input maid ID
        $title = $_POST['title'];
        $scheduledate = $_POST['scheduledate'];
        $scheduletime = $_POST['scheduletime'];
        $fees_per_hour = $_POST['fees_per_hour']; // Get fees per hour

        $sql = "INSERT INTO schedule (maidid, title, scheduledate, scheduletime, fees_per_hour) 
                VALUES ('$maidid', '$title', '$scheduledate', '$scheduletime', '$fees_per_hour')";

        if ($database->query($sql) === TRUE) {
            $message = "<div class='message success-msg'>Availability added successfully!</div>";
        } else {
            $message = "<div class='message error-msg'>Error: " . $database->error . "</div>";
        }
    }

    // Fetch the maid's schedule
    $schedules = $database->query("SELECT * FROM schedule ORDER BY scheduledate, scheduletime");
    ?>
    <div class="container">
        <div class="menu">
            <!-- Include your existing menu code here -->
        </div>
        <div class="dash-body">
            <!-- Back Button -->
            <a href="index.php" class="back-btn">Back to Home</a>

            <!-- Display the message -->
            <?= $message ?>

            <!-- Form to add availability -->
            <div class="form-container">
                <h2>Add Availability</h2>
                <form method="POST">
                    <label for="maidid">Maid ID:</label>
                    <input type="number" name="maidid" id="maidid" required>
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" required>
                    <label for="scheduledate">Date:</label>
                    <input type="date" name="scheduledate" id="scheduledate" required>
                    <label for="scheduletime">Time:</label>
                    <input type="time" name="scheduletime" id="scheduletime" required>
                    <label for="fees_per_hour">Fees/Hour:</label>
                    <input type="number" name="fees/hr" id="fees_per_hour" required>
                    <button type="submit">Add Availability</button>
                </form>
            </div>

            <!-- Table to display the schedule -->
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Maid ID</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Fees/Hour</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($schedules->num_rows > 0): ?>
                        <?php while ($row = $schedules->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['scheduleid'] ?></td>
                                <td><?= $row['maidid'] ?></td>
                                <td><?= $row['title'] ?></td>
                                <td><?= $row['scheduledate'] ?></td>
                                <td><?= $row['scheduletime'] ?></td>
                                <td><?= $row['fees/hr'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No availability added yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
