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
    $author = "Developer Team";
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

    $sql = "UPDATE users SET unreadNotification = 1";
    $result = $conn->query($sql);
    $sql = "SELECT notificationReference FROM users WHERE Username = '$uname'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $refs = $row["notificationReference"];
    }
    $code = "," . $code;

    $sql = "UPDATE users SET notificationReference = CONCAT(notificationReference, '$code')";
    $result = $conn->query($sql);

    $_SESSION["alert"] = true;
    $_SESSION["prompt"] = "Notification broadcasted successfully";

    header('Location: broadcast.php');
?>