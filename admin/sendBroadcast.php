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

    $uname = $_SESSION["uName"];

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
    $date = date("m/d/y");
    $time = date("h:i");

    $badCode = true;
    while($badCode) {
        $badCode = false;
        $permittedChars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $code = substr(str_shuffle($permittedChars), 0, 10);
        $sql = "SELECT * FROM notifications";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            if($row["Code"] == $code) {
                $badCode = true;
            }
        }
    }

    $sql = "INSERT INTO notifications (Team, Permission, Author, Message, Time, Date, Code) VALUES ('$team', '$perms', '$author', ?, '$time', '$date', '$code')";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $msg);
        mysqli_stmt_execute($stmt);
    }

    $sql = "UPDATE users SET unreadNotification = 1 WHERE Team = '$team'";
    $result = $conn->query($sql);
    $sql = "SELECT notificationReference FROM users WHERE Username = '$uname'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $refs = $row["notificationReference"];
    }
    $code = "," . $code;

    if($_POST["headScout"] == "on") {
        $perms = 1;
        $sql = "UPDATE users SET notificationReference = CONCAT(notificationReference, '$code') WHERE Team = '$team' && Permissions = '$perms'";
        $result = $conn->query($sql);
    }
    if($_POST["assistantScout"] == "on") {
        $perms = 2;
        $sql = "UPDATE users SET notificationReference = CONCAT(notificationReference, '$code') WHERE Team = '$team' && Permissions = '$perms'";
        $result = $conn->query($sql);
    }
    if($_POST["coach"] == "on") {
        $perms = 3;
        $sql = "UPDATE users SET notificationReference = CONCAT(notificationReference, '$code') WHERE Team = '$team' && Permissions = '$perms'";
        $result = $conn->query($sql);
    }
    if($_POST["basicScout"] == "on") {
        $perms = 4;
        $sql = "UPDATE users SET notificationReference = CONCAT(notificationReference, '$code') WHERE Team = '$team' && Permissions = '$perms'";
        $result = $conn->query($sql);
    }
    if($_POST["other"] == "on") {
        $perms = 5;
        $sql = "UPDATE users SET notificationReference = CONCAT(notificationReference, '$code') WHERE Team = '$team' && Permissions = '$perms'";
        $result = $conn->query($sql);
    }
    //for devs
    $perms = 6;
    $sql = "UPDATE users SET notificationReference = CONCAT(notificationReference, '$code') WHERE Team = '$team' && Permissions = '$perms'";
    $result = $conn->query($sql);

    $_SESSION["alert"] = true;
    $_SESSION["prompt"] = "Notification broadcasted successfully";

    header('Location: broadcast.php');
?>