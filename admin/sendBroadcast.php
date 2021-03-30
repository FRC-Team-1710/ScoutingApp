<?php
    session_start();
    if(!$_SESSION["isSessionValid"]) {
        header('Location: ../index.php');
    }
    if($_SESSION["perms"] != 1) {
        if($_SESSION["perms"] != 6) {
            header('Location: ../hub.php');
        }
    }

    date_default_timezone_set('America/North_Dakota/Center');

    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $msg = $_POST["broadcast"];
    $team = $_SESSION["Team"];
    $perms = $_POST["perms"]; //REMOVE AFTER PERMS CREATION
    $author = $_SESSION["fName"] . " " . $_SESSION["lName"];
    $time = date("h:i");

    $permittedChars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $code = substr(str_shuffle($permittedChars), 0, 10);

    //Generate Permission Value
    $perms = 100000;
    if($_POST["headScout"] == "on") {
        $perms += 10000;
    }
    if($_POST["assistantScout"] == "on") {
        $perms += 1000;
    }
    if($_POST["coach"] == "on") {
        $perms += 100;
    }
    if($_POST["basicScout"] == "on") {
        $perms += 10;
    }
    if($_POST["other"] == "on") {
        $perms += 1;
    }

    $sql = "INSERT INTO notifications (Team, Permission, Author, Message, Time, Code) VALUES ('$team', '$perms', '$author', ?, '$time', '$code')";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $msg);
        mysqli_stmt_execute($stmt);
    }

    $sql = "UPDATE users SET unreadNotification = 1 WHERE Team = '$team'";
    $result = $conn->query($sql);

    $_SESSION["alert"] = true;
    $_SESSION["prompt"] = "Notification broadcasted successfully";

    header('Location: broadcast.php');
?>