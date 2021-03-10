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
    $team = 34522;
    $author = "Developer Team";
    $time = date("h:i");

    //Generate Permission Value
    $perms = 111111;

    $sql = "INSERT INTO notifications (Team, Permission, Author, Message, Time) VALUES ('$team', '$perms', '$author', ?, '$time')";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error";
    } else {
        mysqli_stmt_bind_param($stmt, "s", $msg);
        mysqli_stmt_execute($stmt);
    }
    $notification = 1;

    $sql = "UPDATE users SET unreadNotification = '$notification'";
    $result = $conn->query($sql);

    $_SESSION["alert"] = true;
    $_SESSION["prompt"] = "Notification broadcasted successfully";

    header('Location: broadcast.php');
?>