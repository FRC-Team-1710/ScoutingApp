<?php
    session_start();
    $sessionValid = $_SESSION["isSessionValid"];
    $perms = $_SESSION["perms"];
    if($sessionValid != true) {
        header('Location: ../index.php');
    } else if($perms != 1) {
        if($perms != 2) {
            header('Location: ../hub.php');
        }
    }

    $uname = $_POST["username"];
    $servername = "localhost";
    $username = "mattbzco_779ccb2";
    $password = "q1w2E#R$";
    $dbname = "mattbzco_Scouting";
    $isDev = true;

    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT Permissions FROM users WHERE Username = '$uname'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        if($row["Permissions"] != 2) {
            $isDev = false;
        }
    }




    if(!$isDev) {
        $sql = "UPDATE users SET Permissions = 0 WHERE Username = '$uname'";
        $result = $conn->query($sql);
    }

    header('Location: index.php');
?>