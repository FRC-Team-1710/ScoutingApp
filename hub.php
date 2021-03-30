<?php 
    session_start();
    $sessionValid = $_SESSION["isSessionValid"];
    if($sessionValid != true) {
        header('Location: index.php');
    }

    //Connection variables
    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbName = "mattbzco_Scouting";

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbName);
    //Check connection
    if($conn->connect_error) {
        die("Error: " . $conn->connect_error);
    }

    $uname = $_SESSION["uName"];
    $sql = "SELECT unreadNotification FROM users WHERE Username = '$uname'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $unreadNots = $row["unreadNotification"];
    }

    $count = 0;
    $sql = "SELECT * FROM feedback WHERE isRead = 1";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $count++;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Team 1710 Scouting App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!--FontAwesome import-->
    <script src="https://kit.fontawesome.com/eb8581ba7a.js" crossorigin="anonymous"></script>
</head>
<body style="background-color: rgb(54, 59, 66)">
        <!--This is the hub where people sign in to the system, can view their shekel count, view leaderboards, request loans, and bet on matches-->
        <div class="container"> 
            <center id="centerTag">
                <div id="hubContainer">
                    <div class="pt-3">
                        <h2 class="display-4 text-white text-center">
                            Team 1710 Scouting App
                        </h2>
                        <h4 class="text-white text-center">
                            <?php echo "Welcome, " . $_SESSION["fName"] . " " . $_SESSION["lName"]; ?>
                        </h4>
                    </div>
                    <hr style="border:1px solid white; width:80%">
                    <?php
                        if($_SESSION["perms"] == 1 || $_SESSION["perms"] == 6) {
                            echo '<div class="col-xs-12 pt-1"> <a href="admin/index.php"> <button class="btn btn-primary">Admin Settings</button> </a> </div>';
                        }
                    ?>
                    <?php
                        if($count > 0) {$color = "warning";} else {$color = "primary";}
                        if($_SESSION["perms"] == 6) {
                            echo '<div class="col-xs-12 pt-3"> <a href="dev/index.php"> <button class="btn btn-'.$color.'">Dev Settings <strong>'.$count.'</strong></button> </a> </div>';
                        }
                    ?>
                    <div class="col-xs-12 pt-3">
                        <a href="about.php">
                            <button class="btn btn-primary">About</button>
                        </a>
                    </div>
                    <div class="col-xs-12 pt-3">
                        <a href="settings.php">
                            <button class="btn btn-primary">Settings</button>
                        </a>
                    </div>
                    <div class="col-xs-12 pt-3">
                        <a href="feedback.php">
                            <button class="btn btn-primary">Feedback</button>
                        </a> 
                    </div>
                    <div class="col-xs-12 pt-3">
                        <a href="notifications.php">
                            <button class="btn btn-<?php if($unreadNots == 0) {echo "primary";} else {echo "warning";}?>">Notfications</button>
                        </a>
                    </div>
                    <?php
                        if($_SESSION["perms"] == 6) {
                            echo '<div class="col-xs-12 pt-3"> <a href="scouting/schedule.php"> <button class="btn btn-success btn-lg">Scout!</button> </a> </div>';
                        }
                    ?>
                    <br>
                    <div class="col-xs-12 pt-3">
                        <a href="server/logout.php">
                            <button class="btn btn-primary">Logout</button>
                        </a>
                    </div>
                </div>
            </center>
        </div>
    </body>
</html>