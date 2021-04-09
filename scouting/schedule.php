<?php 
    session_start();
    $sessionValid = $_SESSION["isSessionValid"];
    if($sessionValid != true) {
        header('Location: index.php');
    }
    if($_SESSION["perms"] != 6) {
        header('Location: hub.php');
    }

    $team = $_SESSION["Team"];
    $scout = $_SESSION["fName"] . " " . $_SESSION["lName"];

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

    //Command
    $sql = "SELECT * FROM schedule WHERE TeamScheduled = '$team' && Scout = '$scout'";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Scouting Schedule</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="icon" href="logo.jpg">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </head>
    <body style="background-color: rgb(54,59,66);">
        <div class="container"> 
            <center id="centerTag">
                <div class="pt-3">
                    <h2 class="display-4 text-white text-center">
                        GKC Schedule
                    </h2>
                </div>
                <hr style="border:1px solid white; width:80%">
                <?php
                    while($row = $result->fetch_assoc()) {
                        if($row["Alliance"] == "red") {
                            $alliance = "btn-danger";
                            $dropColor = "#dc3545";
                        } else {
                            $alliance = "btn-primary";
                            $dropColor = "#0275d8";
                        }
                        echo '
                        <div class="btn-group py-3">
                            <button type="button" class="btn '.$alliance.' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:60vw;">
                                '.$row["MatchType"].' '.$row["MatchNumber"].'
                            </button>
                            <div id="dropdown" class="dropdown-menu" style="width:60vw;background-color:'.$dropColor.';">
                            <center>
                                <p class="dropdown-item mt-1 mb-1" style="color:white;">'.$row["Date"].' '.$row["Time"].'</p>
                                <a class="dropdown-item" href="../hub.php"><button class="btn btn-success" style="width:50vw;position:relative;left:-4.5px;font-size:20px;">Scout '.$row["Team"].'</button></a>
                            </center>
                            </div>
                        </div>
                        ';
                    }
                ?>
                <div class="col-xs-12 my-5">
                    <a href="../hub.php">
                        <button type="button" class="btn btn-success" style="position:fixed;width:75%;height:5vh;bottom:25px;margin-left:-37.5%;left:50%">Back to Hub</button>
                    </a>
                </div>
            </center>
        </div>
    </body>
</html>